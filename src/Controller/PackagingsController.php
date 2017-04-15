<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Packagings Controller
 *
 * @property \App\Model\Table\PackagingsTable $Packagings
 */
class PackagingsController extends AppController
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
        $permissionLvl = $user['Auth']['User']['products'];
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
        $this->paginate = [
            'contain' => ['Users_CreatedBy'],
            'order' => [
                'name' => 'asc'
            ],
            'maxLimit' => 15
        ];
        $packagings = $this->paginate($this->Packagings);
        $numberRows = 15;
        
        $this->set(compact('packagings', 'numberRows'));
        $this->set('_serialize', ['packagings']);
    }

    /**
     * View method
     *
     * @param string|null $id Packaging id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $packaging = $this->Packagings->get($id, [
            'contain' => ['Users_CreatedBy', 'Users_ModifiedBy']
        ]);

        $this->set('packaging', $packaging);
        $this->set('_serialize', ['packaging']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $packaging = $this->Packagings->newEntity();
        if ($this->request->is('post')) {
            $packaging = $this->Packagings->patchEntity($packaging, $this->request->data);
            $packaging->created_by = $this->user['Auth']['User']['id'];
            $packaging->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Packagings->save($packaging)) {
                $this->Flash->success(__('has been saved.', ['L\'emballage', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['L\'emballage', '']));
            }
        }
        $this->set(compact('packaging'));
        $this->set('_serialize', ['packaging']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Packaging id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $packaging = $this->Packagings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $packaging = $this->Packagings->patchEntity($packaging, $this->request->data);
            $packaging->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Packagings->save($packaging)) {
                $this->Flash->success(__('has been saved.', ['L\'emballage', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['L\'emballage', '']));
            }
        }
        $this->set(compact('packaging'));
        $this->set('_serialize', ['packaging']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Packaging id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $packaging = $this->Packagings->get($id);
        if ($this->Packagings->delete($packaging)) {
            $this->Flash->success(__('The packaging has been deleted.'));
        } else {
            $this->Flash->error(__('The packaging could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
