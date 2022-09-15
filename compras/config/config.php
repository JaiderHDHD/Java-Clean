<?php 
define("CLIENT_ID","AeDR1r7Tpj-RQGg2t5FKksv4uhg9SG1IFKC67cdsP9dHwhZMQhnjhqlfJXCN5kr_vvAQyi7mhc1A2U4X");
define("KEY_TOKEN","APR.wqc-345*");
define("MONEDA","$");

session_start(); 

$num_cart =0;
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart=count($_SESSION['carrito']['productos']);
}

?>