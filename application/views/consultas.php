<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo $consultas;?>
<?php 
if (is_null($id) and $consultas[0]) {
}else{
    echo "<br>";
    echo "Al aprobar la consulta, sus datos seran enviados al paciente, por correo, para que lo contacte";
    echo "<br>";
    echo "<br>";
    echo '<a class="btn btn-default confirmation" href='.base_url()."Consultas/AprobarConsulta/".$id.">Aprobar»</a>";
} 
?> 
<script type="text/javascript">
    $('.confirmation').on('click', function () {
        return confirm('Esta seguro?');
    });
</script>