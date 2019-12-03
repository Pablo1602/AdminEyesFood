<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tiendas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Perfil de Tienda";
            $subTitleContent = "Perfil";
            $level = "Perfil de Tienda";
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
                $pdocrud->setPK("idTienda");
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $pdocrud->setViewColumns(array("nombre","email","descripcion","telefono","facebook","twitter","instagram","direccion","paginaWeb"));
                $pdocrud->fieldRenameLable("paginaWeb", "Pagina Web");//Rename label
                $experto = $pdocrud->dbTable("tiendas")->render("VIEWFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 0;
                $this->template("Tiendas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            //Si es administrador
        }else{
             $this->load->view('403');
        }
    }
    
    public function editar(){
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Edicion de Perfil de Tienda";
            $subTitleContent = "Edicion de Perfil";
            $level = "Perfil de Tienda";
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
                $pdocrud->setPK("idTienda");
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $pdocrud->addCallback("after_update", "afterUpdateCallBack");
                $pdocrud->formFields(array("nombre","email","descripcion","telefono","facebook","twitter","instagram","direccion","paginaWeb"));
                $experto = $pdocrud->dbTable("tiendas")->render("EDITFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 1;
                $this->template("Tiendas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            //Si es administrador
        }else{
             $this->load->view('403');
        }
    }
    
    public function cambiarPass(){
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Edicion de Perfil de Tienda";
            $subTitleContent = "Edicion de Perfil";
            $level = "Perfil de Tienda";
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
                $pdocrud->setPK("idTienda");
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $pdocrud->addCallback("before_update", "beforeUpdateCallBack");
                $pdocrud->formFields(array("hash_password", "confirm_password"));
                $pdocrud->fieldValidationType("hash_password", "data-match", "confirm_password", "Las contraseñas no coinciden");
                $pdocrud->formStaticFields("confirm_password", "text");
                $experto = $pdocrud->dbTable("tiendas")->render("EDITFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 1;
                $this->template("Tiendas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
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
    
     public function listTiendas(){
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("0"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Administracion de Tiendas";
            $subTitleContent = "Tiendas";
            $level = "Tiendas";
            $experto = $pdocrud->dbTable("tiendas")->render();
            $data['experto'] = $experto;
            $data['aux'] = 1;
            $this->template("Tiendas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }
}