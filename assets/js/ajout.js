jQuery(document).ready(function() {
    initFile();
    initPrice();
});

$("#no-more-tables").on('change', "input[type='file']", function(evt){
    var number = $(this).attr('id').replace( /^\D+/g, '').charAt(0);
    readURL($(this), number);
});

$("#no-more-tables").on('click', ".box_img > a", function(evt){
    var number = $(this).attr('id');
    deletePhoto(number);
});

$(".custom_table_prix").on('click', ".delete", function(evt){
    var tr = $(this).closest("tr");
    tr.remove();

    checkIfRemoveEmptyRow();
});

$('.date').datepicker({
    language: "fr",
    autoclose: true
});

function checkIfRemoveEmptyRow(){
    var tbody = $(".custom_table_prix tbody");
    if (tbody.children().length == 1) {
        $('#empty_row').css('display', 'table-row');
    }else{
        $('#empty_row').css('display', 'none');
    }
}

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

function deletePhoto(val) {
    $('#td_'+val).remove();
}

function addRessourceForm(collectionHolder) {
    var prototype = collectionHolder.data('prototype');

    var index = collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    collectionHolder.data('index', index + 1);

    var $newFormLi = $("<td id='td_"+ index +"'></td>").append(newForm);
    $('#appartment_ressources').append($newFormLi);
}

function addPriceForm(collectionHolder) {
    var prototype = collectionHolder.data('prototype');

    var index = collectionHolder.data('index');
    console.log(index);
    index = index - 1;

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    collectionHolder.data('index', index + 2);

    var $newFormLi = $("<tr id='tr_price_"+ index +"'></tr>").append(newForm);
    $('.custom_table_prix tbody').append($newFormLi);
    checkIfRemoveEmptyRow();
}

function initFile() {
    var collectionHolder = $('#appartment_ressources');
    collectionHolder.data('index', collectionHolder.find(':input').length);

    $('#add_image').on('click', function(e) {
        addRessourceForm(collectionHolder, $('#add_image'));
    });
}

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