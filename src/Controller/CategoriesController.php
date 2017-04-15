<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Response;
use Cake\Network\Exception\NotFoundException;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
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
        //debug($user['Auth']['User']['id']);die();
        $privilege = array('index' => 1, 'view' => 1, 'viewPic' => 1, 'viewDoc' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['categories'];
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
            'contain' => ['Users_CreatedBy', 'Users_ModifiedBy'],
            'maxLimit' => 15,
            'order' => [
                'name' => 'asc'
            ]
        ];
        $numberRows = 15;
        $categories = $this->paginate($this->Categories);
        $this->loadModel('Dependencies');
        //recupérer les quota des categ et leurs stocks
        if(isset($categories)){
            foreach ($categories as $key => $category){
                //$LesQuota[] = $this->Dependencies->find('all')->where(['id_category1' => $category->id, 'id_category2' => $category->id])->toArray();
                $infoCategs[$key]['quota'] = $this->Dependencies->find('all')->where(['id_category1' => $category->id, 'id_category2' => $category->id])->toArray();
                $infoCategs[$key]['amount'] = $this->getStockByIdCategory($category->id);
            }
            //debug($infoCategs);die();
            if(isset($infoCategs))
                foreach($infoCategs as $key => $infoCateg){
                    $idCat = $infoCateg['quota'][0]['id_category1'];
                    $quotaCat = $infoCateg['quota'][0]['quota'];
                    $lesQuotaView[$idCat] = $quotaCat;
                    $amountView[$idCat] = $infoCateg['amount'];
                }
            $this->set(compact('lesQuotaView', 'amountView'));
        }
        //debug($lesQuotaView);die();
        $this->set(compact('categories', 'numberRows'));
        $this->set('_serialize', ['categories']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null){
        $category = $this->Categories->get($id, [
            'contain' => ['Products', 'Users_CreatedBy', 'Users_ModifiedBy']
        ]);
        
        $this->loadModel('Dependencies');
        $dependency = $this->Dependencies->find('all')->where(['id_category1' => $id, 'id_category2' => $id])->select(['quota', 'tolerance'])->limit(1)->toArray();
        $dependencies = $this->Dependencies->find('all')->where(['Not' => ['id_category1' => $id, 
                                                                           'id_category2' => $id],
                                                                'Or' => ['id_category1' => $id, 
                                                                         'id_category2' => $id]
                                                                ])
                                                        ->toArray();
        //debug($dependency);die();
        $categories = $this->Categories->find('list')->toArray();
        $quota = $dependency[0]['quota'];
        $tolerance = $dependency[0]['tolerance'];
        $amount = $this->getStockByIdCategory($id);
        $idThisCat = $id;
        
        //$url_img = WWW_ROOT . 'uploads'.DS;
        $this->set('category', $category);
        $this->set('_serialize', ['category']);
        $this->set(compact('quota', 'dependencies', 'categories', 'tolerance', 'idThisCat', 'amount', 'url_img'));
    }
    /**
     * Afficher le Pictogramme
     * @param type $id
     * @return type
     */
    public function viewPic($id = null){
        $category = $this->Categories->get($id);
        $this->response->file(WWW_ROOT.'uploads'.DS.$category->pictogramme_path);
        return $this->response;
    }
    
    public function viewDoc($id = null, $numDoc = 1){
        $category = $this->Categories->get($id);
        $ext = pathinfo($category->doc_path, PATHINFO_EXTENSION);
        if($numDoc == 1){
            $allPath = WWW_ROOT.'uploads'.DS.$category->doc_path;
            $nameFile = basename($category->doc_path);
        }elseif($numDoc == 2){
            $allPath = WWW_ROOT.'uploads'.DS.$category->doc_path2;
            $nameFile = basename($category->doc_path2);
        }else{
            $allPath = WWW_ROOT.'uploads'.DS.$category->doc_path3;
            $nameFile = basename($category->doc_path3);
        }
        //debug($nameFile); die(); 
        //basename("/etc/sudoers.d").PHP_EOL;
        //$this->response->file($allPath, ['download' => true, 'name' => $category->name.'.'.$ext]);
        
        $this->response->file($allPath, ['download' => true, 'name' => $nameFile]);
        return $this->response;
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->data['quota']); die();
            if((!isset($this->request->data['quota'])) || ($this->request->data['quota'] == '')){
                $this->Flash->error(__('could not be saved. Please, try again.', ['La catégorie', 'e']));
                return $this->redirect(['action' => 'add']);
            }
            
            $with_quota = isset($this->request->data['with_quota']) ? $this->request->data['with_quota'] : NULL;
            $without_quota = isset($this->request->data['without_quota']) ? $this->request->data['without_quota'] : NULL;
            $this->request->data['products']['_ids'] = $this->getProdIds($with_quota, $without_quota);
            
            //$category->doc_path = $this->doUploadAndReturnName($this->request->data['doc_path'], 2, 'categories'.DS.'piecejointe');
            //die();
            $category = $this->Categories->patchEntity($category, $this->request->data);
            $category->created_by = $this->user['Auth']['User']['id'];
            $category->modified_by = $this->user['Auth']['User']['id'];
            if($result = $this->Categories->save($category)){
                $category1 = $this->Categories->get($result->id);
                $category1->pictogramme_path = $this->doUploadAndReturnName($this->request->data['pictogramme_path'], $result->id, 'categories'.DS.'pictogramme');
                $category1->doc_path = $this->doUploadAndReturnName($this->request->data['doc_path'], $result->id, 'categories'.DS.'piecejointe');
                $category1->doc_path2 = $this->doUploadAndReturnName($this->request->data['doc_path2'], $result->id, 'categories'.DS.'piecejointe');
                $category1->doc_path3 = $this->doUploadAndReturnName($this->request->data['doc_path3'], $result->id, 'categories'.DS.'piecejointe');
                $this->Categories->save($category1);
                //Ajouter Quota dans la table Dependencies
                $this->loadModel('Dependencies');
                $dependencyAdd = $this->Dependencies->newEntity();
                $values_dependency = array("id_category1" => $result->id, 
                                            "id_category2" => $result->id, 
                                            "quota" => $category->quota,
                                            "tolerance" => $category->tolerance,
                                            "created_by" => $this->user['Auth']['User']['id']);
                $dependencyAdd = $this->Dependencies->patchEntity($dependencyAdd, $values_dependency);
                
                //debug($dependencie); die();
                //Modifier le champs is_considired pour chaque nouvelle association (catégories) sans quota
                if(!empty($this->request->data['without_quota']))
                    $this->updateAssociations($this->request->data['without_quota'], $result->id);
                
                if($this->Dependencies->save($dependencyAdd)){
                    $this->Flash->success(__('has been saved.', ['La catégorie', 'e']));
                    return $this->redirect(['action' => 'view', $result->id]);
                }else{
                    $this->Flash->error(__('could not be saved. Please, try again.', ['La dépendance', 'e']));
                }
                
            //if ($this->Categories->save($category)) {
                //$this->Flash->success(__('The category has been saved.'));
                //return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['La catégorie', 'e']));
            }
        }
        $products = $this->Categories->Products->find('list')->order('name')->toArray();
        $page_name = 'categories_add';
        
        $this->set(compact('category', 'products', 'page_name'));
        $this->set('_serialize', ['category']);
    }
    
    function doUploadAndReturnName($pictogramme, $id, $upload_file){
        //debug($pictogramme); die();
        if((isset($pictogramme['name'])) && ($pictogramme['name'] != '')){
            //Création d'une repertoire ou des répertoire d'upload 
            //upload peut avoir le nom d'un seul répertoire ou rep1.DS.rep2
            $array_files = explode(DS, $upload_file);
            //debug($array_files); die();
            //return $array_files;
            $create_path = '';
            foreach ($array_files as $key => $value) {
                if($create_path == '')
                    $create_path = $create_path.$value;
                else 
                    $create_path = $create_path.DS.$value;
                $pathToDir = WWW_ROOT . 'uploads'.DS.$create_path;
                if(!file_exists($pathToDir)){
                    mkdir($pathToDir, 0777, true);
                }    
            }
            
            //Remplacer les espaces par '_'
            $pictogramme['name'] = str_replace(' ', '_', $pictogramme['name']);
            //Récuperation du racine et ajout d'un prefixe id pour chaque doc
            
            $i = 1;
            $nameFile = $id . "_".$i."_" .$pictogramme['name'];
            $path = $pathToDir . DS . $nameFile;
            //S'il y a deux fichier uploadé du m^me nom la fnc genere un num diff pour chacune
            while(file_exists($path)){
                $i++;
                $nameFile = $id . "_".$i."_" .$pictogramme['name'];
                $path = $pathToDir . DS . $nameFile;
            }
                
            //debug($path); die();
            //Upload
            move_uploaded_file($pictogramme['tmp_name'], $path);
            $db_path = $upload_file. DS . $nameFile;
            return $db_path;
        }else{
            return NULL;
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){
        $category = $this->Categories->get($id, [
            'contain' => ['Products']
        ]);
        
        $this->loadModel('Dependencies');
        $dependency = $this->Dependencies->find('all')->where(['id_category1' => $id, 'id_category2' => $id])->select(['id', 'quota', 'tolerance'])->limit(1)->toArray();
        
        if($dependency){
            $quota = $dependency[0]['quota'];
            $tolerance = $dependency[0]['tolerance'];
            $id_quota = $dependency[0]['id'];
        }else{
            $quota = 0; $id_quota = 0; $tolerance = 0;
        }
        
        if ($this->request->is(['patch', 'post', 'put'])){
            //debug($this->request->data); die();
            
            if((!isset($this->request->data['quota'])) || ($this->request->data['quota'] == '')){
                $this->Flash->error(__('could not be saved. Please, try again.', ['La catégorie', 'e']));
                return $this->redirect(['action' => 'edit']);
            }
            
            $with_quota = isset($this->request->data['with_quota']) ? $this->request->data['with_quota'] : NULL;
            $without_quota = isset($this->request->data['without_quota']) ? $this->request->data['without_quota'] : NULL;
            $this->request->data['products']['_ids'] = $this->getProdIds($with_quota, $without_quota);
            
            $do_upload = false;
            $do_uploadDoc = false;
            $do_uploadDoc2 = false;
            $do_uploadDoc3 = false;
            
            //Pictogramme
            if((isset($this->request->data['supp_pic'])) && ($this->request->data['supp_pic'] == '1')){
                $this->request->data['pictogramme_path'] = NULL;
                $this->deleteDocFromFile($id, 'pictogramme');
            }elseif($this->request->data['pictogramme_path']['name'] == ''){
                unset($this->request->data['pictogramme_path']);
            }else{
                $do_upload = true;
                $this->deleteDocFromFile($id, 'pictogramme');
            }
            //Doc
            $this->handleDocument($id, 'supp_doc', 'doc_path', 1);
            $do_uploadDoc = $this->do_uploadDoc;
            $this->handleDocument($id, 'supp_doc2', 'doc_path2', 2);
            $do_uploadDoc2 = $this->do_uploadDoc;
            $this->handleDocument($id, 'supp_doc3', 'doc_path3', 3);
            $do_uploadDoc3 = $this->do_uploadDoc;
            
            $category = $this->Categories->patchEntity($category, $this->request->data);
            $category->modified_by = $this->user['Auth']['User']['id'];
            
            if ($result = $this->Categories->save($category)){
                
                if(($do_upload) || ($do_uploadDoc) || ($do_uploadDoc2) || ($do_uploadDoc3)){
                    $categoryPic = $this->Categories->get($result->id);
                    if($do_upload){//Si la case supp n'est pas cocher et l'utilisateur a choisi un autre pictogramme on exécute l'upload et l'update DB
                        $categoryPic->pictogramme_path = $this->doUploadAndReturnName($this->request->data['pictogramme_path'], $result->id, 'categories'.DS.'pictogramme');
                    }
                    if($do_uploadDoc){//Meme operation pour la piece jointe
                        $categoryPic->doc_path = $this->doUploadAndReturnName($this->request->data['doc_path'], $result->id, 'categories'.DS.'piecejointe');
                    }
                    if($do_uploadDoc2){//Meme operation pour la piece jointe 2
                        $categoryPic->doc_path2 = $this->doUploadAndReturnName($this->request->data['doc_path2'], $result->id, 'categories'.DS.'piecejointe');
                    }
                    if($do_uploadDoc3){//Meme operation pour la piece jointe 3
                        $categoryPic->doc_path3 = $this->doUploadAndReturnName($this->request->data['doc_path3'], $result->id, 'categories'.DS.'piecejointe');
                    }
                    $this->Categories->save($categoryPic);
                }
                
                
                //Modifier le champs is_considired pour chaque nouvelle association (catégories) sans quota
                if(!empty($this->request->data['without_quota']))
                    $this->updateAssociations($this->request->data['without_quota'], $result->id);
                /*$category = $this->Categories->get($result->id);
                debug($category);die();*/
                
                if(isset($id_quota)){
                    $DependenciesTable = TableRegistry::get('Dependencies');
                    $dependencyRow = $DependenciesTable->newEntity();
                    $dependencyRow = $DependenciesTable->get($id_quota);
                    $dependencyRow->quota = $category->quota;
                    $dependencyRow->tolerance = $category->tolerance;
                    $dependencyRow->modified_by = $this->user['Auth']['User']['id'];
                    $DependenciesTable->save($dependencyRow);
                }
                
                $this->Flash->success(__('has been saved.', ['La catégorie', 'e']));
                return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['La catégorie', 'e']));
            }
        }
        //debug($product['categories']);die();
        foreach ($category['products'] as $key => $value){
            $product_Id = $value['id'];
            if($value['_joinData']['is_considered'])
                $prodWithQuota[$product_Id] = $value['name'];
            else
                $prodWithoutQuota[$product_Id] = $value['name'];
            $associations[] = $value['id'];
        }
        
        //get tolerance et quota
        $page_name = 'categories_edit';
        
        $products = $this->Categories->Products->find('list')->order('name');
        $this->set(compact('category', 'products', 'quota', 'tolerance', 'page_name', 'associations', 'prodWithQuota', 'prodWithoutQuota'));
        $this->set('_serialize', ['category']);
    }
    
    private function handleDocument($id, $supp_doc, $doc_path, $num = 1){
        //debug($this->request->data[$doc_path]);die();
        if((isset($this->request->data[$supp_doc])) && ($this->request->data[$supp_doc] == '1')){
                $this->request->data[$doc_path] = NULL;
                $this->deleteDocFromFile($id, 'doc', $num);
                $this->do_uploadDoc = false;
            }elseif($this->request->data[$doc_path]['name'] == ''){
                unset($this->request->data[$doc_path]);
                $this->do_uploadDoc = false;
            }else{
                //$do_uploadDoc = true;
                $this->do_uploadDoc = true;
                $this->deleteDocFromFile($id, 'doc', $num);
            }
    }

    private function deleteDocFromFile($id = null, $type = 'pictogramme', $num = 1){
        if($id == null)
            throw new NotFoundException(__('Catégories non trouvée !'));
        $categorie = $this->Categories->get($id);
        //debug($categorie);die();
        //$path = FULL_URL.'webroot'.DS.'uploads'.DS.$document->path;
        if((($categorie->pictogramme_path !== NULL) && ($type == 'pictogramme')) || ($type == 'doc')){
            $path = Null;
            if($type == 'pictogramme')
                $path = 'uploads'.DS.$categorie->pictogramme_path;
            elseif($type == 'doc'){
                //if($num == 1) {debug('uploads'.DS.$categorie->doc_path2); die();}
                if(($num == 1)&&($categorie->doc_path !== Null))
                    $path = 'uploads'.DS.$categorie->doc_path;
                elseif(($num == 2)&&($categorie->doc_path2 !== Null))
                    $path = 'uploads'.DS.$categorie->doc_path2;
                elseif(($num == 3)&&($categorie->doc_path3 !== Null))
                    $path = 'uploads'.DS.$categorie->doc_path3;
            }else
                $this->Flash->error(__('Type fichier non déclaré'));
                //throw new NotFoundException(__('Type fichier non déclaré !'));
            if($path !== null){
                if(file_exists($path))
                    unlink($path);
                else
                    //throw new NotFoundException(__('Fichier non trouvé !'));
                    $this->Flash->error(__('Fichier non trouvé pour la suppression !'));
            }
        }
        
    }
    
    private function getProdIds($with_quota, $without_quota){
        if(($with_quota === NULL)&&($without_quota  === NULL))
            return array();
        elseif($with_quota === NULL)
            return $without_quota;
        elseif($without_quota === NULL)
            return $with_quota;
        else
            return array_merge($with_quota, $without_quota);
    }
    
    private function updateAssociations($quota, $id, $is_considered = 0){
        // $is_considered = 1 => categories considered in the lots/add
        // $is_considered = 0 => categories not considered in the lots/add
        foreach ($quota as $key => $value) {
            $associationController = New AssociationsController;
            $association = $associationController->getAssoc_ByProduct_Cat($value, $id); // La diff avec la fn Products::updateAssociations()
            $associationsTable = $this->loadModel('Associations');
            $associationTable = TableRegistry::get('Associations');
            $association = $associationTable->get($association[0]['id']);
            $association->is_considered = $is_considered;
            $associationTable->save($association);
        }
    }
    
    private function DeleteDependeciesByCatId($id){
        $this->loadModel('Dependencies');
        $DependenciesTable = TableRegistry::get('Dependencies');
        $dependencies = $this->Dependencies->find('all')->where(['Or' => ['id_category1' => $id, 'id_category2' => $id]])->toArray();
        foreach($dependencies as $dependency){
            $dependencyRow = $DependenciesTable->newEntity();
            //debug($dependency['id']); die();
            $idDep = $dependency['id'];
            $dependencyRow = $DependenciesTable->get($idDep);
            $result = $this->Dependencies->delete($dependencyRow);
        }
        //debug($dependencies); die();
    }
    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->DeleteDependeciesByCatId($id);
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        
        $doc_path = 'uploads'.DS.$category->doc_path;
        $pictogramme_path = 'uploads'.DS.$category->pictogramme_path;
        //Suppression des fichiers
        if((file_exists($doc_path))&&($category->doc_path !== NULL))
            unlink($doc_path);
        elseif($category->doc_path !== NULL){
            $this->Flash->error(__('Document non trouvé pour la suppression !'));
            //return $this->redirect(['action' => 'index']);
        }
        if((file_exists($pictogramme_path))&&($category->pictogramme_path !== NULL))
            unlink($pictogramme_path);
        elseif($category->pictogramme_path !== NULL){
            $this->Flash->error(__('Pictogramme non trouvé pour la suppression !'));
            //return $this->redirect(['action' => 'index']);
        }
            //throw new NotFoundException(__('Erreur !'));
        
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('has been deleted.', ['La catégorie', 'e']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['La catégorie', 'e']));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /*
     * 
     */
    public function getStockByIdProduct($idProduct){
        $this->loadModel('Stocks');
        $stock_product = $this->Stocks->find('all')->where(['product_id' => $idProduct])->toArray();
        $productAmount = $stock_product['0']['amount'];
        return $productAmount;
    }
    /**
     * getStockByIdCategory
     * @param type $id
     */
    public function getStockByIdCategory($idcategory){
        $this->loadModel('Categories');
        $category = $this->Categories->find('all')->contain('Products')->where(['id' => $idcategory])->toArray();
        //debug($category[0]->products);die();
        $categorieAmount = 0;
        foreach ($category[0]->products as $key => $value) {
            $categorieAmount += $this->getStockByIdProduct($value['id']);
        }
        return $categorieAmount;
    }
}
