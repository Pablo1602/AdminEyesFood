<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alimento_tienda extends CI_Controller {

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
        //$pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Alimentos";
            $subTitleContent = "Administracion de Alimentos";
            $level = "Alimentos";
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
                $pdocrud->formFields(array("codigoBarras", "idTienda", "precio"));
                $pdocrud->crudTableCol(array("codigoBarras", "fecha", "precio"));
                $pdocrud->relatedData('codigoBarras','alimentos','codigoBarras','nombreAlimento');
                $pdocrud->where("idTienda", $pdocrud->getUserSession("userId"), "=");
                $pdocrud->formFieldValue("idTienda", $pdocrud->getUserSession("userId"));//set some default value for customer Id 
                //or you can entirly hide that field also
                $pdocrud->fieldHideLable("idTienda");
                $pdocrud->fieldDataAttr("idTienda", array("style"=>"display:none"));
                $action = base_url()."Alimento_tienda/ver/{pk}";//pk will be replaced by primary key value
                $text = '<i class="fa fa-external-link" aria-hidden="true"></i>';
                $attr = array("title"=>"Abrir en OpenFoodFacts");
                $pdocrud->enqueueBtnActions("url", $action, "url",$text,"precio", $attr);
                $alimentos = $pdocrud->dbTable("alimento_tienda")->render();
                $data['alimentos'] = $alimentos;
                $this->template("Alimento_tienda", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "alimento_tienda", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
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
    
    public function ver($codigo) {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $pdomodel->where("idAlimentoTienda", $codigo);
            $obj =  $pdomodel->select("alimento_tienda");
            $alimento = $obj[0];
            $url = "https://cl.openfoodfacts.org/producto/".$alimento['codigoBarras'];
            header("Location: $url");
        }else{
            $this->load->view('403');
        }
    }
    
    public function pendientes() {
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $pdocrud->crudTableCol(array("codigoBarras", "nombreAlimento", "producto", "marca", "contenidoNeto", "ingredientes", "alergenos", "trazas"));
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Alimentos Subidos Pendientes";
            $subTitleContent = "Administracion de Alimentos";
            $level = "Alimentos";
            $pdocrud->where("estadoAlimento", "2","=");
            $pdocrud->where("idTienda", $pdocrud->getUserSession("userId"), "=");
//            $pdocrud->fieldRenameLable("idUsuario", "Usuario");//Rename label
//            $pdocrud->relatedData("idUsuario", "usuarios", "idUsuario", "correo");
//            $pdocrud->tableColFormatting("estadoAlimento", "replace",array("2" =>"Pendiente"));
            $pdocrud->setSettings("viewbtn", false);
//            $action = base_url()."Alimentos/verAlimento/{idAlimentoNuevo}";//pk will be replaced by primary key value
//            $text = '<i class="fa fa-eye" aria-hidden="true"></i>';
//            $attr = array("title"=>"Ver");
//            $pdocrud->enqueueBtnActions("url", $action, "url",$text,"estadoAlimento", $attr);
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
//                $pdocrud->setSettings("viewbtn", false);
//                $pdocrud->setSettings("editbtn", false);
//                $pdocrud->setSettings("delbtn", false);
                $pdocrud->setSettings("addbtn", false);
                $pendientes = $pdocrud->dbTable("alimento_nuevo");
                $data['alimentos'] = $pendientes;
                $data['rateit'] = NULL;
                $this->template("Alimentos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "alimentos", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            //Si es administrador
        }else{
             $this->load->view('403');
        }
    }
    
    public function rechazados(){
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("4"))){
            $nombreApellido = $pdocrud->getUserSession("nombre");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Alimentos Subidos Rechazados";
            $subTitleContent = "Administracion de Alimentos";
            $level = "Alimentos";
            $pdocrud->where("estadoAlimento", "3","=");
            $pdocrud->where("idTienda", $pdocrud->getUserSession("userId"),"=");
            $pdocrud->fieldRenameLable("idUsuario", "Usuario");//Rename label
            $pdocrud->relatedData("idUsuario", "usuarios", "idUsuario", "correo");
            $pdocrud->tableColFormatting("estadoAlimento", "replace",array("3" =>"Rechazado"));
            $pdocrud->setSettings("viewbtn", false);
//            $action = base_url()."Alimentos/verAlimento/{idAlimentoNuevo}";//pk will be replaced by primary key value
//            $text = '<i class="fa fa-eye" aria-hidden="true"></i>';
//            $attr = array("title"=>"Ver");
//            $pdocrud->enqueueBtnActions("url", $action, "url",$text,"estadoAlimento", $attr);
            $estado = $pdocrud->getUserSession("estado");
            //Si esta activo
            if ($estado == 1) {
//                $pdocrud->setSettings("viewbtn", false);
            $pdocrud->setSettings("editbtn", false);
            $pdocrud->setSettings("delbtn", false);
            $rechazados = $pdocrud->dbTable("alimento_nuevo");
            $data['alimentos'] = $rechazados;
            $data['rateit'] = NULL;
            $this->template("Alimentos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "alimentos", $data, $rol);                
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
        }else{
             $this->load->view('403');
        }
    }
}