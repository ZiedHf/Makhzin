<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RequiredDocs Controller
 *
 * @property \App\Model\Table\RequiredDocsTable $RequiredDocs
 */
class RequiredDocsController extends AppController
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
        $permissionLvl = $user['Auth']['User']['required_docs'];
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
        $numberRows = 15;
        $requiredDocs = $this->paginate($this->RequiredDocs);
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        $this->set(compact('requiredDocs', 'types', 'numberRows'));
        $this->set('_serialize', ['requiredDocs']);
    }

    /**
     * View method
     *
     * @param string|null $id Required Doc id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $requiredDoc = $this->RequiredDocs->get($id, [
            'contain' => ['Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        $this->set('requiredDoc', $requiredDoc);
        $this->set(compact('types'));
        $this->set('_serialize', ['requiredDoc']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $requiredDoc = $this->RequiredDocs->newEntity();
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        if ($this->request->is('post')) {
            $requiredDoc = $this->RequiredDocs->patchEntity($requiredDoc, $this->request->data);
            $requiredDoc->created_by = $this->user['Auth']['User']['id'];
            $requiredDoc->modified_by = $this->user['Auth']['User']['id'];
            if ($this->RequiredDocs->save($requiredDoc)) {
                $this->Flash->success(__('has been saved.', ['Le type des documents', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le type des documents', '']));
            }
        }
        $this->set(compact('requiredDoc', 'types'));
        $this->set('_serialize', ['requiredDoc']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Required Doc id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $requiredDoc = $this->RequiredDocs->get($id, [
            'contain' => []
        ]);
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requiredDoc = $this->RequiredDocs->patchEntity($requiredDoc, $this->request->data);
            $requiredDoc->modified_by = $this->user['Auth']['User']['id'];
            if ($this->RequiredDocs->save($requiredDoc)) {
                $this->Flash->success(__('has been saved.', ['Le type des documents', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le type des documents', '']));
            }
        }
        $this->set(compact('requiredDoc', 'types'));
        $this->set('_serialize', ['requiredDoc']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Required Doc id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $requiredDoc = $this->RequiredDocs->get($id);
        if ($this->RequiredDocs->delete($requiredDoc)) {
            $this->Flash->success(__('has been deleted.', ['Le type des documents', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le type des documents', '']));
        }
        return $this->redirect(['action' => 'index']);
    }
}
