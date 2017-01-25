<?php
require_once('Model.php');

class Product extends Model
{
    protected $id;
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected function checkprice($value)
    {
        $this->addErrorMessage("quatity", " * Erreur Prix Unitaire");
        if (!is_numeric($value)) {
          $this->addErrorAttribute("price");
          return false;
        }
        return true;
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
  protected function checkvat($value)
  {
        $this->addErrorMessage("vat", " * Erreur TVA");
        if (!is_numeric($value)) {
          $this->addErrorAttribute("vat");
          return false;
        }
        return true;
  }
}
