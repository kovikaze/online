<?php
 $ch = curl_init( "<ip>:80/new/product" );
 curl_setopt( $ch, CURLOPT_POST, 1 );
 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
 $data["prod_name"] = htmlspecialchars( $_POST["prod_name"] );
 $data["prod_type"] = htmlspecialchars( $_POST["prod_type"] );
 $data["prod_value"] = htmlspecialchars( $_POST["prod_value"] );
 $data["prod_price"] = htmlspecialchars( $_POST["prod_price"] );
 curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
 $response = curl_exec( $ch );
 header( "Location: /index.php" );
?>