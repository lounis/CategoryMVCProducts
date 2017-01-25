<?php
require_once('BaseController.php');

class ProductsController extends Controller
{

    public function index($id=null)
    {
        $maxResultsPage = 100;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $maxResultsPage;
        if (is_null($id)) {
            $product = new Product();
            $this->viewData['items'] = $product->fetch($start, $maxResultsPage);
        } else {
            $category = new Category($id);
            $this->viewData['items'] = $category->fetchChildrens($start, $maxResultsPage);
            $this->viewData['parentItems']  = $category;
        }
        
        $this->view(__FUNCTION__);
    }


    public function addnew($id=null)
    {
        $fields_notempty = array('designation', 'quantity', 'price', 'vat', 'categoryId');
        $product = new Product();
        $this->viewData['item'] = $product;
        $category = new Category($id);
        $this->viewData['categoryItems'] = is_null($id) ? $category->fetch() : array($category->toArray()) ;

        if (!isset($_POST['designation'])) {
            $this->view(__FUNCTION__);
            return ;
        }

        foreach ($fields_notempty as $f) {
            if (!isset($_REQUEST[$f]) || empty($_REQUEST[$f])) {
                $product->addErrorAttribute($f)->addErrorMessage($f, "* field required");
            }
        }

        $product->set('designation', $_POST['designation'])
                ->set('price', $_POST['price'])
                ->set('vat', $_POST['vat'])
                ->set('quantity', $_POST['quantity'])
                ->set('categoryId', $_POST['categoryId']);

        if ($product->IsValid()) {
            $product->insert();
            /* rederiction vers index.phtml */
            $this->redirectAction("Products");
        } else {
               $this->view(__FUNCTION__);
        }
    }
    
    
    public function update($id)
    {
        $fields_notempty = array('designation', 'quantity', 'price', 'vat');
        $product = new Product($id);
        $this->viewData['item'] = $product;
        $category = new Category($product->categoryId);
        $this->viewData['parentItem'] = $category;
        // $this->viewData['categoryItems'] = $category->gfetchChildrens();
        
        if(!isset($_POST['designation'])) {
            $this->view( __FUNCTION__);
        } else {
            foreach ($fields_notempty as $f) {
                if (!isset($_REQUEST[$f]) || empty($_REQUEST[$f])) {
                    $product->addErrorAttribute($f)->addErrorMessage($f, "* field required");
                }
            }

            $product->set('designation', $_POST['designation'])
                            ->set('price', $_POST['price'])
                            ->set('vat', $_POST['vat'])
                            ->set('quantity', $_POST['quantity']);
            if ($product->IsValid()) {
                    $product->update();
                    // rederiction vers index.phtml
                    $this->redirectAction("Products");
            } else {
            	   $this->view( __FUNCTION__);
            }
        }
    }

    public function delete($id)
    {
        $product = new Product($id);
        $this->viewData['item'] = $product ;
        $this->viewData['parentItem'] = new Category($product->categoryId);
        if (isset($_POST['id'])) {
            $product->deleteById($id);
            //rederiction vers index.phtml
            $this->redirectAction("Products");
        }
            $this->view(__FUNCTION__);
    }

    public function stock($id=null)
    {
        $stock = new Stock();
        $this->viewData['item'] = $stock;
        $this->viewData['stockItems'] = $stock->fetchChildrens($id);
        if(!isset($_POST['date'])) {
            $this->view( __FUNCTION__);
        } else{
            $stock->setDate($_POST['date'])->set('quantity', $_POST['quantity']);
            if($stock->IsValid()){
            	   $stock->insert();
            	   //rederiction vers index.phtml
            	   $this->rederictAction("Products");
            }else {
            	   $this->view( __FUNCTION__);
            }
        }
    }

}


