<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AssocCarriersRv Controller
 *
 * @property \App\Model\Table\AssocCarriersRvTable $AssocCarriersRv
 */
class AssocCarriersRvController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $assocCarriersRv = $this->paginate($this->AssocCarriersRv);

        $this->set(compact('assocCarriersRv'));
        $this->set('_serialize', ['assocCarriersRv']);
    }

    /**
     * View method
     *
     * @param string|null $id Assoc Carriers Rv id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $assocCarriersRv = $this->AssocCarriersRv->get($id, [
            'contain' => []
        ]);

        $this->set('assocCarriersRv', $assocCarriersRv);
        $this->set('_serialize', ['assocCarriersRv']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $assocCarriersRv = $this->AssocCarriersRv->newEntity();
        if ($this->request->is('post')) {
            $assocCarriersRv = $this->AssocCarriersRv->patchEntity($assocCarriersRv, $this->request->data);
            if ($this->AssocCarriersRv->save($assocCarriersRv)) {
                $this->Flash->success(__('The assoc carriers rv has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The assoc carriers rv could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('assocCarriersRv'));
        $this->set('_serialize', ['assocCarriersRv']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Assoc Carriers Rv id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $assocCarriersRv = $this->AssocCarriersRv->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $assocCarriersRv = $this->AssocCarriersRv->patchEntity($assocCarriersRv, $this->request->data);
            if ($this->AssocCarriersRv->save($assocCarriersRv)) {
                $this->Flash->success(__('The assoc carriers rv has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The assoc carriers rv could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('assocCarriersRv'));
        $this->set('_serialize', ['assocCarriersRv']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Assoc Carriers Rv id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $assocCarriersRv = $this->AssocCarriersRv->get($id);
        if ($this->AssocCarriersRv->delete($assocCarriersRv)) {
            $this->Flash->success(__('The assoc carriers rv has been deleted.'));
        } else {
            $this->Flash->error(__('The assoc carriers rv could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
