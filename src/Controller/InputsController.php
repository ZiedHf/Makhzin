<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\Network\Exception\NotFoundException;
use Cake\Event\Event;
//use Cake\Core\Configure;
/**
 * Inputs Controller
 *
 * @property \App\Model\Table\InputsTable $Inputs
 */

class InputsController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'printInput' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['inputs'];
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
   

    public function index()
    {
        $inputs = $this->paginate($this->Inputs);

        $this->set(compact('inputs'));
        $this->set('_serialize', ['inputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->traitview($id);
    }
    
    public function printInput($id = null){
        //$this->viewBuilder()->layout('');
        $this->viewBuilder()->layout('Print');
        //$this->autoRender = false ;
        //$this->autoLayout = false; 
        $this->traitview($id);
    }
    function traitview($id){
        $input = $this->Inputs->get($id, [
            'contain' => ['Files', 'Lots']
        ]);
        //debug($input->carriers); die();
        $file = $this->Inputs->Files->get($input->file->id, [
            'contain' => ['Lots', 'Documents', 'Clients', 'Providers']
        ])->toArray();
        //Ajouter les noms des produits
        $productsController = new ProductsController;
        foreach ($file['lots'] as $key => $value){
            //Nom Produit
            $nameProduct = $productsController->getNameProductById($value['product_id']);
            $file['lots'][$key]['nameProduct'] = $nameProduct;
            //table name product by id lot
            $idLot = $value['id'];
            $nameProductArray[$idLot] = $nameProduct;
            //Code Produit
            $codeProduct = $productsController->getCodeProductById($value['product_id']);
            $file['lots'][$key]['codeProduct'] = $codeProduct;
            //table code product by id lot
            $codeProductArray[$idLot] = $codeProduct;
            //NgpcCode Produit
            $ngpcodeProduct = $productsController->getNgpcodeProductById($value['product_id']);
            $file['lots'][$key]['ngpcodeProduct'] = $ngpcodeProduct;
            //table code product by id lot
            $ngpcodeProductArray[$idLot] = $ngpcodeProduct;
        }
        //Ajouter les statuts
        $statuts = unserialize(STATS_FILES);
        //Types des version
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        //Nombre des lots
        $nombreLots = count($file['lots']);
        //debug($nombreLots);die();
        //
        $nameHeader = 'Bon d\'entrée';
        $this->set(compact('nameProductArray', 'codeProductArray', 'ngpcodeProductArray', 'statuts', 'nombreLots', 'file', 'types', 'nameHeader'));
        $this->set('input', $input);
        $this->set('_serialize', ['input']);
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idFile = null, $carriers = null){
        //debug($carriers); die();
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        if($carriers == null) {
            throw new NotFoundException(__('Liste des transporteurs vide !'));
        }
        
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile, [
            'contain' => ['Lots', 'Inputs']
            ]);
        //si un seul lot a un actualQte = -1 le input ne sera pas généré
        
        foreach ($file->lots as $key => $lot) {
            if($lot['actualQte'] == -1)
                return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile, 'error']);
        }
        
        if(!(isset($file->lots[0]['id'])))
            throw new NotFoundException(__('Pas de lots !'));
        if(isset($file->input['id']))
            throw new NotFoundException(__('Un bon d\'entré est déja disponible !'));
        if($file->statut != 0)
            throw new NotFoundException(__('Ce dossier n\'est pas en cours !'));
        //debug();die();
        //Changer le statut à 1 (En stock)
        $ControllerFile = new FilesController;
        $ControllerFile->updateStat($file->id, 1);

        //debug($file->input['id']);//die($file->lot[0]['id']);
        //die();
        $input = $this->Inputs->newEntity();
        $inputToAdd['file_id'] = $idFile;
        $inputToAdd['date'] = Time::now();
        //die();
        //if ($this->request->is('post')) {
        $inputToAdd['carriers']['_ids'] = $carriers;
        //debug($carriers); die();
        $input = $this->Inputs->patchEntity($input, $inputToAdd);
        $input->created_by = $this->user['Auth']['User']['id'];
        $input->modified_by = $this->user['Auth']['User']['id'];
        if ($result = $this->Inputs->save($input)) {
            $this->Flash->success(__('has been saved.', ['Le bon d\'entrée', '']));
            $id_input = $result->id;
            $ControllerLots = new LotsController;
            $ControllerLots->updateInputIdLots($file->id, $id_input);
            
            //Ajouter la relation entre les transporteurs et le nouveau input
            
        } else {
            $this->Flash->error(__('could not be saved. Please, try again.', ['Le bon d\'entrée', '']));
        }
        
        //Update du champ input_id dans Files
        
        $file->input_id = $id_input;
        $file->modified_by = $this->user['Auth']['User']['id'];
        if ($fileTable->save($file)){
            // The foreign key value was set automatically.
            //return $this->redirect(['action' => 'view', $id_input]);
        }else{
            $this->Flash->error(__('Problème au niveau de l\'update de Dossier. Merci de réessayer encore.'));
        }
        
        //Update des stocks
        //Et Creation des mouvements selon les lots
        $this->loadModel('Stocks');
        $stockTable = TableRegistry::get('Stocks');
        $this->loadModel('Products');
        //$this->loadModel('Movements');
        $movementsController = new MovementsController;
        $lotsController = new LotsController;
        //$mvtTable = TableRegistry::get('Movements');
        foreach($file->lots as $lot){
            $product_id = $lot['product_id'];
            $product = $this->Products->get($product_id)->toArray();
            $getStock = $this->Stocks->find('all')->where(['product_id' => $product_id])->toArray();
            $stock_id = $getStock[0]['id'];
            $stock = $stockTable->get($stock_id);
            $stock->amount = $stock->amount + $lot['actualQte'];
            $stock->modified_by = $this->user['Auth']['User']['id'];
            if($stockTable->save($stock)){
                //success
            }else{
                $this->Flash->error(__('Problème au niveau de l\'update des stocks. Merci de réessayer encore.'));
            };
            //Ajouter mouvement $type = 0 'entrant'
            $movementsController->insertMvt('0', $lot['actualQte'], $getStock[0]['amount'], $getStock[0]['amount'] + $lot['actualQte'], $lot['id'], $stock_id);
            //modifier remainedQte des lots
            $lotsController->updateRemainedQte($lot['id'], 'add', $lot['actualQte']);
        }
        return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $input = $this->Inputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $input = $this->Inputs->patchEntity($input, $this->request->data);
            $input->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Inputs->save($input)) {
                $this->Flash->success(__('has been saved.', ['Le bon d\'entrée', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le bon d\'entrée', '']));
            }
        }
        $this->set(compact('input'));
        $this->set('_serialize', ['input']);
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Input id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $input = $this->Inputs->get($id);
        //debug($input->file_id); die();
        $idFile = $input->file_id;
        $this->annulerInput($idFile);
        
        if ($this->Inputs->delete($input)) {
            $this->Flash->success(__('has beed deleted.', ['Le bon d\'entrée', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le bon d\'entrée', '']));
        }
        
        return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile]);
        //return $this->redirect(['action' => 'index']);
    }*/
    
    public function annulerInput($idFile){
        $ControllerFile = new FilesController;
        //Update statut à 0 Entrant et desactiver le redirection avec le 3eme attr
        $updatestat = $ControllerFile->updateStat($idFile, 0, 1);
        //Update des stocks
        //Et Creation des mouvements selon les lots
        $fileTable = TableRegistry::get('Files');
        $file = $fileTable->get($idFile, [
            'contain' => ['Lots', 'Inputs']
            ]);
        $this->loadModel('Stocks');
        $stockTable = TableRegistry::get('Stocks');
        $this->loadModel('Products');
        $this->loadModel('Movements');
        $mvtTable = TableRegistry::get('Movements');
        foreach($file->lots as $lot){
            $product_id = $lot['product_id'];
            $product = $this->Products->get($product_id)->toArray();
            $getStock = $this->Stocks->find('all')->where(['product_id' => $product_id])->toArray();
            $stock_id = $getStock[0]['id'];
            $stock = $stockTable->get($stock_id);
            $stock->amount = $stock->amount - $lot['actualQte'];
            $stock->modified_by = $this->user['Auth']['User']['id'];
            if($stockTable->save($stock)){
                //success
            }else{
                $this->Flash->error(__('Problème au niveau de l\'update des stocks. Merci de réessayer encore.'));
            };
            
            $getMvt = $this->Movements->find('all')->where(['lot_id' => $lot['id']])->toArray();
            $mvtId = $getMvt[0]['id'];
            $mvt = $mvtTable->get($mvtId);
            if($mvtTable->delete($mvt)){
                //success
                $test = 'ok';
            }else{
                $this->Flash->error(__('Problème au niveau de création des mouvements. Merci de réessayer encore.'));
            }
        }
    }
}
