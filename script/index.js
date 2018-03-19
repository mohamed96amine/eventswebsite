
window.addEventListener("load", init);


function init(){
    drawmap();
}


var sum = 0;
var markers = new Array();                                                                  // marqueurs dessinés sur la carte
var from = 0;                                                                               // variable qui gére l'affichage des pages

function drawmap(){
    var map = L.map('map');
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    map.locate({setView: true, maxZoom: 8});                                                // affiche la map avec localisation de l'utilisateur
    addListners(map);                                                                       // appel de la fonction addListners qui relie les evenements aux elements HTML

}


function addListners(map){
    var author = document.getElementById("author");
    var title = document.getElementById("title");
    var date1 = document.getElementById("date1");
    var date2 = document.getElementById("date2");
    var limit = document.getElementById("limit");
    var elements = [author, title, date1, date2, limit];            // tableau qui contient tous les elements de filtrage
    for(var i=0; i < elements.length; i++){                         // boucle sur tous les elements de filtrage
        elements[i].addEventListener("input", function () {
            from = 0;
            results(elements, map, from);                           // relie le changement d'un element de recherche a l'actualisation des resultats
        });
    }
    map.on('moveend',function () {
        from = 0;
        results(elements, map, from);                               // relie le mouvement de la carte a l'actualisation des resultats
    });
    nextAndBackListeners(elements, map);                                // appel fonction qui gére la l'affichage de la page suivante ou précedente
    dropDownListners();
}

function dropDownListners() {
    var signindrop = document.getElementById('signindrop');
    var signinform = document.getElementById('signinform');
    var closebtn = document.getElementById('closebtn');
    signindrop.addEventListener('click', function () {
        signinform.style.display = 'block' ;
    });
}

function nextAndBackListeners(elements, map) {
    var next = document.getElementById('next');
    var back = document.getElementById('back');
    limit = elements[4];
    next.addEventListener('click', function () {

        from += parseInt(limit.value);                                        // calcul du nombre de resultats à afficher a la page suivante
        results(elements, map, from);                                         // relie le changement d'un element de recherche a l'actualisation des resultats
    });
    back.addEventListener('click', function () {

        from -= parseInt(limit.value);                                        // calcul du nombre de resultats à afficher a la page précedente
        results(elements, map, from);                                         // relie le changement d'un element de recherche a l'actualisation des resultats
    });
}

function results(e, map, f) {
    var loader = document.getElementById('loader');
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){    // requête términée
            loader.style.display = 'none';                                    // cacher l'image du chargemenet
            var resp = JSON.parse(xhr.responseText);                          // convertir le resultat en JSON
            displayResults(resp.events, map);                                 // fonction qui gére l'affichage du resultat récupéré
            numberElements(resp.total);                                       // nombre total des evenements qui correspondent aux critéres
        }else{                                                                // requête en cours d'execution
            loader.style.display = 'block';                                   // affichage de l'image du chargement
        }
    }
    var b = bounds(map); // récupere latmin , latmax, lonmin et lonmax
    var url = encodeURI("search.php?author="+e[0].value+"&title="+e[1].value+"&date1="+e[2].value+"&date2="+e[3].value+"&latmax="+b[0]+"&latmin="+b[1]+"&lonmax="+b[2]+"&lonmin="+b[3]+"&limit="+e[4].value+"&from="+f);
    xhr.open("GET",url, true);
    xhr.send(null);
}

function drawMarker(lat, lon, title,id , map) {
    var marker = L.marker([lat, lon]).addTo(map).bindPopup("<b><a href='http://webtp.fil.univ-lille1.fr/~elbachra/projet/getevent.php?id="+id+"'>"+ title + "</a></b><br>"); // dessine le marqueur
    markers.push(marker); // ajoute le marqueur au tableau des marqueurs déssinés
}

function displayResults(list, map) {
    var results = document.getElementById('results') // récuperation des resultats
    removeMarkers(map); // supression des tous les marqueurs
    results.innerHTML = "<div>"; // div qui contient tous les elements du result (evenements)
    for(var i = 0 ; i < list.length; i++) { // boucle sur tous les elements
        results.innerHTML += displayEvent(list[i]) ; // appel de la fonction displayEvent qui affiche l'evenement
        drawMarker(list[i].lat, list[i].lon, list[i].title, list[i].id,map); // dessine le marqueur
    }
    results.innerHTML += "</div>"; // fermeture du div
    var limit = document.getElementById("limit"); // récuperation du limit des evenements par page
    var page = parseInt(from) / parseInt(limit.value)+1; // calcul du numéro de la page actuelle
    var p = document.getElementById('page'); // récuperation de l'element qui affiche le numéro de la page actuelle
    if (isNaN(page)){page = 0;}
    p.innerHTML = "Your On Page:"+page; // affiche le numéro de la page actuelle
    handle_from(limit.value);
}

function displayEvent(event){
    var result = "<div class='events'><h2 class='eventtitle'><a href='http://webtp.fil.univ-lille1.fr/~elbachra/projet/getevent.php?id="+event.id+" '>" + event.title + "</a></h2><p class='eventdate'>Date : " + event.date + "</p><p class='eventauthor'>   by : " + event.author + "</p><p class='eventtext'>"+event.text+"</p></div>"
    return result;
}


function bounds(map) {
    var b = map.getBounds();
    var latmax = (b.getNorth().toFixed(5));
    var latmin = (b.getSouth().toFixed(5));
    var lonmax = (b.getEast().toFixed(5));
    var lonmin = (b.getWest().toFixed(5));
    var coords  = new Array(latmax, latmin, lonmax, lonmin);
    return coords;
}


function removeMarkers(map){
    for(var i=0; i < markers.length; i++){
        map.removeLayer(markers[i]); // suppression de tous les marqueurs
    }
}


function numberElements(total) {
    sum = total;
    var limit = document.getElementById('limit');
    var numberpages = document.getElementById('numberpages');
    var events, t;
    if(total == null){
        events = t = 0;
    }else{
        events = limit.value;
        t = parseInt(parseInt(total)/parseInt(limit.value))+1 ;
    }
    numberpages.innerHTML = events.toString()+" evenements "+t.toString() +" pages.";
}


function post(){
    window.location = "postanevent.php"; // redirection to the page that handles event posting
}


function showbutton(id) {
    var button = document.getElementById(id);
    button.style.display = 'block';
}

function hidebutton(id) {
    var button = document.getElementById(id);
    button.style.display = 'none';
}


function handle_from(value) {
    if(from <= 0){
        hidebutton('back');
        showbutton('next');
    }else if(from + parseInt(value) >= sum){
        hidebutton('next');
        showbutton('back');
    }else{
        showbutton('next');
        showbutton('back');
    }
}