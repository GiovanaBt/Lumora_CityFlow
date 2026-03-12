<?php
include 'Conexao.php';

$sql = "SELECT id_evento, descricao, latitude, longitude, rua, bairro, numero 
        FROM Eventos_Cadastrados";

$result = $conexao->query($sql);

$eventos = [];

while($row = $result->fetch_assoc()){
    $eventos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>CityFlow - Mapa de Eventos</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<link rel="stylesheet" href="mapa.css">
</head>

<body>

<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

let map = L.map('map').setView([-23.22, -45.90], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution:'© OpenStreetMap'
}).addTo(map);


navigator.geolocation.getCurrentPosition(function(pos){

    var lat = pos.coords.latitude;
    var lon = pos.coords.longitude;

    map.setView([lat,lon],14);

    L.marker([lat,lon])
    .addTo(map)
    .bindPopup("📍 Você está aqui")
    .openPopup();

});


let eventos = <?php echo json_encode($eventos); ?>;

// console.log(eventos);

eventos.forEach(function(evento){
    if(evento.latitude && evento.longitude){
    let popupHTML = `<div class="popupEvento">

    <b>${evento.descricao}</b>
    <p>${evento.rua} ${evento.numero}, ${evento.bairro}</p>
    </div>`;

L.marker([evento.latitude,evento.longitude])
.addTo(map)
.bindPopup(popupHTML);

}

});

</script>

</body>
</html>