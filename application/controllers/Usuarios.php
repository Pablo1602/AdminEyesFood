<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuarios extends CI_Controller {

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
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $pdocrud->crudRemoveCol(array("idUsuario","rol"));
            $pdocrud->crudTableCol(array("Nombre","Apellido","Correo","Sexo","Estatura", "rol","Activo"));
            $pdocrud->fieldTypes("Sexo", "radio");//change gender to radio button
            $pdocrud->fieldTypes("Activo", "radio");
            $pdocrud->fieldDataBinding("Sexo", array("M","F"), "", "","array");//add data for radio button
            $pdocrud->fieldDataBinding("Activo", array("Desactivado","Activado"), "", "","array");
            $pdocrud->fieldTypes("hash_password", "password", array("encryption"=>"sha1"));
            $pdocrud->checkDuplicateRecord(array("Correo"));
            $pdocrud->tableColFormatting("Sexo", "replace",array("0" =>"M"));
            $pdocrud->tableColFormatting("Sexo", "replace",array("1" =>"F"));
            $pdocrud->tableColFormatting("Activo", "replace",array("0" =>"Desactivado"));
            $pdocrud->tableColFormatting("Activo", "replace",array("1" =>"Activado"));
            $pdocrud->formFields(array("Nombre","Apellido","Correo", "hash_password", "Sexo","Activo"));
            $pdocrud->editFormFields(array("Nombre","Apellido", "Correo", "Sexo","Activo"));
            $pdocrud->buttonHide($buttonname="cancel");
            $pdocrud->where("rol","5","=");
            $usuarios = $pdocrud->dbTable("usuarios");
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Usuarios";
            $subTitleContent = "Administracion de Usuarios";
            $level = "Usuarios";
            $data['usuarios'] = $usuarios;
            $this->template->set('title', 'Usuarios');
            $this->template->set('username', $username);
            $this->template->set('nombreApellido', $nombreApellido);
            $this->template->set('titleContent', $titleContent);
            $this->template->set('subTitleContent', $subTitleContent);
            $this->template->set('level', $level);
            $this->template->set('rol', $rol);
            $this->template->load('default_layout', 'contents' , 'usuarios', $data);
        }else{
             $this->load->view('403');
        }
    }
    
    public function perfil() {
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Perfil de Usuario";
            $subTitleContent = "Perfil";
            $level = "Perfil de Usuario";
            $pdocrud->setPK("idUsuario");
            $pdocrud->setSettings("viewBackButton", false);
            $pdocrud->setSettings("viewPrintButton", false);
            $pdocrud->setViewColumns(array("nombre", "apellido", "correo"));
            $experto = $pdocrud->dbTable("usuarios")->render("VIEWFORM",array("id" =>$pdocrud->getUserSession("userId")));
            $data['experto'] = $experto;
            $data['aux'] = 2;
            $this->template("Usuario", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }
    
    public function editar() {
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Edicion de Perfil de Usuario";
            $subTitleContent = "Edicion de Usuario";
            $level = "Perfil de Usuario";
            
            //Si esta activo
                $pdocrud->setPK("idUsuario");
                $pdocrud->addCallback("after_update", "afterUpdateCallBack2");
                $pdocrud->formFields(array("Nombre","Apellido","Correo"));
                $experto = $pdocrud->dbTable("usuarios")->render("EDITFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 1;
                $this->template("Usuarios", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso

            //Si es administrador
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
}