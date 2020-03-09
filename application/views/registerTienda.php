<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<head>    
    <title>EyesFood | Registro Profesional</title>
    <link rel="stylesheet" href="<?php echo base_url();?>dist/css/register.css">
</head>
<div class="login-page">
    <form class="login-form">
        <div class="form">
            <a class="btn btn-primary" href="<?php echo base_url();?>" role="button">Staff</a>
            <a class="btn btn-primary" href="<?php echo base_url();?>Login/loginProfesional" role="button">Salud</a>
            <a class="btn btn-primary" href="<?php echo base_url();?>Login/loginTienda" role="button">Tiendas</a>
            <?php echo $registro;?>
        </div>
    </form>
</div>