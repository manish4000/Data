
        @php

        $multiple_delete_url = (isset($multiple_delete_url)) ? $multiple_delete_url :'' ;

        $currentPage = $paginator->currentPage() ;
        $offset = 0 ;
        if( $currentPage > 1 ) {
            $offset = ($currentPage - 1)* $paginator->perPage() ;
        }

            $request_params = request()->all();

    
            $selected_per_page =  isset($request_params['perPage'])? $request_params['perPage'] : $paginator->perPage();
            unset( $request_params['perPage']);
    
        @endphp
    <div class="d-flex  row">

    <div class="col-xl-2 col-lg-2 col-md-3 ol-sm-3 col-5 pb-2 text-center text-md-left text-xl-left text-lg-left">

    <div class="dropdown">
        <button class="btn btn-gray-action dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">{{__('webCaption.actions.title')}}</button>
        <ul class="dropdown-menu">
           <li><a class="dropdown-item" href="#">Add Multiple </a></li>
            <li><a class="dropdown-item" onclick="deleteMultiple('{{$multiple_delete_url}}')">{{__('webCaption.delete_multiple.title')}} </a></li>
        </ul>
    </div>
    
    </div>


       
        
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-7  pt-50 pb-2">{{__('webCaption.total_records.title')}}: {{ number_format( $paginator->total()) }}</div>      

    
        <div class="col-xl-6 col-lg-4 col-md-6 col-sm-5  text-center pl-0 pr-0 pl-xl-1 pl-lg-1 pl-md-1 pr-xl-1 pr-lg-1 pr-md-1">  
            @if ($paginator->hasPages())
            <nav>
                <ul class="pagination float-right float-none d-inline-flex">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
            @endif
        </div>
        <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 text-center pt-25 mt-xl-0 mt-lg-0">
            <div class="mb-1">
                <span class="mr-0">{{__('webCaption.per_page.title')}}</span> 
                <a class="btn border btn-sm dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                   <span id="selected"> @if($selected_per_page != '') {{$selected_per_page}} @else {{__('webCaption.per_page.title')}} @endif</span>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item @php echo ($selected_per_page == 20 )? 'active' :''; @endphp" href="{{url()->current().'?'.http_build_query( array_merge($request_params, ['perPage'=>'20'] ) ) }}">20</a> 
                    <a class="dropdown-item @php  echo ($selected_per_page ==50 )? 'active'   :''; @endphp" href="{{url()->current().'?'.http_build_query( array_merge($request_params, ['perPage'=>'50'] ) ) }}">50</a> 
                    <a class="dropdown-item  @php  echo ($selected_per_page ==100 )? 'active' :''; @endphp" href="{{url()->current().'?'.http_build_query( array_merge($request_params, ['perPage'=>'100'] ) ) }}">100</a> 
                    <a class="dropdown-item  @php  echo ($selected_per_page ==500 )? 'active' :''; @endphp" href="{{url()->current().'?'.http_build_query( array_merge($request_params, ['perPage'=>'500'] ) ) }}">500</a> 
                    <a class="dropdown-item  @php  echo ($selected_per_page ==1000 )? 'active' :''; @endphp" href="{{url()->current().'?'.http_build_query( array_merge($request_params, ['perPage'=>'1000'] ) ) }}">1000</a> 
                </div>

            </div>
        </div>




       
    </div>


    <style>

.btn-gray-action { background:#f3f2f7;}
.dropdown-toggle::after {background-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23807e8c'><path fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/></svg>") !important;}

    </style>