@extends('layouts/contentLayoutMaster')

 {{-- @section('content_header')
  
@stop  --}}
@section('title', $pageConfigs['moduleName'])
@section('content')
<div>
	{{-- <div class="row mb-2">
		<div class="col-md-12 m-auto">
			
		</div>
	</div> --}}
	<div class="row">
		<div class="col-md-12 ">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" title="{{__('webCaption.search_filter.caption')}}"  data-toggle="tooltip" > {{__('webCaption.search_filter.title')}} </h4>                    
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('site-languages.index')}}">
						<div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
							<div class="col-md-3">
								<div class="form-group">
									<x-admin.form.inputs.text id="searchKeyword" for="{{__('webCaption.keyword.title')}}" label="{{__('webCaption.keyword.title')}}" tooltip="{{__('webCaption.keyword.caption')}}"  class="form-control" name="search[keyword]"  placeholder="{{__('webCaption.keyword.title')}}" value="{{ request()->input('search.keyword') }}"  required="" />
								</div>
							</div>
							<div class="col-md-3">
								<x-admin.form.buttons.search />
								<x-admin.form.buttons.reset href="{{route('site-languages.index')}}" />
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card card-default">
				<div class="card-header">
				</div>
				<div class="card-body">
				  @if(count($languages) > 0)	
					<div class="table-responsive">
						<div class="mt-2">
							{{ $languages->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
						</div>
							@can('main-navigation-masters-languages-delete')
									<div class="px-2 my-2">
										{{-- deleteMultiple() for delete multiple data pass url here  --}}
										<x-admin.form.buttons.multipleDelete url="{{route('site-languages.delete-multiple')}}" />
									</div>
							@endcan
							<table class="table">
							<thead>
								<tr>
								<th> <x-admin.form.inputs.multiple_select_checkbox id="checkAll"   value="1"  customClass=""  /> </th>	
								<th scope="col" class="position-for-filter-heading" >#
									<x-admin.filter.order-by-filter-div orderBy="id" />
								</th>
								<th scope="col" class="position-for-filter-heading"  data-toggle="tooltip" title="{{__('webCaption.title_english.caption')}}" >
									{{__('webCaption.title_english.title')}}
									<x-admin.filter.order-by-filter-div orderBy="language_en" />
								</th>
								<th scope="col" data-toggle="tooltip" title="{{__('webCaption.title.caption')}}">{{__('webCaption.title.title')}}</th>
								<th scope="col" data-toggle="tooltip" title="{{__('webCaption.status.caption')}}">{{__('webCaption.status.title')}}</th>
								<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.alias.caption')}}">{{__('webCaption.alias.title')}}
									<x-admin.filter.order-by-filter-div orderBy="alias" />
								</th>
								<th scope="col"  class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.show_in_caption.caption')}}">{{__('webCaption.show_in_caption.title')}}
									<x-admin.filter.order-by-filter-div orderBy="show_in_captions" />
								</th>
								<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.show_in_master.caption')}}">
									{{__('webCaption.show_in_master.title')}}
									<x-admin.filter.order-by-filter-div orderBy="show_in_masters" />
								</th>
								<th scope="col" class="position-for-filter-heading" data-toggle="tooltip" title="{{__('webCaption.default.caption')}}">
									{{__('webCaption.default.title')}}
									<x-admin.filter.order-by-filter-div orderBy="default_lang" />
								</th>
								<th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">{{__('webCaption.actions.title')}}</th>
								</tr>
							</thead>
							<tbody>
							
									@foreach ($languages as $language)
										<tr>
										<td>
										<x-dash.form.inputs.multiple_select_checkbox id="select{{$language->id}}"   value="{{$language->id}}"    customClass="checkbox"  />            
										</td>
										<th scope="row">{{$language->id}}</th>
										<td>{{ $language->language_en; }}</td>
										<td>{{ $language->language_text; }}</td>
										<td>{{ $language->status; }}</td>
										<td>{{ $language->alias; }}</td>
										<td>@if($language->show_in_captions == 1) Yes @else No @endif</td>
										<td>@if($language->show_in_masters == 1) Yes @else No @endif </td>
										<td>@if($language->default_lang == 1) Yes @else No @endif </td>
										<td>
											
											@can('main-navigation-masters-languages-edit')
											<x-admin.form.buttons.edit href="{{ route('site-languages.edit', $language->id) }}" />&ensp;
											@endcan
											&nbsp;
											@can('main-navigation-masters-languages-delete')
											<x-admin.form.buttons.delete id="{{$language->id}}" name="{{$language->language_en}}" url="{{route('site-languages.destroy')}}" action="{{route('site-languages.destroy', $language->id) }}" /> 
{{-- 
											<span type="submit" onclick="deleteSingleData('{{$language->id}}','{{$language->language_en}}' ,'{{route('site-languages.destroy')}}')"><i class="fa fa-archive" title="{{__('webCaption.delete.title')}}"  data-toggle="tooltip"></i></span> --}}
											@endcan
										</td>
										</tr>
					
									@endforeach
						
							</tbody>
							</table>
						<div class="mt-2">
							{{ $languages->onEachSide(2)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}       
						</div>	
					</div>
				  @else
				  <div class="text-center my-2">
					<h3>{{__('webCaption.record_not_found.title')}} </h3>
				  </div>	
				  @endif	
				</div>
			</div>
		</div>
	</div>
</div>

{{-- this file include for delete alert box  --}}
@include('components.admin.alerts.delete-alert-box')
@include('components.admin.alerts.multiple-delete-alert-box')
<!-- users list ends -->
{{-- this file include for short data asc and desc   --}}
@include('components.admin.filter.order-by')
@endsection
