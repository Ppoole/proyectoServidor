<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de notas</title>
    <style>
        form{
            display: grid;
            grid-template-columns: auto auto auto auto auto auto ;
            gap: 10px;
      background-color: #ffcc66;
      padding: 10px;
        }

        body{
            background-color: #ffcc66;
        }

    </style>

</head>

<body>

    <?php

        include 'controller/controllerPagNota.php';

    ?>


</body>

</html>