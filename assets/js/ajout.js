jQuery(document).ready(function() {
    $('.force-hidden').parent().remove();

    $collectionHolder = $('#appartment_ressources');

    $collectionHolder.find($("div[id^='appartment_ressources_']")).each(function() {
        addTagFormDeleteLink($(this));
    });

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('#add_image').on('click', function(e) {
        addTagForm($collectionHolder, $('#add_image'));
    });
});

$("#no-more-tables").on('change', "input[type='file']", function(evt){
    var number = $(this).attr('id').replace( /^\D+/g, '').charAt(0);
    readURL($(this), number);
});

$("#no-more-tables").on('click', ".box_img > a", function(evt){
    var number = $(this).attr('id');
    deletePhoto(number);
});

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
    var $el = $('#appartment_ressources_'+ val + '_file');

    console.log($el);
    $el.wrap('<form>').closest('form').get(0).reset();
    $el.unwrap();

    $('#box_'.concat(val)).show();
    $('#img_'.concat(val)).hide();
    $('#circle_'.concat(val)).hide();
}

function addTagForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');

    var index = $collectionHolder.data('index');

    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<td></td>').append(newForm);
    $('#appartment_ressources').append($newFormLi);
}