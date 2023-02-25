@props([
    'for',
    'caption',
    'name',
    'placeholder',
    'value'
])

<div class="media">
    @php $logo_file = asset('images/portrait/small/avatar-s-11.jpg'); @endphp
    @if(isset($data->logo_file) && !empty($data->logo_file))
        @php $logo_file = 'https://www.japanesecartrade.com/logo/'.$data->logo_file;  @endphp
    @endif
    <a href="javascript:void(0);" class="mr-25">
        <img src="{{$logo_file}}" id="{{ $for }}" class="rounded mr-50" alt="logo image" height="80" width="80" />
    </a>
    <div class="media-body mt-75 ml-1">
        <label for="" class="btn btn-sm btn-primary mb-75 mr-75">{{ $caption }}</label>
        <input type="file" name="{{ $name }}" id="" hidden accept="image/*" />
        <p>Allowed JPEG, JPG, PNG, GIF or BMP. Max size of 5MiB</p>
    </div>
</div>