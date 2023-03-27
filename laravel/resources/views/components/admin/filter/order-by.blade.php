@php
    $request_params = request()->all();
    $filter_order = (!isset($request_params['order']))? "desc" : (( isset($request_params['order']) &&  $request_params['order'] == "asc" )? "desc" :"asc") ;
    unset( $request_params['order'], $request_params['order_by'] );
    $url = url()->current().'?'.http_build_query($request_params) ;
  
@endphp

@push('script')
<script>
    $('.short-by-filter').click(function(e){
        e.preventDefault();        
        let eObject = this;
        let orderBy = $(this).attr('data-orderBy');
        let url = "{{$url}}&"+"order_by="+orderBy+"&order="+"{{$filter_order}}"; 
        window.location.href=url; 
    });
</script>
@endpush

