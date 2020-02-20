$('.btnReserv').on('click', function(){
    var id = $(this).attr('data-id');
    $('#program_id').val(id);
});
