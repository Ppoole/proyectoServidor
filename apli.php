<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main</title>
  <link rel="stylesheet" href="styles.css">
  
</head>



<body>

  <div class=item1> <h1>Aplicación teléfono</h1></div>



  <div class=item2><h3 class=item21>Introduce el número de teléfono.</h3>
    <input class="num item22" type="text" name="tel" size="10">
    <button class="item23" id="botonCentro">Buscar!</button>
  </div>
    

    
    

    
      <script type="text/javascript" src="controller/mainController.js"></script>  
    
    <div class="item4" id="notasPh"></div>
    <div class="item3" id="datosPer"></div>
</body>

</html>