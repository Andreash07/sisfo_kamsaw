<?php
function bukakoneksi(){
$server="localhost";
$user="alvin";
$pw="BIH8b67897YNJHYB3rfidsf&dfskb";
$database="dbais";

$konek=new mysqli($server, $user, $pw, $database);
return $konek;
}
?>