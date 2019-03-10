/*************** INITIALISATION ***************/

$( document ).ready(function() {
    /** Initialisation des images */
    initImage();

    /** Initialisation placeholder */
    initSelect();

    /** Initialisation calendrier */
    initCalendar();

    /** Initialisation de la map */
    initMap();
});

/*************** FONCTION ***************/

/** Fonction initialisation des images */
function initImage(){
    $('.carousel-inner').each(function(i, element) {
        $(element).find('.item').first().addClass('active');
    });

    $('.carousel-indicators').each(function(i, element) {
        $(element).find('li').first().addClass('active');
    });

    $("#carousel").owlCarousel({
        slideSpeed : 300,
        autoPlay : true,
        navigation : false,
        pagination : false,
        singleItem:true
    });
}

/** Fonction initialisation de la map */
function initMap(){
    var map;

    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: $('#map').data('lat'), lng: $('#map').data('lng')},
        zoom: 17
    });

    var m = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng($('#map').data('lat'), $('#map').data('lng'))
    });
}

/** Initialisation des placeholders des select */
function initSelect() {
    $('.city').selectpicker({noneSelectedText: 'Ville'});
    $('.locker').selectpicker({noneSelectedText: 'Casier'});
    $('.garage').selectpicker({noneSelectedText: 'Garage'});
    $('.department').selectpicker({noneSelectedText: 'Département'});
}

/** Initialisation des calendriers */
function initCalendar(){
    $('td').hover(function() {
        $(this).children('.blurb').show();
    }, function() {
        $(this).children('.blurb').hide();
    });
}