/*************** INITIALISATION ***************/

/** Initialisation de la datatable */
initTable();

/*************** LISTENER ***************/

/** Listener d'affichage du texte */
$('tbody').on('click', '.link_form', function(){
    var msg = $(this).closest('tr').next('tr');

    if ($(msg).is(":hidden")){
        $(msg).show();
    }else{
        $(msg).hide();
    }
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
});

/** Listener de suppression */
$('#messages tbody').on( 'click', '.delete', function () {
    var id = $(this).data('id');
    var table = $('#messages').DataTable();
    var counter = $('#counter').text();

    $(this).empty();
    $(this).addClass('loading spinner');

    $.ajax({
        url : '/xhr/message/suppression',
        type : 'POST',
        data : {
            'message' : id
        },
        dataType:'json',
        success : (res) => {
            if(res.data.delete){
                table
                    .row($(this).closest('tr').next('tr'))
                    .remove();

                table
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();

                $('#counter').text(parseInt(counter) - 1);
            }
        }
    });
});

/*************** FONCTION ***************/

/** Fonction initialisation datatable */
function initTable(){
    $('#messages').dataTable({
        "searching": false,
        "lengthChange": false,
        "language": {
            "info": "Page _PAGE_ sur _PAGES_",
            "zeroRecords": "Aucun message !",
            "infoEmpty": "",
            "paginate": {
                "previous": "«",
                "next": "»"
            }
        },
        "ordering": false,
        "pageLength": 10,
        "dom": '<"top"p<"clear">>rt<"bottom"i<"clear">>',
        "pagingType": "simple"
    });
}