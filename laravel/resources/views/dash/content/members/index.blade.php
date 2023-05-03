@extends('dash/layouts/LayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('content')
<div>
    <div class="row">
        <div class="col-md-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" title="{{__('webCaption.search_filter.caption')}}" data-toggle="tooltip">
                        {{__('webCaption.search_filter.title')}} </h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{route('dashmembers.index')}}">
                        <div class="d-flex justify-content-between align-items-center  row pt-0 pb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.text id="searchKeyword"
                                        label="{{__('webCaption.keyword.title')}}"
                                        tooltip="{{__('webCaption.keyword.caption')}}"
                                        for="{{__('webCaption.keyword.title')}}" class="form-control"
                                        name="search[keyword]" placeholder="{{__('webCaption.keyword.title')}}"
                                        value="{{ request()->input('search.keyword') }}" required="" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-dash.form.inputs.select label="{{__('webCaption.status.title')}}"
                                        tooltip="{{__('webCaption.status.caption')}}"
                                        for="{{__('webCaption.status.title')}}" name="search[status]"
                                        placeholder="{{ __('locale.status.caption') }}"
                                        editSelected="{{ request()->input('search.status')}}" required=""
                                        :optionData="$status" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-dash.form.buttons.search />
                                <x-dash.form.buttons.reset href="{{route('dashmembers.index')}}" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-body">
                    @if(count($members) > 0)
                    <div class="table-responsive">
                        <div class="mt-2">
                            {{ $members->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                        </div>
                        @if (Auth::guard('dash')->user()->can('members-delete'))
                        <div class="px-2 my-2">
                            {{-- deleteMultiple() for delete multiple data pass url here  --}}
                            <x-dash.form.buttons.multipleDelete url="{{route('dashmembers.delete-multiple')}}" />
                        </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <x-dash.form.inputs.multiple_select_checkbox id="checkAll" value="1"
                                            customClass="" />
                                    </th>
                                    <th scope="col" class="position-for-filter-heading">#
                                        <x-dash.filter.order-by-filter-div orderBy="id" />
                                    </th>
                                    <th class="position-for-filter-heading" scope="col" data-toggle="tooltip"
                                        title="{{__('webCaption.name.caption')}}">
                                        {{__('webCaption.name.title')}}
                                        <x-dash.filter.order-by-filter-div orderBy="name" />
                                    </th>
                                    <th scope="col" class="position-for-filter-heading" data-toggle="tooltip"
                                        title="{{__('webCaption.email.caption')}}">
                                        {{__('webCaption.email.title')}}
                                        <x-dash.filter.order-by-filter-div orderBy="email_1" />
                                    </th>
                                    <th scope="col" class="position-for-filter-heading" data-toggle="tooltip"
                                        title="{{__('webCaption.status.caption')}}">
                                        {{__('webCaption.status.title')}}
                                        <x-dash.filter.order-by-filter-div orderBy="status" />
                                    </th>
                                    <th scope="col" data-toggle="tooltip" title="{{__('webCaption.actions.caption')}}">
                                        {{__('webCaption.actions.title')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($members as $member)
                                <tr>
                                    <td>
                                        <x-dash.form.inputs.multiple_select_checkbox id="select{{$member->id}}"
                                            value="{{$member->id}}" customClass="checkbox" />
                                    </td>
                                    <th scope="row">{{$member->id}} </th>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email_1 }}</td>
                                    {{-- <td>{{ $member->status }}</td> --}}
                                    <td>
                                        <x-dash.form.inputs.listing_checkbox id="list{{$member->id}}"  onclick="changeDisplayStatus('{{$member->id}}','{{route('dashmembers.update-status')}}')"  dataItemId="{{$member->id}}" dataUrl="{{route('dashmembers.update-status')}}" 
                                            value="{{$member->id}}" checked="{{($member->status == 'Active')? 'checked' :''}}"  /> 
                                    </td>
                                    <td>
                                        <x-dash.form.buttons.edit href="{{ route('dashmembers.edit', $member->id) }}" />
                                        &nbsp
                                        <x-dash.form.buttons.delete id="{{$member->id}}" name="{{$member->name}}"
                                            url="{{route('dashmembers.delete')}}"
                                            action="{{route('dashmembers.delete', $member->id) }}" />
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $members->onEachSide(1)->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
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
@include('components.dash.alerts.delete-alert-box')
@include('components.dash.alerts.multiple-delete-alert-box')
@include('components.dash.filter.order-by')
@endsection