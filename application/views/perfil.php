<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $experto;?>
<a class="btn btn-default" <?php if ($aux != 0){ echo 'style="display:none;"'; } ?> href="<?php echo base_url();?>Tiendas/editar">Editar»</a>
<a class="btn btn-default" <?php if ($aux != 2){ echo 'style="display:none;"'; } ?> href="<?php echo base_url();?>Usuarios/editar">Editar»</a>
<a class="btn btn-default" <?php if ($aux != 3){ echo 'style="display:none;"'; } ?> href="<?php echo base_url();?>Expertos/editar">Editar»</a>
<!--<a class="btn btn-default" <?php if ($aux != 0){ echo 'style="display:none;"'; } ?> href="<?php echo base_url();?>Tiendas/cambiarPass">Cambiar Contraseña»</a>-->