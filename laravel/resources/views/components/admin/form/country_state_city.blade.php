<script>
 
 function stateLists(country_field_id , state_filed_id ,selected_state = ''){

    let  country  = $('#'+country_field_id).find(":selected").val();

    if(country){
        $.ajax ({
            type: 'POST',
            url: "{{route('company.state-list')}}",
            data: { id : country },
            success : function(result) {

            $('#'+state_filed_id).html('<option value="">Select State</option>');
            $.each(result.states, function (key, value) {
                if(value.id == selected_state){
                    var selected_s = 'selected';
                }else{
                    var selected_s = '';
                }
                $("#"+state_filed_id).append('<option value="' + value
                        .id + '" '+ selected_s + '>' + value.name + '</option>');
            });
           
            }
        });
    }
}



function cityList(state_field_id,city_filed_id,selected_city = '',state_id =''){

    let state;
    if(state_id != ''){
             state  = state_id;
    }else{
         state  = $('#'+state_field_id).find(":selected").val();
    }

    if(state){
         $.ajax ({
            type: 'POST',
            url: "{{route('company.city-list')}}",
            data: { id : state },
            success : function(result) {
                
               $('#'+city_filed_id).html('<option value="">Select City</option>');
               $.each(result.cities, function (key, value) {
                  if(value.id == selected_city){
                     var selected_c = 'selected';
                  }else{
                     var selected_c = '';
                  }
                  $("#"+city_filed_id).append('<option value="' + value
                          .id + '" '+ selected_c +'>' + value.name + '</option>');
               });
            }
         });
      }
    }

</script> 