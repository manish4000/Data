@extends('layouts/contentLayoutMaster')

@section('title', 'Company List')

@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
@endsection

@section('content')

<section id="advanced-search-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-bottom"><h4 class="card-title">{{ __('locale.Search.caption') }}</h4></div>
        <!--Search Form -->
        <div class="card-body mt-1">
          <form class="dt_adv_search" method="POST">
            <div class="row">
              <div class="col-12">
                <div class="form-row mb-1">
                  <div class="col-lg-2">
                    <!--<label>Membership Type:</label>-->
                    <input type="text" class="form-control dt-input" data-columns="1" placeholder="{{ __('locale.Membership_Type.caption') }}" data-column-index="1" />
                  </div>
                  <div class="col-lg-2">
                    <!--<label>Short Name:</label>-->
                    <input type="text" class="form-control dt-input" data-columns="4" placeholder="{{ __('locale.Short_Name.caption') }}" data-column-index="4" />
                  </div>
                  <div class="col-lg-3">
                    <!--<label>Company Name:</label>-->
                    <input type="text" class="form-control dt-input" data-columns="2" placeholder="{{ __('locale.Company_Name.caption') }}" data-column-index="2" />
                  </div>                  
                  <div class="col-lg-3">
                    <!--<label>Email:</label>-->
                    <input type="text" class="form-control dt-input" data-columns="3" placeholder="{{ __('locale.Email.caption') }}" data-column-index="3" />
                  </div>                  
                  <div class="col-lg-2">
                    <!--<label>City:</label>-->
                    <input type="text" class="form-control dt-input" data-columns="5" placeholder="{{ __('locale.City.caption') }}" data-column-index="5" />
                  </div>
                  <div class="col-lg-4 mt-1">
                    <!--<label>Business Types:</label>-->
                    <select class="form-control select2 dt-select-mul" multiple data-autofill="true" data-columns="6" data-column-index="6">
                      @if(isset($BusinessTypes) && count($BusinessTypes)>0)
                        @foreach($BusinessTypes as $dts)
                          @if($dts['is_service'] == 'No')
                            <option value="{{$dts->id}}">{{$dts->name}}</option>
                          @endif
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="col-lg-4 mt-1">
                    <!--<label>Deals In:</label>-->
                    <select class="form-control select2 dt-select-mul" multiple data-autofill="true" data-columns="7" data-column-index="7">
                      @if(isset($DealIns) && count($DealIns)>0)
                        @foreach($DealIns as $dts)
                          <option value="{{$dts->id}}">{{$dts->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="col-lg-4 mt-1">
                   <!-- <label>Languages:</label>-->
                    <select class="form-control select2 dt-select-mul" multiple data-autofill="true" data-columns="8" data-column-index="8">
                      @if(isset($Languages) && count($Languages)>0)
                        @foreach($Languages as $dts)
                          <option value="{{$dts->id}}">{{$dts->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <hr class="my-0" />
        <div class="card-datatable">
          <table class="dt-advanced-search table">
            <thead>
              <tr>
                <th>##</th>
                <th>{{ __('locale.Membership.caption') }}</th>
                <th>{{ __('locale.Company_Name.caption') }}</th>
                <th>{{ __('locale.City.caption') }}</th>
                <th>{{ __('locale.Email.caption') }}</th>
                <th>{{ __('locale.Phone.caption') }}</th>
                <th>{{ __('locale.Action.caption') }}</th>                
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>##</th>
                <th>{{ __('locale.Membership.caption') }}</th>
                <th>{{ __('locale.Company_Name.caption') }}</th>
                <th>{{ __('locale.City.caption') }}</th>
                <th>{{ __('locale.Email.caption') }}</th>
                <th>{{ __('locale.Phone.caption') }}</th>
                <th>{{ __('locale.Action.caption') }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/tables/datatables-companies-list.js')) }}"></script>
@endsection
