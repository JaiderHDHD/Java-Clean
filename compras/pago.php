<?php
require 'config/config.php';
require 'config/database.php';
$db=new Database();
$con= $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos']:null;

#print_r($_SESSION); 
#session_destroy();

$lista_carrito=array();


if($productos !=null){
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id_productos, nombre_prod, precio, descuento, $cantidad AS cantidad FROM productos 
        WHERE id_productos=? and activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}else {
    header("Location: index.php");
    exit;
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
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                <h4 class="text-white">&copy;  Jaider Hernadez |&copy;  Carlos Moreno |&copy;  Jonatan Riveros</h4>
                <li><a href="dashboard.php" class="text-white">Inicio</a></li>
                
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                <h4 class="text-white">Contact</h4>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Follow on Twitter</a></li>
                    <li><a href="#" class="text-white">Like on Facebook</a></li>
                    <li><a href="#" class="text-white">Email me</a></li>
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
                        <a href="index.php" class="nav-link active">Catalogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <a href="Carrito.php" class="btn btn-primary">
                    Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                </a> 
            </div>

            </div>
        </div>
    </header>
    <main>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de Pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                        <tbody>
                            <?php if ($lista_carrito==null) { 
                                echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                            }else {
                                $total=0;
                                foreach($lista_carrito as $productos){
                                    $id = $productos['id_productos'];
                                    $nombre = $productos['nombre_prod'];
                                    $precio = $productos['precio'];
                                    $descuento = $productos['descuento'];
                                    $cantidad = $productos['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                                ?>
                            <tr>
                                <td><?php echo $nombre ?></td>
                                <td>
                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                    <?php echo MONEDA. number_format($subtotal,2,'.',','); ?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr> 
                                <td colspan="2">
                                    <p class="h3 text-end" id="total"><?php echo MONEDA. number_format($total,2,'.',','); ?></p>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </thead>
                </table>
            </div>
            
        </div>
            </div> 
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" 
    crossorigin="anonymous"></script> 
    <script src="https://www.paypal.com/sdk/js?client-id=AeDR1r7Tpj-RQGg2t5FKksv4uhg9SG1IFKC67cdsP9dHwhZMQhnjhqlfJXCN5kr_vvAQyi7mhc1A2U4X&currency=USD" data-sdk-integration-source="button-factory"></script>

    <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"amount":{"currency_code":"USD","value":<?php echo $total; ?>}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(detalles) {
            
            console.log(detalles);
            window.location.href="index.php"

            return fetch(url,{
                  method:'post',
                  headers:{
                      'content-type':'application/json'
                  },
                  body: JSON.stringify({
                      detalles:detalles
                  })
              })
              
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>

<script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'pill',
          color: 'blue',
          label: 'pay',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{
                "amount":{
                    "currency_code":"USD","value":<?php echo $total; ?>
                }
            }]
          });
        },

        onApprove: function(data, actions) {
            let url='clases/captura.php'
          actions.order.capture().then(function(detalles){
              console.log(detalles);
              //window.location.href="completado.html"
              return fetch(url,{
                  method:'post',
                  headers:{
                      'content-type':'application/json'
                  },
                  body: JSON.stringify({
                      detalles:detalles
                  })
              })
              
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>
</body>
</html> 