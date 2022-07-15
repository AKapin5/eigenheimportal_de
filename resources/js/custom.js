window.addEventListener('DOMContentLoaded', function () {
    const body = document.querySelector('#body');

    if (/iPhone|iPad/i.test(navigator.userAgent)) {
        body.classList.add('ios');
    } else {
        body.classList.add('web');
    }
    body.classList.remove('loaded');

    const slickSlider = $('.js-slick');

    if (slickSlider.length) {
        $(slickSlider).slick({
            dots: true,
            autoplay: false,
            prevArrow: '<button type="button" class="slick-prev">' +
                '<img src="/img/icons/arrow-prev.svg">' +
                '</button>',
            nextArrow: '<button type="button" class="slick-next">' +
                '<img src="/img/icons/arrow-next.svg">' +
                '</button>'
        });
    }


    const categoryItems = document.querySelectorAll('.js-categories-list .blog__categories-item');
    for (let i = 0; i < categoryItems.length; i++) {
        categoryItems[i].addEventListener('click', function () {
            if (this.classList.contains('m-active')) {
                this.classList.remove('m-active');
            } else {
                this.classList.add("m-active");
            }
        });
    }

    const burgerMenu = document.querySelector('.js-burger-menu');
    const menuList = document.querySelector('.js-menu-list');
    const overlay = document.querySelector('.js-overlay');

    burgerMenu.addEventListener('click', function () {
        if (this.classList.contains('m-active')) {
            this.classList.remove('m-active');
            menuList.classList.remove('m-active');
            body.classList.remove('m-fixed');
            overlay.classList.remove('m-show');
        } else {
            this.classList.add("m-active");
            menuList.classList.add("m-active");
            body.classList.add('m-fixed');
            overlay.classList.add('m-show');
        }
    });
});
