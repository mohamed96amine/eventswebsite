
window.addEventListener("load", init);


function init(){
    drawmap();
}

var coords = new Array();
var m;

function drawmap(){
    var map = L.map('map');
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
    map.setView([45, 3.1416], 5);
    map.on('click',function (e) {mapClick(e, map);});
    var title = document.getElementById('title');
    var text = document.getElementById('text');
    var date = document.getElementById('date');
    elements = [title, text, date];
    var send = document.getElementById('send');
    send.addEventListener("click", function () {
        store_request(elements);
    });
}


function mapClick(e, map) {
    if (m != null){
        map.removeLayer(m);
    }
    var lat = (e.latlng.lat).toFixed(5);
    var lon = (e.latlng.lng).toFixed(5);
    coords = [];
    coords.push(lat);
    coords.push(lon);
    var marker = L.marker([lat, lon]).addTo(map).bindPopup("<b>Here!</b><br>"); // dessine le marqueur
    m = marker;
}


function store_request(elements){
    var loader = document.getElementById('loader');
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){ // requête términée
            loader.style.display = 'none'; // cacher l'image du chargemenet
            var resp = (xhr.responseText); // convertir le resultat en JSON
            handle(resp);
        }else{ // requête en cours d'execution
            loader.style.display = 'block'; // affichage de l'image du chargement
        }
    }
    var title = elements[0].value;
    var text = elements[1].value;
    var date = elements[2].value;
    var url = encodeURI("lib/saveevent.php?title="+title+"&text="+text+"&date="+date+"&lat="+coords[0]+"&lon="+coords[1]);
    xhr.open("GET",url, true);
    xhr.send(null);
}


function handle(string) {
    var t = document.getElementById("notification");
    t.innerHTML = "<p>"+string+"</p>";
    t.style.display='block';
}
