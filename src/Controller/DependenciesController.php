<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Dependencies Controller
 *
 * @property \App\Model\Table\DependenciesTable $Dependencies
 */
class DependenciesController extends AppController
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
        $permissionLvl = $user['Auth']['User']['dependencies'];
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
            'contain' => ['Categories']
        ];
        $dependencies = $this->paginate($this->Dependencies);
        $categories = $this->Dependencies->Categories->find('list', ['limit' => 200])->toArray();

        $this->set(compact('dependencies', 'categories'));
        $this->set('_serialize', ['dependencies']);
    }

    /**
     * View method
     *
     * @param string|null $id Dependency id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dependency = $this->Dependencies->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('dependency', $dependency);
        $this->set('_serialize', ['dependency']);
    }
    /**
     * Fonction pour eliminer les categories qui ont deja une depandance
     */
    private function CheckCatExist($id){
        if(!isset($id)) return false;
        $dependencies = $this->Dependencies->find('all')->toArray();
        //unset($dependencies[0]);
        foreach ($dependencies as $key => $value) {
            if($value['id_category1'] == $id){
                $categoriesExist[] = $value['id_category2'];
            }elseif($value['id_category2'] == $id){
                $categoriesExist[] = $value['id_category1'];
            }
        }
        if(isset($categoriesExist))
            return $categoriesExist;
        else return false;
        
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    
    public function add($id = null)
    {
        if($id == null) {
            throw new NotFoundException(__('Categorie invalide !'));
        }
        $category = $this->Dependencies->Categories->get($id)->toArray();
        //debug($category); die();
        $dependency = $this->Dependencies->newEntity();
        
        $categoriesExist = $this->CheckCatExist($id);
        $categoriesExist[] = $id;
        
        if ($this->request->is('post')) {
            $dependency = $this->Dependencies->patchEntity($dependency, $this->request->data);
            $dependency->created_by = $this->user['Auth']['User']['id'];
            $thisCat = $this->request->data['id_category1'];
            if($thisCat == $this->request->data['id_category2']){
                $this->Flash->error(__('could not be saved. Please, try again.', ['La dépendance', 'e']));
            }else{
                if ($this->Dependencies->save($dependency)) {
                    $this->Flash->success(__('has been saved.', ['La dépendance', 'e']));
                    return $this->redirect(['controller' => 'categories', 'action' => 'view', $thisCat]);
                } else {
                    $this->Flash->error(__('could not be saved. Please, try again.', ['La dépendance', 'e']));
                }
            }
        }
        $categories = $this->Dependencies->Categories->find('list', ['limit' => 200])->where(['id NOT IN' => $categoriesExist])->ToArray();
        //$categories = $this->Dependencies->Categories->find('list', ['limit' => 200])->where(['id !=' => $id])->ToArray();
        //debug($categories); die();
        $this->set(compact('dependency', 'categories', 'category'));
        $this->set('_serialize', ['dependency']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dependency id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($idThisCat = null, $id = null)
    {
        if(($idThisCat == null)||($id == null)) {
            throw new NotFoundException(__('Categorie ou dépandence invalide !'));
        }
        
        $dependency = $this->Dependencies->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dependency = $this->Dependencies->patchEntity($dependency, $this->request->data);
            $dependency->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Dependencies->save($dependency)) {
                $this->Flash->success(__('has been saved.', ['La dépendance', 'e']));
                return $this->redirect(['controller' => 'categories', 'action' => 'view', $idThisCat]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['La dépendance', 'e']));
            }
        }
        $categories = $this->Dependencies->Categories->find('list', ['limit' => 200]);
        $this->set(compact('dependency', 'categories'));
        $this->set('_serialize', ['dependency']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Dependency id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($idThisCat = null, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dependency = $this->Dependencies->get($id);
        if ($this->Dependencies->delete($dependency)) {
            $this->Flash->success(__('has been deleted.', ['La dépendance', 'e']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['La dépendance', 'e']));
        }
        return $this->redirect(['controller' => 'categories', 'action' => 'view', $idThisCat]);
    }
}
