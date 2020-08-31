<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 40%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.isDisabled {
  color: currentColor;
  cursor: not-allowed;
  opacity: 0.5;
  text-decoration: none;
  pointer-events: none;
}
.dialog{
  border:5px solid #666;
  padding:10px;
  background:#3A3A3A;
  position:absolute;
  display:none;
}
.dialog label{
  display:inline-block;
  color:#cecece;
}
input[type=text]{
  border:1px solid #333;
  display:inline-block;
  margin:5px;
  width: 200px;
  height: 100px;
}
#btnOK{
  border:1px solid #000;
  background:#ff9999;
  margin:5px;
}

#btnOK:hover{
  border:1px solid #000;
  background:#ffacac;
}
</style>

<div class="row" style="width: 100%">
  <div class="column" >
      <?php echo $alimento;?>
  </div>
  <div class="column">
      <img src="<?php print_r($response);?>" class="img img-rounded img-responsive fit-image" alt="Imagen Frontal" style="height: 100%">
  </div>
</div>
<div id="panel">
  <input type="button" class="button btn btn-default" value="Comentar" id="btn1">
  <br>
  <br>
  <!-- Dialog Box-->
  <div class="dialog" id="myform">
    <form>
      <label id="valueFromMyButton">
      </label>
      <input type="text" id="name">
      <div align="center">
        <input type="button" class="btn btn-success" value="Ok" id="btnOK">
        <input type="button" class="btn btn-danger" value="Cancelar" id="btnNo">
      </div>
	</form>
  </div>
</div>
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i = 0, $size = count($comentarios); $i < $size; ++$i) {
                    echo '<tr>';
                    echo '<td>';
                      echo $comentarios[$i]['0'];
                    echo '</td>';
                    echo '<td>';
                      echo $comentarios[$i]['comentario'];
                    echo '</td>';
                    echo '<td>';
                      echo $comentarios[$i]['fecha'];
                    echo '</td>';
                    echo '<td>';
                      if ($comentarios[$i]['Borrar'] == 0){
                          echo 'Activo';
                      } elseif ($comentarios[$i]['Borrar'] == 1){
                          echo 'Desactivado';
                      }
                    echo '</td>';
                    echo '<td>';
                    echo '<a class="btn btn-default confirmation" href="'.base_url().'Alimentos/borraComentario/'.$contexto.'/'.$codigo.'/'.$comentarios[$i]['idComentario'].'">Desactivar</a>';
                    echo '<a class="btn btn-default" href="'.base_url().'Alimentos/respuestas/'.$comentarios[$i]['idComentario'].'">Respuestas</a>';
                    echo '</td>';
                    echo '</tr>';
//                    $people[$i]['salt'] = mt_rand(000000, 999999);
                }
                
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Usuario</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>

<script type="text/javascript">
    $('.confirmation').on('click', function () {
        return confirm('Esta seguro?');
    });
    $(function() {
    $(".button").click(function() {
        $("#myform #valueFromMyButton").text($(this).val().trim());
        $("#myform input[type=text]").val('');
        $("#valueFromMyModal").val('');
        $("#myform").show(500);
    });
    $("#btnOK").click(function() {
        if ($("#name").val().length == 0) {
            alert('Ingrese un comentario');
            return false;
        }else{
            $("#valueFromMyModal").val($("#myform input[type=text]").val().trim());
            window.location.href = "<?php echo base_url().'Alimentos/comentar/'.$contexto.'/'.$codigo.'/'?>"+$("#name").val().trim();
        }
    });
    $("#btnNo").click(function() {
        var modal = document.getElementById('myform');
        modal.style.display = "none";
    });
});
</script>