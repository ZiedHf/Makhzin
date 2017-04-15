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
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'viewDoc' => 1, 'viewPic' => 1, 'add' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['products'];
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
            'contain' => ['Stocks'],
            'sortWhitelist' => ['name', 'productCode', 'ngpCode', 'quota', 'unit', 'Stocks.amount'],
            'maxLimit' => 15,
            'order' => [
                'name' => 'asc'
            ]
        ];
        $products = $this->paginate($this->Products);
        
        //debug($products);die();
        $numberRows = 15;
        $this->set(compact('products', 'numberRows'));
        $this->set('_serialize', ['products']);
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null){
        $this->loadModel('Lots');
        $this->loadModel('Files');
        $this->loadModel('Clients');
        
        $product = $this->Products->get($id, [
            'contain' => ['Categories', 'Stocks', 'Lots', 'Zones', 'Users_CreatedBy', 'Users_ModifiedBy', 'productstates', 'Packagings'],
            'maxLimit' => 15
        ]);
        //debug(WWW_ROOT);die();
        $fileController = new FilesController;
        $clientController = new ClientsController;
        foreach ($product->lots as $key => $value) {
            //debug($value);die();
            $id_lot = $value['id'];
            $file_num[$id_lot] = $fileController->getNumFileById($value['file_id']);
            $client_name[$id_lot] = $clientController->getNameClientById($value['client_id']);
        }
        //debug($product);die();
        $this->set(compact('client_name', 'file_num'));
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    public function viewPic($id = null){
        $product = $this->Products->get($id);
        //debug($product);
        $this->response->file(WWW_ROOT.'uploads'.DS.$product->pic_path);
        return $this->response;
    }
    
    public function viewDoc($id = null){
        $product = $this->Products->get($id);
        $ext = pathinfo($product->doc_path, PATHINFO_EXTENSION);
        $this->response->file(WWW_ROOT.'uploads'.DS.$product->doc_path,
                                ['download' => true, 'name' => $product->name.'.'.$ext]);
        return $this->response;
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null){
        $this->loadModel('Categories');
        $product = $this->Products->newEntity();
        //Select la categorie
        if($id != null){
            $product->categories = array();
            $product->categories[0] = $this->Categories->newEntity();
            $product->categories[0] = $this->Categories->get($id);
        }
        
        if ($this->request->is('post')) {
            //debug($this->request->data);die();
            $quota_test = true;
            if(!isset($this->request->data['quota'])) $this->request->data['quota'] = NULL;
            if(($this->request->data['quota'] == '') && ($this->request->data['subjectToQuota'] == '0')){
                $quota_test = false;
            }
            
            $with_quota = isset($this->request->data['with_quota']) ? $this->request->data['with_quota'] : NULL;
            $without_quota = isset($this->request->data['without_quota']) ? $this->request->data['without_quota'] : NULL;
            $this->request->data['categories']['_ids'] = $this->getCategIds($with_quota, $without_quota);
            //debug($this->request->data['categories']['_ids']);die();
            $stock = $this->Products->Stocks->newEntity();
            $product = $this->Products->patchEntity($product, $this->request->data);
            $product->approved = '1';
            $product->created_by = $this->user['Auth']['User']['id'];
            $product->modified_by = $this->user['Auth']['User']['id'];
            $product->productCode = $this->generateProductCode();
            
            if(($quota_test) && ($result = $this->Products->save($product))){
                
                $categoriesController = New CategoriesController;
                $product1 = $this->Products->get($result->id);
                $product1->pic_path = $categoriesController->doUploadAndReturnName($this->request->data['pic_path'], $result->id, 'products'.DS.'pic');
                $product1->doc_path = $categoriesController->doUploadAndReturnName($this->request->data['doc_path'], $result->id, 'products'.DS.'piecejointe');
                $this->Products->save($product1);
                
                $stockdata['amount'] = '0';
                if(isset($this->request->data['unitQte'])) $stockdata['unitQte'] = $this->request->data['unitQte'];
                $stockdata['unit'] = $this->request->data['unit'];
                $stockdata['product_id'] = $result->id;
                //$categories_ids = $this->request->data['categories'];
                //foreach ($categories_ids as $key => $value) {
                    //$stockdata['category_id'] = $value;
                    $stock = $this->Products->Stocks->patchEntity($stock, $stockdata);
                    $stock->created_by = $this->user['Auth']['User']['id'];
                    $this->Products->Stocks->save($stock);
                //}
                //Modifier le champs is_considired pour chaque nouvelle association (catégories) sans quota
                if(!empty($this->request->data['without_quota']))
                    $this->updateAssociations($this->request->data['without_quota'], $result->id);
                    
                $this->Flash->success(__('has been saved.', ['Le produit', '']));
                return $this->redirect(['action' => 'view', $result->id]);
                //$stockdata['category_id'] = $this->request->data['category_id'];
                //$stock = $this->Products->Stocks->patchEntity($stock, $stockdata);
                /*
                if($this->Products->Stocks->save($stock)){
                    $this->Flash->error(__('The stock of this product could not be saved. Please, try again.'));
                }else{
                    $this->Flash->success(__('The product has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }*/
            }else{
                if(!$quota_test)
                    $this->Flash->error(__('Merci de vérifier le quota du produit.'));
                else
                    $this->Flash->error(__('could not be saved. Please, try again.', ['Le produit', '']));
            }
        }
        $productCode = $this->generateProductCode();
        $page_name = "product_add";
        $categories = $this->Products->Categories->find('list')->order('name')->toArray();
        $zones = $this->Products->Zones->find('list')->order('name');
        $productStates = $this->Products->Productstates->find('list')->order('name');
        $packagings = $this->Products->Packagings->find('list')->order('name');
        $this->set(compact('product', 'categories', 'zones', 'page_name', 'productStates', 'packagings', 'productCode'));
        $this->set('_serialize', ['product']);
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    
    public function edit($id = null){
        $product = $this->Products->get($id, [
            'contain' => ['Categories']
        ]);
        //debug($product['categories']);die();
        foreach ($product['categories'] as $key => $value){
            $categ_Id = $value['id'];
            if($value['_joinData']['is_considered'])
                $categWithQuota[$categ_Id] = $value['name'];
            else
                $categWithoutQuota[$categ_Id] = $value['name'];
            $associations[] = $value['id'];
        }
        //debug($associations);die();
        if ($this->request->is(['patch', 'post', 'put'])){
            //Quota / tolerance / illimité
            $quota_test = true;
            if(!isset($this->request->data['quota'])) $this->request->data['quota'] = NULL;
            if(($this->request->data['quota'] == '') && ($this->request->data['subjectToQuota'] == '0')){
                $quota_test = false;
            }
            
            $do_upload = false;
            $do_uploadDoc = false;
            
            //Pictogramme
            if((isset($this->request->data['supp_pic'])) && ($this->request->data['supp_pic'] == '1')){
                $this->request->data['pic_path'] = NULL;
                $this->deleteDocFromFile($id, 'pic');
            }elseif($this->request->data['pic_path']['name'] == ''){
                unset($this->request->data['pic_path']);
            }else{
                $do_upload = true;
                $this->deleteDocFromFile($id, 'pic');
            }
            //Doc
            if((isset($this->request->data['supp_doc'])) && ($this->request->data['supp_doc'] == '1')){
                $this->request->data['doc_path'] = NULL;
                $this->deleteDocFromFile($id, 'doc');
            }elseif($this->request->data['doc_path']['name'] == ''){
                unset($this->request->data['doc_path']);
            }else{
                $do_uploadDoc = true;
                $this->deleteDocFromFile($id, 'doc');
            }
            
            $with_quota = isset($this->request->data['with_quota']) ? $this->request->data['with_quota'] : NULL;
            $without_quota = isset($this->request->data['without_quota']) ? $this->request->data['without_quota'] : NULL;
            $this->request->data['categories']['_ids'] = $this->getCategIds($with_quota, $without_quota);
            
            //debug($without_quota);die();
            
            $product = $this->Products->patchEntity($product, $this->request->data);
            $product->modified_by = $this->user['Auth']['User']['id'];
            if ($result = $this->Products->save($product)){
                
                if(($do_upload) || ($do_uploadDoc)){
                    $categoriesController = New CategoriesController;
                    $product1 = $this->Products->get($result->id);
                    if($do_upload){//Si la case supp n'est pas cocher et on l'utilisateur a choisi un autre pictogramme on exécute l'upload et l'update DB
                        $product1->pic_path = $categoriesController->doUploadAndReturnName($this->request->data['pic_path'], $result->id, 'products'.DS.'pic');
                    }
                    if($do_uploadDoc){//Meme operation pour la piece jointe
                        $product1->doc_path = $categoriesController->doUploadAndReturnName($this->request->data['doc_path'], $result->id, 'products'.DS.'piecejointe');
                    }
                    $this->Products->save($product1);
                }
                
                //Modifier le champs is_considired pour chaque nouvelle association (catégories) sans quota
                if($without_quota !== NULL)
                    $this->updateAssociations($this->request->data['without_quota'], $result->id); // update from without quota to with quota
                elseif($with_quota !== NULL)
                    $this->updateAssociations($this->request->data['with_quota'], $result->id, 1); // update from with quota to without quota
                
                $this->Flash->success(__('has been saved.', ['Le produit', '']));
                return $this->redirect(['action' => 'view', $id]);
            }else{
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le produit', '']));
            }
        }
        $page_name = "product_edit";
        $categories = $this->Products->Categories->find('list')->order('name');
        $zones = $this->Products->Zones->find('list')->order('name');
        $productStates = $this->Products->Productstates->find('list')->order('name');
        $packagings = $this->Products->Packagings->find('list')->order('name');
        $this->set(compact('product', 'categories', 'zones', 'associations', 'categWithQuota', 'categWithoutQuota', 'page_name', 'productStates', 'packagings'));
        $this->set('_serialize', ['product']);
    }
    /**
     * 
     * @param type $id
     * @param type $type
     * @throws NotFoundException
     */
    private function deleteDocFromFile($id = null, $type = 'pic'){
        if($id == null)
            throw new NotFoundException(__('Produit non trouvé !'));
        $product = $this->Products->get($id);
        
        //$path = FULL_URL.'webroot'.DS.'uploads'.DS.$document->path;
        if((($product->pic_path !== NULL) && ($type == 'pic')) || (($product->doc_path !== NULL) && ($type == 'doc'))){
            if($type == 'pic')
                $path = 'uploads'.DS.$product->pic_path;
            elseif($type == 'doc')
                $path = 'uploads'.DS.$product->doc_path;
            else
                $this->Flash->error(__('Type fichier non déclaré'));
                //throw new NotFoundException(__('Type fichier non déclaré !'));
            if(file_exists($path))
                unlink($path);
            else
                //throw new NotFoundException(__('Fichier non trouvé !'));
                $this->Flash->error(__('Fichier non trouvé pour la suppression !'));
        }
    }
    /**
     * Delete Stock by Id Product
     * 
     */
    private function DeleteStockByPrId($id){
        $this->loadModel('Stocks');
        $StocksTable = TableRegistry::get('Stocks');
        $Stocks = $this->Stocks->find('all')->where(['product_id' => $id])->toArray();
        foreach($Stocks as $stock){
            $stockRow = $StocksTable->newEntity();
            //debug($dependency['id']); die();
            $idStock = $stock['id'];
            $stockRow = $StocksTable->get($idStock);
            $result = $this->Stocks->delete($stockRow);
        }
    }
    
    private function updateAssociations($quota, $id, $is_considered = 0){
        // $is_considered = 1 => categories considered in the lots/add
        // $is_considered = 0 => categories not considered in the lots/add
        foreach ($quota as $key => $value) {
            $associationController = New AssociationsController;
            $association = $associationController->getAssoc_ByProduct_Cat($id, $value);
            $associationsTable = $this->loadModel('Associations');
            $associationTable = TableRegistry::get('Associations');
            $association = $associationTable->get($association[0]['id']);
            $association->is_considered = $is_considered;
            $associationTable->save($association);
        }
    }
    
    private function getCategIds($with_quota, $without_quota){
        if(($with_quota === NULL)&&($without_quota  === NULL))
            return array();
        elseif($with_quota === NULL)
            return $without_quota;
        elseif($without_quota === NULL)
            return $with_quota;
        else
            return array_merge($with_quota, $without_quota);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){
        $this->DeleteStockByPrId($id);
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        //Suppression des fichiers
        $doc_path = 'uploads'.DS.$product->doc_path;
        $pic_path = 'uploads'.DS.$product->pic_path;
        if((file_exists($doc_path)) && ($product->doc_path !== NULL)){//die($doc_path);
            unlink($doc_path);
        }elseif($product->doc_path !== NULL){
            $this->Flash->error(__('Image non trouvé pour la suppression !'));
        }
        if((file_exists($pic_path)) && ($product->pic_path !== NULL)){
            unlink($pic_path);
        }elseif($product->pic_path !== NULL){
            $this->Flash->error(__('Document non trouvé pour la suppression !'));
        }
        
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('has been deleted.', ['Le produit', '']));
        } else {
            $this->Flash->error(__('could not be deleted. Please, try again.', ['Le produit', '']));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function getNameProductById($id){
        $product = $this->Products->find('list')->where(['id' => $id])->toArray();
        //debug($product[$id]); die();
        return $product[$id];
    }
    public function getCodeProductById($id){
        $product = $this->Products->find('list', ['keyField' => 'id', 'valueField' => 'productCode'])->where(['id' => $id])->toArray();
        //debug($product[$id]); die();
        return $product[$id];
    }
    public function getNgpcodeProductById($id){
        $product = $this->Products->find('list', ['keyField' => 'id', 'valueField' => 'ngpCode'])->where(['id' => $id])->toArray();
        //debug($product[$id]); die();
        return $product[$id];
    }
    private function generateProductCode(){
        $lastRow = $this->Products->find('list', ['keyField' => 'id', 'valueField' => 'productCode'])->order(['id' => 'desc'])->first();
        //debug($lastRow);die();
        if(!$lastRow)
            return 'P0001';
        else{
            $numString = substr($lastRow, 1, strlen($lastRow) - 1);
            if(ctype_digit($numString)){
                $numInt = (int)$numString;
                if($numInt < 10) $zero = '000';
                elseif($numInt < 100) $zero = '00';
                elseif($numInt < 1000) $zero = '0';
                else $zero = '';
                return 'P'.$zero.(string)($numInt+1);
            }else{
                return 'P0001';
            }
        }
    }
}
