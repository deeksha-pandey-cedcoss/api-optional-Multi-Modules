<?php

declare(strict_types=1);

namespace Tests\Unit;

define('BASE_PATH', dirname(__DIR__));


require_once(BASE_PATH . "/../vendor/autoload.php");

use IndexController as GlobalIndexController;
use MyApp\Controllers\IndexController;
use MyApp\Models\Users;
use MyApp\Controllers\LoginController;
use MyApp\Controllers\ProductController;

class IndexControllerTest extends AbstractUnitTest
//class UnitTest extends \PHPUnit\Framework\TestCase
{

    public function testProductsadd()
    {
        $mongo = new \MongoDB\Client(
            'mongodb+srv://deekshapandey:Deeksha123@cluster0.whrrrpj.mongodb.net/?retryWrites=true&w=majority'
        );
        $input = [
            "id" => "1",
            "name" => "book",
            "type" => "padhai",
            "price" => "100",
        ];
        $collection = $mongo->testing->products;
        $status = $collection->insertOne($input);
        $r = $status->getInsertedCount();
        $this->assertEquals($r, 1);
    }
    public function testProductsdelete()
    {
        $mongo = new \MongoDB\Client(
            'mongodb+srv://deekshapandey:Deeksha123@cluster0.whrrrpj.mongodb.net/?retryWrites=true&w=majority'
        );
        $collection = $mongo->testing->products;
        $deleted = $collection->deleteOne(['id' => "1"]);
        $r = $deleted->getDeletedCount();
        $this->assertEquals($r, 1);
    }
    public function testProductsnew()
    {
        $new = new LoginController();
        $arr = [
            "email" => "d@gmail.com",
            "password" => "123",
            "role" => "user"
        ];
        $r = $new->loginAction($arr);
        $this->assertEquals($r, "user");
    }
    public function testProductsaddnew()
    {
        $new = new ProductController();
        $input = [
            "id" => "11",
            "name" => "book",
            "type" => "padhai",
            "price" => "100",
        ];
        $r = $new->addnewAction($input);
        print_r($r);
        var_dump($r);
        $this->assertEquals($r, 1);
    }
}
