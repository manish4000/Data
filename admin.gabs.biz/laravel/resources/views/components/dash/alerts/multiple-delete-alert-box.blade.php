
<script>
 
        //this for delete multiple
function deleteMultiple(url){
    
          var delete_ids_ary = [];
          $(".checkbox:checked").each(function(){
              var listid = $(this).val();
              delete_ids_ary.push(listid);
          });

          if(delete_ids_ary.length == 0){
            questionToast("{{__('webCaption.alert_select_atleast_one.title')}}");
          }else{
              Swal.fire({
                title: "{{__('webCaption.alert_are_you_sure.title')}}",
                text: "{{__('webCaption.alert_confirm_multiple_delete_text.title')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{__('webCaption.alert_confirm_yes_to_delete.title')}}"
              }).then((result) => {
                  if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {delete_ids: delete_ids_ary,"_token": "{{ csrf_token() }}"},
                        success: function(data) {       
                          if(data.result.status == true ){      
                              successToast(data.result.message);
                              location.reload(true);                   
                          }else if(data.result.status == false){
                              errorToast(data.result.message);
                          }
                        }
                    });
                  }
              });

          }
}

  </script>