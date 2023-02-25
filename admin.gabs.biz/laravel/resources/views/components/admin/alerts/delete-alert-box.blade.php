
  <script>
    function deleteSingleData(id, name ='',url) {

      Swal.fire({
              title: "{{__('webCaption.alert_are_you_sure.title')}}",
              text: "{{__('webCaption.alert_confirm_delete_text.title')}} " + name ,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: "{{__('webCaption.alert_confirm_yes_to_delete.title')}}"
            }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                    type: "POST",
                    url: url,
                    data: {id:id ,"_token": "{{ csrf_token() }}"},
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

  </script>