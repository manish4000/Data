@props([
    'orderBy',
])
@php

$order = isset(request()->order)? request()->order :'';
$orderBy_request = isset(request()->order_by)? request()->order_by :'';

switch ($order) {
    case 'asc':
        $icon = "fa-solid fa-arrow-down-short-wide";
  
        break;
    case 'desc':
        $icon = "fa-solid fa-arrow-up-wide-short";

        break;
}

if($orderBy_request == $orderBy ){
     $icon = $icon;
}else{
    $icon ="fa-solid fa-arrows-up-down";
  
}
@endphp

<div class="short-by-filter filter-short " @if(isset($orderBy)) data-orderBy="{{$orderBy}}"  @endif >
       <i class="{{$icon}}"></i> 
</div>

