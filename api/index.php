<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;



// Use Loader() to autoload our model
$loader = new Loader();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/html/');

require_once APP_PATH . '/vendor/autoload.php';

$loader->registerDirs(
    [
        APP_PATH . "/models/",
    ]
);

$loader->registerNamespaces(
    [
        'Store\Toys' => APP_PATH . '/models/',
    ]
);

$loader->register();

$container = new FactoryDefault();

// Set up the database service


$container->set(
    'mongo',
    function () {
        $mongo = new MongoDB\Client(
            'mongodb+srv://deekshapandey:Deeksha123@cluster0.whrrrpj.mongodb.net/?retryWrites=true&w=majority'
        );

        return $mongo->api;
    },
    true
);

$app = new Micro($container);



// // Retrieves all products

$app->get(
    '/api/robots',
    function () use ($app) {
        $robot = $this->mongo->movies->find();
        $data = [];
        foreach ($robot as $value) {

            $data[] = [
                "name" => $value->name,
                "id" => $value->id,
                "type" => $value->type,
            ];
        }
        echo json_encode($data);
    }
);
// Searches for products with $name in their name
$app->get(
    '/api/robots/search/{name}',
    function ($name) use ($app) {
        $robot = $this->mongo->movies->findOne(["name" => $name]);

        $data = [];
        $data[] = [
            "name" => $robot->name,
            "id" => $robot->id,
            "type" => $robot->type,
        ];


        echo json_encode($data);
    }

);

// Retrieves products based on primary key
$app->get(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $product = $this->mongo->movies->findOne(['id' => $id]);
        $data = [];
        $data[] = [
            'id'   => $product->id,
            'name' => $product->name,
            'type' => $product->type,
        ];
        echo json_encode($data);
    }
);

// Adds a new product
$app->post(
    '/api/robots',
    function () use ($app) {
        $payload = [
            "id" => $_POST['id'],
            "name" => $_POST['name'],
            "type" => $_POST['type'],
        ];
        $collection = $this->mongo->movies;
        $status = $collection->insertOne($payload);
        print_r($status ->getInsertedCount());
    }
);

// Updates product based on primary key
$app->put(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $robot = $app->request->getJsonRawBody();
        $payload = [
            "name" => $robot->name,
            "type" => $robot->type,
        ];
        $collection = $this->mongo->movies;
        $updateResult = $collection->updateOne(
            ['id'  =>  $id],
            ['$set' =>  $payload]
        );
        print_r($updateResult);
    }
);

// Deletes product based on primary key
$app->delete(
    '/api/robots/{id:[0-9]+}',
    function ($id) use ($app) {
        $collection = $this->mongo->movies;
        $deleted = $collection->deleteOne(['id' => $id]);
        print_r($deleted);
        die;
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
