<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Consultas extends CI_Controller {

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
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("3","2","1"))){
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Consultas";
            $subTitleContent = "Administracion de Consultas";
            $level = "Consultas";
            $estado = $pdocrud->getUserSession("estado");
            if ($estado == 1 and $rol != 1) {
                $pdomodel->where("email",$username,"=");
                $result =  $pdomodel->select("expertos");
                $obj = $result[0];
                $pdocrud->where("idExperto", $obj['idExperto'], "=");
                $pdocrud->crudTableCol(array("idUsuario","fechaConsulta","fechaRespuesta",));//optional
                $pdocrud->relatedData('idUsuario','usuarios','idUsuario','correo');
                $pdocrud->setSettings("editbtn", false);
                //$pdocrud->setSettings("delbtn", false);
                $pdocrud->setSettings("addbtn", false);
                $pdocrud->setSettings("delbtn", false);
                $pdocrud->setSettings("viewbtn", false);
                $action = base_url()."Consultas/verConsulta/{idConsulta}";//pk will be replaced by primary key value
                $text = '<i class="fa fa-eye" aria-hidden="true"></i>';
                $attr = array("title"=>"Ver");
                $pdocrud->enqueueBtnActions("url", $action, "url",$text,"fechaConsulta", $attr);
                $consultas = $pdocrud->dbTable("consultas")->render();
                $data['consultas'] = $consultas;
                $data['id']=NULL;
                $this->template("Consultas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "consultas", $data, $rol);
            //Para el usuario administrador
            }else if ($rol == 1){
                $pdocrud->crudTableCol(array("idExperto","idUsuario","fechaConsulta","fechaRespuesta",));//optional
                $pdocrud->relatedData('idUsuario','usuarios','idUsuario','correo');
                $pdocrud->relatedData('idExperto','expertos','idExperto','email');
                $pdocrud->setSettings("editbtn", false);
                //$pdocrud->setSettings("delbtn", false);
                $pdocrud->setSettings("addbtn", false);
                $pdocrud->setSettings("delbtn", false);
                $pdocrud->setSettings("viewbtn", false);
                //$pdocrud->crudRemoveCol(array("Acciones"));
                $consultas = $pdocrud->dbTable("consultas")->render();
                $data['consultas'] = $consultas;
                $data['id']=NULL;
                $this->template("Consultas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "consultas", $data, $rol);
            }
            else{
                $this->load->view('estado');
            }
            
        }else{
             $this->load->view('403');
        }
    }
    
    public function verConsulta($id){
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("3","2","1"))){
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Consultas";
            $subTitleContent = "Ver Consulta";
            $level = "Consultas";
            $estado = $pdocrud->getUserSession("estado");
            if ($estado == 1) {
                $pdocrud->setPK("idConsulta");
                $pdocrud->setViewColumns(array("idUsuario","fechaConsulta",));
                $pdocrud->setSettings("viewBackButton", false);
                $pdocrud->setSettings("viewPrintButton", false);
                $consultas = $pdocrud->dbTable("consultas")->render("VIEWFORM",array("id" =>$id));
                $data['consultas']=$consultas;
                $data['id']=$id;
                $this->template("Consultas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "consultas", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            
        }else{
            $this->load->view('403');
        }   
    }

    public function aprobarConsulta($id) {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("3","2"))){
            $estado = $pdocrud->getUserSession("estado");
            if ($estado == 1) {
                $pdomodel->where("idConsulta",$id,"=");
                $consulta =  $pdomodel->select("consultas");
                $pdomodel->where("idUsuario",$consulta[0]['idUsuario'],"=");
                $usuario =  $pdomodel->select("usuarios");
                $pdomodel->where("idExperto",$consulta[0]['idExperto'],"=");
                $experto =  $pdomodel->select("expertos");
                $destinatario = $usuario[0]['Correo'];
                //$destinatario = $usuario[0]["Correo"]; 
                $asunto = "Solicitud de Consulta"; 
                $cuerpo = ' 
                <html> 
                <head> 
                   <title>Consulta</title> 
                </head> 
                <body> 
                <h1>Hola!</h1> 
                <p> 
                <b>Su solicitud de consulta ha sido respondida</b>.</p> <p>A continuacion estan los datos del profesional de la salud al que le solicito una consulta.</p>  
                <p>Nombre: '.$experto[0]["nombre"]." ".$experto[0]["apellido"].'</p>
                <p>Correo: '.$experto[0]["email"].'</p>
                <p>Especialidad: '.$experto[0]["especialidad"].'</p>
                <p>Teléfono: '.$experto[0]["telefono"].'</p>
                <p>Dirección: '.$experto[0]["direccion"].'</p>
                <p>Web: '.$experto[0]["paginaWeb"].'</p>
                <p></p>
                 <b>Gracias por utilizar EyesFood</b>
                </body> 
                </html> 
                ';
                //para el envío en formato HTML 
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

                //dirección del remitente 
                $headers .= "From: EyesFood <eyesfoodcl@gmail.com>\r\n"; 
                mail($destinatario,$asunto,$cuerpo,$headers);
                $date = date("Y-m-d H:i:s");
                $updateData = array("fechaRespuesta"=> $date);
                $pdomodel = $pdocrud->getPDOModelObj();
                $pdomodel->where("idConsulta", $id);
                $pdomodel->update("consultas", $updateData);
                redirect('/Consultas/index/');
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
}