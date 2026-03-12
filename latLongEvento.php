<?php
session_start();
include 'Conexao.php';



<script>
var endereco = "Av Andrômeda 500, São José dos Campos";

fetch("https://nominatim.openstreetmap.org/search?format=json&q=" + endereco)

.then(response => response.json())

.then(data => {

    var lat = data[0].lat;
    var lon = data[0].lon;

    console.log(lat, lon);

});
?>