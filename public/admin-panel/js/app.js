(function ($) {

    const dataGrid = {
        init: function() {
            dataGrid.handleDeleteRows();
        },

        handleDeleteRows: function() {
            $(document).on('click', '.power-grid-table .btn-delete-row', function() {
                return confirm('Are you sure you want to delete this record?');
            });
        }
    };

    const _csrfToken = function () {
        return $('meta[name="csrf-token"]').attr('content');
    };

    const lang = function () {
        return $('html').attr('lang');
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _csrfToken()
        }
    })

    dataGrid.init();

    $('.datetimepicker').each(function () {
        let that = $(this);
        that.flatpickr({
            locale: lang(),
            enableTime: that.data('enableTime') || true,
            enableSeconds: that.data('enableSeconds') || true,
            dateFormat: that.data('dateFormat'),
            allowInput: true
        });
    });

})(jQuery);
