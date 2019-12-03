<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo $alimento;
?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
.fit-image{
display: block;
object-fit: cover;
height:100%;/* only if you want fixed height */
}
</style>
</head>
<div id="exTab3" class="container" style="width: 100%; height: 100%">	
    <ul  class="nav nav-pills">
        <li class="active">
            <a  href="#1b" data-toggle="tab">Frontal</a>
        </li>
        <li>
            <a href="#2b" data-toggle="tab">Ingredientes</a>
        </li>
        <li>
            <a href="#3b" data-toggle="tab">Aporte Nutricional</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active responsive" id="1b">
            <div class="row" <?php if (is_null($front)){ echo 'style="display:none;"'; } ?>>
                <div class="column responsive">
                    <img src="<?php echo $front ?>" class="img-rounded img-responsive fit-image" alt="Imagen Frontal">
                </div>
                <div class="column">
                    <?php echo $alimento ?>
                    <button class="btn btn-info" id="btn-approve">Aprobar</button>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Aprobar</h4>
                          Esta seguro de aprobar la imagen frontal del alimento <?php echo ($ind["idAlimentoNuevo"]); ?> ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" id="modal-btn-si">Si</button>
                          <button type="button" class="btn btn-primary" id="modal-btn-no">No</button>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
            </div>
            <div <?php if (isset($front)){ echo 'style="display:none;"'; } ?>>
                La imagen no existe
            </div>
        </div>
        <div class="tab-pane" id="2b">
            <div class="row" <?php if (is_null($ingr)){ echo 'style="display:none;"'; } ?>>
                <div class="column responsive">
                    <img src="<?php echo $ingr ?>" class="img-rounded img-responsive fit-image" alt="Imagen Ingredientes">
                </div>
                <div class="column">
                    <?php echo $alimento2 ?>
                    <button class="btn btn-info" id="btn-approve2">Aprobar</button>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal2">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Aprobar</h4>
                          Esta seguro de aprobar la imagen de los ingredientes del alimento <?php echo ($ind["idAlimentoNuevo"]); ?> ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" id="modal-btn-si2">Si</button>
                          <button type="button" class="btn btn-primary" id="modal-btn-no2">No</button>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
            </div>
            <div <?php if (isset($ingr)){ echo 'style="display:none;"'; } ?>>
                La imagen no existe
            </div>
        </div>
        <div class="tab-pane" id="3b">
            <div class="row" <?php if (is_null($nutr)){ echo 'style="display:none;"'; } ?>>
                <div class="column responsive">
                    <img src="<?php echo $nutr ?>" class="img-rounded img-responsive fit-image" alt="Imagen Frontal">
                </div>
                <div class="column">
                    <?php echo $alimento3 ?>
                    <button class="btn btn-info" id="btn-approve3">Aprobar</button>
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal3">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Aprobar</h4>
                          Esta seguro de aprobar la imagen de la informacion nutricional del alimento <?php echo ($ind["idAlimentoNuevo"]); ?> ?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" id="modal-btn-si3">Si</button>
                          <button type="button" class="btn btn-primary" id="modal-btn-no3">No</button>
                        </div>
                      </div>
                    </div>
                    </div>
                </div>
            </div>
            <div <?php if (isset($nutr)){ echo 'style="display:none;"'; } ?>>
                La imagen no existe
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
     <!--Placed at the end of the document so the pages load faster--> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
    window.location.href = "<?php echo base_url().'Alimentos/aprobarImg/'.$ind["idAlimentoNuevo"]."/"."front";?>";
    //alert('El alimento ha sido aprobado exitosamente');
  }else{
    //Acciones si el usuario no confirma
  }
});
</script>
<script type="text/javascript">
    var modalConfirm = function(callback){
  
  $("#btn-approve2").on("click", function(){
    $("#mi-modal2").modal('show');
  });

  $("#modal-btn-si2").on("click", function(){
    callback(true);
    $("#mi-modal2").modal('hide');
  });
  
  $("#modal-btn-no2").on("click", function(){
    callback(false);
    $("#mi-modal2").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    window.location.href = "<?php echo base_url().'Alimentos/aprobarImg/'.$ind["idAlimentoNuevo"]."/"."ingr";?>";
    //alert('El alimento ha sido aprobado exitosamente');
  }else{
    //Acciones si el usuario no confirma
  }
});
</script>
<script type="text/javascript">
    var modalConfirm = function(callback){
  
  $("#btn-approve3").on("click", function(){
    $("#mi-modal3").modal('show');
  });

  $("#modal-btn-si3").on("click", function(){
    callback(true);
    $("#mi-modal3").modal('hide');
  });
  
  $("#modal-btn-no3").on("click", function(){
    callback(false);
    $("#mi-modal3").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    window.location.href = "<?php echo base_url().'Alimentos/aprobarImg/'.$ind["idAlimentoNuevo"]."/"."nutr";?>";
    //alert('El alimento ha sido aprobado exitosamente');
  }else{
    //Acciones si el usuario no confirma
  }
});
</script>