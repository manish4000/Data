@extends('layouts/contentLayoutMaster')
@section('title', $pageConfigs['moduleName'])
@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css'))}}">
@endsection
@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
@endsection
@section('content')

<section>
  <div class="row">
    <div class="col-12">           
              <form method="post" action="{{route('company.plansPermission.store')}}">
                    @csrf
                <div class="row">
                  @if(count($companyPlans) > 0)
                    @foreach($companyPlans as $plan)
                        <div class="col-3">
                            <div class="card p-2">
                              <h5 class="card-title text-center">{{$plan->title}}</h5> 
                                <input type="hidden" name="plan_id[]" value="{{$plan->id}}">
                                @if ($companyPermissions)
                                <div class="jstree-basic">
                                    <ul>    
                                        @php 
                                        $checkedPermission =  App\Models\Company\CompanyPlanPermissionModel::where('company_plan_id',$plan->id)->first();  
                                        @endphp
                                        @foreach ( $companyPermissions as $permission )
                                          @if(count($permission->menuChild) > 0)
                                            <li class="jstree-open">

                                                {{-- <label class="form-check-label">
                                                    <input class="form-check-input" value="{{ $permission->id }}" type="checkbox" name="permissions[{{$plan->id}}][]" @php echo (isset($checkedPermission) && in_array($permission->id,$checkedPermission->permissions))?'checked':'';  @endphp > {{ $permission->title }}
                                                </label> --}}

                                                <x-admin.form.inputs.checkbox  for="{{$permission->id}}{{$plan->id}}main" name="permissions[{{$plan->id}}][]" label="{{ $permission->title }}" checked="{{( isset($checkedPermission) && in_array($permission->id,$checkedPermission->permissions) )?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />


                                                @if($checkedPermission) 
                                                @include('content.admin.company.planPermission.childList',['items' => $permission->menuChild, 'user' => '','plan_id' => $plan->id ,'checked_permission' => $checkedPermission->permissions ])
                                                @else
                                                @include('content.admin.company.planPermission.childList',['items' => $permission->menuChild, 'user' => '','plan_id' => $plan->id  ])
                                                @endif

                                            </li>
                                          @else
                                            <li>
                                                {{-- <label class="form-check-label">
                                                    <input class="form-check-input" value="{{ $permission->id }}" type="checkbox" name="permissions[{{$plan->id}}][]" @php echo (isset($checkedPermission) && in_array($permission->id,$checkedPermission->permissions))?'checked':'';  @endphp > {{ $permission->title }}
                                                </label> --}}

                                                <x-admin.form.inputs.checkbox  for="{{$permission->id}}{{$plan->id}}main" name="permissions[{{$plan->id}}][]" label="{{ $permission->title }}" checked="{{( isset($checkedPermission) && in_array($permission->id,$checkedPermission->permissions) )?'checked' :''; }}"  value="{{ $permission->id }}"  customClass="form-check-input"  />
                                            </li>
                                          @endif
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                  @else
                        <div class="card">
                          <div class="text-center my-2">
                              <h3>{{__('webCaption.record_not_found.title')}} </h3>
                          </div>
                        </div>
                  @endif
                </div>
                @can('main-navigation-company-plan-permission-edit')
                <div class="text-center">
                  <x-admin.form.buttons.update /> 

                </div>
                @endcan
              </form> 
    </div>
  </div>       
<!-- list section end -->
</section>



@endsection


@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@push('script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>

  <script type="text/javascript">
  	$(document).ready(function() {
        $(".jstree-basic ul li a, .jstree-basic ul li ul li a").each(function() {
            var attributes = $.map(this.attributes, function(item) {
            return item.name;
            });
        
            var img = $(this);
            $.each(attributes, function(i, item) {
              img.removeAttr(item);
            });
       });
  	})
  </script>
@endpush
 

