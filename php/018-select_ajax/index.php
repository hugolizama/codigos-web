<?php 
require_once './con_db.php'; //libreria de conexion a la base

$con = conDb();
if(!$con){
  die("<br/>Sin conexi&oacute;n.");
}

/*obtenemos los datos del primer select*/
$sql = "select * from bandas";
$query = mysqli_query($con, $sql);
$filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
mysqli_close($con);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Select Ajax</title>
  </head>
  <body>
    <label>Bandas</label>
    <select id="bandas">
      <option value="">- Seleccione -</option>
      <?php foreach ($filas as $op): //llenar las opciones del primer select ?>
      <option value="<?= $op['id'] ?>"><?= $op['nombre'] ?></option>  
      <?php endforeach; ?>
    </select>
    
    <br/><br/>
    <label>Discos</label>
    <select id="discos" disabled="">
      <option value="">- Seleccione -</option>
    </select>
    
    <br/><br/>
    Opci&oacute;n seleccionada: <span style="font-weight: bold;" id="disco_sel"></span>
    
    <!-- Agregamos la libreria Jquery -->
    <script type="text/javascript" src="jquery-3.2.0.min.js"></script>
    
    <!-- Iniciamos el segmento de codigo javascript -->
    <script type="text/javascript">
      $(document).ready(function(){
        var discos = $('#discos');
        var disco_sel = $('#disco_sel');
        
        //Ejecutar accion al cambiar de opcion en el select de las bandas
        $('#bandas').change(function(){
          var banda_id = $(this).val(); //obtener el id seleccionado
          
          if(banda_id !== ''){ //verificar haber seleccionado una opcion valida
            
            /*Inicio de llamada ajax*/
            $.ajax({
              data: {banda_id:banda_id}, //variables o parametros a enviar, formato => nombre_de_variable:contenido
              dataType: 'html', //tipo de datos que esperamos de regreso
              type: 'POST', //mandar variables como post o get
              url: 'get_discos.php' //url que recibe las variables
            }).done(function(data){ //metodo que se ejecuta cuando ajax ha completado su ejecucion             
              
              discos.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
              discos.prop('disabled', false); //habilitar el select
            });
            /*fin de llamada ajax*/
            
          }else{ //en caso de seleccionar una opcion no valida
            discos.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
            discos.prop('disabled', true); //deshabilitar el select
          }    
        });
        
        
        //mostrar una leyenda con el disco seleccionado
        $('#discos').change(function(){
          $('#disco_sel').html($(this).val() + ' - ' + $('#discos option:selected').text());
        });
        
      });
    </script>    
  </body>
</html>
