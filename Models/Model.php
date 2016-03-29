<?php
	
abstract class Model
{
    protected $errorAttribute = array();
    protected $listErrors = array();
    protected $describe = null;
    protected $data = array();
    protected $dbh = null;
    protected $link = null;
    protected $table;
    protected $id;
    protected $primaryKey = null;

    public function __construct($mixed=null)
    {
        $this->id = $mixed;
        if(!is_null($this->id)) {
            $this->data = $this->getById($this->id);
        }
    }

    public function getDescribe () 
    {
        if (is_null($this->describe)) {
            $sth = $this->dbh()->prepare("describe ".$this->table);
            $sth->execute();
            foreach ($sth->fetchAll() as $champ) {
                $this->describe[$champ['Field']] = '';
            }
        }
    }

    public function set($key, $value)
    {
        $this->getDescribe();
         if (array_key_exists ($key, $this->describe)) {
            $m = 'check'.$key;
            $check = method_exists($this, $m);
            if (!$check || ($check&& $this->$m($value))) {
                $this->data[$key] = $value;
            }
        }
        return $this;
    }

    public function insert()
    {
        $sql = "INSERT INTO ".$this->table." ".
                    "(".implode(', ', array_keys($this->data)).") ".
                    "VALUES ".
                    "('".implode("', '" , $this->data)."') ";
                    
        $sth = $this->dbh()->prepare($sql);
        return $sth->execute();
    }

    public function update()
    {
        if (is_null ($this->id) || is_null($this->primaryKey))
            throw new Exception ("Impossible de faire l'update avec une valeur null pour id.");
        
        $sql =
            "UPDATE ".$this->table." ".
            "SET ".implode (', ', $this->forupdate()).
            " WHERE {$this->primaryKey} = '{$this->id}'";
            echo $sql;
        $sth = $this->dbh()->prepare($sql);
        return $sth->execute();
    }

    protected function forupdate ()
    {
        $champs = array ();
        foreach ($this->data as $key => $value)
            $champs[$key] = "{$key} = '{$value}'";
        return $champs;
    }

    public function fetch($start=0, $max=100, $orderby='')
    {
        $sth = $this->dbh()->prepare("SELECT * FROM ".$this->table." $orderby LIMIT $start, $max");
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public function getById($id)
    {
        $sth = $this->dbh()->prepare("SELECT * FROM ".$this->table." WHERE {$this->primaryKey} = ".$id);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteById($id)
    {
        $sth = $this->dbh()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey}= ".$id);
        return $sth->execute();
    }

    public function dbh ()
    {
        if (!$this->dbIsConnected()) {
            $this->connect();
        }
        return isset($GLOBALS['dbh']) ? $GLOBALS['dbh'] : null ;
    }

    public function dbIsConnected()
    {
        return isset($GLOBALS['dbh']);
    }

    public function connect()
    {
        try {
            $GLOBALS['dbh'] = new PDO("mysql:host=".DBH_HOST.";dbname=".DBH_NAME.";charset=utf8", DBH_USER, DBH_PASS);
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() ."<p>";
        }
    }

    /**
     * 
     * @param   str $attribute      
     * @param   str $messageError           
    */
    public function addErrorMessage($attribute, $messageError)
    {
        $this->listErrors[$attribute][] = $messageError;
         return $this;
    }

    public function addErrorAttribute($attribute)
    {
        $this->errorAttribute[] = $attribute;
        return $this;
    }

    /**
     * @param   str $attribut      
     * @return   $listError  or ""         
    */
    public function getAttributErrorMessages($attribute)
    {
        return (in_array($attribute, $this->errorAttribute) && isset($this->listErrors[$attribute]))? 
        $this->listErrors[$attribute] : array();
    }

    /**
    * @return   1 or 0          valide ou not
    */
    public function IsValid()
    {
        return (count($this->errorAttribute)==0);
    }

    public function __call($method, $args)
    {
        $trace = debug_backtrace();
        trigger_error('Méthode membre non-définie : ' . $method .
                                     ' dans ' . $trace[0]['file'] .
                                     ' à la ligne ' . $trace[0]['line'],
                                     E_USER_WARNING);
    }
    
    public static function __callStatic($method, $args)
    {
        $trace = debug_backtrace();
        trigger_error('Méthode static non-définie : ' . $method .
                                     ' dans ' . $trace[0]['file'] .
                                     ' à la ligne ' . $trace[0]['line'],
                                     E_USER_WARNING);
    }
    
    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        
        // $trace = debug_backtrace ();
        // trigger_error('Propriété non-définie : ' . $key .
        //                              ' dans ' . $trace[0]['file'] .
        //                              ' à la ligne ' . $trace[0]['line'],
        //                              E_USER_NOTICE);<div></div>
        return null;
    }
    
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }
    
    public function __isset($key)
    {
        return array_key_exists($key, $this->data);
    }
    
    public function __unset($key)
    {
        unset ($this->data[$key]);
    }
    
    public function __toString()
    {
        return serialize($this->data);
    }
    
    public function toArray()
    {
        return $this->data;
    }

}
