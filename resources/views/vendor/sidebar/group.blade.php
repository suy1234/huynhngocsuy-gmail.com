@if($group->shouldShowHeading())
 <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">{{ $group->getName() }}</div> <i class="icon-menu" title="Main"></i></li>
@endif

@foreach($items as $item)
    {!! $item !!}
@endforeach
