@extends('layouts/contentLayoutMaster')
{{-- @section('title', $pageConfigs['moduleName']) --}}

@section('title', __('webCaption.company_add.title'))

@section('content')
   <!-- users edit start -->
   <h1>test</h1>
 
@endsection

{{-- @push('script')

   <script>
      $(document).ready(function() {
         var  country  = $('.country').find(":selected").val();
         var  state  = "{{old('state_id')}}";
         var  city  = "{{old('city_id')}}";

         if(country){
            stateList(country,state);
         }

         if(state){
            $.ajax ({
               type: 'POST',
               url: "{{route('company.city-list')}}",
               data: { id : state },
               success : function(result) {
                  $('#city_id').html('<option value="">Select City</option>');
                  $.each(result.cities, function (key, value) {
                     if(value.id == city){
                        var selected_c = 'selected';
                     }else{
                        var selected_c = '';
                     }
                     $("#city_id").append('<option value="' + value
                             .id + '" '+ selected_c +'>' + value.name + '</option>');
                  });
               }
            });
         }

         $('.country').on('change', function(){
            var selectCountry  = $(this).val();
            stateList(selectCountry);
         });
         $('.state').on('change', function () {
            var selectState  = $(this).val();
            cityList(selectState);
         });
      });
      function stateList(country , selected_state = ''){
         $.ajax ({
            type: 'POST',
            url: "{{route('company.state-list')}}",
            data: { id : country },
            success : function(result) {
               $('#state_id').html('<option value="">Select State</option>');
               $.each(result.states, function (key, value) {
                  if(value.id == selected_state){
                     var selected_s = 'selected';
                  }else{
                     var selected_s = '';
                  }
                  $("#state_id").append('<option value="' + value
                          .id + '" '+ selected_s + '>' + value.name + '</option>');
               });
               $('#city_id').html('<option value="">Select City</option>');
            }
         });
      }
      function cityList(state,selected_city =''){
         $.ajax ({
            type: 'POST',
            url: "{{route('company.city-list')}}",
            data: { id : state },
            success : function(result) {
               $('#city_id').html('<option value="">Select City</option>');
               $.each(result.cities, function (key, value) {
                  if(value.id == selected_city){
                     var selected_c = 'selected';
                  }else{
                     var selected_c = '';
                  }
                  $("#city_id").append('<option value="' + value
                          .id + '" '+ selected_c +'>' + value.name + '</option>');
               });
            }
         });
      }
   </script>

@endpush --}}

