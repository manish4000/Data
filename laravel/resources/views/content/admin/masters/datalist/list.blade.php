<div class="card-datatable table-responsive pt-0">
    <table class="data-list-table table">
        <thead class="thead-light"><tr>
        @isset($pageConfigs['dataListCols'])
            @foreach($pageConfigs['dataListCols'] as $key=>$val)
            <th class="{{$val['class']}}">
                @if(!empty($val['caption'])) {{ __('locale.'.str_replace(' ', '_', $val['caption']).'.caption') }} @endif
            </th>    
            @endforeach   
        @endisset
        </tr></thead>
    </table>
</div>