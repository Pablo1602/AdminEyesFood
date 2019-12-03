<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recomendaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        header("Access-Control-Allow-Origin: *");
        require_once "script/pdocrud.php";
        $pdocrud = new PDOCrud();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("0", "2"))){
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Recomendaciones";
            $subTitleContent = "Administracion de recomendaciones";
            $level = "Recomendaciones";
            if ($rol==2) {
                $estado = $pdocrud->getUserSession("estado");
                //Si esta activo
                if ($estado == 1) {
//                $pdocrud->setSettings("viewbtn", false);
//                $pdocrud->setSettings("editbtn", false);
                    $pdocrud->setSettings("delbtn", false);
                    //$pdocrud->setSettings("addbtn", false);
                    $recomendaciones = $pdocrud->dbTable("recomendaciones")->render();
                    $data['recomendaciones'] = $recomendaciones;
                    $this->template("Recomendaciones", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "recomendaciones", $data, $rol);
                //Si esta inactivo se muestra pantalla de permiso
                }else{
                    $this->load->view('estado');
                }
            //Si es administrador
            }else{
                $recomendaciones = $pdocrud->dbTable("recomendaciones")->render();
                $data['recomendaciones'] = $recomendaciones;
                $this->template("Recomendaciones", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "recomendaciones", $data, $rol);
            }
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