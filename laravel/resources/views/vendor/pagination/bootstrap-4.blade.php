
        @php
        $currentPage = $paginator->currentPage() ;
        $offset = 0 ;
        if( $currentPage > 1 ) {
            $offset = ($currentPage - 1)* $paginator->perPage() ;
        }

            $request_params = request()->all();
            $selected_per_page =  isset($request_params['perPage'])? $request_params['perPage'] : $paginator->perPage();
            unset( $request_params['perPage']);
    
        @endphp
    <div class="d-flex justify-content-between mx-2 row">
        <div class="col-sm-4 col-md-4">
            <div class="mb-1">
                <span class="mr-2">{{__('webCaption.record_per_page.title')}}</span> 
                <a class="btn btn-secondary btn-sm dropdown-toggle"  data-toggle="dropdown" aria-expanded="false">
                   <span id="selected"> @if($selected_per_page != '') {{$selected_per_page}} @else {{__('webCaption.record_per_page.title')}} @endif</span>
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
        <div class="col-sm-4 col-md-4">
                       
            {{__('webCaption.showing.title')}} {{ number_format($offset + 1)  }} {{__('webCaption.to.title')}} {{ number_format( $offset + $paginator->perPage() ) }}  {{__('webCaption.of.title')}}  {{ number_format( $paginator->total()) }} {{__('webCaption.entries.title')}}
           
        </div>

        

        @if ($paginator->hasPages())
        <div class="col-sm-4 col-md-4">  
            
            <nav>
                <ul class="pagination float-right">
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
        </div>
        @endif
    </div>




    

