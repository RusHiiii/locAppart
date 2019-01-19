/*************** INITIALISATION ***************/

/** Initialisation de la datatable */
initTable();

/*************** LISTENER ***************/

/** Listener de suppression */
$('#dashboard tbody').on( 'click', '.delete', function () {
    var id = $(this).data('id');
    var table = $('#dashboard').DataTable();
    var counter = $('#counter').text();

    $(this).empty();
    $(this).addClass('loading spinner');

    $.ajax({
        url : '/xhr/appartement/suppression',
        type : 'POST',
        data : {
            'appartment' : id
        },
        dataType:'json',
        success : (res) => {
            if(res.data.delete){
                table
                    .row($(this).parents('tr'))
                    .remove()
                    .draw();
                $('#counter').text(parseInt(counter) - 1);
            }
        }
    });
} );

/*************** FONCTION ***************/

/** Fonction initialisation des dates */
function initTable(){
    $('#dashboard').dataTable({
        "searching": false,
        "lengthChange": false,
        "language": {
            "info": "Page _PAGE_ sur _PAGES_ pour _TOTAL_ annonce(s)",
            "zeroRecords": "Aucune annonce trouvée. N'hesitez pas à en créer !",
            "infoEmpty": "",
            "paginate": {
                "previous": "«",
                "next": "»"
            }
        },
        "ordering": false,
        "pageLength": 4,
        "dom": '<"top"p<"clear">>rt<"bottom"i<"clear">>',
        "pagingType": "simple"
    });
}