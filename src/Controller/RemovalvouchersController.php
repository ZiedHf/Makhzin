<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Removalvouchers Controller
 *
 * @property \App\Model\Table\RemovalvouchersTable $Removalvouchers
 */
class RemovalvouchersController extends AppController
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
        $privilege = array('index' => 1, 'view' => 1, 'printRemovalVoucher' => 3, 'add' => 3, 'edit' => 3, 'delete' => 4, 'test' => 1);
        $action = $this->request->params['action'];
        $permissionLvl = $user['Auth']['User']['files'];
        //debug($permissionLvl);die();
        if($privilege[$action] <= $permissionLvl){
            return true;
        }
        //$this->Flash->error(__('Vous n\'êtes pas autoriser d\'acceder à cette page'));
        return false;
    }
    
    /*function test(){
        $time = Time::now();
        echo $this->pad($time->month);
        die();
    }*/
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users_CreatedBy'],
            'order' => [
                'created' => 'desc'
            ]
        ];
        
        $removalvouchers = $this->paginate($this->Removalvouchers);
        
        //debug($removalvouchers);die();
        $this->set(compact('removalvouchers'));
        $this->set('_serialize', ['removalvouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Removalvoucher id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $removalvoucher = $this->Removalvouchers->get($id, [
            'contain' => ['Users_CreatedBy']
        ]);
        
        $this->set('removalvoucher', $removalvoucher);
        $this->set('_serialize', ['removalvoucher']);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($entrepositaire_id = null, $client_id = null, $carriers = null, $date = null){
        
            $time = Time::now();
            
            //Generate the number of RemovalVoucher
            $lastRow = $this->Removalvouchers->find()->order(['id' => 'desc'])->first();
            if($lastRow){
                $lenght_number = strlen($lastRow->number);
                $lastNumber = substr($lastRow->number, 11, $lenght_number-8);
                $lastMonth = substr($lastRow->number, 7, 2);
            }else{
                $lastNumber = 0;
                $lastMonth = -1;
            }
            $zero = '';
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
            $number = 'BAE' . (string)$time->year . $zeroMonth . (string)$time->month . $zeroDay . (string)$time->day . $zero . (string)$thisNumber;
            
            
        
            $removalvoucher['created_by'] = $this->user['Auth']['User']['id'];
            $removalvoucher['modified_by'] = $this->user['Auth']['User']['id'];
            $removalvoucher['number'] = $number;
            $removalvoucher['entrepositaire_id'] = $entrepositaire_id;
            $removalvoucher['client_id'] = $client_id;
            $carriers = unserialize($carriers);
            //debug($carriers); die();
            $removalvoucher['carriers']['_ids'] = $carriers;
            //$removalvoucher['date'] = $date;
            $removalvoucher['date_rv'] = $date;
            $removalvoucherEntity = $this->Removalvouchers->newEntity($removalvoucher);
            //debug($removalvoucher); die();
            //$removalvoucherEntity = $this->Removalvouchers->patchEntities($removalvoucherEntity, $removalvoucher);
            //$removalvoucherEntity->number = $number;
            //debug($removalvoucherEntity); die();
            if ($result = $this->Removalvouchers->save($removalvoucherEntity)) {
                //$this->Flash->success(__('The removalvoucher has been saved.'));
                $this->Flash->success(__('has been saved.', ['Le bon à enlever', '']));
                return $result->id;
            } else {
                //$this->Flash->error(__('The removalvoucher could not be saved. Please, try again.'));
                $this->Flash->error(__('could not be saved. Please, try again.', ['Le bon à enlever', '']));
                return false;
            }
        //}
        //$this->set(compact('removalvoucher'));
        //$this->set('_serialize', ['removalvoucher']);
    }
    
    function pad($num){
        if($num < 10) $num_str = '0'.(string)$num;
        return $num_str;
    }
    /**
     * Edit method
     *
     * @param string|null $id Removalvoucher id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $removalvoucher = $this->Removalvouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $removalvoucher = $this->Removalvouchers->patchEntity($removalvoucher, $this->request->data);
            if ($this->Removalvouchers->save($removalvoucher)) {
                $this->Flash->success(__('The removalvoucher has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The removalvoucher could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('removalvoucher'));
        $this->set('_serialize', ['removalvoucher']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Removalvoucher id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $removalvoucher = $this->Removalvouchers->get($id);
        if ($this->Removalvouchers->delete($removalvoucher)) {
            $this->Flash->success(__('The removalvoucher has been deleted.'));
        } else {
            $this->Flash->error(__('The removalvoucher could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function printRemovalVoucher($id_rv = null){
        $outputsets = new OutputsetsController;
        $outputsets->integrateOutput($id_rv);
        $checkOutputSets = $outputsets->getopsByrv($id_rv);
        $outPutSetsData = $outputsets->dataOutputSets($checkOutputSets);
        //$this->viewBuilder()->layout('');
        $this->viewBuilder()->layout('Print');
        
        $allOutputs = $outPutSetsData['allOutputs'];
        unset($outPutSetsData['allOutputs']);
        //debug($outPutSetsData);die();
        $statuts = unserialize(STATS_FILES);
        $arraySatut = unserialize(STATS_OUTPUTSETS);
        $firstelement = current($outPutSetsData);
        $nameEntrepositaire = $firstelement['nameClient'];
        $nameProvider = $firstelement['nameProvider'];
        $idClient = $this->getClientById($id_rv);
        $clientsController = New ClientsController;
        $nameClient = $clientsController->getNameClientById($idClient);
        
        //nom title header
        $nameHeader = 'Bon à enlever';
        $this->set(compact('outPutSetsData', 'statuts', 'nameHeader', 'arraySatut', 'nameClient', 'nameEntrepositaire', 'nameProvider', 'allOutputs'));
    }
    
    public function getClientById($id_rv){ // retourner le client d'un RV
        $rv = $this->Removalvouchers->find('all')->where(['id' => $id_rv])->toArray();
        return $rv[0]['client_id'];
    }
}
