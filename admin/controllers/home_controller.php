<?php
require_once('controllers/base_controller.php');
//Tạo lớp HomeController kế thừa từ lớp BaseController
class HomeController extends BaseController
{
    function __construct()
    {
        $this->folder = 'home';
        //Chỉ định thư mục home là thư mục lưu các file của view trong module home.
    }

    public function index()
    {
        $data = array();
        $this->render('index', $data); //Gọi đến index view.
    }
    
    public function error()
    {
        $this->render('error'); //Gọi đến error view.
    }
}