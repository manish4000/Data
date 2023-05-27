@php 
$messenger  =   DB::connection('dash')->table('messenger')->select('id as value', 'name', 'logo')->where('deleted_at',NULL)->get();
$makeArr = array(); 
if(isset($editSelected) && is_array($editSelected) && count($editSelected)>0){
    foreach ($editSelected as $key => $value) {
        $makeArr[] = $value->id;
    }
}
else $makeArr[] = "";
@endphp

<x-dash.form.inputs.multiple_select onChange="messengerSelect(this.id)" optionImg="{{asset('master/company/messenger/')}}" label="{{__('webCaption.messenger.title')}}" customClass="messenger" for="{{ isset($id) ? $id : '' }}" name="{{ isset($name) ? $name : '' }}[]" placeholder="{{__('webCaption.messenger.title')}}" :oldValues="[]" :editSelected="$makeArr"  required="" :optionData="$messenger" />
    
@push('script')
<script type="text/javascript">


function messengerImageCode(){
    $(".messenger").select2({
        placeholder: 'Select',
        closeOnSelect: false,
        templateResult: optionImage,
        templateSelection: imageshow,
    });
    $('.select2-search--inline').hide();
}
function imageshow (image) {
    if (!image.id) { return image.text; }
        var $image = $(
        '<span><img sytle="display:inline-block;" src='+image.title+' width="15" height="15" /></span>'
    );
    return $image;
}
function optionImage (img) {
    if (!img.id) { return img.text; }
        var $img = $(
        '<span><img sytle="display:inline-block;" src='+img.title+' width="20" height="20" /> ' + img.text + '</span>'
    );
    return $img;
}

/* function messengerSelect(id){
  //var getId = $('#'+id).next('span#select2').find('ul').attr('id');
  //select2-personal_messenger
  $('#select2-'+id+'-container').hide();
    $('.select2-search--inline').hide();
    $('.counter_'+id).remove();
    //var counter = '';
    var counter = $('#'+id+' option:selected').attr('title');
    console.log(counter);
    imgpath = "<img src='"+counter+"' width='25' />"
    $('#select2-'+id+'-container').before('<div style="line-height: 24px; padding: 3px;" class="counter_'+id+'">'+imgpath+'</div>');
    //$('#'+id+' option:selected').attr('title','');
    //counter = "<img src='"+iomgpath+"' width="25" />";
    //counter = $('#select2-'+id+'-container li').length;
    //$('#select2-'+id+'-container').before('<div style="line-height: 24px; padding: 3px;" class="counter_'+id+'">'+counter+' selected</div>');
} */

</script>
@endpush