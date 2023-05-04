
<div class="gabs_table-row parent-id-{{$item->parent_id}} {{$display}}">

    <div class="gabs_table-row-column gabs_table-row-index">
        <x-admin.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
    </div>

    <div class="gabs_table-row-column gabs_table-center" @if($childTdColor != '') class="{{$childTdColor}} " @endif >
        <span style=" margin-left: {{$marginLeft}}">{{$item->id}}</span>
    </div>

</div>    