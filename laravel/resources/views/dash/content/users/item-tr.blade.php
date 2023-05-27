

<div class="table_row">
    <div class="make_col width_5 xs_width_50">
        <div class="div-mobile">{{__('webCaption.master_checkbox_text.title')}}</div>
      
        <x-dash.form.inputs.multiple_select_checkbox id="select{{$item->id}}"   value="{{$item->id}}"  customClass="checkbox"  />        
               
    </div>

    <div class="make_col width_5 xs_width_50">
        <div class="div-mobile">{{__('webCaption.id.title')}}</div>
        <span>{{$item->id}}</span>
    </div>

    <div class="make_col width_45 xs_width_50" >
        <div class="div-mobile">{{__('webCaption.make.title')}}</div>
        @php echo  str_ireplace( request()->input('search.keyword'), '<span class="heighlight-string" >'. request()->input('search.keyword').'</span>',$item->name) @endphp
    </div>
       
   
    

    <div class="make_col width_12 xs_width_50 text-xl-center text-lg-center text-md-center">
        <div class="div-mobile">{{__('webCaption.actions.title')}}</div>
        @if (Auth::guard('dash')->user()->can('common-users-edit'))	
        <x-dash.form.buttons.edit href="{{ route('dashusers.edit', $user->id) }}" />
        @endif
        &nbsp;

        <form method="post" style="display: inline-block" action="{{ route('dashusers.login-form-admin') }}"  id="login-form-{{$user->id}}" target="_blank">
            @csrf
            <?php $id =  \Illuminate\Support\Facades\Crypt::encrypt($item->id); ?>
            <input type="hidden" name="id" value="{{$id}}">
            <span type="submit"  onclick="submit('login-form-{{$user->id}}')"  title="{{__('webCaption.login.title')}}"  data-toggle="tooltip"  id="login"><i class="text-info fa fa-key" ></i></span> 
        </form>&nbsp;

        {{-- pass in  deleteSingleData(id , name ,url ) for delete  --}}

        @if (Auth::guard('dash')->user()->can('common-users-delete'))	
        <x-dash.form.buttons.delete id="{{$user->id}}" name="{{$user->name}}" url="{{route('dashusers.delete')}}" action="{{route('users.delete', $user->id) }}" />  
        @endif
    </div>           
</div>    


@push('script')
<script>
    function submit(id) {
        var form = document.getElementById(id);
        form.submit();
    }
</script>
@endpush