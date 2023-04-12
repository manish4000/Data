

<tr>
    <td>
     <x-dash.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
    </td>
    <td>
    {{$item->id}}          
    </td>
    <td >
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->title) @endphp
    </td>
    <td >{{$item->person_name}}    </td>
    <td >{{$item->email}}    </td>
    <td >{{$item->country->name}}    </td>
    <td >{{$item->posted_date}}    </td>
    <td>
        @if (Auth::guard('dash')->user()->can('common-bank-details-edit'))	
        <x-dash.form.buttons.edit href="{{ route('dashtestimonial.edit', $item->id) }}" />
        @endif    
    &nbsp;

    {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

    @if (Auth::guard('dash')->user()->can('common-testimonial-delete'))	
        <x-dash.form.buttons.delete id="{{$item->id}}" name="{{$item->bank_name}}" url="{{route('dashtestimonial.delete')}}" action="{{route('dashtestimonial.delete',$item->id)}}" /> 
    @endif    
    </td>
</tr>