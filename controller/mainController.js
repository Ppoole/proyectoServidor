var telActual = 0;


      function cambiarCompletada(chkbox) {

        if (chkbox.checked == true) { //Si la estamos completando.
          xhttp = new XMLHttpRequest();
          xhttp.open("POST", "controller/marcaHecha.php");
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          let datos = "codNota=" + chkbox.name + "&nuevoValor=" + 1;
          xhttp.send(datos);
        } else {
          xhttp = new XMLHttpRequest();
          xhttp.open("POST", "controller/marcaHecha.php");
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          let datos = "codNota=" + chkbox.name + "&nuevoValor=" + 0;
          xhttp.send(datos);
        }
      }


      function muestraNotas(notas) {
        const miPromesa = new Promise(function(miSi, miNo) {
          var xhttp = new XMLHttpRequest();
          xhttp.open("POST", "controller/muestraNotas.php");
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.onload = function() {
            if (xhttp.status == 200) {
              miSi(this.responseText);

            } else {

              miNo(this.responseText);
            }
          };
          let pedirNot = "not=" + notas;
          xhttp.send(pedirNot);
        })
        miPromesa.then(
          function(value) {

            document.getElementById('notasPh').innerHTML = value;
          },
          function(error) {
            console.log(error);
            alert("Algo ha falladooooo");
          }
        )
      }

      function muestraPersona(telefono) {
        const miPromesa = new Promise(function(miSi, miNo) {
          var xhttp = new XMLHttpRequest();
          xhttp.open("POST", "controller/muestraPersona.php");
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.onload = function() {
            if (xhttp.status == 200) {
              miSi(this.responseText);

            } else {

              miNo(this.responseText);
            }
          };
          let pedirNot = "not=" + telefono;
          xhttp.send(pedirNot);
        })
        miPromesa.then(
          function(value) {

            document.getElementById('datosPer').innerHTML = value;
          },
          function(error) {
            console.log(error);
            alert("Algo ha falladooooo");
          }
        )
      }


      function nuevoTel(tel) {

        xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
          muestraNotas(telActual);
          muestraPersona(telActual);
        }
        xhttp.open("POST", "controller/guardaTel.php");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        let pedirTel = "tel=" + tel;
        xhttp.send(pedirTel);
      }

      function setSession(variable, value) {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "controller/guardaSesion.php?variable=" + variable + "&valor=" + value, true);
        xmlhttp.send();
      }

      function buscaTel() {
        const miPromesa = new Promise(function(miSi, miNo) {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open("GET", "controller/getTel.php?cod=" + document.querySelector(".num").value, true);
          xmlhttp.onload = function() {
            if (xmlhttp.status == 200) {
              miSi(this.responseText);
            } else {
              miNo(this.responseText);
            }
          };
          xmlhttp.send();
        })
        miPromesa.then(
          function(value) {
            if (value == "nuevo") {
              nuevoTel(telActual);
            } else {
              muestraPersona(telActual);
              muestraNotas(telActual);
              
            }
          },
          function(error) {
            alert("Algo ha fallado");
          }
        )
      }

      window.addEventListener("load", () => {
        document.querySelector("input").addEventListener("keydown", (evt) => {
          if (evt.key == "Enter") {
            evt.preventDefault();
            telActual = document.querySelector(".num").value; //Esto es en el raro caso de que la promise tarde y entren 2 llamadas en el acto.
            buscaTel();
            setSession("tel", document.querySelector(".num").value);
          }
        })

        document.querySelector("#botonCentro").addEventListener("click", (evt) => {
          
            evt.preventDefault();
            telActual = document.querySelector(".num").value; //Esto es en el raro caso de que la promise tarde y entren 2 llamadas en el acto.
            buscaTel();
            setSession("tel", document.querySelector(".num").value);
          
        })
        window.addEventListener("focus", function(event) {
          if (typeof telActual !== 'undefined') {
            muestraNotas(telActual);
            muestraPersona(telActual);
          }

        })

        
          
        
      });