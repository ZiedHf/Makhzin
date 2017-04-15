<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Stocks Controller
 *
 * @property \App\Model\Table\StocksTable $Stocks
 */
class StocksController extends AppController
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
        $permissionLvl = $user['Auth']['User']['stocks'];
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
    /*public function index()
    {
        $this->paginate = [
            'maxLimit' => 15
        ];
        $numberRows = 15;
        $stocks = $this->paginate($this->Stocks);

        $this->set(compact('stocks', 'numberRows'));
        $this->set('_serialize', ['stocks']);
    }*/

    /**
     * View method
     *
     * @param string|null $id Stock id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $stock = $this->Stocks->get($id, [
            'contain' => ['Products', 'Movements']
        ]);

        $this->set('stock', $stock);
        $this->set('_serialize', ['stock']);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $stock = $this->Stocks->newEntity();
        if ($this->request->is('post')) {
            $stock = $this->Stocks->patchEntity($stock, $this->request->data);
            $stock->created_by = $this->user['Auth']['User']['id'];
            if ($this->Stocks->save($stock)) {
                $this->Flash->success(__('The stock has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The stock could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('stock'));
        $this->set('_serialize', ['stock']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Stock id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $stock = $this->Stocks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stock = $this->Stocks->patchEntity($stock, $this->request->data);
            $stock->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Stocks->save($stock)) {
                $this->Flash->success(__('The stock has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The stock could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('stock'));
        $this->set('_serialize', ['stock']);
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Stock id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stock = $this->Stocks->get($id);
        if ($this->Stocks->delete($stock)) {
            $this->Flash->success(__('The stock has been deleted.'));
        } else {
            $this->Flash->error(__('The stock could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }*/
}
