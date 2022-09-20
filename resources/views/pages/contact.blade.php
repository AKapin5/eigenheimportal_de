<x-app>
    <div class="wrapper">
        <section class="contact">
            <h1 class="contact__title">{{ __('app.contact.title') }}</h1>
            <div class="contact__info">
                <ul class="contact__list">
                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/geolocation-secondary.svg" alt="">
                            <div class="contact__item-text">
                                {{ __('app.contact.address1.title') }}<br>
                                {{ __('app.contact.address1.street') }}<br>
                                {{ __('app.contact.address1.city') }}<br>
                            </div>
                        </div>
                    </li>
                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/geolocation-secondary.svg" alt="">
                            <div class="contact__item-text">
                                {{ __('app.contact.address2.title') }}<br>
                                {{ __('app.contact.address2.street') }}<br>
                                {{ __('app.contact.address2.city') }}<br>
                            </div>
                        </div>
                    </li>

                    <li class="contact__item">
                        <div>
                            <img class="contact__item-icon" src="/img/icons/phone-secondary.svg" alt="">
                            <a href="tel:+4976211569777" class="contact__item-text">+49 7621 1569 777</a>
                        </div>
                        <div>
                            <div class="contact__item-icon"></div>
                            <a href="tel:+4976211569111" class=" contact__item-text">+49 7621 1569 111</a>
                        </div>
                        <div>
                            <img class="contact__item-icon" src="/img/icons/mail-secondary.svg" alt="">
                            <a href="mailto:info@eigenheimwunsch.de" class="contact__item-text">
                                info@eigenheimwunsch.de
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <livewire:contact-form theme="m-secondary"/>
        </section>
    </div>
</x-app>
