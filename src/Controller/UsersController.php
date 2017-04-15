<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Response;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        
        $this->membreType = ['admin' => 'Admin', 'douanier' => 'Douanier', 'membre' => 'Membre'];
        
        if($this->Auth->user()){
            $this->user = $this->Auth->session->read();
            $this->permissionLvl = $this->user['Auth']['User']['users'];
            $this->id_user = $this->user['Auth']['User']['id'];
        }
        //privilege des pages
        $this->privilege = array('logout' => 0, 'login' => 0, 'index' => 0, 'editmyprofile' => 0, 'edit' => 2, 'view' => 0, 'add' => 2, 'disableUser' => 4, 'delete' => 4);
        //privilege à afficher dans la page add et edit
        $this->privilege_names = array(0 => 'Pas d\'accès', 1 => 'Consultation', 3 => 'Modification', 4 => 'Suppression', 5 => 'Tous');
        $this->privilege_users = array(0 => 'Pas d\'accès', 4 => 'Tous');
    }
    public function isAuthorized($user){
        $parentValue = parent::isAuthorized($user);
        //debug($user['Auth']['User']); die();
        if(!$parentValue) return false;
        
        $action = $this->request->params['action'];
        
        //debug($user['Auth']['User']['id']);die();
        if($this->privilege[$action] <= $this->permissionLvl){
            return true;
        }/*elseif(isset($id_user)){
            return $this->redirect(['controller' => 'Users', 'action' => 'edit', $id_user]);
        }*/
        //$this->Flash->error(__('Vous n\'êtes pas autoriser d\'acceder à cette page'));
        return false;
        
    }
    /**
     * 
     * @return type
     */
    public function login()
    {
        //debug(WWW_ROOT.'img'.DS.'logos'.DS.'logo-palliserIntr.png'); die();
        $this->viewBuilder()->layout('AddDocumentLayout');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Auth->redirectUrl();
                return $this->redirect(['controller' => 'Pages', 'action' => 'display']);
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
    /**
     * 
     * @return type
     */
    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    
    public function index()
    {
        //debug($this->permissionLvl);die();
        //redirect to edit
        if((isset($this->id_user))&&($this->permissionLvl < 1)){
            return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->id_user]);
        }
        
        $this->paginate = [
            'maxLimit' => 15
        ];
        $numberRows = 15;
        $users = $this->paginate($this->Users);
        $this->set(compact('numberRows'));
        $this->set('users', $users);
        /*$users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);*/
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id)
    {
        //$priv = array('Rien', 'Consulter', 'Modifier', 'Supprimer', 'Tous');
        $priv = $this->privilege_names;
        //$priv_user = $this->privilege_users;
        $permissionLvl = $this->user['Auth']['User']['users'];
        $user = $this->Users->get($id);
        $id_user_auth = $this->id_user;
        $id_user_view = $id;
        $this->set(compact('user', 'id_user_auth', 'id_user_view', 'priv', 'permissionLvl'));
        /*$user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);*/
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        $privilege = $this->privilege_names;
        $priv_user = $this->privilege_users;
        if ($this->request->is('post')) {
            
            //debug($this->request->data); die();
            if($this->request->data['password'] == $this->request->data['password2']){
                //Categ, Dependencies, zones
                $this->request->data['zones'] = $this->request->data['categories'];
                $this->request->data['dependencies'] = $this->request->data['categories'];
                //Clients, Fournisseurs
                $this->request->data['providers'] = $this->request->data['clients'];
                //movements, stocks, inputs, outputSets, outputs, outputs, documents, documents, required_docs
                $this->request->data['movements'] = $this->request->data['files'];
                $this->request->data['stocks'] = $this->request->data['files'];
                $this->request->data['inputs'] = $this->request->data['files'];
                $this->request->data['outputSets'] = $this->request->data['files'];
                $this->request->data['outputs'] = $this->request->data['files'];
                $this->request->data['documents'] = $this->request->data['files'];
                $this->request->data['required_docs'] = $this->request->data['files'];
                
                $user = $this->Users->patchEntity($user, $this->request->data);
                $user->created_by = $this->user['Auth']['User']['id'];
                $user->modified_by = $this->user['Auth']['User']['id'];
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('has been saved.', ['L\'utilisateur', '']));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('Unable to add the user.'));
            }else{
                $this->Flash->error(__('Unable to add the user.'));
            }
        }
        $membreType = $this->membreType;
        $this->set(compact('privilege', 'priv_user', 'membreType'));
        $this->set('user', $user);
        /*$user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);*/
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //Si un user n'a la permission que pour changer son nom et son pw
        $id_user = $this->id_user;
        $permissionLvl = $this->permissionLvl;
        $privilege = $this->privilege_names;
        $priv_user = $this->privilege_users;
        if((isset($this->id_user))&&($this->permissionLvl < 1)&&($this->id_user != $id)){
            return $this->redirect(['controller' => 'Users', 'action' => 'editmyprofile', $this->id_user]);
        }
        
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //Categ, Dependencies, zones
            //$this->request->data['categories'] = $this->request->data['products'];
            $this->request->data['zones'] = $this->request->data['categories'];
            $this->request->data['dependencies'] = $this->request->data['categories'];
            //Clients, Fournisseurs
            $this->request->data['providers'] = $this->request->data['clients'];
            //Products, Categ, Dependencies, zones
            $this->request->data['movements'] = $this->request->data['files'];
            $this->request->data['stocks'] = $this->request->data['files'];
            $this->request->data['inputs'] = $this->request->data['files'];
            $this->request->data['outputSets'] = $this->request->data['files'];
            $this->request->data['outputs'] = $this->request->data['files'];
            $this->request->data['documents'] = $this->request->data['files'];
            $this->request->data['required_docs'] = $this->request->data['files'];
            
            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Users->save($user)) {
                $this->Flash->success(__('has been saved.', ['L\'utilisateur', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['L\'utilisateur', '']));
            }
        }
        $membreType = $this->membreType;
        $this->set(compact('user', 'id_user', 'permissionLvl', 'id', 'privilege', 'priv_user', 'membreType'));
        $this->set('_serialize', ['user']);
    }
    public function editmyprofile($id = null){
        //Si un user n'a la permission que pour changer son nom et son pw
        //$id_user = $this->id_user;
        //$permissionLvl = $this->permissionLvl;
        //$privilege = array(0 => 'Rien', 1 => 'Consulter', 2 => 'Modifier', 3 => 'Supprimer', 4 => 'Tous');
        //if((isset($this->id_user))&&($this->permissionLvl < 1)&&($this->id_user != $id)){
            //return $this->redirect(['controller' => 'Users', 'action' => 'editmyprofile', $this->id_user]);
        //}
        //get this user id
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        //debug($user);die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                    'password_old'  => $this->request->data['password_old'],
                    'password'      => $this->request->data['password_new'],
                    'password_new'     => $this->request->data['password_new'],
                    'password_new2'     => $this->request->data['password_new2']
                ], ['validate' => 'password']);
            //debug($user);die();
            /*$newHash = Security::hash($user->password_old, 'sha1', true);
            $user->password_new = $this->_setPassword($user->password_new);
            $user->password_new2 = $this->_setPassword($user->password_new2);
            echo $newHash .'---'. $user->password.'---'. $user->password_new2;*/
            //die();
            //if(($user->password_old == $user->password) && ($user->password_new == $user->password_new2)){
                //$user->password = $this->_setPassword($user->password_new);
                $user->modified_by = $this->user['Auth']['User']['id'];    
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('has been saved.', ['Mot de passe', '']));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('could not be saved. Please, try again.', ['Mot de passe', '']));
                }
            /*}else {
                    $this->Flash->error(__('The user could not be saved. Please, try again.2'));
            }*/
        }
        $this->set(compact('user', 'id'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function delete($id = null)
    {
        if($id == 1){
            $this->Flash->error(__('Vous ne pouvez pas effacer le superadmin'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('has been deleted.', ['L\'utilisateur', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['L\'utilisateur', '']));
        }
        return $this->redirect(['action' => 'index']);
    }
    */
    public function disableUser($id, $enable){
        if($id == null) {
            throw new NotFoundException(__('Utilisateur invalide !'));
        }
        //Id du super admin
        if($id == 1){
            $this->Flash->error(__('Vous ne pouvez pas désactiver le superadmin'));
            return $this->redirect(['action' => 'index']);
        }
        if($id == $this->user['Auth']['User']['id']){
            $this->Flash->error(__('Vous ne pouvez pas désactiver votre profile'));
            return $this->redirect(['action' => 'index']);
        }
        
        $userTable = TableRegistry::get('Users');
        $user = $userTable->get($id);
        $user->enable = $enable;
        $user->modified_by = $this->user['Auth']['User']['id'];
        if ($userTable->save($user)){
            if($enable == 0)
                $this->Flash->success(__('L\'utilisateur a été désactivé.'));
            else
                $this->Flash->success(__('L\'utilisateur a été activé.'));
        } else {
            if($enable == 0)
                $this->Flash->error(__('Problème : Utilisateur n\'a pas été désactivé.'));
            else
                $this->Flash->error(__('Problème : Utilisateur n\'a pas été activé.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
    
    public function showlogo($nameLogo){
        //$this->response->file(WWW_ROOT.'img/logos/'.$nameLogo);
        //$this->response->file(WWW_ROOT.'uploads'.DS.'categories'.DS.'pictogramme'.DS.$nameLogo);
        return $this->response;
    }
    
}
