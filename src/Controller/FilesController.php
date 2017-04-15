<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Files Controller
 *
 * @property \App\Model\Table\FilesTable $Files
 */
class FilesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->user = $this->Auth->session->read();
    }
    public function isAuthorized($user){
        $parentValue = parent::isAuthorized($user);
        //debug($parentValue); die();
        if(!$parentValue) return false;
        
        $user = $this->Auth->session->read();
        $privilege = array('index' => 1, 'view' => 1, 'allLotsInOutput' => 2,'add' => 2,'validateActualQte' => 2, 'getAllFilesByIdClient' => 2, 'edit' => 3, 'delete' => 4, 'updateWarningMsg' => 2);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['files'];
        //debug($permissionLvl);die();
        if($privilege[$action] <= $permissionLvl){
            return true;
        }
        //$this->Flash->error(__('Vous n\'êtes pas autoriser d\'acceder à cette page'));
        return false;
        
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    
    public function index($stat = -1)
    {
        $this->paginate = [
            'contain' => ['Clients', 'Providers'],
            'maxLimit' => 15,
            'order' => [
                'created' => 'desc'
            ]
        ];
        if($stat == -1)
            $files = $this->paginate($this->Files);
        else
            $files = $this->paginate($this->Files->find('all')->where(['statut' => $stat]));
        $numberRows = 15;
        $statuts = unserialize(STATS_FILES);
        $this->set(compact('statuts', 'numberRows'));
        $this->set(compact('files'));
        $this->set('_serialize', ['files']);
    }

    /**
     * View method
     *
     * @param string|null $id File id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null, $error = null){
        //msg erreur from controller : inputs/add s'il y a des lots ont -1 comme actual qte lors de la gestion des inputs
        if($error == "error")
        $msgError = '<div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Erreur !</strong> Merci de vérifier les quantités arrivées.
                      </div>';
        //Les types des documents
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        
        /*$file = $this->Files->get($id, [
            'contain' => ['Clients', 'Inputs', 'Documents', 'Lots', 'Outputs', 'Providers', 'OutputSets', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);*/
        
        $file = $this->getAllDataFile($id);
        //debug($file);die();
        //charger les produit
        
        if(!empty($file->input_id))
            $input = $this->Files->Inputs->get($file->input_id);
        $statut = $this->getStat($id);
        /*
        $this->loadModel('Products');
        $products=array();
        foreach($file->lots as $lot){
            $product_id = $lot['product_id'];
            $products[$product_id] = $this->Products->find('all')->where(['id'=>$product_id])->select(['id', 'name', 'productCode', 'ngpCode'])->toArray();
        }*/
        $products = $this->getProductData($file->lots);
        //debug($file);die();
        //Chargement des types de document
        $this->loadModel('Required_docs');
        $typeDocs = $this->Required_docs->find('all')->toArray();
        //comparison avc Les doc de ce dossier
        foreach($typeDocs as $key => $value){
            
            $i = 0;
            //debug($file->documents[$i]);
            $fileFound = false;
            while (isset($file->documents[$i]['id'])) {
                if(($value['name'] == $file->documents[$i]['name'])&&($value['type'] == $file->documents[$i]['type'])){
                    $fileFound = true;
                    $version = $file->documents[$i]['version'];
                }
                $i++;
            }
            
            if(!($fileFound)){
                $idType = $value['type'];
                $value['typeName'] = $types[$idType];
                $fileMissing[] = $value;
            }elseif(($value['type'] == '1')&&($version == '0')){
                $idType = $value['type'];
                $value['typeName'] = $types[$idType];
                $fileMissing[] = $value;
            }
        }
        
        //Fonction sur les quota des lots, et voir si les actualQte = les expectedQte
        $outdatedLots = $this->verifQuotaAndQuantite($id);
        //debug($outdatedLots); die();
        //S'il y a pas des lots restant pour ce outputSet on peut pas accéder à la page add outputSet
        $allLotsInOutput = $this->allLotsInOutput($id);
        //die($allLotsInOutput);
        $statOutput = unserialize(STATS_OUTPUTSETS);
        $page_name = 'file_view';
        $this->set(['file' => $file, 'products' => $products]);
        $this->set(compact('types', 'fileMissing', 'outdatedLots', 'input', 'statut', 'statOutput', 'page_name', 'msgError', 'allLotsInOutput'));
        $this->set('_serialize', ['file']);
    }

    public function verifQuotaAndQuantite($idFile){ //Fonction sur les quota des lots, et voir si les actualQte = les expectedQte
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile, [
            'contain' => ['Clients', 'Inputs', 'Documents', 'Lots', 'Outputs', 'Providers', 'OutputSets', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        
        
        $lots = new LotsController;
        $outdatedLots = array();
        $expectedNotActual = array();
        //debug($file->lots);die();
        foreach($file->lots as $key => $value){
            if(isset($value['product_id'])){
                $arrayLots[$key] = $lots->ProductQuotaVerif($value['product_id']);
                //debug($arrayLots);die();
                //if(($arrayLots[$key]['stockLibre'] <= $file->lots[$key]['expectedQte'])||($value['actualQte'] != $value['expectedQte'])){
                if(($arrayLots[$key]['stockLibre'] < $file->lots[$key]['expectedQte'])||($value['actualQte'] != $value['expectedQte'])){
                    $outdatedLots[$key]['stockLibre'] = $arrayLots[$key]['stockLibre'];
                    $outdatedLots[$key]['expectedQte'] = $file->lots[$key]['expectedQte'];
                    $outdatedLots[$key]['actualQte'] = $file->lots[$key]['actualQte'];
                    $outdatedLots[$key]['number'] = $file->lots[$key]['number'];
                    $outdatedLots[$key]['product_id'] = $file->lots[$key]['product_id'];
                }    
            }
        }
        return $outdatedLots;
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $file = $this->Files->newEntity();
        //Recuperer l'annee et le mois
        $time = Time::now();
        //Recuperer le dernier numero du dossier
        $lastRow = $this->Files->find()->order(['id' => 'desc'])->first();
        if($lastRow){
            $lenght_number = strlen($lastRow->number);
            $lastNumber = substr($lastRow->number, 9, $lenght_number-6);
            $lastMonth = substr($lastRow->number, 5, 2);
        }else{
            $lastNumber = 0;
            $lastMonth = -1;
        }
        
        $zero = '';
        if($lastMonth == $time->month){
            //Si on est dans le même mois on ajout 1
            $thisNumber = (int)($lastNumber + 1);
            //Ajouter les zero au nouveau numero, Exp : 201611 => 201601001 AnneeMoisNumero
            if($thisNumber < 10) $zero = '00';
            elseif($thisNumber < 100) $zero = '0';
        }else{
            //sinon reinitialiser le compteur
            $thisNumber = '001';
            
        }
        //Ajouter les zero au nouveau numero, Exp : 201611 => 201601001 AnneeMoisNumero
        if($time->month<10) $zeroMonth = '0';
        else $zeroMonth = '';
        if($time->day < 10) $zeroDay = '0';
        else $zeroDay = '';
        //Nouveau num
        $number = 'D' . (string)$time->year . $zeroMonth . (string)$time->month . $zeroDay . (string)$time->day . $zero . (string)$thisNumber;
        //debug($number);die();
        $clients = $this->Files->Clients->find('all')->where(['approved' => true, 'entrepositaire' => 1])->select(['id', 'name', 'code', 'matriculeFiscale'])->order('name')->toArray();
        $providers = $this->Files->Providers->find('all')->select(['id', 'name'])->order('name')->toArray();
        //debug($providers);die();
        if ($this->request->is('post')) {
            $file = $this->Files->patchEntity($file, $this->request->data);
            $file->number = $number;
            //debug($file); die();
            $file->created_by = $this->user['Auth']['User']['id'];
            $file->modified_by = $this->user['Auth']['User']['id'];
            if ($file = $this->Files->save($file)) {
                $this->Flash->success(__('has been saved.', ['Le dossier', '']));
                return $this->redirect(['action' => 'view', $file->id]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le dossier', '']));
            }
        }
        //debug($providers);die();
        $this->set(compact('file', 'clients', 'providers', 'number'));
        $this->set('_serialize', ['file']);
    }

    /**
     * Edit method
     *
     * @param string|null $id File id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $file = $this->Files->get($id, [
            'contain' => []
        ]);
        if($file->statut != 0) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->data);
            $file->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Files->save($file)) {
                $this->Flash->success(__('has been saved.', ['Le dossier', '']));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le dossier', '']));
            }
        }
        //$clients = $this->Files->Clients->find('list', ['limit' => 200]);
        $clients = $this->Files->Clients->find('all')->where(['approved' => true])->select(['id', 'name', 'code', 'matriculeFiscale'])->order('name')->toArray();
        $providers = $this->Files->Providers->find('all')->select(['id', 'name'])->order('name')->toArray();
        $this->set(compact('file', 'clients', 'providers'));
        $this->set('_serialize', ['file']);
    }

    /**
     * Delete method
     *
     * @param string|null $id File id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);
        if($file->statut != 0) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('has been deleted.', ['Le dossier', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le dossier', '']));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function updateStat($idFile = null, $idStatut = null, $redirect = null, $flash = true){
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        } elseif($idStatut === null) {
            throw new NotFoundException(__('Statut invalide !'));
        }
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile);
        $file->statut = $idStatut;
        $file->modified_by = $this->user['Auth']['User']['id'];
        if ($fileTable->save($file)) {
            if($flash){ // afficher le flash
                if($idStatut == 2)
                    $this->Flash->success(__('Le dossier a été enregistrer comme livré.'));
                elseif($idStatut == 3){
                    $this->Flash->success(__('Le dossier a été annulé.'));
                }elseif($idStatut == 0)
                    $this->Flash->success(__('Le dossier a été activé.'));
            }
            
        } else {
            $this->Flash->error(__('Problème au niveau du changement du statut.'));
        }
        if($redirect === null)
            return $this->redirect(['action' => 'view', $idFile]);
        else
            return true;
    }
    
    public function getStat($idFile = null){
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        
        $statuts = unserialize(STATS_FILES);
        //$fileTable = TableRegistry::get('Files');
        $file = $this->Files->get($idFile)->toArray();
        $idStatut = $file['statut'];
        return $statuts[$idStatut];
    }
    public function getstatFileById($id){
        $file = $this->Files->find('list', ['keyField' => 'id', 'valueField' => 'statut'])->where(['id' => $id])->toArray();
        return $file[$id];
    }
    
    //Voir si tout les lots ont des OUTPUT ===> RemainedQte = 0
    public function finishedFile($idFile){
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile, ['contain' => ['Lots']]);
        foreach ($file->lots as $key => $value) {
            if($value['remainedQte'] != '0')
                return false;
        }
        return true;
    }
    public function getNumFileById($id){
        $file = $this->Files->find('list', ['keyField' => 'id', 'valueField' => 'number'])->where(['id' => $id])->toArray();
        return $file[$id];
    }
    
    public function getAllFilesByIdClient($idClient){
        $fileTable = TableRegistry::get('Files');
        $files = $fileTable->find('all')->where(['client_id' => $idClient])->contain(['OutputSets'])->toArray();
        return $files;
    }
    
    public function updateWarningMsg($idFile){
        if($idFile === null){
            throw new NotFoundException(__('Erreur Ajax : updateWarningMsg !'));
        }
        $file = $this->getAllDataFile($idFile);
        $outdatedLots = $this->verifQuotaAndQuantite($idFile);
        //charger les produit
        $products = $this->getProductData($file->lots);
        
        $this->viewBuilder()->autoLayout(false);
        $this->set(compact('outdatedLots', 'file', 'products'));
    }
    private function getAllDataFile($idFile){
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile, [
            'contain' => ['Clients', 'Inputs.Carriers', 'Documents', 'Lots', 'Outputs', 'Providers', 'OutputSets', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        return $file;
    }
    private function getProductData($lots){
        $this->loadModel('Products');
        $products=array();
        foreach($lots as $lot){
            $product_id = $lot['product_id'];
            $products[$product_id] = $this->Products->find('all')->where(['id'=>$product_id])->select(['id', 'name', 'productCode', 'ngpCode'])->toArray();
        }
        return $products;
    }
    
    private function allLotsInOutput($id){
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($id, [
            'contain' => ['Lots']
        ]);
        foreach($file->lots as $key => $value){
            if($value['remainedQte'] != 0)
                return false;
                //die('false');
        }
        return true;
        //die('true');
    }
    
    public function validateActualQte($id = Null){
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($id, [
            'contain' => ['Lots']
        ]);
        foreach ($file->lots as $key => $value) {
            if($value->actualQte == -1){
                //on cas ou un ou pls lots n'ont pas une actual qte
                return $this->redirect(['action' => 'view', $id, 'error']);
            }
        }
        //on cas ou tout les lot ont des actual qte
        return $this->redirect(['controller' => 'Carriers', 'action' => 'selectCarriers', $id]);
    }
    
}
