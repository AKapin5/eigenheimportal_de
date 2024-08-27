<ul>
    @foreach($pageLinks as $language => $pageLink)
        <li @if(app()->getLocale() == $language) class="active" @endif>
            <a href="{{ $pageLink }}">{{ $language }}</a>
        </li>
    @endforeach
</ul>
