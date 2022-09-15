<?php
require 'config/config.php';
require 'config/database.php';
$db=new Database();
$con= $db->conectar();


$id = isset($_GET['id']) ? $_GET['id'] : "";
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == ''){
    echo 'Error al procesar la petición.';
    exit;

  }else{

    $token_tmp = hash_hmac('sha1',$id,KEY_TOKEN);

    //if($token == $token_tmp){

      $sql = $con->prepare("SELECT count(id_productos) FROM productos WHERE id_productos=? AND activo=1");
      $sql->execute([$id]);
      if($sql->fetchColumn() > 0){

        $sql = $con->prepare("SELECT nombre_prod, descripcion, precio, descuento FROM productos WHERE id_productos=? AND activo=1 
        LIMIT 1");
        $sql->execute([$id]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $nombre = $row['nombre_prod'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $descuento = $row['descuento'];
        $precio_desc = $precio - (($precio * $descuento) / 100);

        $dir_images = 'images/Productos/'.$id.'/';

        $rutaImg = $dir_images.'uno.jpeg';
        if (!file_exists($rutaImg)) {
            $rutaImg = 'images/Productos/nofoto.png';
        }

        $images = array();
        if (file_exists($dir_images)) {
            $dir = dir($dir_images);

            while (($archivo=$dir->read())!=false) {
                if ($archivo !='uno.jpeg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                    $imagenes[]= $dir_images.$archivo;
                }
            }
            $dir->close(); 
        }
      } 
    
  }

?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
     rel="stylesheet" 
     integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" 
     crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
   
</head>
<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
            <a href="#" class="navbar-brand">
                <strong>Tienda Online</strong> 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
            aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Catalogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <a href="checkout.php" class="btn btn-primary">
                    Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a> 
            </div>

            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                            <img src="<?php echo $rutaImg; ?>" class="d-block w-100">
                            </div>
                            <?php foreach($imagenes as $img) { ?>
                                <div>
                                <img src="<?php echo $img; ?>" class="d-block w-100">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre ?></h2>
                    
                    <?php if($descuento>0) { ?>
                        <p><del><?php echo MONEDA . number_format($precio,2,'.',','); ?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc,2,'.',',');  ?>
                            <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                        </h2>
                    <?php } else { ?>
                        <h2>
                            <?php echo MONEDA . number_format($precio,2,'.',','); ?>
                        </h2>
                    <?php } ?>
                    <h2><?php echo MONEDA . number_format($precio,2,'.',','); ?></h2>
                    <p class="lead">
                        <?php echo $descripcion; ?>
                    </p> 
                    <div class="g-grid gap-3 col-10 mx-auto">
                    <a href="checkout.php" class="btn btn-primary">
                    Comprar Ahora<span id="num_cart" class="badge bg-secondary"></span>
                </a> 
                        <button class="btn btn-outline-primary" 
                        type="button" onclick="addProducto(
                            <?php echo $id;?>,'<?php echo $token_tmp; ?>')">
                        Agregar al Carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" 
    crossorigin="anonymous"></script>

    <script>
        function addProducto(id,token){
            let url = 'clases/carrito.php'
            let formDate = new FormData()
            formDate.append('id',id)
            formDate.append('token',token)

            fetch(url,{
                method: 'POST',
                body: formDate,
                mode: 'cors'
            }).then(Response => Response.json())
            .then (data =>{
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML=data.numero
                }
            })
        }
    </script>
</body>
</html> 