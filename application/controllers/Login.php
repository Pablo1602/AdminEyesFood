<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_once "script/pdocrud.php";
    }

    public function index(){
        $pdocrud = new PDOCrud();
        $pdocrud->addCallback("before_select", "beforeloginCallback");
        $pdocrud->addCallback("after_select", "afterLoginCallBack");
        //only required fields to be display on form
        $pdocrud->formFields(array("Correo", "hash_password"));
        //$pdo_crud->fieldTypes("password", "hash_password", array("encryption"=>"sha1"));
        //set session variables - 1st parameter is the session variable name and 2nd is value to be matched in database table
        $pdocrud->setUserSession("userName", "Correo");
        //You can set any no. of session variables
        $pdocrud->setUserSession("userId", "idUsuario");
        $pdocrud->setUserSession("role", "rol");
        $pdocrud->setUserSession("nombre", "Nombre");
        $pdocrud->setUserSession("apellido", "Apellido");
        $pdocrud->setUserSession("lastLoginTime", date("now"));
        $pdocrud->fieldRenameLable("hash_password", "Password");
        $pdocrud->buttonHide($buttonname="cancel");
        $login = $pdocrud->dbTable("usuarios")->render("selectform");
        $data['login'] = $login;
        $this->load->helper('url');
        $this->load->view('login.php', $data);
    }
    
    public function loginProfesional(){
        $pdocrud = new PDOCrud();
        $pdocrud->addCallback("before_select", "beforeloginCallback2");
        $pdocrud->addCallback("after_select", "afterLoginCallBack2");
        //only required fields to be display on form
        $pdocrud->formFields(array("email", "hash_password"));
        //$pdo_crud->fieldTypes("password", "hash_password", array("encryption"=>"sha1"));
        //set session variables - 1st parameter is the session variable name and 2nd is value to be matched in database table
        $pdocrud->setUserSession("userName", "email");
        //You can set any no. of session variables
        $pdocrud->setUserSession("userId", "idExperto");
        $pdocrud->setUserSession("role", "rol");
        $pdocrud->setUserSession("nombre", "nombre");
        $pdocrud->setUserSession("apellido", "apellido");
        $pdocrud->setUserSession("estado", "activo");
        $pdocrud->setUserSession("lastLoginTime", date("now"));
        $pdocrud->buttonHide($buttonname="cancel");
        $pdocrud->fieldRenameLable("hash_password", "Password");
        $login = $pdocrud->dbTable("expertos")->render("selectform");
        $data['login'] = $login;
        $this->load->helper('url');
        $this->load->view('login2.php', $data);
    }
    
    public function loginTienda(){
        $pdocrud = new PDOCrud();
        $pdocrud->addCallback("before_select", "beforeloginCallbackTienda");
        $pdocrud->addCallback("after_select", "afterLoginCallBackTienda");
        //only required fields to be display on form
        $pdocrud->formFields(array("email", "hash_password"));
        //$pdo_crud->fieldTypes("password", "hash_password", array("encryption"=>"sha1"));
        //set session variables - 1st parameter is the session variable name and 2nd is value to be matched in database table
        $pdocrud->setUserSession("userName", "email");
        //You can set any no. of session variables
        $pdocrud->setUserSession("userId", "idTienda");
        $pdocrud->setUserSession("role", "4");
        $pdocrud->setUserSession("nombre", "nombre");
        $pdocrud->setUserSession("estado", "activo");
        $pdocrud->setUserSession("lastLoginTime", date("now"));
        $pdocrud->fieldRenameLable("hash_password", "Password");
        $pdocrud->buttonHide($buttonname="cancel");
        $login = $pdocrud->dbTable("tiendas")->render("selectform");
        $data['login'] = $login;
        $this->load->helper('url');
        $this->load->view('login3.php', $data);
    }

    public function logout(){
        $pdo_crud = new PDOCrud();
        $pdo_crud->unsetUserSession();
        //$pdo_crud->formRedirection("http://".$_SERVER['SERVER_NAME'] . "/AdminModEyesFood/login.php", true);
        header('Location: ../Login');
    }
    
    public function register(){
        $pdocrud = new PDOCrud();
        $pdocrud->addCallback("after_insert", "afterRegisterCallBack");
        $pdocrud->tableColFormatting("rol", "replace",array("0" =>"Nutricionista"));
        $pdocrud->tableColFormatting("rol", "replace",array("1" =>"Coucher"));
        $pdocrud->fieldTypes("rol", "radio");//change gender to radio button
        $roles = array("2"=>"Nutricionista","3"=>"Coach");
        $pdocrud->fieldDataBinding("rol", $roles, "", "","array");//add data for radio button
//        $pdocrud->formFieldValue("rol", "2");
//        $pdocrud->fieldDataAttr("rol", array("disabled"=>"disabled"));
        $pdocrud->formFields(array("nombre", "apellido", "email", "especialidad", "telefono", "direccion", "rol","descripcion", "paginaWeb","hash_password"));
        $pdocrud->fieldTypes("hash_password", "password", array("encryption"=>"sha1"));
        $pdocrud->formStaticFields("personalinfo", "html", "<h3>1.Solicitud de Registro de Profesional </h3><br><small>Ingrese su información. Todos los campos son requeridos</small>");//html field
        $pdocrud->fieldDisplayOrder(array("personalinfo")); 
        $pdocrud->formStaticFields("Términos_y_condiciones", "checkbox", array("Acepto los términos y condiciones"));//checkbox field
        $link = '<a href="terminos" target="_blank">Ver Terminos y Condiciones</a>';
        $pdocrud->fieldDesc("Términos_y_condiciones", $link);// Add field description
        $pdocrud->checkDuplicateRecord(array("email"));
        $pdocrud->fieldTooltip("descripcion", "Por favor, ingrese su información academica y de formación. relacionada al área de salud");//tooltip
        $pdocrud->fieldRenameLable("paginaWeb", "Pagina Web");
        $pdocrud->fieldRenameLable("hash_password", "Password");
        $pdocrud->fieldNotMandatory("telefono");
        $pdocrud->fieldNotMandatory("direccion");
        $pdocrud->fieldNotMandatory("paginaWeb");
        $pdocrud->buttonHide($buttonname="cancel");
        //$pdocrud->recaptcha("6LeW1KoUAAAAAJyRLSZF5kezshtEEjbLtqaBTjzK","6LeW1KoUAAAAAIsvauCrbfHYsNysRiVLiUrxHrYT");
        $registro = $pdocrud->dbTable("expertos")->render("insertform");
        $data['registro'] = $registro;
        $this->load->helper('url');
        $this->load->view('register.php', $data);
    }
    
    public function registerTienda(){
        $pdocrud = new PDOCrud();
        $pdocrud->addCallback("after_insert", "afterRegisterCallBack");
        $pdocrud->formFields(array("nombre", "email", "descripcion", "telefono", "direccion", "paginaWeb","hash_password", "facebook","twitter","instagram","rss"));
        $pdocrud->fieldTypes("hash_password", "password", array("encryption"=>"sha1"));
        $pdocrud->formStaticFields("personalinfo", "html", "<h3>1.Solicitud de Registro de Tienda Saludable </h3><br><small>Ingrese su información</small>");//html field
        $pdocrud->fieldDisplayOrder(array("personalinfo")); 
        $pdocrud->formStaticFields("Términos_y_condiciones", "checkbox", array("Acepto los términos y condiciones"));//checkbox field
        $link = '<a href="terminos" target="_blank">Ver Terminos y Condiciones</a>';
        $pdocrud->fieldDesc("Términos_y_condiciones", $link);// Add field description
        $pdocrud->fieldTooltip("rss", "Las RSS es un formato de archivos que posibilita la creación de canales de publicación que son leídos por programas, como lectores de noticias, sin necesidad de acceder a una página web");//tooltip
        $pdocrud->checkDuplicateRecord(array("email"));
        $pdocrud->fieldRenameLable("hash_password", "Password");
        $pdocrud->fieldRenameLable("paginaWeb", "Pagina Web");
        $pdocrud->fieldNotMandatory("telefono");
        $pdocrud->fieldNotMandatory("direccion");
        $pdocrud->fieldNotMandatory("paginaWeb");
        $pdocrud->fieldNotMandatory("facebook");
        $pdocrud->fieldNotMandatory("twitter");
        $pdocrud->fieldNotMandatory("instagram");
        $pdocrud->fieldNotMandatory("rss");
        $pdocrud->buttonHide($buttonname="cancel");
        //$pdocrud->recaptcha("6LeW1KoUAAAAAJyRLSZF5kezshtEEjbLtqaBTjzK","6LeW1KoUAAAAAIsvauCrbfHYsNysRiVLiUrxHrYT");
        $registro = $pdocrud->dbTable("tiendas")->render("insertform");
        $data['registro'] = $registro;
        $this->load->helper('url');
        $this->load->view('registerTienda.php', $data);
    }
    
    public function terminos() {
        $data['link'] = "0";
        $data['boton'] = "";
        $data['text'] = "";
        $this->load->view('terminos.php', $data);
    }
    
    public function registroDone(){
        $data['link'] = base_url();
        $data['boton'] = "Volver";
        $data['text'] = "La solicitud de registro ha sido enviada. Sera notificado por los administradores cuando se haya revisado y aprobado.";
        $this->load->view('terminos.php', $data);
    }
}
?>