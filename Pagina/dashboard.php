<?php 
    session_start();
  
    if(!$_SESSION['id']){
        header('location:login.php');
    }
 
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Java Clean</title>
    <link rel="shortcut icon" href="imagenes/pngwing.com (2).png" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        
        <nav>
        <h1 >Bienvenido <?php echo ucfirst($_SESSION['nombre']); ?></h1>
        <a href="#">inicio</a>
        <a href="logout.php?logout=true">Logout</a>
        </nav>
        <section class="textos-header">
            <h1>Tus mejores productos al mejor precio</h1>
            <h2>Con descuentos del 50% </h2>
        </section>
        <div class="wave" style="height: 150px; overflow: hidden;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;"><path d="M0.00,49.98 C294.21,175.17 301.21,-18.23 500.00,49.98 L507.00,166.30 L0.00,150.00 Z" style="stroke: none; fill: rgb(255, 255, 255);"></path></svg></div>
    </header>
    <main>
        <section class="contenedor sobre-nosotros">
            <h2 class="titulo">Nuestro Producto</h2>
            <div class="contenedor-sobre-nosotros">
                <img src="imagenes/90100112010110.jpg" alt=""class="imagen-about-us">
                <div class="contenido-textos">
                    <h3><span>1</span>Quienes somos:</h3>
                    <p>Somos una empresa distribuidora de productos de limpieza, pide tus productos desde la comodidad de tu casa o de donde estes </p>
                    <h3><span>2</span>Los Mejores Productos a tu disposicion</h3>
                    <p>Disfruta de la mejor experiencia comercial, obteniendo descuentos hasta del 50 % de tus productos de compra </p>
                </div>
            </div>
        </section>
        <section class="portafolio">
            <div class="contenedor">
                <h2 class="titulo">Portafolio</h2>
                <div class="galeria-port">
                    <div class="imagen-port">
                        <img src="imagenes/Productos-de-aseo.jpg" alt="">
                        <div class="hover-galeria">
                            <a href="../Compras/index.php" id="Comprar" class="button u-full-width">Comprar</a>
                        </div>
                    </div>
                    <div class="imagen-port">
                        <img src="imagenes/escobas-traperos-recogedores.jpg.opdownload" alt="">
                        <div class="hover-galeria">
                            <img src="imagenes/agotado.png" alt="">
                        </div>
                    </div>
                    <div class="imagen-port">
                        <img src="imagenes/herramientas-limpieza-dental-productos-higiene-bucal_169241-1264.jpg" alt="">
                        <div class="hover-galeria">
                            <img src="imagenes/agotado.png" alt="">
                        </div>
                    </div>
                    <div class="imagen-port">
                        <img src="imagenes/escobas-traperos-recogedores.jpg.opdownload" alt="">
                        <div class="hover-galeria">
                            <img src="imagenes/agotado.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clientes contenedor">
            <h2 class="titulo">Opiniones Generales</h2>
            <div class="cards">
                <div class="card">
                    <img src="imagenes/diegoooo4.jpg" alt="">
                    <div class="contenido-texto-card">
                        <h4>Diego Penagos</h4>
                        <p>Estupenda la pagina Wed 10/10 muy faacil hacer las comprar y los pedidos llegan muy a tiempo</p> 
                    </div>
                </div>
                <div class="card">
                    <img src="imagenes/urregooo.jpg" alt="">
                    <div class="contenido-texto-card">
                        <h4>Andres Urrego</h4>
                        <p>Muy agradable la pagina y los precios son estupendos</p> 
                    </div>
                </div>
            </div>
        </section>
        <section class="about-services">
            <div class="contenedor">
                <h2 class="titulo">NUESTOS MEJORES SERVICIOS</h2>
                <div class="servicio-cont">
                    <div class="servicio-ind">
                        <img src="imagenes/experiencia-usuario-cabecera.jpg" alt="">
                        <h3>Estrategia Financiera</h3>
                        <p>Contamos con las mejores recomendaciones dada de la manos de nuestro analistas para ofrecer nuestro muejores servicios </p>
                    </div>
                    <div class="servicio-ind">
                        <img src="imagenes/domicilios.png" alt="">
                        <h3>Domicilios</h3>
                        <p>Tenermos el mejor servicio al cliente en las entregas de los domicilios </p>
                        
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="contenedor-footer">
            <div class="contenedor-foo">
                <h4>JavaClean</h4>
                <p>8296312</p>
            </div>
            <div class="contenedor-foo">
                <h4>JavaClean_FS@gmail.com</h4>
                <p>8296312</p>
            </div>
            <div class="contenedor-foo">
                <h4>Fusagasuga/Cundinamarca</h4>
                <p>8296312</p>
            </div>
            
        </div>
        <h2 class="titulo-final">&copy;  Jaider Hernadez </h2>
    </footer>
</body>
</html>