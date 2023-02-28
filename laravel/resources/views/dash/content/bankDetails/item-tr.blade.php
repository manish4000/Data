

<tr>
    <td>
     <x-dash.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />            
    </td>
    <td>
    {{$item->id}}          
    </td>
    <td >
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->bank_name) @endphp
    </td>
    <td >{{$item->dealer_name}}    </td>
    <td >{{$item->branch_name}}    </td>
    <td >{{$item->account_name}}    </td>
    <td >{{$item->account_number}}    </td>
    <td > @if($item->jumvea_account == 1) Yes @else No  @endif  </td>
    <td >{{$item->swift_code}}    </td>
    <td>

        <x-dash.form.inputs.listing_checkbox id="list{{$item->id}}"  onclick="changeDisplayStatus('{{$item->id}}','{{route('bank-details.status')}}')"  dataItemId="{{$item->id}}" dataUrl="{{route('bank-details.status')}}" 
            value="{{$item->id}}" checked="{{($item->status == 1)? 'checked' :''}}"  /> 
    </td>
<td>
  
    <x-dash.form.buttons.edit href="{{ route('bank-details.edit', $item->id) }}" />

   &nbsp;

  {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}


   <x-dash.form.buttons.delete id="{{$item->id}}" name="{{$item->bank_name}}" url="{{route('bank-details.delete')}}" action="{{route('bank-details.delete',$item->id)}}" /> 

</td>
</tr>