@props(['menu'])
<li class="{{!$menu->children->isEmpty() ? 'page-item-has-children' : ''}}">
    <a href="{{!$menu->children->isEmpty() ? 'javascript:;' : (!empty($menu->route) ? url($menu->route ) : url('/'))}}">
        {!! ucfirst($menu->label) !!}
        @if( !$menu->children->isEmpty() )
            <i class="am-icon-chevron-down"></i>
        @endif
    </a>
    @if( !$menu->children->isEmpty() )
        <ul class="sub-menu">
            @foreach( $menu->children as $child)
                <x-menu-item :menu="$child" />
            @endforeach
        </ul>
    @endif
</li>
