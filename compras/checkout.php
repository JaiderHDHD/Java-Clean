<?php
require 'config/config.php';
require 'config/database.php';
$db=new Database();
$con= $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos']:null;



$lista_carrito=array();

if($productos !=null){
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id_productos, nombre_prod, precio, descuento, $cantidad AS cantidad FROM productos 
        WHERE id_productos=? and activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
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
                                <td><?php echo MONEDA. number_format($precio_desc,2,'.',','); ?></td>
                                <td>
                                    <input type="number" min="1" max="10" step="1" 
                                    value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" 
                                    onchange="actualizarCantidad(this.value,<?php echo $_id; ?>)">
                                </td>
                                <td>
                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                    <?php echo MONEDA. number_format($subtotal,2,'.',','); ?>
                                    </div>
                                </td>
                                <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" 
                                data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar
                                </a></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>  
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA. number_format($total,2,'.',','); ?></p>
                                </td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </thead>
                </table>
            </div>
            <?php if ($lista_carrito != null) { ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ¿Desea Eliminar el Producto de la Lista?
        </div>
        <div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
        </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" 
    crossorigin="anonymous"></script> 

    <script>

        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal',function(event){
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value= id
        })                         

        function actualizarCantidad(cantidad,id){
            let url = 'clases/actualizar_carrito.php'
            let formDate = new FormData()
            formDate.append('action','agregar')
            formDate.append('id',id)
            formDate.append('cantidad',cantidad)

            fetch(url,{
                method: 'POST',
                body: formDate,
                mode: 'cors'
            }).then(response => response.json())
            .then (data =>{
                if (data.ok) {

                    let divsubtotal= document.getElementById('subtotal_'+id)
                    divsubtotal.innerHTML= date.sub

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')

                    for (let i = 0; i < list.length; i++) {
                        total += parseFloat(list[i].innerHTML.replace(/[$,]/g,''))
                    }
                    total = new Intl.NumberFormat('en-US',{
                        minimumFractionDigits: 2
                    }).format(total)
                    document.getElementById('total').innerHTML= '<?php echo MONEDA;?>'+total 
                }
            })
        }
        function eliminar(){

            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_carrito.php'
            let formDate = new FormData()
            formDate.append('action','eliminar')
            formDate.append('id',id)

            fetch(url,{
                method: 'POST', 
                body: formDate,
                mode: 'cors'
            }).then(response => response.json())
            .then (data =>{
                if (data.ok) {
                    location.reload()
                }
            })
        }
    </script>
</body>
</html> 