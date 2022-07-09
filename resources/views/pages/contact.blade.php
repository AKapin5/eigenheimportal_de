<x-layout>
    <div class="wrapper">
        <section class="contact">
            <h1 class="contact__title">Kontakte</h1>
            <div class="contact__info">
                <ul class="contact__list">
                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/geolocation-secondary.svg" alt="">
                        </div>
                        <div class="contact__item-text">EigenheimWunsch GmbH
                            Hauptstraße 28
                            15806 Zossen
                        </div>
                    </li>

                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/geolocation-secondary.svg" alt="">
                        </div>
                        <div class="contact__item-text">EigenheimWunsch GmbH
                            Hauptstraße 196
                            79576 Weil am Rhein
                        </div>
                    </li>

                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/mail-secondary.svg" alt="">
                        </div>
                        <a href="mailto:info@eigenheimwunsch.de" class="contact__item-text">
                            info@eigenheimwunsch.de
                        </a>
                    </li>

                    <li class="contact__item">
                        <div class="contact__item-wrapper-icon">
                            <img class="contact__item-icon" src="/img/icons/phone-secondary.svg" alt="">
                        </div>
                        <a href="tel:+4976211569111" class="contact__item-text">+49 7621 1569 111</a>
                        <a href="tel:+4976211569777" class="contact__item-text">+49 7621 1569 777</a>
                    </li>
                </ul>
            </div>
            <section class="form__wrapper m-secondary">
                <h2 class="form__title m-secondary">Kontakt</h2>
                <form class="form">
                    <div class="form__group">
                        <div class="form__field">
                            <label for="form__name" class="form__label m-secondary">Name</label>
                            <input type="text" id="form__name" class="form__input m-secondary">
                        </div>
                        <div class="form__field">
                            <label for="form__mail" class="form__label m-secondary">E-mail</label>
                            <input type="text" id="form__mail" class="form__input m-secondary">
                        </div>
                    </div>
                    <div class="form__field textarea">
                        <label for="form__news" class="form__label m-secondary">Nachricht</label>
                        <textarea class="form__input textarea m-secondary" rows="5"></textarea>
                    </div>
                    <input type="submit" class="form__btn m-secondary" value="Senden">
                </form>
            </section>
        </section>
    </div>
</x-layout>
