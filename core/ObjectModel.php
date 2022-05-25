<?php 
abstract class ObjectModel {

    /** @var int Id de l'objet */
    public $id;

    /** @var string Nom de la table associé en BD */
    protected $table ;

    /** @var array Tableau des champs de l'objet à definir en BD */
    public $fields= array();

    function __construct($id = null) {
        $this->define();
        if($id != null){
            $obj = $this->getObjectById($id);
            foreach($this->fields as $field){
                $this->{$field['name']} = $obj[$field['name']];
            }
        }
        $this->createTable();

    }

    /**
     * Methode pour les classes enfant pour definir les champs de l'objet
     *
     * @return void
     */
    abstract protected function define();

    /**
     * Reconstruit l'objet avec les valeur de la BD
     *
     * @return void
     */
    public function refresh(){
        if(isset($this->id) && !empty($this->id)){
            $this->__construct($this->id);
        }
    }

    /**
     * Construit la table en BD
     *
     * @return void
     */
    protected function createTable(){
        $var = "";
        foreach($this->fields as $field){
            $var .= $field['name']. " " . $field['type'] . " " . $field['more'] .",";
        }
        $var = substr($var, 0, -1);

        $db = DataBase::connectdb();
        $sql ="CREATE table IF NOT EXISTS $this->table(". $var .");";
        $db->exec($sql);
    }

    public function delete(){
        if(isset($this->id) && !empty($this->id)){
            $db = DataBase::connectdb();
            $sql ="DELETE from $this->table  WHERE id  = " . $this->id;
            $db->query($sql);
        }
    }

    /**
     * Crée ou modifier l'objet selon si il existe deja ou non et applique les modification en BD
     *
     * @return void
     */
    public function save(){
        if ($this->id == null){
            $this->create();
        } 
        else{
            $this->update();
        }
        $obj = $this->getObjectById($this->id);
        foreach($this->fields as $field){
            $this->{$field['name']} = $obj[$field['name']];
        }

    }

    /**
     * Modifie l'objet en BD
     *
     * @return void
     */
    protected function update(){
        $var = "";
        foreach($this->fields as $field){
            $val = $this->{$field['name']};
            if($field['type'] == "BIT(1)") $var .= $field['name']. " =  " . $val . ",";
            else if(!empty($val)) $var .= $field['name']. " =  '" . $val . "',";
        }
        $var = substr($var, 0, -1);



        $db = DataBase::connectdb();
        $sql =" UPDATE $this->table   
                SET ". $var ."  WHERE id  = " . $this->id;

        $db->exec($sql);
    }

     /**
     * Crée l'objet en BD
     *
     * @return void
     */
    protected function create(){
        $value = "";
        $var = "" ;
        foreach($this->fields as $field){
            $val = $this->{$field['name']};
           
            if (!empty($val)){
                if (is_string($val))$value .= '"'. $val . '",';
                else $value .=  $val . ','; 
                $var .=  $field['name'] . ",";
            } 
          
        }
        $value = substr($value, 0, -1);
        $var = substr($var, 0, -1);

        $db = DataBase::connectdb();
        $sql ="INSERT INTO $this->table (". $var .") VALUES (". $value .") ;";
        var_dump($sql);
        $db->exec($sql);
        $this->id = $db->lastInsertId();
    }

    /**
     * Retourne la liste de tout les elements de la table
     *
     * @return array
     */
    public function getAll(){
        $db = DataBase::connectdb();
        $sql ="SELECT * from " . $this->table;
        $objects = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $objects;
    }
    
    /**
     * Retourne un objet selon le champ definit
     * 
     * @param string $var Nom du champ
     * @param string $val Valeur du champ
     * @return array
     */
    public function getObjectBy(string $var, string $val){
        $db = DataBase::connectdb();
        $sql ="SELECT * from $this->table where $var = '$val' ";
        $object = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $object;
    }

    /**
     * Retourne un objet selon son id
     *
     * @param integer $id Id de l'objet
     * @return void
     */
    public function getObjectById(int $id){
        $db = DataBase::connectdb();
        $sql ="SELECT * from $this->table where id = $id ";
        $object = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $object;
    }

    /**
     * Retourne si l'objet existe en BD ou non selon un champ choisit
     *
     * @param string $var Nom du champ
     * @param string $val Valeur du champ
     * @return boolean
     */
    public function isObjectExistBy(string $var, string $val){
        $db = DataBase::connectdb();
        $sql ="SELECT * from ".$this->table." where ".$var." = '".$val."' ";
        $object = $db->query($sql)->fetch();
        if($object == false){
            return false;
        }
        return true;
    }
}