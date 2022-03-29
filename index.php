<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color:#ffcc66;
    }

    form {
      border: 3px solid #f1f1f1;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: #996600;
      color:#ffcc66;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      opacity: 0.8;
    }

    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
    }

    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
    }

    img.avatar {
      width: 40%;
      border-radius: 50%;
    }

    .container {
      padding: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }
  </style>
</head>

<body>
  <?php
  include 'controller/conexion.php';
  
  if (isset($_SESSION['validado'])&&$_SESSION['validado']) {
    header("location: apli.php");
    exit();
  }

  if (isset($_POST['nomUsu'])&&isset($_POST['conUsu'])){
    comprobarPassword($_POST['nomUsu'],$_POST['conUsu']);
  }



  ?>
  <h2>Login</h2>



  <form action="" method="post">


    <div class="container">
      <label for="uname"><b>Usuario</b></label>
      <input type="text" placeholder="Enter Username" name="nomUsu" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="conUsu" required>

      <button type="submit">Login</button>

    </div>


  </form>

</body>

</html>