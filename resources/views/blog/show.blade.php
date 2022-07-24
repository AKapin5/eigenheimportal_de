<x-layout>
    <div class="wrapper">
        <section class="question">
            <div class="question__wrapper">
                <div class="question__content">
                    <h2 class="question__header">{{ $blog->name }}</h2>
                    <div class="question__banner-wrapper">
                        @if ($photo = $blog->getFirstMedia('photo'))
                            <img class="question__banner" src="{{ thumb($photo, 'fit', 800) }}" alt="">
                        @endif
                    </div>
                    <h3 class="question__date">{{ date('M d, Y', $blog->from_date) }}</h3>
                    <div>
                        {!! $blog->description !!}
                    </div>
                </div>

                @include('blog.categories', ['theme' => 'm-secondary'])
            </div>
        </section>

        <section class="comments">
            <h3 class="comments__title"><span class="comments__amount">1</span> Comments</h3>
            <ul class="comments__list">
                <li class="comments__item">

                    <div class="comments__container">
                        <div class="comments__icon-wrapper">
                            <img class="comments__icon" src="/img/icons/commet-icon_1.jpg" alt=""></div>
                        <div class="comments__comment">
                            <h4 class="comments__comment-name">Jeffrey</h4>
                            <div class="comments__comment-additon">
                                <time class="comments__comment-date">AUGUST 5, 2019 AT 5:36 AM</time>
                            </div>
                            <p class="comments__comment-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        </div>
                    </div>
                </li>
            </ul>
        </section>
        <section class="add-comment">
            <h3 class="add-comment__title">Leave a Comment</h3>
            <div class="add-comment__container">
                <div class="add-comment__info">
                    <div class="add-comment__info-icon-wrapper">
                        <img src="/img/icons/user.svg" alt="" class="add-comment__info-icon">
                    </div>
                    <div class="add-comment__name">
                        <label for="input-comment-name" class="add-comment__name-label">Name*</label>
                        <input type="text" id="input-comment-name" placeholder="Name*" class="add-comment__name-input">
                    </div>
                </div>
                <label class="add-comment__comment-label" for="">Add Comment*</label>
                <textarea class="add-comment__comment" name="" id="add-comment" rows="3" placeholder="Comment*"></textarea>
            </div>
        </section>
    </div>
</x-layout>
