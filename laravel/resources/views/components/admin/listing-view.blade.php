
@props([
    'grid',
    'list'    
])

<div class="float-right">
    @if(isset($grid) && ($grid ==true) )
      <span  onclick="changeView('grid')" class="grid" > <i class="fa-solid fa-grip fa-2x grid"></i> </span> &nbsp;
    @elseif(isset($list) && ($list == true))
     <span onclick="changeView('list')" class="list"  >  <i class="fa-solid fa-table-list fa-2x list"></i>  </span>
    @endif
</div>