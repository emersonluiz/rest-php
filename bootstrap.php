<?php
//Config Entity Manager Doctrine
 
//Autoload Classes
require 'vendor/autoload.php';

//Doctrine namespaces
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

//Entity directory
$entidades = array("src/model/");
$isDevMode = true;

//Config connection
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'my-user',
    'password' => 'my-pass',
    'dbname'   => 'crm'
);

//Set config
$config = Setup::createAnnotationMetadataConfiguration($entidades, $isDevMode);

//Create Entity Manager
$entityManager = EntityManager::create($dbParams, $config);
