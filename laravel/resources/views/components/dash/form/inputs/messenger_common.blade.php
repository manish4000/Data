@php 
$messenger  =   DB::table('messenger')->select('id as value', 'name', 'logo')->where('deleted_at',NULL)->get(); 
@endphp

    <x-dash.form.inputs.multiple_select onChange="messengerSelect(this.id)" optionImg="{{asset('master/company/messenger/')}}" label="{{__('webCaption.messenger.title')}}" customClass="messenger" for="{{ isset($id) ? $id : '' }}" name="{{ isset($name) ? $name : '' }}[]" placeholder="{{__('webCaption.messenger.title')}}" :oldValues="[]" :editSelected="[]"  required="" :optionData="$messenger" />
    
@push('script')
<script type="text/javascript">

function messengerImageCode(){
    $(".messenger").select2({
        closeOnSelect: false,
        templateResult: formatState,
    });
}
        
function formatState (state) {
    if (!state.id) { return state.text; }
        var $state = $(
        '<span><img sytle="display:inline-block;" src='+state.title+' width="20" height="20" /> ' + state.text + '</span>'
    );
    return $state;
}

function messengerSelect(id){
  //var getId = $('#'+id).next('span#select2').find('ul').attr('id');
  //select2-personal_messenger
  $('#select2-'+id+'-container').hide();
    $('.select2-search--inline').hide();
    $('.counter_'+id).remove();
    var counter = 0;
    counter = $('#select2-'+id+'-container li').length;
    $('#select2-'+id+'-container').before('<div style="line-height: 24px; padding: 3px;" class="counter_'+id+'">'+counter+' selected</div>');
}

</script>
@endpush