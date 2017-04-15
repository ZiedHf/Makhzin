<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\Network\Exception\NotFoundException;

/**
 * Movements Controller
 *
 * @property \App\Model\Table\MovementsTable $Movements
 */
class MovementsController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'add' => 2, 'insertMvt' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['movements'];
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
            'contain' => ['Stocks', 'Lots'],
            'maxLimit' => 15,
            'sortWhitelist' => ['type', 'qte', 'before_qte', 'after_qte', 'date', 'Lots.number', 'stock_id'],
            'order' => [
                'date' => 'desc'
            ]
        ];
        $this->loadModel('Products');
        $products = $this->Products->find('list')->toArray();
        $movements = $this->paginate($this->Movements);
        $numberRows = 15;
        $this->set(compact('movements', 'numberRows', 'products'));
        $this->set('_serialize', ['movements']);
    }

    /**
     * View method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $movement = $this->Movements->get($id, [
            'contain' => ['Stocks', 'Lots']
        ]);

        $this->set('movement', $movement);
        $this->set('_serialize', ['movement']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $movement = $this->Movements->newEntity();
        if ($this->request->is('post')) {
            $movement = $this->Movements->patchEntity($movement, $this->request->data);
            if ($this->Movements->save($movement)) {
                $this->Flash->success(__('The movement has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movement could not be saved. Please, try again.'));
            }
        }
        $stocks = $this->Movements->Stocks->find('list', ['limit' => 200]);
        $lots = $this->Movements->Lots->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'stocks', 'lots'));
        $this->set('_serialize', ['movement']);
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $movement = $this->Movements->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $movement = $this->Movements->patchEntity($movement, $this->request->data);
            if ($this->Movements->save($movement)) {
                $this->Flash->success(__('The movement has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The movement could not be saved. Please, try again.'));
            }
        }
        $stocks = $this->Movements->Stocks->find('list', ['limit' => 200]);
        $lots = $this->Movements->Lots->find('list', ['limit' => 200]);
        $this->set(compact('movement', 'stocks', 'lots'));
        $this->set('_serialize', ['movement']);
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Movement id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $movement = $this->Movements->get($id);
        if ($this->Movements->delete($movement)) {
            $this->Flash->success(__('The movement has been deleted.'));
        } else {
            $this->Flash->error(__('The movement could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }*/
    
    public function insertMvt($type = null, $qte = null, $before_qte = null, $after_qte = null, $lot_id = null, $stock_id = null, $date = null){
        $this->loadModel('Movements');
        $mvtTable = TableRegistry::get('Movements');
        if($date === null)
            $date = Time::now();
        $mvt = $mvtTable->newEntity();
        $mvt->date = $date;
        $mvt->type = $type;
        $mvt->qte = $qte;
        $mvt->before_qte = $before_qte;
        $mvt->after_qte = $after_qte;
        $mvt->stock_id = $stock_id;
        $mvt->lot_id = $lot_id;
        $mvt->created_by = $this->user['Auth']['User']['id'];
        if($mvtTable->save($mvt)){
            return true;
        }else{
            $this->Flash->error(__('Problème au niveau de création des mouvements. Merci de réessayer encore.'));
            return false;
        };
    }
}
