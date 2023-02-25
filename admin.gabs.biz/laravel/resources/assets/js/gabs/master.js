

    function changeDisplayStatus(id,url){

        $.ajax({    
            type: "POST",
            url: url,
            data: {id:id},
            success: function(data) {
                    if(data.result.status == true){
                        successToast(data.result.message);
                    }else{
                        errorToast(data.result.message);
                    }
                }
        });
    }





    


