<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

session_start();


class ProductController extends Controller
{
    public function indexAction()
    {

        $ch = curl_init();
        $url = "http://172.23.0.4/api/robots";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);
        // print_r($contents);die;

        $this->view->data = json_decode($contents);
    }
    public function addAction()
    {
        // defalt page for add
    }
    public function addnewAction()
    {

        $ch = curl_init();
        $url = "http://172.23.0.4/api/robots";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $r = curl_exec($ch);
        curl_close($ch);
        $this->response->redirect('/product/index');
    }

    public function deleteAction()
    {

        $id = $_GET['id'];
        $ch = curl_init();
        $url = "http://172.23.0.4/api/robots/$id";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $contents = curl_exec($ch);
        $this->response->redirect("product/index");
    }
    public function editAction()
    {
        $id = $_GET['id'];

        $ch = curl_init();
        $url = "http://172.23.0.4/api/robots/$id";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($ch);

        $this->view->data = json_decode($contents);
    }
    public function updateAction()
    {

        $id = $_GET['id'];
        $ch = curl_init();
        $url = "http://172.23.0.4/api/robots/$id";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "put");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_POST));
        $contents = curl_exec($ch);

        print_r($contents);
        $this->response->redirect("product/index");
    }
}
