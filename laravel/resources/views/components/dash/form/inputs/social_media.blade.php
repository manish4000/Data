@php $socialMedia  =   DB::connection('dash')->table('social_medias')->select('id as value', 'name', 'icon')->where('deleted_at',NULL)->get(); @endphp

<div class="col-md-4">
    <div class="form-group">
        <x-dash.form.inputs.select onChange="onChangeSocialMedia(this.id)" data_attr="icon" tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}" for="{{isset($id) ? $id : ''}}" name="{{isset($name) ? $name : ''}}[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{ isset($social_media[0]->id) ? $social_media[0]->id : ''}}" required="" :optionData="$socialMedia" />
    </div>
</div>

<div class="col-md-1 text-center pt-1">
    @php  
        if(isset($social_media[0]->id) && !empty($social_media[0]->id))
        $social_image  =   DB::connection('dash')->table('social_medias')->where('id',$social_media[0]->id)
                                ->where('deleted_at',NULL)->get()->value('icon');
        if(!empty($social_image)) $image_src = asset('social_media')."/".$social_image;
        else $image_src =  asset('assets/images/globe.png');   
    @endphp
    <span class="display-6"><img src="{{$image_src}}" class="img_{{isset($id) ? $id : ''}}" width="30"
        height="30" alt="social_media_icon"/></span>
</div>

<div class="col-md-6">
    <x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}" for="value" name="social_value[]" placeholder="{{ __('locale.value.caption') }}" value="{{isset($social_media[0]->value) ? $social_media[0]->value : ''}}" required="" />
</div>

<div class="col-md-1 mt-2">
    @if(isset($_POST['name']) && !empty($_POST['name']))
        <x-dash.form.buttons.custom color="bg-danger" id="DeleteRow_{{$_POST['randval']}}" value="" onClick="delete_social('{{ $id }}')" iconClass="fa fa-xmark"/>
    @else
        <x-dash.form.buttons.custom color="bg-dark" id="add_btn_{{isset($id) ? $id : ''}}" value="" onClick="addNewInput('{{isset($id) ? $id : ''}}','{{isset($name) ? $name : ''}}')" iconClass="fa fa-add"/>
    @endif
</div>

@if(isset($social_media) && is_array($social_media) && count($social_media)>0)
@php $i = 0; @endphp
@foreach($social_media as $key=>$value)
@if($i>0)
<div>
<div class="row delete_social_{{$key}}">
    <div class="col-md-4">
        <div class="form-group">
            <x-dash.form.inputs.select onChange="onChangeSocialMedia(this.id)" data_attr="icon" tooltip="{{__('webCaption.social_media.caption')}}" label="{{__('webCaption.social_media.title')}}" for="{{isset($id) ? $id : ''}}_{{$key}}" name="{{isset($name) ? $name : ''}}[]" placeholder="{{ __('locale.social_media.caption') }}" editSelected="{{ isset($value->id) ? $value->id : ''}}" required="" :optionData="$socialMedia" />
        </div>
    </div>

    <div class="col-md-1 text-center pt-1">
        @php 
            if(isset($value->id) && !empty($value->id))
            $socialMediaImage = DB::connection('dash')->table('social_medias')->where('id',$value->id)
                                    ->where('deleted_at',NULL)->get()->value('icon');
            if(!empty($socialMediaImage)) $image_src = asset('social_media')."/".$socialMediaImage;
            else $image_src =  asset('assets/images/globe.png'); 
            
            @endphp
        <span class="display-6"><img src="{{$image_src}}" class="img_{{isset($id) ? $id : ''}}_{{$key}}" width="30"
            height="30" alt="social_media_icon"/></span>
    </div>

    <div class="col-md-6">
        <x-dash.form.inputs.text maxlength="100" tooltip="{{__('webCaption.value.caption')}}" label="{{__('webCaption.value.title')}}" for="value" name="social_value[]" placeholder="{{ __('webCaption.value.title') }}" value="{{isset($value->value) ? $value->value : ''}}" required="" />
    </div>
    <div class="col-md-1 mt-2">
        <x-dash.form.buttons.custom color="bg-danger" id="DeleteRow_{{$key}}" value="" onClick="delete_social('{{$key}}')" iconClass="fa fa-xmark"/>
    </div>
</div>
</div>
@endif
@php $i++; @endphp
@endforeach
@endif

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