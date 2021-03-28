@inject('menuItemHelper', \JeroenNoten\LaravelAdminLte\Helpers\MenuItemHelper)

@if ($menuItemHelper->isHeader($item))

    {{-- Header --}}
    @level($item['access_level'])
    <li @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header">
        {{ is_string($item) ? $item : $item['header'] }}
    </li>
    @endlevel

@elseif ($menuItemHelper->isSearchBar($item))

    {{-- Search form --}}
    @include('adminlte::partials.sidebar.menu-item-search-form')

@elseif ($menuItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    @include('adminlte::partials.sidebar.menu-item-treeview-menu')

@elseif ($menuItemHelper->isLink($item))

    {{-- Link --}}
    @include('adminlte::partials.sidebar.menu-item-link')

@endif
