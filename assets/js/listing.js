/*************** INITIALISATION ***************/

$( document ).ready(function() {
    /** Initialisation des images */
    initImage();

    /** Initialisation placeholder */
    initSelect();
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

/** Initialisation des placeholders des select */
function initSelect() {
    $('.city').selectpicker({noneSelectedText: 'Ville'});
    $('.locker').selectpicker({noneSelectedText: 'Casier'});
    $('.garage').selectpicker({noneSelectedText: 'Garage'});
    $('.department').selectpicker({noneSelectedText: 'Département'});
}