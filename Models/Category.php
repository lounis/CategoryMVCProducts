<?php
/* Models : classe ProductFamilly */
require_once('Model.php');
class Category extends Model
{
    protected $id;
    protected $table = 'categories';
    protected $childrensTable = 'products';
    protected $primaryKey = 'id';
    protected $foreignKey = 'categoryId';

    public function fetchChildrens($start=0, $max=100, $orderby='')
    {
        $sth = $this->dbh()->prepare("SELECT * FROM {$this->childrensTable} 
            WHERE {$this->foreignKey} = ".$this->id." $orderby LIMIT $start, $max");
        $sth->execute();
        return $sth->fetchAll();
    }
    

    public function deleteChildrens()
    {
        $sth = $this->dbh()->prepare("DELETE FROM {$this->childrensTable} 
            WHERE {$this->foreignKey} = ".$this->id);
        $sth->execute();
    }
}

