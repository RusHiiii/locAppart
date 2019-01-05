/*************** INITIALISATION ***************/

/** Initialisation des inputs file */
initFile();

/** Initialisation des inputs pour les prix */
initPrice();

/** Initialisation des dates */
initDate();

/** Initialisation de la map */
initMap();


/*************** LISTENER ***************/

/** Listener changement des fichiers */
$("#no-more-tables").on('change', "input[type='file']", function(evt){
    var number = $(this).attr('id').replace( /^\D+/g, '').charAt(0);
    readURL($(this), number);
});

/** Listener suppression des fichiers */
$("#no-more-tables").on('click', ".box_img > a", function(evt){
    var number = $(this).attr('id');
    $('#td_'+ number).remove();
    $('#add_image').prop("disabled", false);
});

/** Listener suppression des prix */
$(".custom_table_prix").on('click', ".delete", function(evt){
    var tr = $(this).closest("tr");
    tr.remove();

    checkIfRemoveEmptyRow();
});

/** Listener changement de ville */
$('#appartment_city').on('change', (function() {
    var city = $('#appartment_city').find(':selected').val();

    $.ajax({

        url : '/xhr/city',
        type : 'POST',
        data : {
            'city' : city
        },
        dataType:'json',
        success : function(res) {
            var myLatlng = new google.maps.LatLng(res.data.lat,res.data.lng);
            marker = new google.maps.Marker({
                position: myLatlng,
                title:"Position"
            });
            changeLoc(res.data.lat, res.data.lng);
        }
    });
}));

/** Listener sur le form */
$('form[name="appartment"]').on('submit', function(evt){
    if(!$('#appartment_lng').val().trim()){
        evt.preventDefault();
        $('button[data-id="appartment_city"]').css('border-color', 'red');
    }else{
        $('#appartment_save').empty();
        $('#appartment_save').addClass('loading spinner');
    }
});


/*************** FONCTION ***************/

/** Fonction initialisation des dates */
function initDate(){
    $('.date').datepicker({
        language: "fr",
        autoclose: true
    });
}

/** Fonction pour check les lignes vides du tableau des prix */
function checkIfRemoveEmptyRow(){
    var tbody = $(".custom_table_prix tbody");
    if (tbody.children().length == 1) {
        $('#empty_row').css('display', 'table-row');
    }else{
        $('#empty_row').css('display', 'none');
    }
}

/** Fonction d'affichage des fichiers */
function readURL(input, val) {
    if (input[0].files && input[0].files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_'.concat(val))
                .attr('src', e.target.result)
                .show()
            $('#box_'.concat(val))
                .hide()
            $('#circle_'.concat(val))
                .show()

        };

        reader.readAsDataURL(input[0].files[0]);
    }
}

/** Fonction d'ajout d'une ressource */
function addRessourceForm(collectionHolder) {
    var newForm = collectionHolder.data('prototype');

    var index = collectionHolder.data('index');

    newForm = newForm.replace(/__name__/g, index);

    collectionHolder.data('index', index + 1);

    var $newFormLi = $("<td id='td_"+ index +"'></td>").append(newForm);
    $('#appartment_ressources').append($newFormLi);
}

/** Fonction d'ajout d'un prix */
function addPriceForm(collectionHolder) {
    var newForm = collectionHolder.data('prototype');

    var index = $('.custom_table_prix > tbody > tr').length - 1;

    newForm = newForm.replace(/__name__/g, index);

    var $newFormLi = $("<tr id='tr_price_"+ index +"'></tr>").append(newForm);
    $('.custom_table_prix tbody').append($newFormLi);
    checkIfRemoveEmptyRow();
}

/** Fonction d'init des fichiers */
function initFile() {
    var collectionHolder = $('#appartment_ressources');
    collectionHolder.data('index', collectionHolder.find(':input').length);

    if($('#appartment_ressources > td').length > 3){
        $('#add_image').prop("disabled", true);
    }

    $('#add_image').on('click', function(e) {
        if($('#appartment_ressources > td').length < 4){
            addRessourceForm(collectionHolder, $('#add_image'));

            if($('#appartment_ressources > td').length > 3){
                $('#add_image').prop("disabled", true);
            }
        }
    });
}

/** Fonction d'ajout des prix */
function initPrice() {
    var collectionHolder = $('#appartment_prices');

    collectionHolder.data('index', collectionHolder.find(':input').length);

    $('#add_price').on('click', function(e) {
        addPriceForm(collectionHolder, $('#add_price'));
        $("input[id*='date']").datepicker({
            language: "fr",
            autoclose: true
        });
        $("select[id*='availability']").selectpicker();
    });

    checkIfRemoveEmptyRow();
}

/** Fonction d'init de la map */
function initMap() {
    var tab = [];

    map = new google.maps.Map($('#map')[0], {
        center: {lat: 47.149241, lng: 2.296294},
        zoom: 5
    });

    google.maps.event.addListener(map, 'click', function (event) {
        marker.setMap(null);
        for (var i = 0; i < tab.length; i++ ) {
            tab[i].setMap(null);
        }
        var m = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
        });

        tab.push(m);
        var lastLat = m.getPosition().lat();
        var lastLng = m.getPosition().lng();

        $("#appartment_lat").val(lastLat.toFixed(8));
        $("#appartment_lng").val(lastLng.toFixed(8));
    });
}

/** Fonction changement loc sur la map */
function changeLoc(lat, lng) {
    map.setCenter(new google.maps.LatLng(lat,lng));
    map.setZoom(13);

    var lastLat = marker.getPosition().lat();
    var lastLng = marker.getPosition().lng();

    $("#appartment_lat").val(lastLat.toFixed(8));
    $("#appartment_lng").val(lastLng.toFixed(8));

    marker.setMap(map);
}