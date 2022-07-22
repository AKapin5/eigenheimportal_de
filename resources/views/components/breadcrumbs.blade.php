@isset($breadcrumbs)
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item">
            <a href="{{ route('home') }}" class="breadcrumbs__link">{{ __('Heim') }}</a>
        </li>
        @foreach($breadcrumbs as $item)
            <li class="breadcrumbs__item">
                @isset($item['url'])
                    <a href="{{ $item['url'] }}" class="breadcrumbs__link">{{ $item['name'] }}</a>
                @else
                    {{ $item['name'] }}
                @endisset
            </li>
        @endforeach
    </ul>
@endisset
