<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo $alimento;
?>
<!-- Button trigger modal -->
<button <?php if ($ind['estadoAlimento'] != 2){ echo 'style="display:none;"'; } ?> class="btn btn-info" id="btn-approve">Aprobar</button>
<button <?php if ($ind['estadoAlimento'] != 2){ echo 'style="display:none;"'; } ?> class="btn btn-danger" id="btn-reject">Rechazar</button>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar</h4>
        ¿Esta seguro de aprobar el alimento <?php echo ($ind["nombreAlimento"]); ?> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="modal-btn-si">Si</button>
        <button type="button" class="btn btn-danger" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal-2">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Rechazar</h4>
        ¿Esta seguro de rechazar el alimento <?php echo ($ind["nombreAlimento"]); ?> ?
      </div>
      <h5 class="modal-header">Comentario de rechazo</h5>
      <textarea type="text" style="resize:none; margin-left:10px;" rows="8" cols="30" id="texto"></textarea>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="modal-btn-2-si">Si</button>
        <button type="button" class="btn btn-danger" id="modal-btn-2-no">No</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var modalConfirm = function(callback){
  
  $("#btn-approve").on("click", function(){
    $("#mi-modal").modal('show');
  });

  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    window.location.href = "<?php echo base_url().'Alimentos/Aprobar/'.$ind["idAlimentoNuevo"]; ?>";
    //alert('El alimento ha sido aprobado exitosamente');
  }else{
    //Acciones si el usuario no confirma
  }
});
</script>
<script type="text/javascript">
var modalConfirm = function(callback){
  
  $("#btn-reject").on("click", function(){
    $("#mi-modal-2 input[type=text]").val('');
    $("#mi-modal-2").modal('show');
  });

  $("#modal-btn-2-si").on("click", function(){
    callback(true);
    $("#mi-modal-2").modal('hide');
  });
  
  $("#modal-btn-2-no").on("click", function(){
    callback(false);
    $("#mi-modal-2").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    window.location.href = "<?php echo base_url().'Alimentos/rechazar/'.$ind["idAlimentoNuevo"].'/'?>"+$("#texto").val().trim();
    //alert('El alimento ha sido rechazado exitosamente');
  }else{
    //Acciones si el usuario no confirma
    
  }
});
</script>