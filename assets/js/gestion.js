/*************** INITIALISATION ***************/

/** Initialisation de la datatable */
initTable();

/*************** FONCTION ***************/

/** Fonction initialisation des dates */
function initTable(){
    $('#dashboard').dataTable({
        "searching": false,
        "lengthChange": false,
        "language": {
            "info": "Page _START_ sur _END_ pour _TOTAL_ annonce(s)",
            "zeroRecords": "Aucune annonce trouvée. N'hesitez pas à en créer !",
            "infoEmpty": "",
            "paginate": {
                "previous": "«",
                "next": "»"
            }
        },
        "ordering": false,
        "pageLength": 4
    });
}