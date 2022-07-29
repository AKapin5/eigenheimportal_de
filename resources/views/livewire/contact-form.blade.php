<section class="form__wrapper {{ $theme }}">
    <h2 class="form__title">{{ __('Kontakt') }}</h2>
    @if ($submitted)
        <p class="form__alert">
            {{ __('Ihre Anfrage wurde erfolgreich gesendet.') }}
        </p>
    @else
        <form id="contactForm" class="form" wire:submit.prevent="send">
            <div class="form__group">
                <div class="form__field">
                    <label for="form__name" class="form__label">{{ __('Name') }}</label>
                    <input type="text" wire:model="name" class="form__input">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form__field">
                    <label for="form__mail" class="form__label">{{ __('E-mail') }}</label>
                    <input type="email" wire:model="email" class="form__input">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form__field textarea">
                <label for="form__news" class="form__label">{{ __('Nachricht') }}</label>
                <textarea wire:model="text" class="form__input textarea" rows="5"></textarea>
                @error('text') <span class="error">{{ $message }}</span> @enderror
            </div>
            <input type="submit" class="form__btn" value="{{ __('app.send') }}">
        </form>
    @endif
</section>
