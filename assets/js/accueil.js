/*************** INITIALISATION ***************/

$( document ).ready(function() {
  /** Initialisation du rgpd */
  initRgpd();

});

/*************** INITIALISATION ***************/

/** Carousel */
$("#owl-demo").owlCarousel({
  slideSpeed : 300,
  autoPlay : true,
  navigation : false,
  pagination : false,
  singleItem:true
});

/*************** FONCTION ***************/

/** Fonction du RGPD */
function initRgpd(){
  window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#1f4567"
        },
        "button": {
          "background": "#008caf"
        }
      },
      "theme": "edgeless",
      "position": "bottom-right",
      "content": {
        "message": "<i class=\"fas fa-cookie-bite\"></i>Loc'Appart utilise des cookies pour assurer le bon fonctionnement du site.",
        "dismiss": "Accepter",
        "link": "Plus d'infos",
        "href": "www.locappart-dev.fr/mentions-legales"
      }
    })});
}