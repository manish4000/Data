@props([
    'headingFields'
])


<div class="table_header " id="master-list" >

    
    <div class="header_col position-for-filter-heading common_heading">    
        <x-dash.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  />
    </div>
    
    @if(isset($headingFields) && is_array($headingFields))
            @foreach($headingFields as $fields)           
            @php
                $active_class = (isset(request()->order_by) && (request()->order_by == $fields['orderby'] ) )? 'active' :'';                
                $hover_class =  ($fields['orderby'] !== null) ? "header_col" : "" ;

                 $extra_classes = (  isset($fields['classes']) && ( $fields['classes'] !== null)) ? $fields['classes'] : "" ;
            @endphp                
                <div class=" {{$hover_class}} position-for-filter-heading {{$active_class}} heading_col {{$extra_classes}}" data-toggle="tooltip"
                 title="<?php echo __('webCaption.'.$fields['title'].'.caption') ?>">
                    <?php echo __('webCaption.'.$fields['title'].'.title') ?>
                    
                    @if($fields['orderby'] !== null)    
                        <x-dash.filter.order-by-filter-div orderBy="{{$fields['orderby']}}" />
                    @endif
                </div>
            @endforeach

        @endif

</div>


<style>
/* 
    .gabs_table {width:100%;height:auto;display:flex;flex-direction: column; }
    .gabs_table-row {width:100%;height:4vw;display:flex;border-bottom:1px solid #f2f2f2;}
    .gabs_table-header {font-weight:bold;background: #f2f2f2;}
    .gabs_table-row div:first-child {width:10% !important;}
    .gabs_table-row div:nth-child(2) {width:9% !important; justify-content:center;}
     .gabs_table-row div:nth-child(3) { width:40% !important;}
    .gabs_table-row div:nth-child(4) {width:20% !important;}
    .gabs_table-row-column {width:30%;height:100%;display:flex;align-items:center;justify-content:center;word-break: break-word;}
    .custom-control-inline { margin-right:.5rem !important;}
    .gabs_table-center { text-align:center;}
    
    @media only screen and ( min-width:1024px ) and ( max-width:1050px ) {
        .gabs_table-row { height:8vw;}
    }
    
    @media only screen and ( min-width:767px ) and ( max-width:1023px ) {
        .gabs_table-row { height:auto; display:block; width:auto;}
        .gabs_table-row-column { float:left; width:20%;}
       
    }
    
    
    @media only screen and ( min-width:320px ) and ( max-width:767px ) {
    .gabs_table-header { display:none;}
    .gabs_table-row { height:auto; display:block; width:auto;}
    .gabs_table-row-column { float: left;}
    .gabs_table-row div:first-child {width:13% !important; justify-content: start; padding-bottom:10px;padding-top: 10px;}
    .gabs_table-row div:nth-child(2) {width:15% !important;justify-content: start; padding-bottom:10px;padding-top: 10px;}
    .gabs_table-row div:nth-child(3) {justify-content:start;width: 61% !important; padding-bottom:10px;padding-top: 10px;}
    
    .gabs_table-row div:nth-child(4) {width:33% !important; justify-content: start; padding-bottom:10px;}
    
    
    }
     */
       </style>