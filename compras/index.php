<?php
require 'config/config.php';
require 'config/database.php';
$db=new Database();
$con= $db->conectar();

$sql = $con->prepare("SELECT id_productos, nombre_prod,precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

session_destroy();

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
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                <h4 class="text-white">&copy;  Jaider Hernadez |&copy;  Carlos Moreno |&copy;  Jonatan Riveros</h4>
                <li><a href="../Pagina/dashboard.php" class="text-white">Inicio</a></li>
                
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                <h4 class="text-white">Contact</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Twitter</a></li>
                    <li><a href="#" class="text-white">Facebook</a></li>
                    <li><a href="#" class="text-white">Instagram</a></li>
                </ul>
                </div>
            </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong>Java Clean</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
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
                        <a href="#" class="nav-link active">Catalogo</a>
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
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($resultado as $row){?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                        $id = $row['id_productos'];
                        $imagen = "images/Productos/". $id . "/uno.jpeg";
                        if(!file_exists($imagen)){
                            $imagen="images/Productos/nofoto.png";
                        }
                        ?>
                        <img src="<?php echo $imagen; ?>">
                        <div class="card-body">
                        <p class="card-title"><?php echo $row['nombre_prod'];?></p>
                        <p class="card.text"><?php echo number_format($row['precio'],2,'.',',');?></p>
                        <div class="d-flex justify-content-between align-items-center"> 
                            <div class="btn-group">
                                <a href="detalles.php?id=<?php echo $row['id_productos']; ?>&token=
                                <?php echo hash_hmac('sha1',$row['id_productos'],KEY_TOKEN); ?>" class="btn btn-primary">Detelles</a>
                            </div>
                            <button class="btn btn-outline-success" 
                        type="button" onclick="addProducto(
                            <?php echo $row['id_productos'];?>,'<?php echo hash_hmac('sha1',$row['id_productos'],KEY_TOKEN); ?>')">
                        Agregar al Carrito
                        </button>
                        </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
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