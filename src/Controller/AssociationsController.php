<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Associations Controller
 *
 * @property \App\Model\Table\AssociationsTable $Associations
 */
class AssociationsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories', 'Products']
        ];
        $associations = $this->paginate($this->Associations);

        $this->set(compact('associations'));
        $this->set('_serialize', ['associations']);
    }

    /**
     * View method
     *
     * @param string|null $id Association id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $association = $this->Associations->get($id, [
            'contain' => ['Categories', 'Products']
        ]);

        $this->set('association', $association);
        $this->set('_serialize', ['association']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $association = $this->Associations->newEntity();
        if ($this->request->is('post')) {
            $association = $this->Associations->patchEntity($association, $this->request->data);
            if ($this->Associations->save($association)) {
                $this->Flash->success(__('The association has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The association could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Associations->Categories->find('list', ['limit' => 200]);
        $products = $this->Associations->Products->find('list', ['limit' => 200]);
        $this->set(compact('association', 'categories', 'products'));
        $this->set('_serialize', ['association']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Association id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $association = $this->Associations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $association = $this->Associations->patchEntity($association, $this->request->data);
            if ($this->Associations->save($association)) {
                $this->Flash->success(__('The association has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The association could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Associations->Categories->find('list', ['limit' => 200]);
        $products = $this->Associations->Products->find('list', ['limit' => 200]);
        $this->set(compact('association', 'categories', 'products'));
        $this->set('_serialize', ['association']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Association id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $association = $this->Associations->get($id);
        if ($this->Associations->delete($association)) {
            $this->Flash->success(__('The association has been deleted.'));
        } else {
            $this->Flash->error(__('The association could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function getAssoc_ByProduct_Cat($idProduct, $idCat){
        $this->loadModel('Associations');
        $association = $this->Associations->find('all')->where(['And' => ['category_id' => $idCat, 'product_id' => $idProduct]])->toArray();
        return $association;
    }
    
}
