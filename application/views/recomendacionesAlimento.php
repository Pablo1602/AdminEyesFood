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

<?php echo $recomendaciones;?>