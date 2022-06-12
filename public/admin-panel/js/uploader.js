$(function() {
    $(document).on('click', '.file-uploader [data-remove-file]', function(e) {
        e.preventDefault();
        let _that = $(this);
        if (!confirm(_that.data('confirmText'))) {
            return;
        }
        $.ajax({
            url: _that.attr('href'),
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    _that.closest('.file-item').remove();
                }
            },
        });
    });

    $('.file-uploader .sortable').sortable({
        handle: ".handle",
        stop: function( event, ui ) {
            const cont = ui.item.closest('tbody');
            const ids = [];
            cont.find('tr').map(function() {
                ids.push($(this).data('id'));
            });
            $.ajax({
                url: cont.attr('data-sort-url'),
                type: 'post',
                data: {
                    ids: ids
                }
            });
        }
    });
});
