<?php
require_once('Model.php');

class Stock extends Model
{
    protected $id;
    protected $table = 'stock';
    protected $primaryKey = 'id';
    protected $foreignKey = 'productId';

    public function setDate($value)
    {
        $day = $month = $year = null;
        if (strpos($value, '/')) {
            list($day, $month, $year) = explode('/', $value);
        } elseif (strpos($value, '-')) {
            list($day, $month, $year) = explode('-', $value);
        } 
        var_dump(checkdate((int) $month, (int) $day, (int) $year));
        if (checkdate((int) $month, (int) $day, (int) $year)) {
            $this->set('dateOfStock', $year.'/'.$month.'/'.$day);
        } else {
            $this->addErrorAttribute("date")->addErrorMessage("date", " * Date invalide");
        }
        return $this;
    }

    public function getDate()
    {
        list($year, $month, $day) = explode('/', $this->dateOfStock);
        return $day.'/'. $month.'/'. $year;
    }

     protected function checkquantity($value)
     {
        $this->addErrorMessage("quantity", " * Erreur Quantité");
        if (!is_numeric($value)) {
          $this->addErrorAttribute("quantity");
          return false;
        }
        return true;
  }


    public function fetchChildrens($id)
    {
        $sth = $this->dbh()->prepare("SELECT id, DATE_FORMAT(dateOfStock, '%d/%m/%Y') 
        as date, quantite FROM {$this->table} 
            WHERE {$this->foreignKey} = ".$id);
        $sth->execute();
        return $sth->fetchAll();
    }
	
}
