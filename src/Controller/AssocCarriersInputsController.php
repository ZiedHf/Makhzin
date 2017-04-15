<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AssocCarriersInputs Controller
 *
 * @property \App\Model\Table\AssocCarriersInputsTable $AssocCarriersInputs
 */
class AssocCarriersInputsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $assocCarriersInputs = $this->paginate($this->AssocCarriersInputs);

        $this->set(compact('assocCarriersInputs'));
        $this->set('_serialize', ['assocCarriersInputs']);
    }

    /**
     * View method
     *
     * @param string|null $id Assoc Carriers Input id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assocCarriersInput = $this->AssocCarriersInputs->get($id, [
            'contain' => []
        ]);

        $this->set('assocCarriersInput', $assocCarriersInput);
        $this->set('_serialize', ['assocCarriersInput']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assocCarriersInput = $this->AssocCarriersInputs->newEntity();
        if ($this->request->is('post')) {
            $assocCarriersInput = $this->AssocCarriersInputs->patchEntity($assocCarriersInput, $this->request->data);
            if ($this->AssocCarriersInputs->save($assocCarriersInput)) {
                $this->Flash->success(__('The assoc carriers input has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The assoc carriers input could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('assocCarriersInput'));
        $this->set('_serialize', ['assocCarriersInput']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Assoc Carriers Input id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assocCarriersInput = $this->AssocCarriersInputs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assocCarriersInput = $this->AssocCarriersInputs->patchEntity($assocCarriersInput, $this->request->data);
            if ($this->AssocCarriersInputs->save($assocCarriersInput)) {
                $this->Flash->success(__('The assoc carriers input has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The assoc carriers input could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('assocCarriersInput'));
        $this->set('_serialize', ['assocCarriersInput']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Assoc Carriers Input id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assocCarriersInput = $this->AssocCarriersInputs->get($id);
        if ($this->AssocCarriersInputs->delete($assocCarriersInput)) {
            $this->Flash->success(__('The assoc carriers input has been deleted.'));
        } else {
            $this->Flash->error(__('The assoc carriers input could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
