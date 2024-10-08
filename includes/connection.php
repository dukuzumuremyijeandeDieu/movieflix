<?php
$conn = mysqli_connect('localhost','root','','rukari');
if($conn == True){
    echo "Connected well";
}else{
    echo "not connected";
}
?>