<?php
require_once('BaseController.php');

class CategoriesController extends Controller
{

    public function index()
    {
        $maxResultsPage = 100;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $start = ($page - 1) * $maxResultsPage;
        $category = new Category();

        $this->viewData['items'] = $category->fetch($start, $maxResultsPage);
        $this->view(__FUNCTION__);
    }


    public function addnew()
    {
        $fields_notempty = array('category',);
        $category = new Category();
        $this->viewData['item'] = $category;

        if (!isset($_POST['category'])) {
            $this->view(__FUNCTION__);
            return ;
        }

        foreach ($fields_notempty as $f) {
            if (!isset($_REQUEST[$f]) || empty($_REQUEST[$f])) {
                $category->addErrorAttribute($f)->addErrorMessage($f, "* field required");
            }
        }

        $category->set('category', $_POST['category']);

        if ($category->IsValid()) {
            $category->insert();
            /* rederiction vers index.phtml */
            $this->redirectAction("Categories");
        } else {
               $this->view(__FUNCTION__);
        }
    }
    
    
    public function update($id)
    {
        $fields_notempty = array('category');
        $category = new Category($id);
        $this->viewData['item'] = $category;
        
        if(!isset($_POST['category'])) {
            $this->view( __FUNCTION__);
        } else {
            foreach ($fields_notempty as $f) {
                if (!isset($_REQUEST[$f]) || empty($_REQUEST[$f])) {
                    $category->addErrorAttribute($f)->addErrorMessage($f, "* field required");
                }
            }

            $category->set('category', $_POST['category']);

            if ($category->IsValid()) {
                    $category->update();
                    // rederiction vers index.phtml
                    $this->redirectAction("Categories");
            } else {
            	   $this->view( __FUNCTION__);
            }
        }
    }

    public function delete($id)
    {
        $category = new Category($id);
        $this->viewData['item'] = $category ;
        
        if (isset($_POST['id'])) {
            $category->deleteChildrens();
            $category->deleteById($id);
            //rederiction vers index.phtml
            $this->redirectAction("Categories");
        }
            $this->view(__FUNCTION__);
    }

}


