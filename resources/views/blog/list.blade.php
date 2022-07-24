<x-layout>
    <div class="wrapper">
        <section class="blog page">
            <h1 class="blog__title page">
                {{ $pageTitle }}
            </h1>
            <div class="blog__wrapper">
                <div class="blog__content">
                    <ul class="blog__list">
                        @foreach($blogs as $blog)
                        <li class="blog__item">
                            <figure class="blog__item-card">
                                @if ($photo = $blog->getFirstMedia('photo'))
                                    <a href="{{ $blog->getLink() }}">
                                        <img src="{{ thumb($photo, 'fit', 800, 400) }}" alt="">
                                    </a>
                                @endif
                                <figcaption class="blog__item-info">
                                    <div class="blog__item-container">
                                        <time class="blog__item-date">{{ date('M d, Y', $blog->from_date) }}</time>
                                    </div>
                                    <div class="blog__item-text">
                                        <h4 class="blog__item-title">{{ $blog->name }}</h4>
                                        <p class="blog__item-subtitle">{{ $blog->short_text }}</p>
                                    </div>
                                    <a href="{{ route('blog.show', ['category' => $blog->category->alias, 'alias' => $blog->alias]) }}"
                                       class="blog__item-btn">
                                        {{ __('Mehr Info') }}
                                    </a>
                                </figcaption>
                            </figure>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @include('blog.categories')
            </div>
        </section>
        {!! PaginateRoute::renderPageList($blogs, false, 'pagination', true) !!}
    </div>
</x-layout>
