(function ($) {

    let _csrfToken = function () {
        return $('meta[name="csrf-token"]').attr('content');
    };
    let _apiToken = function () {
        return $('meta[name="api-token"]').attr('content');
    };
    let lang = function () {
        return $('html').attr('lang');
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': _csrfToken()
        }
    });

    $(document).on('click', '[data-confirm]', function() {
        return confirm($(this).data('confirm'));
    });

    $('.select2').select2({
        theme: 'bootstrap4',
        allowClear: true,
        placeholder: '',
        language: lang(),
    });

    bsCustomFileInput.init();

    let transliterate = function(str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();

        let from = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
            'х', 'ц', 'ч', 'ш','щ', 'ъ', 'ь', 'ю', 'я', 'і', 'ї', 'ä', 'ü', 'ß', 'ö'];
        let to = [
            'a', 'b', 'v', 'g', 'd', 'e', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
            'h', 'c', 'ch', 'sh','sht', 'y', '', 'iu', 'ia', 'i', 'i', 'a', 'u', 'b', 'o'];
        for (let key in from) {
            str = str.replace(new RegExp(from[key], 'g'), to[key])
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str;
    };

    [...document.querySelectorAll('[data-transliteration="1"]')].map((element) => {
        ['input', 'paste'].map((event) => {
            document.addEventListener(event, function(e) {
                if (e.target.id === element.id) {
                    const target = element.closest('.tab-pane').querySelector('[data-slug]');
                    target.value = transliterate(element.value);
                }
            });
        })
    });

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
