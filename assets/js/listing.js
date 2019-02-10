/*************** INITIALISATION ***************/

$( document ).ready(function() {
    /** Initialisation des images */
    initImage();
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