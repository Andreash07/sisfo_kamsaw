<?php
function bukakoneksi(){
$server="localhost";
$user="sisd1326_userCI";
$pw="DBKamsaw";
$database="sisd1326_sisfo";

$konek=new mysqli($server, $user, $pw, $database);
return $konek;
}
?>