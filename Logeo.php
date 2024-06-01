
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Expires" content="0">
            <meta http-equiv="Last-Modified" content="0">
                <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
                    <meta http-equiv="Pragma" content="no-cache">
                        <meta http-equiv="cache-control" content="max-age=0" />
                        <meta http-equiv="cache-control" content="no-cache" />

                        <link rel="icon" type="image/png" href="logo/fede.ico" />
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/app.css"/>
                        <link rel="stylesheet" href="foundation-6.4.2-complete/css/foundation.min.css"/>
                        <link rel="stylesheet"  href="foundation-6.4.2-complete/css/auxiliar.css"/>
                        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
                        <script type="text/javascript" src="Validador/vanadium/vanadium.js"></script>
                        <link rel="stylesheet" href="Validador/vanadium/style1.css"/>
                        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/foundation.js"></script>
                        <script type="text/javascript" src="foundation-6.4.2-complete/js/vendor/what-input.js"></script>

                        <script>
                            function mayus(e) {
                                e.value = e.value.toUpperCase();
                            }
                            $(document).foundation();

                        </script>  
                        <script src = "../js/jquery-3.3.1.js"></script>

                        <style>

                        </style>

</head>
        <h2 ALIGN="center" >BIENVENIDO MODULO DE GENERACION DE FINIQUITO</h2>
        <div align="center"><img src="Imagenes/LogoCaja.jpg"/></div>
          <br/>




<body>
 <div style="text-align:center;">
  <div class="form">
    
      <form class="login-form" action="Autenticacion.php" method="post">
                <input type="text" name="username" placeholder="usuario" onkeyup="mayus(this)" onblur="mayus(this)" required/>
                <input type="password" name="password" placeholder="password" onkeyup="mayus(this)" onblur="mayus(this)" required/>
                <input type="submit" class="button" value="Ingresar"/> 
            </form>
  </div>
</div>

</body>
  
          
         

</html>