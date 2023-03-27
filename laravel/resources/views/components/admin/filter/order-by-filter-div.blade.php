@props([
    'orderBy',
])
@php

$order = isset(request()->order)? request()->order :'';
$orderBy_request = isset(request()->order_by)? request()->order_by :'';

switch ($order) {
    case 'asc':
        $icon = "fa-solid fa-arrow-up";
        break;
    case 'desc':
        $icon = "fa-solid fa-arrow-down";
        break;
}

if($orderBy_request == $orderBy ){
     $icon = $icon;
}else{
    $icon ="fa-solid fa-arrows-up-down";
}
@endphp

{{-- <div 
    style="position: absolute;top: 1px;left: 3px;padding:10px;width:100%;height:100%"
    class="short-by-filter"
    @if(isset($orderBy)) data-orderBy="{{$orderBy}}"  @endif >
       <i class="{{$icon}}"></i> 
</div> --}}