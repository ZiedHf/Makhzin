<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Providers Controller
 *
 * @property \App\Model\Table\ProvidersTable $Providers
 */
class ProvidersController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['providers'];
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
        $this->paginate = ['maxLimit' => 15];
        $providers = $this->paginate($this->Providers);
        $numberRows = 15;
        $this->set(compact('providers', 'numberRows'));
        $this->set('_serialize', ['providers']);
    }

    /**
     * View method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $provider = $this->Providers->get($id, [
            'contain' => ['Files', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        $clientsController = new ClientsController;
        foreach ($provider->files as $key => $value) {
            $id_client = $value['client_id'];
            $client_name[$id_client] = $clientsController->getNameClientById($id_client);
        }
        $statuts = unserialize(STATS_FILES);
        $this->set(compact('statuts', 'client_name'));
        $this->set('provider', $provider);
        $this->set('_serialize', ['provider']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $provider = $this->Providers->newEntity();
        if ($this->request->is('post')) {
            $urlStr = '';
            if(!empty($this->request->data['website'])){
                $urlStr = $this->request->data['website'];
                $parsed = parse_url($urlStr);
                if (empty($parsed['scheme'])) {
                    $urlStr = 'http://' . ltrim($urlStr, '/');
                }
            }
            $this->request->data['website'] = $urlStr;
            //debug($parsed); die();
            $provider = $this->Providers->patchEntity($provider, $this->request->data);
            $provider->created_by = $this->user['Auth']['User']['id'];
            $provider->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('has been saved.', ['Le fournisseur', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le fournisseur', '']));
            }
        }
        $this->set(compact('provider'));
        $this->set('_serialize', ['provider']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){
        $provider = $this->Providers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provider = $this->Providers->patchEntity($provider, $this->request->data);
            $provider->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Providers->save($provider)) {
                $this->Flash->success(__('has been saved.', ['Le fournisseur', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le fournisseur', '']));
            }
        }
        $this->set(compact('provider'));
        $this->set('_serialize', ['provider']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Provider id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provider = $this->Providers->get($id);
        if ($this->Providers->delete($provider)) {
            $this->Flash->success(__('has been deleted.', ['Le fournisseur', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le fournisseur', '']));
        }
        return $this->redirect(['action' => 'index']);
    }*/
    //get name provider by id
    public function getNameProviderById($idProvider = null){
        if($idProvider === null) {
            //throw new NotFoundException(__('Provider invalide !'));
            return '';
        }
        $provider = $this->Providers->find('all')->where(['id' => $idProvider])->toArray();
        $providerName = $provider['0']['name'];
        return $providerName;
    }
}
