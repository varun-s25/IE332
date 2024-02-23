<?php 
 if (empty ($_SERVER[ 'QUERY_STRING ' ] ) ) { 
echo "empty";
 } else {
echo "qs: ".$_SERVER['QUERY_STRING ' ] ;
}
?>