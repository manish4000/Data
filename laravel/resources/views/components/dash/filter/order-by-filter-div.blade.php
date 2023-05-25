@props([
    'orderBy',
])
@php

$order = isset(request()->order)? request()->order :'';
$orderBy_request = isset(request()->order_by)? request()->order_by :'';

switch ($order) {
    case 'asc':
        $icon = "fa-solid fa-arrow-down-long";
        break;
    case 'desc':
        $icon = "fa-solid fa-arrow-up-long";
        break;
}

if($orderBy_request == $orderBy ){
     $icon = $icon;
}else{
    $icon ="";
}
@endphp

<div 
    
    class="short-by-filter filter-short"
    @if(isset($orderBy)) data-orderBy="{{$orderBy}}"  @endif >
    <i class="{{$icon}}"></i> 
</div>