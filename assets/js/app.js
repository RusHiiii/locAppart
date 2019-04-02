/*************** INITIALISATION ***************/

$( document ).ready(function() {
  /** Initialisation du rgpd */
  initRgpd();

});

/** Fonction du RGPD */
function initRgpd(){
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
      "message": "Loc'Appart utilise des cookies pour assurer le bon fonctionnement du site.",
      "dismiss": "Accepter",
      "link": "Plus d'infos",
      "href": "www.locappart-dev.fr/mentions-legales"
    }
  });
}