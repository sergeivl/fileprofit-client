$('#add-categories').click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/menu-add-categories',
        data: {'action': 'addCategory'},
        success: function () {
            location.reload();
        }
    });
});