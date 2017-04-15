<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Productstates Controller
 *
 * @property \App\Model\Table\ProductstatesTable $Productstates
 */
class ProductstatesController extends AppController
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
        $productstates = $this->paginate($this->Productstates);
        $numberRows = 15;
        
        $this->set(compact('productstates', 'numberRows'));
        $this->set('_serialize', ['productstates']);
    }

    /**
     * View method
     *
     * @param string|null $id Productstate id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productstate = $this->Productstates->get($id, [
            'contain' => ['Users_CreatedBy', 'Users_ModifiedBy']
        ]);

        $this->set('productstate', $productstate);
        $this->set('_serialize', ['productstate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productstate = $this->Productstates->newEntity();
        if ($this->request->is('post')) {
            $productstate = $this->Productstates->patchEntity($productstate, $this->request->data);
            $productstate->created_by = $this->user['Auth']['User']['id'];
            $productstate->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Productstates->save($productstate)) {
                $this->Flash->success(__('has been saved.', ['L\'état', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['L\'état', '']));
            }
        }
        $this->set(compact('productstate'));
        $this->set('_serialize', ['productstate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Productstate id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productstate = $this->Productstates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productstate = $this->Productstates->patchEntity($productstate, $this->request->data);
            $productstate->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Productstates->save($productstate)) {
                $this->Flash->success(__('has been saved.', ['L\'état', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['L\'état', '']));
            }
        }
        $this->set(compact('productstate'));
        $this->set('_serialize', ['productstate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Productstate id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productstate = $this->Productstates->get($id);
        if ($this->Productstates->delete($productstate)) {
            $this->Flash->success(__('The productstate has been deleted.'));
        } else {
            $this->Flash->error(__('The productstate could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
