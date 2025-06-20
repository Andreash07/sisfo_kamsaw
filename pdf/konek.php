<?php
die("asdasd");
function bukakoneksi(){
$server="localhost";
$user="root";
$pw="";
$database="dbsisfo";

$konek=new mysqli($server, $user, $pw, $database);
return $konek;
}
?>