$(document).ready(function () {
    $('.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div'
    });

});

$('#saveMenu').click(function () {
    var sorting = [];
    var children = [];
    $(document).find('.sortable li').each(function (i, item) {
        sorting[sorting.length] = $(item).attr('data-menu-id');
    });

    $(document).find('.sortable li ol li').each(function (i, item) {
        var parentElement = $(this).parent().parent().attr('data-menu-id');
        children[children.length] = {parent: parentElement, child: $(item).attr('data-menu-id')};
    });


    saveOrder(sorting, children);
});

function saveOrder(sorting, children) {
    $.ajax({
        type: 'POST',
        url: '/admin/save-menu-sorting',
        data: {'ids': sorting, 'children': children},
        success: function (res) {
            if (res === 'ok') {

            } else {

            }
        }
    });
}
