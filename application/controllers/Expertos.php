<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expertos extends CI_Controller {
    public $urlApiComments = 'https://eyesfoodapi.herokuapp.com/api.eyesfood.comments.cl/v1/';
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
        //if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
        if(false){
            $pdocrud->crudRemoveCol(array("idExperto"));
            $pdocrud->crudTableCol(array("idExperto","Nombre","Apellido","Email","Especialidad","Telefono", "Direccion", "Descripcion", "PaginaWeb", "Reputacion", "rol"));
            $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "reputacion", "rol"));
            $pdocrud->editFormFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "reputacion", "rol"));
            $pdocrud->tableColFormatting("rol", "replace",array("2" =>"Nutricionista"));
            $pdocrud->tableColFormatting("rol", "replace",array("3" =>"Coach"));
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
            $pdocrud->buttonHide($buttonname="cancel");
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
                $pdocrud->setViewColumns(array("nombre", "apellido","email","foto","especialidad","telefono","direccion","descripcion","paginaWeb"));
                $experto = $pdocrud->dbTable("expertos")->render("VIEWFORM",array("id" =>$obj['idExperto']));
                $data['experto'] = $experto;
                $data['aux'] = 3;
                $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            //Si esta inactivo se muestra pantalla de permiso
            }else{
                $this->load->view('estado');
            }
            
        }else{
             $this->load->view('403');
        }
    }
    
    public function editar() {
        $pdocrud = $this->cabecera();
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
                $pdocrud->addCallback("after_update", "afterUpdateCallBack3");
                $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono","direccion","descripcion","paginaWeb"));
                $experto = $pdocrud->dbTable("expertos")->render("EDITFORM",array("id" =>$pdocrud->getUserSession("userId")));
                $data['experto'] = $experto;
                $data['aux'] = 1;
                $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "perfil", $data, $rol);
            }else{
                $this->load->view('estado');
            }
        }else{
             $this->load->view('403');
        }
    }

    public function Nutricionistas(){
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $pdocrud->crudRemoveCol(array("idExperto","rol"));
            $pdocrud->crudTableCol(array("Nombre","Apellido","Email","Especialidad","Telefono", "Direccion", "Descripcion", "PaginaWeb","Activo"));
            $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "Activo"));
            $pdocrud->editFormFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "Activo"));
            $pdocrud->fieldTypes("Activo", "radio");
            $pdocrud->fieldDataBinding("Activo", array("Desactivado","Activado"), "", "","array");
            $pdocrud->tableColFormatting("Activo", "replace",array("0" =>"Desactivado"));
            $pdocrud->tableColFormatting("Activo", "replace",array("1" =>"Activado"));
            $pdocrud->where("rol","2","=");
            $action = "Comentarios/2/2/{pk}";//pk will be replaced by primary key value
            $text = '<i class="fa fa-comments" aria-hidden="true"></i>';
            $attr = array("title"=>"Comentarios");
            $pdocrud->enqueueBtnActions("url2", $action, "url",$text,"denuncia", $attr);
            $expertos = $pdocrud->dbTable("expertos");
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Nutricionistas";
            $subTitleContent = "Administracion de Nutricionistas";
            $level = "Nutricionistas";
            $data['expertos'] = $expertos;
            $pdocrud->buttonHide($buttonname="cancel");
            $this->template("Nutricionistas", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "expertos", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }

    public function Coach(){
        $pdocrud = $this->cabecera();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $pdocrud->crudRemoveCol(array("idExperto","rol"));
            $pdocrud->crudTableCol(array("Nombre","Apellido","Email","Especialidad","Telefono", "Direccion", "Descripcion", "PaginaWeb","activo"));
            $pdocrud->formFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "activo"));
            $pdocrud->editFormFields(array("nombre","apellido","email","especialidad","telefono", "direccion", "descripcion", "paginaWeb", "activo"));
            $pdocrud->fieldTypes("activo", "radio");
            $pdocrud->fieldDataBinding("activo", array("Desactivado","Activado"), "", "","array");
            $pdocrud->tableColFormatting("activo", "replace",array("0" =>"Desactivado"));
            $pdocrud->tableColFormatting("activo", "replace",array("1" =>"Activado"));
            $pdocrud->where("rol","3","=");
            $action = "Comentarios/2/3/{pk}";//pk will be replaced by primary key value
            $text = '<i class="fa fa-comments" aria-hidden="true"></i>';
            $attr = array("title"=>"Comentarios");
            $pdocrud->enqueueBtnActions("url2", $action, "url",$text,"denuncia", $attr);
            $expertos = $pdocrud->dbTable("expertos");
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Coach";
            $subTitleContent = "Administracion de los Coach";
            $level = "Coach";
            $data['expertos'] = $expertos;
            $pdocrud->buttonHide($buttonname="cancel");
            $this->template("Coach", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "expertos", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }

    public function comentarios($contexto, $rolExperto, $codigo) {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->
                    urlApiComments."comments/".$contexto."/".$codigo ,
                CURLOPT_USERAGENT => 'EyesFood'
            ]);
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            curl_close($curl);
            $comentarios = json_decode($resp, true);
            for($i = 0, $size = count($comentarios); $i < $size; ++$i) {
                $usuario = $this->correo($comentarios[$i]['colaborador']);
                array_push($comentarios[$i], $usuario['Correo']);
            //$people[$i]['salt'] = mt_rand(000000, 999999);
            }
            // Close request to clear up some resources
            $pdocrud->setPK("idExperto");
            $pdocrud->where("referencia", $codigo,"=");
            $pdocrud->setViewColumns(array("nombre", "apellido","email","especialidad"));
            $pdocrud->setSettings("viewBackButton", false);
            $pdocrud->setSettings("viewPrintButton", false);
            $experto = $pdocrud->dbTable("expertos")->render("VIEWFORM",array("id" =>$codigo)); 

            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Comentarios";
            if($rolExperto == 2){
                $subTitleContent = "Administracion de Nutricionista";
            }elseif($rolExperto == 3){
                $subTitleContent = "Administracion de Coach";
            }
            $level = "Comentarios";
            $data['comentarios'] = $comentarios;
            $data['codigo'] = $codigo;
            $data['contexto'] = $contexto;
            $data['experto'] = $experto;
            $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "comentariosExperto", $data, $rol, $contexto);
        }else{
             $this->load->view('403');
        }
    }

    public function respuestas($IdComentario) {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $nombreApellido = $pdocrud->getUserSession("nombre")." ".$pdocrud->getUserSession("apellido");
            $username = $pdocrud->getUserSession("userName");
            $rol = $pdocrud->getUserSession("role");
            $titleContent = "Comentarios";
            $subTitleContent = "Administracion de Comentario";
            $level = "Comentarios";
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->
                    urlApiComments."comments/respuesta/".$IdComentario ,
                CURLOPT_USERAGENT => 'EyesFood'
            ]);
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            $respuestas = json_decode($resp, true);
            for($i = 0, $size = count($respuestas); $i < $size; ++$i) {
                $usuario = $this->correo($respuestas[$i]['colaborador']);
                array_push($respuestas[$i], $usuario['Correo']);
            //$people[$i]['salt'] = mt_rand(000000, 999999);
            }
            // Close request to clear up some resources
            curl_close($curl);;
            $pdocrud->setPK("idComentario");
            $pdocrud->where("idComentario", $IdComentario,"=");
            $pdocrud->setViewColumns(array("colaborador", "comentario","fecha"));
            $pdocrud->setSettings("viewBackButton", false);
            $pdocrud->setSettings("viewPrintButton", false);
            $comentario = $pdocrud->dbTable("comentarios")->render("VIEWFORM",array("id" =>$IdComentario));
            $data['comentario'] = $comentario;
            $data['IdComentario'] = $IdComentario;
            $data['respuestas'] = $respuestas;
            $this->template("Expertos", $username, $nombreApellido, $titleContent, $subTitleContent, $level, "respuestaExperto", $data, $rol);
        }else{
             $this->load->view('403');
        }
    }

    public function correo($codigo) {
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            $pdomodel->where("idUsuario", $codigo);
            $obj =  $pdomodel->select("usuarios");
            $usuario = $obj[0];
            return $usuario;
        }else{
            $this->load->view('403');
        }
        
    }

    public function borraComentario($contexto ,$codigo, $IdComentario){
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            echo $pdocrud->getUserSession("userId");
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, $this->urlApiComments.'comments/borrar/'.$IdComentario);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            redirect('/Expertos/comentarios/'.$contexto.'/'.$codigo);
        }else{
            $this->load->view('403');
        }
    }

    public function borraRespuesta($IdComentario, $IdRespuesta){
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            echo $pdocrud->getUserSession("userId");
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, $this->urlApiComments.'comments/borrar/respuesta/'.$IdRespuesta);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            redirect('/Expertos/respuesta/'.$IdComentario);
        }else{
            $this->load->view('403');
        }
    }

    public function comentar($contexto ,$codigo, $comentario){
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1"))){
            echo $contexto."\n";
            echo $codigo."\n";
            echo $pdocrud->getUserSession("role")."\n";
            echo $pdocrud->getUserSession("userId")."\n";
            echo $comentario."\n";
            $data_array =  array(
                    "idColaborador"        => $pdocrud->getUserSession("role"),
                    "colaborador"        => $pdocrud->getUserSession("userId"),
                    "comentario"        => urldecode ( $comentario ),
              );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_array));
            curl_setopt($curl, CURLOPT_URL, $this->urlApiComments.'comments/'.$contexto.'/'.$codigo);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            echo $result;
            curl_close($curl);
            
        }else{
            redirect('/Expertos/comentarios/'.$contexto.'/'.$codigo);
            $this->load->view('403');
        }
    }

    public function responder($IdComentario, $comentario){
        $pdocrud = $this->cabecera();
        $pdomodel = $pdocrud->getPDOModelObj();
        if($pdocrud->checkUserSession("userId") and $pdocrud->checkUserSession("role", array("1","2"))){
            echo $pdocrud->getUserSession("role")."\n";

            $data_array =  array(
                    "idColaborador"        => $pdocrud->getUserSession("role"),
                    "colaborador"        => $pdocrud->getUserSession("userId"),
                    "comentario"        => urldecode ( $comentario ),
              );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_array));
            curl_setopt($curl, CURLOPT_URL, $this->urlApiComments.'comments/respuesta/'.$IdComentario);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            redirect('/Expertos/respuesta/'.$IdComentario);
        }else{
            $this->load->view('403');
        }
    }
}