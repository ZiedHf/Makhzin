<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Response;
use Cake\Network\Exception\NotFoundException;
use Cake\Event\Event;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 */
class DocumentsController extends AppController
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
        $permissionLvl = $user['Auth']['User']['documents'];
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
            'contain' => ['Files']
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
        $this->set('_serialize', ['documents']);
    }*/

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Files']
        ]);
        //debug($document->path);die();
        //$http = new Client();
        //$this->redirect(WWW_ROOT.$document->path);
        $this->response->file(WWW_ROOT.'uploads'.DS.$document->path);
        return $this->response;
        //$this->set('document', $document);
        //$this->set('_serialize', ['document']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $types = array('0' => 'Originale obligatoire', 
                      '1' => 'Copie acceptée en attente de l\'originale',
                      '2' => 'Copie acceptée',
                      '3' => 'Optionnel');
        $this->loadModel('Required_docs');
        
        //$this->viewBuilder()->layout('AddDocumentLayout2');
        if($id == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        } else {
            $file = $this->Documents->Files->get($id)->toArray();
        }
        //Afficher une erreur si le dossier n'est pa en cours (statut = 0)
        if($file['statut'] != 0){
            throw new NotFoundException(__('Vous ne pouvez pas ajouter un document à ce dossier !'));
        }
        
        $id_client = $file['client_id'];
        $number_doc = $file['number'];
        $id_file = $file['id'];
        
        //debug($file);die();
        $document = $this->Documents->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->data); die();
            $document = $this->Documents->patchEntity($document, $this->request->data);
            $document->created_by = $this->user['Auth']['User']['id'];
            //Select le nom du fichier par l' Id
            $file_selected = $this->Required_docs->get($document['name'])->toArray();
            $document['name'] = $file_selected['name'];
            if(!isset($document['version']))
                    $document['version'] = $document['version_jq'];
            
            //debug($document);die();
            /*$this->addBehavior('Utils.Uploadable', ['document' => [
                                                                    'path' => '{ROOT}{DS}{WEBROOT}{DS}uploads{DS}{model}{DS}{field}{DS}',
                                                                    'fields' => [
                                                                    'directory' => 'avatar_directory',
                                                                    'url' => 'avatar_url',
                                                                    'type' => 'avatar_type',
                                                                    'size' => 'avatar_size',
                                                                    'fileName' => 'avatar_name',
                                                                    'filePath' => 'path'
                                                                    ]
                                                                ]
                                                                    
                                                    ]);*/
            
            if($result = $this->Documents->save($document)){
                //Création d'une repertoire num dossier
                $pathToDir = WWW_ROOT . 'uploads'.DS.$number_doc;
                if (!file_exists($pathToDir)) {
                    mkdir($pathToDir, 0777, true);
                }
                //Remplacer les espaces par '_'
                $fileToUpload = $document['document'];
                $fileToUpload['name'] = str_replace(' ', '_', $fileToUpload['name']);
                //Récuperation du racine et ajout d'un prefixe id pour chaque doc
                $path = $pathToDir . DS . $result->id . '_' .$fileToUpload['name'];
                $document['path'] = $path;
                // upload
                move_uploaded_file($fileToUpload['tmp_name'], $path);
                //Ajout du champ path à la derniere insertion
                $document = $this->Documents->get($result->id);
                $document->path = $number_doc. DS . $result->id . '_' .$fileToUpload['name']; // After Webroot/uploads
                $this->Documents->save($document);
                $this->Flash->success(__('has been saved.', ['Le document', '']));
                return $this->redirect(['controller' => 'files', 'action' => 'view', $id_file]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le document', '']));
            }
        }
        
        $this->loadModel('Clients');
        $types_name = $this->Required_docs->find('list')->order('id');
        $types_req = $this->Required_docs->find('list', ['keyField' => 'id', 'valueField' => 'type'])->order('id')->toArray();
        //$types = $this->Required_docs->find('all')->select(['id', 'name', 'type'])->order('name')->toArray();
        //debug($types);die();
        //$clients = $this->Clients->find('all')->where(['id' => $file['client_id']])->select(['id', 'name'])->toArray();
        $client = $this->Clients->get($id_client)->toArray();
        $client_name = $client['name'];
        $version = array('0' => 'copie', '1' => 'originale');
        
        $page_name = 'documents_add';
                
        $this->set(compact('document', 'files', 'types_name', 'types_req', 'types', 'clients', 'number_doc', 'page_name', 'id_file', 'client_name', 'id_client', 'version'));
        $this->set('_serialize', ['document']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        $this->loadModel('Required_docs');
        // Get all type in array
        $types_old = $this->Required_docs->find('list')->order('id');
        //change the key value
        foreach ($types_old as $key => $type){
            $types[$key-1] = $type;
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->data);
            //$types[$document->type];
            $document->name = $types[$document->type];
            $document->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('has been saved.', ['Le document', '']));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le document', '']));
            }
        }
        $files = $this->Documents->Files->find('list', ['limit' => 200]);
        $this->set(compact('document', 'files', 'types'));
        $this->set('_serialize', ['document']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        
        //$path = FULL_URL.'webroot'.DS.'uploads'.DS.$document->path;
        $path = 'uploads'.DS.$document->path;
        if(file_exists($path))
            unlink($path);
        else
            throw new NotFoundException(__('Fichier non trouvé !'));

        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('has been deleted.', ['Le document', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le document', '']));
        }
        return $this->redirect(['controller' => 'files', 'action' => 'view', $document->file_id]);
    }
}
