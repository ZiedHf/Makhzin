<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 */
class ClientsController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4);
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
    public function index($entrepositaire = -1){
        $this->paginate = [
            'maxLimit' => 15
        ];
        $numberRows = 15;
        if($entrepositaire === -1){
            $clients = $this->paginate($this->Clients);
        }else{
            $clients = $this->paginate($this->Clients->find('all')->where(['entrepositaire' => $entrepositaire]));
        }
        
        $this->set(compact('clients', 'numberRows'));
        $this->set('_serialize', ['clients']);
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => ['Files', 'Lots', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        
        $this->loadModel('Products');
        $filesList = $this->Clients->Files->find('list', ['keyField' => 'id', 'valueField' => 'number'])->order('id')->toArray();
        $productsList = $this->Products->find('list')->order('id')->toArray();
        //debug($filesList);die();
        $providersController = new ProvidersController;
        foreach ($client->files as $key => $value) {
            $file_id = $value['id'];
            $nameprovider[$file_id] = $providersController->getNameProviderById($value['provider_id']);
        }
        $this->set(compact('filesList', 'productsList', 'nameprovider'));
        $this->set('client', $client);
        $this->set('_serialize', ['client']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $client = $this->Clients->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->data); die();
            $client = $this->Clients->patchEntity($client, $this->request->data);
            $client->created_by = $this->user['Auth']['User']['id'];
            $client->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('has been saved.', ['Le client', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le client', '']));
            }
        }
        $this->set(compact('client'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $client = $this->Clients->get($id, [
            'contain' => []
        ]);
        //debug($client); die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!isset($this->request->data['entrepositaire']))
                $this->request->data['entrepositaire'] = 0;
            $client = $this->Clients->patchEntity($client, $this->request->data);
            $client->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('has been saved.', ['Le client', '']));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le client', '']));
            }
        }
        $this->set(compact('client'));
        $this->set('_serialize', ['client']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('has been deleted.', ['Le client', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le client', '']));
        }
        return $this->redirect(['action' => 'index']);
    }*/
    //get name client by id
    public function getNameClientById($idClient = null){
        if($idClient === null) {
            //throw new NotFoundException(__('Client invalide !'));
            return '';
        }
        $client = $this->Clients->find('all')->where(['id' => $idClient])->toArray();
        $clientName = $client['0']['name'];
        return $clientName;
    }
    
    public function getAllClient() {
        $client = $this->Clients->find('all')->toArray();
        return $client;
    }
    public function getClientByType($type) {
        $client = $this->Clients->find('all')->where(['entrepositaire' => $type])->toArray();
        return $client;
    }
}
