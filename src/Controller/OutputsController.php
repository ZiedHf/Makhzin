<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Outputs Controller
 *
 * @property \App\Model\Table\OutputsTable $Outputs
 */
class OutputsController extends AppController
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
        $permissionLvl = $user['Auth']['User']['outputs'];
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
            'contain' => ['Lots', 'Files']
        ];
        $outputs = $this->paginate($this->Outputs);

        $this->set(compact('outputs'));
        $this->set('_serialize', ['outputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $output = $this->Outputs->get($id, [
            'contain' => ['Lots', 'Files', 'OutputSets']
        ]);
        
        $this->set('output', $output);
        $this->set('_serialize', ['output']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idFile = null, $idOutputset = null)
    {
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        }
        if($idOutputset == null) {
            throw new NotFoundException(__('Groupement des bons de sortie invalide !'));
        }
        
        $lots = $this->getOtherLotsforOutputSet($idOutputset, $idFile);
        
        if(empty($lots)) throw new NotFoundException(__('Pas de lot à ajouter !'));
        
        $output = $this->Outputs->newEntity();
        if (($this->request->is('post'))&&($this->request->data['qte'] <= $this->request->data['maxQte'])) {
            //debug($this->request->data);die();
            //
            $output = $this->Outputs->patchEntity($output, $this->request->data);
            //debug($this->request->data);die();
            //$output->date = 
            $output->created_by = $this->user['Auth']['User']['id'];
            $output->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Outputs->save($output)) {
                $lotsController = new LotsController;
                $lotsController->updateRemainedQte($output['lot_id'], 'substract', $output['qte']);
                $this->Flash->success(__('has been saved.', ['Le bon de sortie', '']));
                return $this->redirect(['controller' => 'OutputSets', 'action' => 'view', $idOutputset]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le bon de sortie', '']));
            }
        }
        
        //$lots = $this->getOtherLotsforOutputSet($idOutputset, $idFile);
        //debug($lots); die();
        //Get name product
        $productsController = new ProductsController;
        foreach ($lots as $key => $value) {
            $lots[$key]['product_name'] = $productsController->getNameProductById($value['product_id']);
        }
        //debug($lots); die();
        //$files = $this->Outputs->Files->find('list');
        $file = $this->Outputs->Files->get($idFile)->toArray();
        $outputset = $this->Outputs->OutputSets->get($idOutputset)->toArray();
        $this->set(compact('output', 'lots', 'file', 'idFile', 'outputset'));
        $this->set('_serialize', ['output']);
    }
    
    //get les lots qui n'ont pas un output pour ce outputSet
    function getOtherLotsforOutputSet($idOutputset, $idFile){
        $outputs_idLot = $this->Outputs->find('list', ['keyField' => 'id', 'valueField' => 'lot_id'])->where(['outputSet_id' => $idOutputset])->toArray();
        if(!empty($outputs_idLot)) $condition = array('id NOT IN' => $outputs_idLot, 'file_id' => $idFile, 'remainedQte >' => 0);
        else $condition = array('file_id' => $idFile, 'remainedQte >' => 0);
        $lots = $this->Outputs->Lots->find('all')
                                    ->select(['id', 'number', 'expectedQte', 'actualQte', 'remainedQte', 'product_id'])
                                    ->where($condition)
                                    ->toArray();
        return $lots;
    }

    /**
     * Edit method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $output = $this->Outputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $output = $this->Outputs->patchEntity($output, $this->request->data);
            $output->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Outputs->save($output)) {
                $this->Flash->success(__('has been saved.', ['Le bon de sortie', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le bon de sortie', '']));
            }
        }
        $lots = $this->Outputs->Lots->find('list', ['limit' => 200]);
        $files = $this->Outputs->Files->find('list', ['limit' => 200]);
        $this->set(compact('output', 'lots', 'files'));
        $this->set('_serialize', ['output']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Output id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $output = $this->Outputs->get($id);
        $lot_id = $output->lot_id;
        $qte = $output->qte;
        $outputSet_id = $output->outputSet_id;;
        if ($this->Outputs->delete($output)) {
            $lotsController = new LotsController;
            $lotsController->updateRemainedQte($lot_id, 'add', $qte);
            $this->Flash->success(__('has been deleted.', ['Le bon de sortie', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le bon de sortie', '']));
        }
        return $this->redirect(['controller' => 'OutputSets', 'action' => 'view', $outputSet_id]);
    }
}
