<div>
    <section class="comments">
        <h3 class="comments__title">
            <span class="comments__amount">{{ count($comments) }}</span> {{__('app.comments.blockTitle')}}
        </h3>
        <ul class="comments__list">
            @foreach($comments as $comment)
                <li class="comments__item">
                    <div class="comments__container">
{{--                        <div class="comments__icon-wrapper">--}}
{{--                            <img class="comments__icon" src="/img/icons/commet-icon_1.jpg" alt=""></div>--}}
                        <div class="comments__comment">
                            <h4 class="comments__comment-name">{{ $comment->name }}</h4>
                            <div class="comments__comment-additon">
                                <time class="comments__comment-date">{{ $comment->created_at->format('M d, Y H:i') }}</time>
                            </div>
                            <p class="comments__comment-text">
                                {{ nl2br($comment->text) }}
                            </p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
    @if ($hasMore)
        <button class="sales-offers__btn" wire:click="loadItems">
            {{ __('app.pagination.showMore') }}
        </button>
    @endif
    <form class="form add-comment" wire:submit.prevent="add">
        <h3 class="add-comment__title">{{ __('app.comments.addTitle') }}</h3>
        <div class="add-comment__container">
            <div class="add-comment__info">
                <div class="add-comment__info-icon-wrapper">
                    <img src="/img/icons/user.svg" alt="" class="add-comment__info-icon">
                </div>
                <div class="add-comment__name">
                    <label class="add-comment__name-label">{{ __('app.comments.labels.name') }}*</label>
                    <input wire:model="name" type="text" class="add-comment__name-input">
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <label class="add-comment__comment-label">{{ __('app.comments.labels.text') }}*</label>
            <textarea wire:model="text" class="add-comment__comment" rows="3"></textarea>
            @error('text') <span class="error">{{ $message }}</span> @enderror
            <input type="submit" class="form__btn" value="{{ __('app.send') }}">
        </div>
    </form>
</div>
