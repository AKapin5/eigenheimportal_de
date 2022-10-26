<aside class="blog__categories {{ $theme ?? '' }}">
    <h3 class="blog__categories-header">{{ __('Kategorien') }}</h3>
    <ul class="blog__categories-list js-categories-list">
        @foreach($categories as $category)
            <li class="blog__categories-item">
                <a href="{{ route('blog.index', ['category' => $category->alias]) }}">
                    {{ $category->name }}
                    (<span class="blog__categories-quantity">{{ $category->blogs()->active()->count() }}</span>)
                </a>
            </li>
        @endforeach
    </ul>
</aside>
