<?php
/**
 * HomeController 
 */ 
require_once('BaseController.php');

class HomeController extends Controller
{
    public function index()
    {
        $this->view( __FUNCTION__);
    }
}

