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

$('.menu-item-edit').click(function(){
    var itemMenuData = $(this).closest('li');

    var itemMenuId = itemMenuData.attr('data-menu-id');
    var itemName = itemMenuData.attr('data-menu-item-name');
    var itemLink = itemMenuData.attr('data-menu-link');


    $('#modal-item-name').html(itemName);
    $('#itemMenuElementId').val(itemMenuId);
    $('#itemMenuName').val(itemName);
    $('#itemMenuLink').val(itemLink);

    $("#editMenuItemModal").modal('show');

    $('#send-edited-item').click(function(){
        $('#item-menu-edit').submit();
    });
});


$('.menu-item-delete').click(function(){

    var itemMenuData = $(this).closest('li');
    var itemMenuId = itemMenuData.attr('data-menu-id');

    $('#itemMenuElementIdForDelete').val(itemMenuId);
    $('#deleteMenuItemModal').modal('show');
});

$('#send-delete-item').click(function(){
    $('#item-menu-delete').submit();
});
