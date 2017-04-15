<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Controller\Controller;

/**
 * Lots Controller
 *
 * @property \App\Model\Table\LotsTable $Lots
 */
class LotsController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'add' => 2, 'updateActualQte' => 2, 'traitementAjaxQuota' => 2, 'edit' => 3, 'delete' => 4);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['lots'];
        
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
    public function index($stat = null)
    {
        
        //filtrer les résultat
        if($stat === '0') //pas encore en stock
            $condition = 'Files.statut = 0';
        elseif($stat === '1') //en stock mais pas encore sorti
            $condition = 'Files.statut = 1 and Lots.remainedQte = Lots.actualQte';
        elseif($stat === '2') // en cours de livraison
            $condition = 'Files.statut = 1 and Lots.remainedQte < Lots.actualQte and Lots.remainedQte > 0';
        elseif($stat === '3') //lot terminés (Dossier en stock)
            $condition = 'Files.statut = 1 and Lots.remainedQte = 0';
        elseif($stat === '4') //lots des dossier terminé
            $condition = 'Files.statut = 2 and Lots.remainedQte = 0';
        else
            $condition = '';
            
        $this->paginate = [
            'contain' => ['Products', 'Clients', 'Zones', 'Inputs', 'Files'],
            'maxLimit' => 15,
            'sortWhitelist' => ['Files.statut', 'Files.number', 'number', 'Clients.name', 'Products.name', 'expectedQte', 'actualQte', 'remainedQte', 'deadline', 'created'],
            'order' => [
                'created' => 'desc'
            ],
            'conditions' => $condition
        ];
            //'conditions' => ['And' => ['Files.statut' => '0', 'And' => ['Files.statut' => '1', 'Lots.remainedQte' => '0']]]
        
        $numberRows = 15;
        $lots = $this->paginate($this->Lots);
        $statuts = unserialize(STATS_FILES);
        $this->set(compact('statuts', 'stat'));
        $this->set(compact('lots', 'numberRows'));
        $this->set('_serialize', ['lots']);
    }

    /**
     * View method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lot = $this->Lots->get($id, [
            'contain' => ['Products', 'Clients', 'Zones', 'Inputs', 'Files', 'Outputs'],
            'maxLimit' => 15
        ]);
        $fileStat = $lot->file->statut;
        $remainedQte = $lot->remainedQte;
        $expectedQte = $lot->expectedQte;
        $actualQte = $lot->actualQte;
        if($fileStat == 0)
            $lotStat = 'Pas encore en stock';
        elseif(($fileStat == 1)&&($remainedQte == $actualQte))
            $lotStat = 'Pas encore sorti';
        elseif(($fileStat == 1)&&($remainedQte < $actualQte)&&($remainedQte > 0))
            $lotStat = 'en cours de livraison';
        elseif(($fileStat == 1)&&($remainedQte == 0)) //Dossier non terminé
            $lotStat = 'Terminé';
        elseif(($fileStat == 2)&&($remainedQte == 0)) //Tout le dossier terminé
            $lotStat = 'Terminé';
        else
            $lotStat = '-';
        
        //die($fileStat .'--'.$remainedQte .'--'.$expectedQte);
        $this->set(compact('lotStat'));
        $this->set('lot', $lot);
        $this->set('_serialize', ['lot']);
        
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($idFile = null){
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        } else {
            $file = $this->Lots->Files->get($idFile)->toArray();
        }
        
        if($file['statut'] != 0){
            throw new NotFoundException(__('Vous ne pouvez pas ajouter un lot à ce dossier !'));
        }
        
        
        
        $time = Time::now();
        //Recuperer le dernier numero du lot
        $lastRow = $this->Lots->find()->order(['id' => 'desc'])->first();
        if($lastRow){
            $lenght_number = strlen($lastRow->number);
            $lastNumber = substr($lastRow->number, 9, $lenght_number-6);
            $lastMonth = substr($lastRow->number, 5, 2);
        }else{
            $lastNumber = 0;
            $lastMonth = -1;
        }
        
        
        $zero = '';
        //echo $time->month;
        if($lastMonth == $time->month){
            //Si on est dans le même mois on ajout 1
            $thisNumber = (int)($lastNumber + 1);
            //Ajouter les zero au nouveau numero, Exp : 201611 => 201601001 AnneeMoisNumero
            if($thisNumber < 10) $zero = '00';
            elseif($thisNumber < 100) $zero = '0';
        }else{
            //sinon reinitialiser le compteur
            $thisNumber = '001';
            
        }
        //Ajouter les zero au nouveau numero, Exp : 201611 => 201601001 AnneeMoisNumero
        if($time->month<10) $zeroMonth = '0';
        else $zeroMonth = '';
        if($time->day < 10) $zeroDay = '0';
        else $zeroDay = '';
        //Nouveau num
        $number = 'L' . (string)$time->year . $zeroMonth . (string)$time->month . $zeroDay . (string)$time->day . $zero . (string)$thisNumber;
        //debug($number);die();
        $id_client = $file['client_id'];
        $number_doc = $file['number'];
        $id_doc = $file['id'];
        $lot = $this->Lots->newEntity();
        //Le champ deadline prend la valeur d'arrivage du dossier
        $lot->deadline = $file['startDate'];
        $lot->deadlineConsumption = $file['startDate']->addYear(1);
        
        if ($this->request->is('post')){
            //Test sur les Quota
            //Ajouter La quantité Actuelle au Stock
            /*$this->loadModel('Stocks');
            $idProduct = $this->request->data['product_id'];
            $stockRow = $this->Stocks->find('all')->where(['product_id' => $idProduct])->limit(1)->toArray();
            $stocksTable = TableRegistry::get('Stocks');
            $stock = $stocksTable->get($stockRow['0']['id']);
            $amountToInsert = $stock->amount + $this->request->data['expectedQte'];
            $stock->amount = $amountToInsert;
            $stocksTable->save($stock);*/
            //Ajouter le Lot
            $lot = $this->Lots->patchEntity($lot, $this->request->data);
            $lot->number = $number;
            //$lot->remainedQte = $lot->expectedQte;
            //$lot->actualQte = $lot->expectedQte;
            //$lot->actualQte = -1;
            $lot->created_by = $this->user['Auth']['User']['id'];
            $lot->modified_by = $this->user['Auth']['User']['id'];
            //debug($this->request->data); die();
            if ($this->Lots->save($lot)) {
                $this->Flash->success(__('has been saved.', ['Le lot', '']));
                return $this->redirect(['controller' => 'files', 'action' => 'view', $this->request->data['file_id']]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le lot', '']));
            }
        }
        //echo $idFile;
        //$products = $this->Lots->Products->find('all')->where(['approved' => true])->select(['id', 'name', 'productCode', 'unit'])->order('name')->toArray();
        $products = $this->Lots->Products->find('all')->where(['approved' => true])->select(['id', 'name', 'productCode', 'unit', 'zone_id'])->order('name');
        $products->notMatching('Lots', function ($q) use ($idFile) {
            return $q->where(['Lots.file_id' => $idFile]);
        })->toArray();
        
        
        $clients = $this->Lots->Clients->find('all')->where(['id' => $id_client])->select(['name'])->toArray();
        $client_name = $clients[0]['name'];
        $zones = $this->Lots->Zones->find('list');
        $inputs = $this->Lots->Inputs->find('list');
        $files = $this->Lots->Files->find('list');
        $this->set(compact('lot', 'products', 'clients', 'zones', 'inputs', 'files', 'number'));
        $this->set('_serialize', ['lot']);
        $this->set(compact('id_client', 'number_doc', 'id_doc', 'client_name'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($idFile = null, $id = null)
    {
        if($idFile == null) {
            throw new NotFoundException(__('Dossier invalide !'));
        } elseif($id == null) {
            throw new NotFoundException(__('Lot invalide !'));
        }
        
        $lot = $this->Lots->get($id, [
            'contain' => ['Files']
        ]);
        
        if($lot->file->statut > 0) {
            throw new NotFoundException(__('Le dossier a été validé !'));
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lot = $this->Lots->patchEntity($lot, $this->request->data);
            $lot->modified_by = $this->user['Auth']['User']['id'];
            if ($this->Lots->save($lot)) {
                $this->Flash->success(__('has been saved.', ['Le lot', '']));
                return $this->redirect(['controller' => 'Files', 'action' => 'view', $idFile]);
            } else {
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le lot', '']));
            }
        }
        //$products = $this->Lots->Products->find('list', ['limit' => 200]);
        $products = $this->Lots->Products->find('all')
                                        ->where(['approved' => true])
                                        ->select(['id', 'name', 'productCode'])
                                        ->order('name')
                                        ->toArray();
        //debug($products);die();
        $clients = $this->Lots->Clients->find('list');
        /*$clients = $this->Lots->Clients->find('all')
                                        ->where(['approved' => true])
                                        ->select(['id', 'name', 'productCode'])
                                        ->order('name')
                                        ->toArray();
        */
        $zones = $this->Lots->Zones->find('list')->order('name');
        $inputs = $this->Lots->Inputs->find('list');
        $files = $this->Lots->Files->find('list')->order('name');
        $this->set(compact('lot', 'products', 'clients', 'zones', 'inputs', 'files'));
        $this->set('_serialize', ['lot']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Lot id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($idThisFile = null, $id = null, $idProduct = null)
    {
        if($idThisFile == null){
            throw new NotFoundException(__('Dossier invalide !'));
        }elseif($idProduct == null){
            throw new NotFoundException(__('Produit invalide !'));
        }
        $this->request->allowMethod(['post', 'delete']);
        $lot = $this->Lots->get($id);
        //debug($lot['expectedQte']);die();
        
        //Quantité du lot supprimer - Stock
        /*$this->loadModel('Stocks');
        $stockRow = $this->Stocks->find('all')->where(['product_id' => $idProduct])->limit(1)->toArray();
        $stocksTable = TableRegistry::get('Stocks');
        $stock = $stocksTable->get($stockRow['0']['id']);
        $amountToInsert = $stock->amount - $lot['expectedQte'];
        $stock->amount = $amountToInsert;
        if($stocksTable->save($stock)){*/
            if ($this->Lots->delete($lot)) {
                $this->Flash->success(__('has been deleted.', ['Le lot', '']));
            } else {
                $this->Flash->error(__('could not be deleted. Please, try again.'));
            }    
        /*}else{
                $this->Flash->error(__('Suppression de lot Erreur : Le Stock ne peut pas être modifié. Merci de réessayer encore.'));
        }*/
        
        return $this->redirect(['controller' => 'Files', 'action' => 'view', $idThisFile]);
    }
    /**
     * 
     * @param type $idProduct
     * @return type
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
    /**
     * 
     * @param type $idcategory
     * @return type
     */
    public function getQuotaByIdCategory($idcategory){
        $this->loadModel('Dependencies');
        $dependency = $this->Dependencies->find('all')->where(['And' => ['id_category1' => $idcategory, 'id_category2' => $idcategory]])->toArray();
        return $dependency[0]['quota'];
    }
    
    public function getNameByIdCategory($idcategory){
        $this->loadModel('Categories');
        $category = $this->Categories->get($idcategory)->toArray();
        return $category['name'];
    }
    /**
     * 
     * @param type $idcategory
     * @return type
     */
    public function getQuotaToleranceByIdCategory($idcategory){
        $this->loadModel('Dependencies');
        $dependency = $this->Dependencies->find('all')->where(['And' => ['id_category1' => $idcategory, 'id_category2' => $idcategory]])->toArray();
        $result['quota'] = $dependency[0]['quota'];
        $result['tolerance'] = $dependency[0]['tolerance'];
        return $result;
    }
    
    /**
     * 
     * @param type $infoTab
     * @return type
     */
    public function getMinStockLibreAndTolerance($infoTab, $subjectToQuota){
        /*if($infoTab['product']['quota'] === null){
            $minStockLibre = 'quotaNotConsidered';
            $tolerance = 'quotaNotConsidered';
        }else*/
        if($subjectToQuota == false){
            $minStockLibre = $infoTab['product']['quota'] - $infoTab['product']['stock'];
            $tolerance = $infoTab['product']['tolerance'];
        }else{
            $minStockLibre = 'Null';
            $tolerance = 'Null';
            //debug('test');
        }
        //debug($minStockLibre);
        $type = 'product';
        $id = $infoTab['product']['id'];
        //Les Categories
        if(!empty($infoTab['categories']))
        foreach ($infoTab['categories'] as $key => $value){
            $stockLibre = $value['quota'] - $value['stock'];
            //Si le quota de produit est non considéré
            /*if($minStockLibre == 'quotaNotConsidered'){
                $minStockLibre = $stockLibre + 99999;
                $tolerance = 0;
            }*/
            //debug($minStockLibre.'---'.$stockLibre);
            //return $minStockLibre;
            if(($minStockLibre === 'Null')||($stockLibre < $minStockLibre)){
                
                $minStockLibre = $stockLibre;
                //debug($minStockLibre);
                $tolerance = $value['tolerance'];
                $type = 'category';
                $id = $value['id'];
            }elseif(($stockLibre == $minStockLibre)&&(($value['tolerance'] < $tolerance)||($tolerance == 'Null'))){
                $tolerance = $value['tolerance'];
                $type = 'category';
                $id = $value['id'];
            }
        }
        
        //Les Dependances
        if(!empty($infoTab['dependencies']))
        foreach ($infoTab['dependencies'] as $key => $value) {
            $stockLibre = $value['quota'] - $value['stock'];
            if($stockLibre < $minStockLibre){
                $minStockLibre = $stockLibre;
                $tolerance = $value['tolerance'];
                $type = 'dependency';
                $id = $value['id'];
            }elseif(($stockLibre == $minStockLibre)&&($value['tolerance'] < $tolerance)){
                $tolerance = $value['tolerance'];
                $type = 'dependency';
                $id = $value['id'];
            }
        }
        //stocker les valeurs dans un array
        $stockLibreMinInfo['stockLibre'] = $minStockLibre;
        $stockLibreMinInfo['tolerance'] = $tolerance;
        $stockLibreMinInfo['type'] = $type;
        $stockLibreMinInfo['id'] = $id;
        
        return $stockLibreMinInfo;
    }
    /**
     * 
     * @param type $idProduct
     * @throws NotFoundException
     */
    public function traitementAjaxQuota($idProduct = Null){
        if($idProduct == null) {
            throw new NotFoundException(__('Produit invalide !'));
        }
        //recuperer les informations du produit
        
        $product = $this->Lots->Products->get($idProduct, ['contain' => 'Categories'])->toArray();
        //debug($product['categories'][0]['_joinData']['is_considered']);die();
        
        //InfoTab est un tableau qui va contenir les quota et les tolerance de Produit + Categories + Dependencies
        
        $infoTab['product']['id'] = $idProduct;
        $infoTab['product']['quota'] = $product['quota'];
        $infoTab['product']['tolerance'] = $product['tolerance'];
        $infoTab['product']['stock'] = $this->getStockByIdProduct($idProduct);
        
        $pasDependece = true;
        //recuperer les informations des catégories
        if(!empty($product['categories'])){
            foreach($product['categories'] as $key => $value){
                //debug($value['_joinData']['is_considered']);die();
                if($value['_joinData']['is_considered']){
                    $idcategoryTab[] = $value['id'];
                    $idCateg = $value['id'];
                    $result = $this->getQuotaToleranceByIdCategory($value['id']);
                    $product['categories'][$key]['quota'] = $result['quota'];
                    $product['categories'][$key]['tolerance'] = $result['tolerance'];
                    $infoTab['categories'][$idCateg]['id'] = $value['id'];
                    $infoTab['categories'][$idCateg]['quota'] = $result['quota'];
                    $infoTab['categories'][$idCateg]['tolerance'] = $result['tolerance'];
                    $infoTab['categories'][$idCateg]['stock'] = $this->getStockByIdCategory($value['id']);
                }else{
                    unset($product['categories'][$key]);
                }                
            }

            //recuperer les informations des dependances
            if(!empty($idcategoryTab)){
                $dependencies = $this->Dependencies->find('all')->where(['Or' => ['id_category1 IN' => $idcategoryTab, 'id_category2 IN' => $idcategoryTab]])->toArray();
                //if($dependencies->isEmpty()) $pasDependece = false;
                //$dependencies = $dependencies->toArray();
            }else{ 
                $dependencies = array();
                //$pasDependece = false;
            }
            $pasDependece = true;    
            foreach ($dependencies as $key => $value){
                //$idcategoryTab[] = $value['id'];
                //$result = $this->getQuotaToleranceByIdCategory($value['id']);
                if($value['id_category1'] != $value['id_category2']){
                    $dependencies[$key]['stock'] = $this->getStockByIdCategory($value['id_category1']) + $this->getStockByIdCategory($value['id_category2']);
                    $idDep = $value['id'];
                    $infoTab['dependencies'][$idDep]['id'] = $value['id'];
                    $infoTab['dependencies'][$idDep]['quota'] = $value['quota'];
                    $infoTab['dependencies'][$idDep]['tolerance'] = $value['tolerance'];
                    $infoTab['dependencies'][$idDep]['stock'] = $dependencies[$key]['stock'];
                    //voir s'il y a des dependance de deux categ different
                    $pasDependece = false;
                }
            }
            //recuperer le stock libre minimum
            $minStock = $this->getMinStockLibreAndTolerance($infoTab, $product['subjectToQuota']);
            //debug($minStock);
        }else{
            if($product['subjectToQuota'] == false){
                /*if($infoTab['product']['quota'] === Null){ //if quota == Null
                    $minStock['stockLibre'] = 'quotaNotConsidered';
                    $minStock['tolerance'] = 'quotaNotConsidered';
                }else{*/
                    $minStock['stockLibre'] = $infoTab['product']['quota'] - $infoTab['product']['stock'];
                    $minStock['tolerance'] = $infoTab['product']['tolerance'];
                //}
            }else{
                $minStock['stockLibre'] = 'Null';
                $minStock['tolerance'] = 'Null';
            }
            $minStock['type'] = 'product';
            $minStock['id'] = $infoTab['product']['id'];
        }
        //debug($minStock);die();
        //affichage
        //PRODUIT
        $this->set(compact('minStock', 'product', 'idcategoryTab', 'infoTab', 'pasDependece', 'dependencies'));
           /*     
        if(($minStock['type'] == 'product')&&($minStock['id'] == $product['id'])&&($minStock['stockLibre'] != 'Null')) $class = 'alert-stock';
        else $class = '';
        echo "<h3>Produit : <b><u>".$product['name']."</u></b></h3>";
        echo "<table id='catTable'>"
        . "<tr>"
            . "<th>productCode</th>"
            . "<th>ngpCode</th>"
            . "<th>barCode</th>"
            . "<th>Quota</th>"
            . "<th>Tolerance</th>"
            . "<th>Stock</th>"
        . "</tr><tr class='".$class."'>"
            . "<td>".$product['productCode']."</td>"
            . "<td>".$product['ngpCode']."</td>"
            . "<td>".$product['barCode']."</td>"
            . "<td>".$product['quota']."</td>"
            . "<td>".($product['tolerance'] === Null) ? '-' : $product['tolerance']."</td>"
            . "<td>".$infoTab['product']['stock']."</td>"
        . "</table>";
        //Information les categories
        
        echo "<br>";
        echo "<h3>Les categories : </h3>";
        if(!empty($idcategoryTab)){
            echo "<table id='catTable'>"
            . "<tr>"
                . "<th>Nom Categorie</th>"
                . "<th>Quota</th>"
                . "<th>Tolerance</th>"
                . "<th>Stock</th>"
            . "</tr>";
            foreach ($product['categories'] as $key => $value) {
                if(($minStock['type'] == 'category')&&($minStock['id'] == $value['id'])) $class = 'alert-stock';
                else $class = '';
                $idcateg = $value['id'];
                echo "<tr class='".$class."'><td>".$value['name']."</td>"
                    . "<td>".$value['quota']."</td>"
                    . "<td>".$value['tolerance']."</td>"
                    . "<td>".$infoTab['categories'][$idcateg]['stock']."</td></tr>";
            }
            echo "</table>";
        }else{
            echo "<div class='panel panel-default'>
                    <div class='panel-body'>".__('Vide', ['e', 'catégorie'])."</div>
                </div>";
        }
        //Iformation sur les dependances
        
        echo "<br>";
        echo "<h3>Les dépandances :</h3>";
        if(!$pasDependece){
        echo "<table id='depTable'>"
        . "<tr>"
            . "<th>Categorie N°1</th>"
            . "<th>Categorie N°2</th>"
            . "<th>Quota</th>"
            . "<th>Tolerance</th>"
            . "<th>Stock</th>"
        . "</tr>";
        
        foreach ($dependencies as $key => $value) {
            if(($minStock['type'] == 'dependency')&&($minStock['id'] == $value['id'])) $class = 'alert-stock';
            else $class = '';
            if($value['id_category1'] != $value['id_category2']){
                $nameCat1 = $this->getNameByIdCategory($value['id_category1']);
                $nameCat2 = $this->getNameByIdCategory($value['id_category2']);
                echo "<tr class='".$class."'><td>".$nameCat1."</td>"
                    . "<td>".$nameCat2."</td>"
                    . "<td>".$value['quota']."</td>"
                    . "<td>".$value['tolerance']."</td>"
                    . "<td>".$value['stock']."</td></tr>";
            }
        }
        echo "</table>";
        }else{
            echo "<div class='panel panel-default'>
                    <div class='panel-body'>".__('Vide', ['e', 'dépendance'])."</div>
                </div>";
        }
        echo "<div class='hide alert-quotaTolerance alert alert-info fade in'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Tolerance : </strong> <span id='mintolerance'>".$minStock['tolerance']."</span>.
                <strong>Amount Stock : </strong> <span id='amountStock'>".$minStock['stockLibre']."</span>.
              </div>";
        */
        //exit();
    }
    
    
    public function ProductQuotaVerif($idProduct) {
        if($idProduct == null) {
            throw new NotFoundException(__('Produit invalide !'));
        }
        //recuperer les informations du produit
        
        $product = $this->Lots->Products->get($idProduct, ['contain' => 'Categories'])->toArray();
        //debug($product);die();
        
        //InfoTab est un tableau qui va contenir les quota et les tolerance de Produit + Categories + Dependencies
        
        $infoTab['product']['id'] = $idProduct;
        $infoTab['product']['quota'] = $product['quota'];
        $infoTab['product']['tolerance'] = $product['tolerance'];
        $infoTab['product']['stock'] = $this->getStockByIdProduct($idProduct);
        
        
        //recuperer les informations des categories
        if(!empty($product['categories'])){
            foreach($product['categories'] as $key => $value) {
                if($value['_joinData']['is_considered']){
                    $idcategoryTab[] = $value['id'];
                    $idCateg = $value['id'];
                    $result = $this->getQuotaToleranceByIdCategory($value['id']);
                    $product['categories'][$key]['quota'] = $result['quota'];
                    $product['categories'][$key]['tolerance'] = $result['tolerance'];
                    $infoTab['categories'][$idCateg]['id'] = $value['id'];
                    $infoTab['categories'][$idCateg]['quota'] = $result['quota'];
                    $infoTab['categories'][$idCateg]['tolerance'] = $result['tolerance'];
                    $infoTab['categories'][$idCateg]['stock'] = $this->getStockByIdCategory($value['id']);
                }
                
            }

            //recuperer les informations des dependances
            if(!empty($idcategoryTab))
                $dependencies = $this->Dependencies->find('all')->where(['Or' => ['id_category1 IN' => $idcategoryTab, 'id_category2 IN' => $idcategoryTab]])->toArray();
            else 
                $dependencies = array();
            
            foreach ($dependencies as $key => $value) {
                //$idcategoryTab[] = $value['id'];
                //$result = $this->getQuotaToleranceByIdCategory($value['id']);
                if($value['id_category1'] != $value['id_category2']){
                    $dependencies[$key]['stock'] = $this->getStockByIdCategory($value['id_category1']) + $this->getStockByIdCategory($value['id_category2']);
                    $idDep = $value['id'];
                    $infoTab['dependencies'][$idDep]['id'] = $value['id'];
                    $infoTab['dependencies'][$idDep]['quota'] = $value['quota'];
                    $infoTab['dependencies'][$idDep]['tolerance'] = $value['tolerance'];
                    $infoTab['dependencies'][$idDep]['stock'] = $dependencies[$key]['stock'];
                }
            }
            //recuperer le stock libre minimum
            $minStock = $this->getMinStockLibreAndTolerance($infoTab, $product['subjectToQuota']);
            //debug($infoTab);die();
        }else{
            if($product['subjectToQuota'] == false){
                /*if($infoTab['product']['quota'] == Null){
                    $minStock['stockLibre'] = 'quotaNotConsidered';
                    $minStock['tolerance'] = 'quotaNotConsidered';
                }
                else{*/
                    $minStock['stockLibre'] = $infoTab['product']['quota'] - $infoTab['product']['stock'];
                    $minStock['tolerance'] = $infoTab['product']['tolerance'];
                //}
            }else{
                $minStock['stockLibre'] = 'Null';
                $minStock['tolerance'] = 'Null';
            }
            $minStock['type'] = 'product';
            $minStock['id'] = $infoTab['product']['id'];
            //die('aa');
        }
        
        return $minStock;
    }
    
    //update les id des inputs selon le id file
    public function updateInputIdLots($idFile = null, $idInput = null){
        if($idFile === null) {
            throw new NotFoundException(__('Dossier invalide !'));
        } elseif($idInput === null) {
            throw new NotFoundException(__('Statut invalide !'));
        }
        $lotsTable = $this->loadModel('Lots');
        $lots = $this->Lots->find('all')->where(['file_id' => $idFile])->toArray();
        foreach ($lots as $key => $value) {
            $lotTable = TableRegistry::get('Lots');
            $lot = $lotTable->get($value['id']);
            $lot->input_id = $idInput;
            $lot->modified_by = $this->user['Auth']['User']['id'];
            $lotTable->save($lot);
        }
    }
    
    //modifier valeur de remainedQte
    public function updateRemainedQte($idLot = null, $operation = null, $qte = null){
        if(($idLot === null)||($operation === null)||($qte === null)) {
            throw new NotFoundException(__('Erreur, merci de vérifier les données de la fonction : Lots > updateRemainedQte !'));
        }
        //$operation -> 'substract' or 'add'
        $lotTable = TableRegistry::get('Lots');
        $lot = $lotTable->get($idLot);
        if($operation == 'add'){
            $lot->remainedQte = $lot->remainedQte + $qte;
        }elseif($operation == 'substract'){
            $lot->remainedQte = $lot->remainedQte - $qte;
        }
        $lot->modified_by = $this->user['Auth']['User']['id'];
        $lotTable->save($lot);
        //die();
    }
    
    //get name lot by id
    public function getNumberLotById($idLot = null){
        if($idLot === null) {
            throw new NotFoundException(__('Lot invalide !'));
        }
        $lot = $this->Lots->find('all')->where(['id' => $idLot])->toArray();
        $lotNumber = $lot['0']['number'];
        return $lotNumber;
    }
    public function getIdProductByIdLot($idLot = null){
        if($idLot === null) {
            throw new NotFoundException(__('Lot invalide !'));
        }
        $lot = $this->Lots->find('all')->where(['id' => $idLot])->toArray();
        $product_id = $lot['0']['product_id'];
        return $product_id;
    }
    
    public function updateActualQte($idLot = null, $actualQte = null){ // fonction Ajax
        if(($idLot === null)||($actualQte === null)){
            throw new NotFoundException(__('Erreur Ajax !'));
        }
        if($actualQte > 0){ // Si la quantité est valide on change dans la bd
            $lotTable = TableRegistry::get('Lots');
            $lot = $lotTable->get($idLot);
            $lot->actualQte = $actualQte;
            $lot->modified_by = $this->user['Auth']['User']['id'];
            $lotTable->save($lot);
            $error = false;
            if($lot->actualQte == $lot->expectedQte){ // Si la quantité egale a ce que est prévu on affiche la validation
                $icon = "<i class='fa fa-check-circle-o color-green' aria-hidden='true'></i>";
            }else{ //sinon danger
                $icon = "<i class='fa fa-exclamation-triangle color-red' aria-hidden='true'></i>";
            }
        }else{ //affichage d'un msg d'erreur et ne sauvegarde pas ds la bd
            $error = true;
            $icon = "";
        }
        
        
        if(! $error)
            $html = '<a href="#" data-toggle="modal" data-target="#IdLot_'.$idLot.'">'
                    . '<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cliquez pour modifier"> '
                    . $actualQte.' '.$icon.'</button></a>';
        else
            $html = '<div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Erreur !</strong> La quantité ne peut pas être négative ou nulle.
                      </div>';
        
        $data = json_encode(array("error" => $error, 'idLot' => $idLot, 'actualQte' => $actualQte, 'html' => $html));
        
        //print json_encode($winetable);
        $this->viewBuilder()->autoLayout(false);
        $this->set(compact('data'));
        //$this->set(compact('winetable'));
    }
}
