<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Zones Controller
 *
 * @property \App\Model\Table\ZonesTable $Zones
 */
class ZonesController extends AppController
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
        $permissionLvl = $user['Auth']['User']['zones'];
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
            'maxLimit' => 15
        ];
        $zones = $this->paginate($this->Zones);
        $numberRows = 15;

        $this->set(compact('zones', 'numberRows'));
        $this->set('_serialize', ['zones']);
    }

    /**
     * View method
     *
     * @param string|null $id Zone id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $zone = $this->Zones->get($id, [
            'contain' => ['Lots', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        $filesController = new FilesController;
        $productsController = new ProductsController;
        $clientController = new ClientsController;
        foreach ($zone->lots as $key => $value) {
            $idLot = $value['id'];
            $lotsInfo[$idLot]['fileNum'] = $filesController->getNumFileById($value['file_id']);
            $lotsInfo[$idLot]['productName'] = $productsController->getNameProductById($value['product_id']);
            $lotsInfo[$idLot]['clientName'] = $clientController->getNameClientById($value['client_id']);
        }
        $this->set(compact('lotsInfo'));
        $this->set('zone', $zone);
        $this->set('_serialize', ['zone']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $zone = $this->Zones->newEntity();
        if ($this->request->is('post')) {
            $zone = $this->Zones->patchEntity($zone, $this->request->data);
            $zone->created_by = $this->user['Auth']['User']['id'];
            $zone->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Zones->save($zone)) {
                $this->Flash->success(__('has been saved.', ['La zone', 'e']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['La zone', 'e']));
            }
        }
        $this->set(compact('zone'));
        $this->set('_serialize', ['zone']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Zone id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $zone = $this->Zones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $zone = $this->Zones->patchEntity($zone, $this->request->data);
            $zone->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Zones->save($zone)) {
                $this->Flash->success(__('has been saved.', ['La zone', 'e']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['La zone', 'e']));
            }
        }
        $this->set(compact('zone'));
        $this->set('_serialize', ['zone']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Zone id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $zone = $this->Zones->get($id);
        if ($this->Zones->delete($zone)) {
            $this->Flash->success(__('has been deleted.', ['La zone', 'e']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['La zone', 'e']));
        }
        return $this->redirect(['action' => 'index']);
    }
}
