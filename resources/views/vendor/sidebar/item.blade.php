<li class="nav-item @if($item->getItemClass()){{ $item->getItemClass() }}@endif @if($active)nav-item-expanded nav-item-open @endif @if($item->hasItems())nav-item-submenu @endif clearfix">
    <a href="{{ $item->getUrl() }}" class="nav-link @if(count($appends) > 0) hasAppend @endif @if(count($items) == 0) nav-item-link @endif" @if($item->getNewTab())target="_blank"@endif>
        @if(!empty($item->getIcon()))
         <i class="{{ $item->getIcon() }}"></i>
        @endif
        <span>{{ $item->getName() }}</span>

        @foreach($badges as $badge)
            {!! $badge !!}
        @endforeach

        @if($item->hasItems())<i class="{{ $item->getToggleIcon() }} pull-right"></i>@endif
    </a>

    @foreach($appends as $append)
        {!! $append !!}
    @endforeach

    @if(count($items) > 0)
        <ul class="nav nav-group-sub">
            @foreach($items as $item)
                {!! $item !!}
            @endforeach
        </ul>
    @endif
</li>
