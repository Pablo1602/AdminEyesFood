<?php

@session_start();
/*enable this for development purpose */
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set(@date_default_timezone_get());
define('PDOCrudABSPATH', dirname(__FILE__) . '/');
require_once PDOCrudABSPATH . "config/config.php";
spl_autoload_register('pdocrudAutoLoad');

function pdocrudAutoLoad($class) {
    if (file_exists(PDOCrudABSPATH . "classes/" . $class . ".php"))
        require_once PDOCrudABSPATH . "classes/" . $class . ".php";
}

if (isset($_REQUEST["pdocrud_instance"])) {
    $fomplusajax = new PDOCrudAjaxCtrl();
    $fomplusajax->handleRequest();
}

//example of how to add action function
function beforeloginCallback($data, $obj) {  
    //do something like if your passwords are md5 encrypted then change the value
    $data["usuarios"]["hash_password"] = sha1($data["usuarios"]["hash_password"]);
    return $data;
}

function beforeUpdateCallback($data, $obj) {  
    //do something like if your passwords are md5 encrypted then change the value
    $data["tiendas"]["hash_password"] = sha1($data["tiendas"]["hash_password"]);
    return $data;
}

function beforeloginCallback2($data, $obj) {  
    //do something like if your passwords are md5 encrypted then change the value
    $data["expertos"]["hash_password"] = sha1($data["expertos"]["hash_password"]);
    return $data;
}
 
function afterLoginCallBack($data, $obj) {
    @session_start();
    if (count($data)) {
    //save data in session
        $_SESSION["data"] = $data;
        $obj->formRedirection("https://admineyesfood.herokuapp.com/Usuarios/index");
    }
    else{
        //no record found so don't redirect
        $obj->formRedirection("");
    }
}

function afterLoginCallBack2($data, $obj) {
    @session_start();
    if (count($data)) {
    //save data in session
        $_SESSION["data"] = $data;
        $obj->formRedirection("https://admineyesfood.herokuapp.com/Expertos/perfil");
    }
    else{
        //no record found so don't redirect
        $obj->formRedirection("");
    }
}
function afterLoginCallBackTienda($data, $obj) {
    @session_start();
    if (count($data)) {
    //save data in session
        $_SESSION["data"] = $data;
        $obj->formRedirection("https://admineyesfood.herokuapp.com/Tiendas/index");
    }
    else{
        //no record found so don't redirect
        $obj->formRedirection("");
    }
}

//example of how to add action function
function beforeloginCallbackTienda($data, $obj) {  
    //do something like if your passwords are md5 encrypted then change the value
    $data["tiendas"]["hash_password"] = sha1($data["tiendas"]["hash_password"]);
    return $data;
}

function afterRegisterCallBack($data, $obj) {
    $obj->formRedirection("https://admineyesfood.herokuapp.com/Login/registroDone");
}

function afterUpdateCallBack($data, $obj) {
    //$obj->formRedirection(base_url());
    $obj->formRedirection("https://admineyesfood.herokuapp.com/Tiendas");
}

function afterUpdateCallBack2($data, $obj) {
    //$obj->formRedirection(base_url());
    $obj->formRedirection("https://admineyesfood.herokuapp.com/Usuarios/perfil");
}