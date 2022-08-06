<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        @foreach($menuItems as $menuItem)
            @isset($menuItem['items'])
                <li class="nav-item @if ($menuItem['active']) menu-open menu-is-open @endif">
                    <a href="javascript:;" class="nav-link @if ($menuItem['active']) active @endif">
                        <i class="nav-icon fas fa-{{ $menuItem['icon'] }}"></i>
                        <p>
                            {{ $menuItem['label'] }}
                            <i class="end fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if (!$menuItem['active']) style="display: none;" @endif>
                        @foreach($menuItem['items'] as $childItem)
                            <li class="nav-item">
                                <a href="{{ url($childItem['url']) }}" class="nav-link @if ($childItem['active']) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $childItem['label'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ url($menuItem['url']) }}" class="nav-link @if ($menuItem['active']) active @endif">
                        <i class="nav-icon fas fa-{{ $menuItem['icon'] }}"></i>
                        <p>{{ $menuItem['label'] }}</p>
                    </a>
                </li>
            @endisset
        @endforeach
    </ul>
</nav>
