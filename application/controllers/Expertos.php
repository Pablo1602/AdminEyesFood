<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expertos extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function cabecera() {
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        return $pdocrud = new PDOCrud();
    }

    public function index(){
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("0"))){
            $pdocrud->crudTableCol(array("idExperto","Nombre","Apellido","Email","Especialidad","Telefono", "Direccion", "Descripcion", "PaginaWeb", "Reputacion", "rol"));
            $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "reputacion", "rol"));
            $pdocrud->editFormFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "reputacion", "rol"));
            $pdocrud->tableColFormatting("rol", "replace",array("0" =>"Nutricionista"));
            $pdocrud->tableColFormatting("rol", "replace",array("1" =>"Coucher"));
            $pdocrud->fieldTypes("rol", "radio");//change gender to radio button
            $roles = array("2"=>"Nutricionista","3"=>"Coucher");
            $pdocrud->fieldDataBinding("rol", $roles, "", "","array");//add data for radio button
            $expertos = $pdocrud->dbTable("expertos");
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Expertos";
            $subTitleContent = "Administracion de Expertos";
            $level = "Expertos";
            $data['expertos'] = $expertos;
            $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "expertos", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }
    
    public function template($title, $username, $nombreApellido, $titleContent, $subTitleContent, $level, $pagina ,$data, $rol){
        $this->template->set('title', $title);
        $this->template->set('username', $username);
        $this->template->set('nombreApellido', $nombreApellido);
        $this->template->set('titleContent', $titleContent);
        $this->template->set('subTitleContent', $subTitleContent);
        $this->template->set('level', $level);
        $this->template->set('rol', $rol);
        $this->template->load('default_layout', 'contents' , $pagina, $data);
    }
    
    public function perfil() {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("2","3"))){
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $estado = $pdocrud->getUserSession("estado");
            if ($estado == 1) {
                $pdomodel->where("email",$username,"=");
                $result =  $pdomodel->select("expertos");
                $obj = $result[0];
                $rol = $pdocrud->getUserSession("role");
                $titleContent = "Perfil";
                $subTitleContent = "Perfil de Usuario";
                $level = "Perfil";
                $pdocrud->setPK("idExperto");
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $experto = $pdocrud->dbTable("expertos")->render("VIEWFORM",array("id" =>$obj['idExperto']));
                $data['experto'] = $experto;
                $data['aux'] = 3;
                $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            
        }
    }
    
    public function editar() {
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("3","2"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Edicion de Perfil de Usuario";
            $subTitleContent = "Edicion de Perfil";
            $level = "Perfil de Usuario";
            $estado = $pdocrud->getUserSession("estado");
            if ($estado == 1) {
                $pdocrud->setPK("idExperto");
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $pdocrud->addCallback("after_update", "afterUpdateCallBack2");
                $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono","direccion","descripcion","paginaWeb"));
                $experto = $pdocrud->dbTable("expertos")->render("EDITFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 1;
                $this->template("Tiendas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            }else{
                $this->load->view('estado');
            }
        }else{
             $this->load->view('403');
        }
    }
}