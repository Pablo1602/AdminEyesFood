<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notificaciones extends CI_Controller {

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
        	$pdocrud->setPK("idNotificacion");
            $pdocrud->crudTableCol(array("titulo","texto","push","habilitar","fecha"));
            $pdocrud->fieldTypes("push", "radio");//change gender to radio button
            $pdocrud->fieldDataBinding("push", array("No","Si"), "", "","array");//add data for radio button
            $pdocrud->fieldTypes("habilitar", "radio");//change gender to radio button
            $pdocrud->fieldDataBinding("habilitar", array("No", "Si"), "", "","array");//add data for radio button
            $pdocrud->tableColFormatting("push", "replace",array("0" =>"No"));
            $pdocrud->tableColFormatting("push", "replace",array("1" =>"Si"));
            $pdocrud->fieldRenameLable("push", "recordatorio");//Rename label
            $pdocrud->tableColFormatting("habilitar", "replace",array("0" =>"No"));
            $pdocrud->tableColFormatting("habilitar", "replace",array("1" =>"Si"));
            $pdocrud->formFields(array("titulo","texto","push","habilitar"));
            $pdocrud->editFormFields(array("titulo","texto","push","habilitar"));
            $pdocrud->buttonHide($buttonname="cancel");
            $pdocrud->setSettings("viewbtn", false);
            $notificaciones = $pdocrud->dbTable("notificaciones");
            $data['notificaciones'] = $notificaciones;
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
			$titleContent = "Notificaciones";
            $subTitleContent = "Administración de notificaciones";
            $level = "Notificaciones";
            $this->template("Notificaciones", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "notificaciones", $data, $rol);
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