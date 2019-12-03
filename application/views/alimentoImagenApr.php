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
                    <table border="1">
                        <caption>Frontal</caption>
                        <tr>
                                <th>Nombre Alimento</th>
                                <td><?php echo $prod["product_name"] ?></td>

                        </tr>
                        <tr>
                                <th>Contenido Neto</th>
                                <td><?php echo $prod["quantity"] ?></td>

                        </tr>
                        <tr>
                                <th>Marca</th>
                                <td><?php echo $prod["brands"] ?></td>

                        </tr>
                        <tr>
                                <th>Tipo</th>
                                <td><?php echo $prod["categories"] ?></td>

                        </tr>
                    </table>
                    <a class="btn btn-default confirmation" href="<?php echo base_url().'Alimentos/aprobarImg2/'.$ind["codigoBarras"]."/"."front";?>">Aprobar»</a>
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
                    <table border="1">
                        <caption>Ingredientes</caption>
                        <tr>
                                <th>Ingredientes</th>
                                <td><?php echo $prod["ingredients_text"] ?></td>

                        </tr>
                    </table>
                    <a class="btn btn-default confirmation" href="<?php echo base_url().'Alimentos/aprobarImg2/'.$ind["codigoBarras"]."/"."ingr";?>">Aprobar»</a>
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
                    <?php // echo $alimento3 ?>
                    <div id="exTab3" class="container" style="width: 100%; height: 100%">
                        <ul  class="nav nav-pills">
                            <li class="active">
                                <a  href="#1c" data-toggle="tab">1</a>
                            </li>
                            <li>
                                <a href="#2c" data-toggle="tab">2</a>
                            </li>
                            <li>
                                <a href="#3c" data-toggle="tab">3</a>
                            </li>
                        </ul>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active responsive" id="1c">
                                <table border="1">
                                    <caption></caption>
                                    <tr>
                                            <th>Porcion</th>
                                            <td><?php echo $prod["product_name"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Porcio Gramos</th>
                                            <td><?php echo $prod["quantity"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Energia</th>
                                            <td><?php echo $prod["brands"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Grasa Total</th>
                                            <td><?php echo $prod["categories"] ?></td>

                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane responsive" id="2c">
                                <table border="1">
                                    <caption></caption>
                                    <tr>
                                            <th>Grasa Saturada</th>
                                            <td><?php echo $prod["product_name"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Grasa Mono</th>
                                            <td><?php echo $prod["quantity"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Grasa Poli</th>
                                            <td><?php echo $prod["brands"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Grasa Trans</th>
                                            <td><?php echo $prod["categories"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Colesterol</th>
                                            <td><?php echo $prod["categories"] ?></td>

                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane responsive" id="3c">
                                <table border="1">
                                    <caption></caption>
                                    <tr>
                                            <th>Hidratos de Carbono</th>
                                            <td><?php echo $prod["product_name"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Azucares Totales</th>
                                            <td><?php echo $prod["quantity"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Fibra</th>
                                            <td><?php echo $prod["brands"] ?></td>

                                    </tr>
                                    <tr>
                                            <th>Sodio</th>
                                            <td><?php echo $prod["categories"] ?></td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-default confirmation" href="<?php echo base_url().'Alimentos/aprobarImg2/'.$ind["codigoBarras"]."/"."nutr";?>">Aprobar»</a>
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
    $('.confirmation').on('click', function () {
        return confirm('Esta seguro?');
    });
</script>
