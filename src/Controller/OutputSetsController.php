<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\Event\Event;
use Cake\I18n\Date;

/**
 * Outputsets Controller
 *
 * @property \App\Model\Table\OutputsetsTable $Outputsets
 */
class OutputSetsController extends AppController
{

    public function initialize(){
        parent::initialize();
        
        $this->loadComponent('RequestHandler');
        $this->user = $this->Auth->session->read();
    }
    public function isAuthorized($user){
        $parentValue = parent::isAuthorized($user);
        //debug($parentValue); die();
        if(!$parentValue) return false;
        
        $user = $this->Auth->session->read();
        $privilege = array('othersOutputSetsValidate' => 0, 'index' => 1, 'view' => 1, 'printOutputset' => 1, 'getopsByrv' => 2, 'test' => 2, 'add' => 2, 'getNumberOutputsByOutputSets' => 2, 'getOutputsByOutputsSets' => 2, 'dataOutputSets' => 2, 'firstValidation' => 2, 'traitementAjax' => 2, 'integrateOutput' => 2, 'chooseClient' => 2, 'validerOutputSets' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['outputSets'];
        //debug($permissionLvl);die();
        if($privilege[$action] <= $permissionLvl){
            return true;
        }
        //$this->Flash->error(__('Vous n\'êtes pas autoriser d\'acceder à cette page'));
        return false;
    }
    
    public function chooseClient($error = 0, $id_client = -1, $errorType = 0, $id_client2 = -1, $carriers = null){
        if($carriers === null) $this->redirect(['controller' => 'carriers', 'action' => 'selectCarriers', 0, 0, 'rv']);
        //echo debug(unserialize($carriers));
        $clientsController = New ClientsController;
        $clients = $clientsController->getClientByType(1);
        //debug($clients); die();
        if($errorType == 0)
            $errorMsg = "Merci de cocher les cases des bons à traiter !";
        else
            $errorMsg = "Merci de choisir le client !";
        $clients2 = $clientsController->getAllClient();
        $this->set(compact('clients', 'error', 'id_client', 'id_client2', 'clients2', 'errorMsg', 'carriers'));
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index(){
        //debug($this->OutputSets);die();
        $count = $this->OutputSets->find('all')->count();
        //debug($count);die();
        $this->paginate = [
            'contain' => ['Files'],
            'maxLimit' => $count
        ];
        $numberRows = $count;
        $outputsets = $this->paginate($this->OutputSets);

        $this->set(compact('outputsets', 'numberRows'));
        $this->set('_serialize', ['outputsets']);
    }

    /**
     * View method
     *
     * @param string|null $id Outputset id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->traitview($id);
    }
    public function printOutputset($id = null){
        //$this->viewBuilder()->layout('');
        $this->viewBuilder()->layout('Print');
        //$this->autoRender = false ;
        //$this->autoLayout = false; 
        $this->traitview($id);
    }
    function traitview($id){
        //$this->loadModel('OutputSets');
        //$outputSetsTable = TableRegistry::get('OutputSets');
        $outputset = $this->OutputSets->get($id, [
            'contain' => ['Files' ,'Outputs', 'Removalvouchers.Carriers', 'Users_CreatedBy']
        ]);
        
        $outputsetArray = $this->OutputSets->get($id, ['contain' => ['Files' ,'Outputs']])->toArray();
        
        //nom client
        $clientsController = new ClientsController;
        $nameClient = $clientsController->getNameClientById($outputsetArray['file']['client_id']);
        //nom provider
        $providersController = new ProvidersController;
        $nameProvider = $providersController->getNameProviderById($outputsetArray['file']['provider_id']);        
        //nombre bon de sorite
        $nombreOutputs = count($outputsetArray['outputs']);
        
        $productsController = new ProductsController;
        if(!empty($outputsetArray['outputs'])){
            $lotsController = new LotsController;
            
            foreach($outputsetArray['outputs'] as $key => $value){
                $idLot = $value['lot_id'];
                $outputsetArray['outputs'][$key]['number'] = $lotsController->getNumberLotById($idLot);
                $arrayNumberLot[$idLot]['lot_number'] = $outputsetArray['outputs'][$key]['number'];
                //name product
                $idProduct = $lotsController->getIdProductByIdLot($idLot);
                $outputsetArray['outputs'][$key]['product_name'] = $productsController->getNameProductById($idProduct);
                $arrayNumberLot[$idLot]['product_name'] = $outputsetArray['outputs'][$key]['product_name'];
                
                $arrayNumberLot[$idLot]['product_code'] = $productsController->getCodeProductById($idProduct);
                $arrayNumberLot[$idLot]['product_ngp'] = $productsController->getNgpcodeProductById($idProduct);
            }
        }else{
            $arrayNumberLot = array();
        }
        
        //S'il y a pas des lots restant pour ce outputSet on peut pas accéder à la page add output
        $outputController = new OutputsController;
        $lots = $outputController->getOtherLotsforOutputSet($id, $outputsetArray['file_id']);
        if(empty($lots)) $pasDeLot = true;
        else{
            $pasDeLot = false;
            foreach ($lots as $key => $value) {
                $lots[$key]['product_name'] = $productsController->getNameProductById($value['product_id']);
            }
        }
        
        //Ajouter les statuts de dossier
        $statuts = unserialize(STATS_FILES);
        
        $arraySatut = unserialize(STATS_OUTPUTSETS);
        $this->set(compact('arraySatut'));
        //debug($outputsetArray);die();
        //nom title header
        //$nameHeader = 'Bon à enlever';
        $nameHeader = 'Groupement des bons de sortie';
        $this->set(compact('arrayNumberLot', 'pasDeLot', 'lots', 'statuts', 'nameClient', 'nameProvider', 'nombreOutputs', 'nameHeader'));
        $this->set('outputset', $outputset);
        $this->set('_serialize', ['outputset']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idFile = null)
    {
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        
        $outputset = $this->OutputSets->newEntity();
        if ($this->request->is('post')) {
            $outputset = $this->OutputSets->patchEntity($outputset, $this->request->data);
            $outputset->created_by = $this->user['Auth']['User']['id'];
            $outputset->modified_by = $this->user['Auth']['User']['id'];
            if ($result = $this->OutputSets->save($outputset)) {
                $this->Flash->success(__('has been saved.', ['Le groupement des bons de sortie', '']));
                return $this->redirect(['action' => 'view', $result->id]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le groupement des bons de sortie', '']));
            }
        }
        //$files = $this->OutputSets->Files->find('list')->where(['id' => $idFile]);
        $file = $this->OutputSets->Files->get($idFile)->toArray();
        //debug($files); die();
        $this->set(compact('outputset', 'file'));
        $this->set('_serialize', ['outputset']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Outputset id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $outputset = $this->OutputSets->get($id, [
            'contain' => []
        ]);
        $filesController = new FilesController;
        $file = $filesController->getstatFileById($outputset->file_id);
        if(($outputset->statut == 1)||($file == 2)) {
            throw new NotFoundException(__('Le groupement des bons de sortie ou dossier validé !'));
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outputset = $this->OutputSets->patchEntity($outputset, $this->request->data);
            $outputset->modified_by = $this->user['Auth']['User']['id'];
            if ($this->OutputSets->save($outputset)) {
                $this->Flash->success(__('has been saved.', ['Le groupement des bons de sortie', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le groupement des bons de sortie', '']));
            }
        }
        $files = $this->OutputSets->Files->find('list', ['limit' => 200]);
        $this->set(compact('outputset', 'files'));
        $this->set('_serialize', ['outputset']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Outputset id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $idFile = null)
    {
        if(($id == null)||($idFile == null)) {
            throw new NotFoundException(__('Groupement des bons de sortie ou dossier invalide !'));
        }
        
        $this->request->allowMethod(['post', 'delete']);
        $outputset = $this->OutputSets->get($id, ['contain' => ['Outputs']]);
        
        //Voir si le dossier ou le bon ont été validés
        $filesController = new FilesController;
        $file = $filesController->getstatFileById($idFile);
        if(($outputset->statut == 1)||($file == 2)||(!isset($file))) {
            throw new NotFoundException(__('Le groupement des bons de sortie ou dossier validé !'));
        }
        
        $outputsController = new OutputsController;
        foreach ($outputset->outputs as $key => $value) {
            $outputsController->delete($value['id']);
        }
        
        if ($this->OutputSets->delete($outputset)) {
            $this->Flash->success(__('has been deleted.', ['Le groupement des bons de sortie', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le groupement des bons de sortie', '']));
        }
        return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile]);
    }
    
    public function validerOutputSets($id = null , $id_rv = null, $flash = true){
        if($id == null) {
            throw new NotFoundException(__('Le groupement des bons de sortie invalide !'));
        }
        $this->loadModel('OutputSets');
        $outputSetsTable = TableRegistry::get('OutputSets');
        $outputset = $outputSetsTable->get($id, ['contain' => ['Outputs', 'Files']]);
        
        //$outputset = $this->OutputSets->get($idOutputSet, ['contain' => ['Outputs', 'Files']]);
        //debug($outputset->id); die();
        $this->loadModel('Lots');
        $lotTable = TableRegistry::get('Lots');
        $this->loadModel('Stocks');
        $stockTable = TableRegistry::get('Stocks');
        $this->loadModel('Products');
        $movementsController = new MovementsController;
        
        foreach ($outputset->outputs as $key => $value){
            //Update des stocks
            //Et Creation des mouvements selon les lots
            $lot = $this->Lots->get($value['lot_id'], ['contain' => ['Products']]);
            $product_id = $lot['product_id'];
            $product = $lot->product->toArray();
            //Modifier la valeur du stock
            $getStock = $this->Stocks->find('all')->where(['product_id' => $product_id])->toArray();
            $stock_id = $getStock[0]['id'];
            $stock = $stockTable->get($stock_id);
            $stock->amount = $stock->amount - $value['qte'];
            $stock->modified_by = $this->user['Auth']['User']['id'];
            if($stockTable->save($stock)){
                //success
            }else{
                $this->Flash->error(__('Problème au niveau de l\'update des stocks. Merci de réessayer encore.'));
            };
            //ajouter mvt de type livré (2)
            $movementsController->insertMvt('2', $value['qte'], $getStock[0]['amount'], $getStock[0]['amount'] - $value['qte'], $value['lot_id'], $stock_id);
        }
        $outputset->statut = 1;
        $outputset->removalVoucher_id = $id_rv;
        $outputset->modified_by = $this->user['Auth']['User']['id'];
        if($outputSetsTable->save($outputset)){
            //success
        }else{
            $this->Flash->error(__('Problème au niveau de l\'update de statut du groupement des bons de sortie. Merci de réessayer encore.'));
        };
        
        //Si tout les autres outPutSets ont été validés, et tout les lots n'ont pas aucune qte restante => changé statut de dossier
        $fileController = new FilesController;
        if(($fileController->finishedFile($outputset->file_id))&&($this->othersOutputSetsValidate($outputset->file_id, $outputset->id))){
            $fileController->updateStat($outputset->file_id, 2, null, $flash);
        }
        
        
        //return $this->redirect(['controller' => 'Outputsets', 'action' => 'view', $id]);
    }
    
    public function firstValidation($id){
        if($id == null) {
            throw new NotFoundException(__('Le groupement des bons de sortie invalide !'));
        }
        $this->loadModel('OutputSets');
        $outputSetsTable = TableRegistry::get('OutputSets');
        $outputset = $outputSetsTable->get($id);
        $outputset->statut = 3; //valid niveau 1
        $outputset->modified_by = $this->user['Auth']['User']['id'];
        if($outputSetsTable->save($outputset)){
            //success
        }else{
            $this->Flash->error(__('Problème au niveau de l\'update de statut du groupement des bons de sortie. Merci de réessayer encore.'));
        };  
        return $this->redirect(['controller' => 'OutputSets', 'action' => 'view', $id]);
    }
    
    public function othersOutputSetsValidate($idFile, $idOutputSet){
        $this->loadModel('OutputSets');
        $outputSetsTable = TableRegistry::get('OutputSets');
        $outputset = $outputSetsTable->find('list', ['keyField' => 'id', 'valueField' => 'statut'])->InnerJoin(['outputs'], ['outputs.outputSet_id = OutputSets.id'])->where(['OutputSets.file_id' => $idFile, 'OutputSets.id !=' => $idOutputSet])->toArray();
        //$outputset = $outputSetsTable->find('list', ['keyField' => 'id', 'valueField' => 'statut'])->InnerJoin(['outputs'], ['outputs.outputSet_id = outputsets.id'])->where(['outputsets.file_id' => $idFile, 'outputsets.id !=' => $idOutputSet])->toArray();
        //On doit tester si les outputsets sur lesquels on va faire ce test ont des outputs ou ils sonts vides
        /*$outputset1 = $outputSetsTable->find('list', ['keyField' => 'id', 'valueField' => 'statut'])->InnerJoin(['outputs'], ['outputs.outputSet_id = outputsets.id'])
                ->where(['outputsets.file_id' => $idFile, 'outputsets.id !=' => $idOutputSet])->toArray();*/
        //debug($outputset); die();
        /*
        $products = $this->Lots->Products->find('all')->where(['approved' => true])->select(['id', 'name', 'productCode', 'unit', 'zone_id'])->order('name');
        $products->notMatching('Lots', function ($q) use ($idFile) {
            return $q->where(['Lots.file_id' => $idFile]);
        })->toArray();
        */
        if(in_array('0', $outputset))
            return false;
        else
            return true;
    }
    
    public function integrateOutput($id_rv = null){
        //debug($this->request->data);die();
        $removalVouchar = New RemovalvouchersController;
        if($this->request->is('post')){
            //debug($this->request->data); die();
            $carriers = $this->request->data['carriers'];
            if(!isset($this->request->data['checkOutputSets'])){ // Retourner à chooseClient et afficher erreur : choisissez les outputSets
                if((isset($this->request->data['idClient2']))&&($this->request->data['idClient2'] != '')) $id_client2 = $this->request->data['idClient2'];
                else $id_client2 = -1;
                return $this->redirect(['controller' => 'OutputSets', 'action' => 'chooseClient', true, $this->request->data['idClient'], 0, $id_client2, $carriers]);
            }
            
            if((!isset($this->request->data['idClient2']))||($this->request->data['idClient2'] == '')){ // Retourner à chooseClient et afficher erreur : choisissez le client
                return $this->redirect(['controller' => 'OutputSets', 'action' => 'chooseClient', true, $this->request->data['idClient'], 1, -1, $carriers]);
            }
            
            $id_client = $this->request->data['idClient2'];
            $id_entrepositaire = $this->request->data['idClient'];
            $carriers = $this->request->data['carriers'];
            $date = new Date($this->request->data['date_year'].'-'.$this->request->data['date_month'].'-'.$this->request->data['date_day']);
            //debug($date); die();
            //Creation d'un RemovalVouchar et récupérer l'id
            $id_rv = $removalVouchar->add($id_entrepositaire, $id_client, $carriers, $date);
            
            //Mofification sur les stock, les DB ...
            $checkOutputSets = $this->request->data['checkOutputSets'];
            $lenghtArray = count($checkOutputSets);
            foreach ($checkOutputSets as $key => $value){
                if($key != $lenghtArray) $flash = false;
                else $flash = true;
                $this->validerOutputSets($value, $id_rv, $flash);
            }
            //Get data pour l'affichage
            $outPutSetsData = $this->dataOutputSets($checkOutputSets);
            
            return $this->redirect(['action' => 'integrateOutput', $id_rv]);
            //debug($checkOutputSets); die();
            //Ajouter les statuts de dossier
            
        }elseif($id_rv != null){
            $checkOutputSets = $this->getopsByrv($id_rv);
            //die(debug(count($checkOutputSets)));
            $outPutSetsData = $this->dataOutputSets($checkOutputSets);
        }
        
        $id_client = $removalVouchar->getClientById($id_rv);
        $clients = New ClientsController;
        $nameClient = $clients->getNameClientById($id_client);
        
        $allOutputs = $outPutSetsData['allOutputs'];
        unset($outPutSetsData['allOutputs']);
        //debug($outPutSetsData);die();
        $statuts = unserialize(STATS_FILES);
        $arraySatut = unserialize(STATS_OUTPUTSETS);
        $firstelement = current($outPutSetsData);
        $nameEntrepositaire = $firstelement['nameClient'];
        $nameProvider = $firstelement['nameProvider'];
        
        //nom title header
        $nameHeader = 'Groupement des bons de sortie';
        $this->set(compact('outPutSetsData', 'statuts', 'nameHeader', 'arraySatut', 'nameClient', 'nameEntrepositaire', 'nameProvider', 'allOutputs', 'id_rv'));
    }
    
    public function getopsByrv($id_rv) { // get outputsSets by removalVouchar : getOPS_byRV
        $this->loadModel('OutputSets');
        $ids_OPS = $this->OutputSets->find('list' , array('keyField' => 'id', 'valueField' => 'id'))->where(['removalVoucher_id' => $id_rv])->toArray();
        return $ids_OPS;
    }
    
    public function dataOutputSets($checkOutputSets){ // array contient les ids des outputssets
        $outPutSetsData['allOutputs'] = 0;
        $this->loadModel('OutputSets');
        
        foreach ($checkOutputSets as $keyOne => $id) {
            $outputset = $this->OutputSets->get($id, [
                'contain' => ['Files' ,'Outputs']
            ]);

            $outputsetArray = $this->OutputSets->get($id, ['contain' => ['Files' ,'Outputs']])->toArray();

            //nom client
            $clientsController = new ClientsController;
            $nameClient = $clientsController->getNameClientById($outputsetArray['file']['client_id']);
            //nom provider
            $providersController = new ProvidersController;
            $nameProvider = $providersController->getNameProviderById($outputsetArray['file']['provider_id']);        
            //nombre bon de sorite
            $nombreOutputs = count($outputsetArray['outputs']);

            $productsController = new ProductsController;
            if(!empty($outputsetArray['outputs'])){
                $lotsController = new LotsController;
                
                if(isset($arrayNumberLot)) unset($arrayNumberLot);
                foreach($outputsetArray['outputs'] as $key => $value){
                    $idLot = $value['lot_id'];
                    $outputsetArray['outputs'][$key]['number'] = $lotsController->getNumberLotById($idLot);
                    $arrayNumberLot[$idLot]['lot_number'] = $outputsetArray['outputs'][$key]['number'];
                    //name product
                    $idProduct = $lotsController->getIdProductByIdLot($idLot);
                    $outputsetArray['outputs'][$key]['product_name'] = $productsController->getNameProductById($idProduct);
                    $arrayNumberLot[$idLot]['product_name'] = $outputsetArray['outputs'][$key]['product_name'];

                    $arrayNumberLot[$idLot]['product_code'] = $productsController->getCodeProductById($idProduct);
                    $arrayNumberLot[$idLot]['product_ngp'] = $productsController->getNgpcodeProductById($idProduct);
                    
                    $outPutSetsData['allOutputs'] += 1;
                }
            }else{
                $arrayNumberLot = array();
            }

            //S'il y a pas des lots restant pour ce outputSet on peut pas accéder à la page add output
            $outputController = new OutputsController;
            $lots = $outputController->getOtherLotsforOutputSet($id, $outputsetArray['file_id']);
            if(empty($lots)) $pasDeLot = true;
            else{
                $pasDeLot = false;
                foreach ($lots as $key => $value) {
                    $lots[$key]['product_name'] = $productsController->getNameProductById($value['product_id']);
                }
            }

            $outPutSetsData[$keyOne]['arrayNumberLot'] = $arrayNumberLot;
            $outPutSetsData[$keyOne]['lots'] = $lots;
            $outPutSetsData[$keyOne]['nameClient'] = $nameClient;
            $outPutSetsData[$keyOne]['nameProvider'] = $nameProvider;
            $outPutSetsData[$keyOne]['nombreOutputs'] = $nombreOutputs;
            $outPutSetsData[$keyOne]['outputset'] = $outputset; 
            //$outPutSetsData['allOutputs'] += $outPutSetsData['allOutputs'];
            //$allOutputs += $nombreOutputs;
        }
        return $outPutSetsData;
    }
    
    public function traitementAjax($idClient){
        // Get All file in stock by id client and their OutputSets
        $filesController = New FilesController;
        $files = $filesController->getAllFilesByIdClient($idClient);
        
        $providerController = New ProvidersController;
        
        $i = 0;
        $outputsets = array();
        //debug($files);die();
        foreach ($files as $key => $value) {
            if($value['statut'] == 1){ // If file in stock
                
                $nameProvider = $providerController->getNameProviderById($value['provider_id']);
                foreach($value['output_sets'] as $keyOPS => $valueOPS) {
                    if($valueOPS['statut'] == 3){ // Afficher les outputsets validé
                        $i++;
                        $outputsets[$i]['numberOutputs'] = $this->getNumberOutputsByOutputSets($valueOPS['id']);
                        $outputsets[$i]['id'] = $valueOPS['id'];
                        $outputsets[$i]['fileNum'] = $value['number'];
                        $outputsets[$i]['providerName'] = $nameProvider;
                        $outputsets[$i]['date'] = $valueOPS['date'];
                    }
                }
            }
        }
        //debug($outputsets);
        //$clientsController = New ClientsController;
        //$clients = $clientsController->getClientByType(0);
        //debug($clients); die();
        $this->viewBuilder()->autoLayout(false);
        $this->set(compact('outputsets', 'idClient', 'clients'));
    }
    public function getOutputsByOutputsSets($ids_str = null){
        // ids_str = les ids des outputsSets selection par l'utilisateur
        // Cette fonction est un traitement Ajax pour prévesualiser les outputs
        if($ids_str === null){
            $ids_array = null;
            $outPutSetsData = null;
        }else{
            $ids_array = explode(";", $ids_str);
            $outPutSetsData = $this->dataOutputSets($ids_array);
            unset($outPutSetsData['allOutputs']);
        }
               
        //$data = $this->dataOutputSets($ids_array);
        //debug($ids_array);
        //die();
        $this->viewBuilder()->autoLayout(false);
        $this->set(compact('ids_array', 'outPutSetsData'));
    }
    
    private function getNumberOutputsByOutputSets($id){
        $this->loadModel('Outputs');
        $number = $this->Outputs->find('all')->where(array('outputSet_id' => $id))->count();
        return $number;
    }
}
