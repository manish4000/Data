@php $socialMedia  =   DB::table('social_medias')->select('id as value', 'name', 'icon')->where('deleted_at',NULL)->get(); @endphp

<div class="col-md-4">
    <div class="form-group">
        <x-dash.form.inputs.select onChange="onChangeSocialMedia(this.id)" data_attr="icon" tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}" for="{{isset($id) ? $id : ''}}" name="{{isset($name) ? $name : ''}}[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="[]" required="" :optionData="$socialMedia" />
    </div>
</div>

<div class="col-md-1 text-center pt-1">
    @php $image_src =  asset('assets/images/globe.png'); @endphp
    <span class="display-6"><img src="{{$image_src}}" class="img_{{isset($id) ? $id : ''}}" width="30"
        height="30" alt="social_media_icon"/></span>
</div>

<div class="col-md-6">
    <x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}"  id="" for="value" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="" required="" />
</div>

<div class="col-md-1 mt-2">
    @if(isset($_POST['name']) && !empty($_POST['name']))
        <x-dash.form.buttons.custom color="bg-danger" id="DeleteRow_{{$_POST['randval']}}" value="" onClick="delete_social('{{ $id }}')" iconClass="fa fa-xmark"/>
    @else
        <x-dash.form.buttons.custom color="bg-dark" id="add_btn_{{isset($id) ? $id : ''}}" value="" onClick="addNewInput('{{isset($id) ? $id : ''}}','{{isset($name) ? $name : ''}}')" iconClass="fa fa-add"/>
    @endif
</div>

<div id="newInput_{{isset($id) ? $id : ''}}"></div>

@push('script')
<script>
    function onChangeSocialMedia(id){
        let img_name,img_path;
        img_name = $('#'+id).find(':selected').attr('data_attr');
        if(img_name != ''){
           img_path =  "{{asset('social_media')}}/"+img_name;
        }else{
             img_path =  "{{asset('assets/images/globe.png')}}";
        }
        $('.img_'+id).attr('src', img_path);
    }

    function addNewInput(idval, nameVal){
        var allowedNumber = 10;
        if($('#newInput_'+idval+' .row').length < allowedNumber){
            let randx = Math.floor((Math.random() * 1000) + 1);
            $.ajax ({
            type: 'POST',
            url: "{{route('dashsocial-media-action')}}",
            data: {randval:randx,id:idval,name:nameVal},
            success : function(result) {
                $('#newInput_'+idval).append(result);
                $(document).ready(function() { $('#'+idval+'_'+randx).select2(); });
            }
            });
        }else{
            alert("You can not add any more");
        }
    }
    function delete_social(id){
		$('.delete_social_'+id).remove();
	}
</script>
@endpush