<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Carriers Controller
 *
 * @property \App\Model\Table\CarriersTable $Carriers
 */
class CarriersController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4, 'selectCarriers' => 2);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['clients'];
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
        $this->paginate = ['contain' => ['Users_CreatedBy', 'Inputs', 'Removalvouchers'], 'maxLimit' => 15];
        $carriers = $this->paginate($this->Carriers);
        $carriers = $carriers->toArray();
        //debug($carriers); die();
        $numberRows = 15;
        $this->set(compact('carriers', 'numberRows'));
        $this->set('_serialize', ['carriers']);
    }

    /**
     * View method
     *
     * @param string|null $id Carrier id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null){
        $carrier = $this->Carriers->get($id, [
            'contain' => ['Inputs', 'Removalvouchers', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        
        //get file num for inputs
        $filesController = New FilesController;
        foreach ($carrier->inputs as $key => $value) {
            $file_id = $value['file_id'];
            $files_nums[$file_id] = $filesController->getNumFileById($file_id);
        }
        
        //get names clients for RV
        $clientsController = New ClientsController;
        foreach ($carrier->removalvouchers as $key => $value) {
            $client_id = $value['client_id'];
            $enterpositaire_id = $value['entrepositaire_id'];
            $clients_names[$client_id] = $clientsController->getNameClientById($client_id);
            $clients_names[$enterpositaire_id] = $clientsController->getNameClientById($enterpositaire_id);
        }
        
        $this->set(compact('files_nums', 'clients_names'));
        $this->set('carrier', $carrier);
        $this->set('_serialize', ['carrier']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carrier = $this->Carriers->newEntity();
        if ($this->request->is('post')) {
            $carrier = $this->Carriers->patchEntity($carrier, $this->request->data);
            $carrier->created_by = $this->user['Auth']['User']['id'];
            $carrier->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Carriers->save($carrier)) {
                $this->Flash->success(__('has been saved.', ['Le transporteur', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le transporteur', '']));
            }
        }
        $this->set(compact('carrier'));
        $this->set('_serialize', ['carrier']);
    }
    
    /**
     * 
     * @return type
     */
    
    public function selectCarriers($idFile = null, $error = 0, $type = 'inputs'){ // Même fonction pour ajouter les transporteurs aux inputs et RV
        //debug($type); die();
        if(($idFile == null) && ($type == 'inputs')) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        
        $carrier = $this->Carriers->newEntity();
        if ($this->request->is('post')){
            //debug($this->request->data); die();
            $type = $this->request->data['typeTrait']; // Recupérer le type à nouveau lors de l'envoie
            
            if(isset($this->request->data['to'])){
                $carriers = $this->request->data['to'];
                if($type == 'inputs'){ // inputs
                    $inputsController = new InputsController;
                    $inputsController->add($idFile, $carriers);
                    return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile]);
                }elseif($type == 'rv'){ // RemovalVouchers
                    return $this->redirect(['controller' => 'OutputSets', 'action' => 'chooseClient', 0, -1, 0, -1, serialize($carriers)]);
                }
            }else{
                $this->redirect(['action' => 'selectCarriers', $idFile, 1, $type]);
            }
        }
        if($error == 1) $errorMsg = "Merci de choisir les transporteurs";
        else $errorMsg = "";
        $page_name = "select_carriers";
        $carriers = $this->Carriers->find('list');
        $inputs = $this->Carriers->Inputs->find('list');
        $this->set(compact('carrier', 'inputs', 'carriers', 'page_name', 'error', 'errorMsg', 'type'));
        $this->set('_serialize', ['carrier']);
    }
    /**
     * Edit method
     *
     * @param string|null $id Carrier id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carrier = $this->Carriers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carrier = $this->Carriers->patchEntity($carrier, $this->request->data);
            $carrier->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Carriers->save($carrier)) {
                $this->Flash->success(__('has been saved.', ['Le transporteur', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le transporteur', '']));
            }
        }
        $this->set(compact('carrier'));
        $this->set('_serialize', ['carrier']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Carrier id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carrier = $this->Carriers->get($id);
        if ($this->Carriers->delete($carrier)) {
            $this->Flash->success(__('The carrier has been deleted.'));
        } else {
            $this->Flash->error(__('The carrier could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
