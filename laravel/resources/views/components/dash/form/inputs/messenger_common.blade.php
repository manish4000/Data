@php 
$messenger  =   DB::table('messenger')->select('id as value', 'name', 'logo')->where('deleted_at',NULL)->get(); 
@endphp

    <x-dash.form.inputs.multiple_select onChange="messengerSelect(this.id)" optionImg="{{asset('master/company/messenger/')}}" label="{{__('webCaption.messenger.title')}}" customClass="messenger" for="{{ isset($id) ? $id : '' }}" name="{{ isset($name) ? $name : '' }}[]" placeholder="{{__('webCaption.messenger.title')}}" :oldValues="[]" :editSelected="[]"  required="" :optionData="$messenger" />
    
@push('script')
<script type="text/javascript">

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


/* $('.messenger').on('select2:close', function() {
  let select = $(this)
  $(this).next('span.select2').find('ul').html(function() {
    let count = select.select2('data').length;
    
    return "<li>" + count + " options selected</li>"
  })
}) 
$('.messenger').select2().on("change", function(e) {
    var theID = $('.messenger').attr('id');
    //console.log(theID);
    $('#'+theID).select2().on("change", function(e) {
        var getId = $(this).next('span.select2').find('ul').attr('id');
        testingcheck(getId);
    });
});*/


 /*  function testingcheck(get_id){
    $('#'+get_id).hide();
    $('.select2-search--inline').hide();
    $('.counter').remove();
    var counter = 0;
    counter = $('#'+get_id+' li').length;
    $('#'+get_id).before('<div style="line-height: 24px; padding: 3px;" class="counter">'+counter+' selected</div>');
  } */
</script>
@endpush