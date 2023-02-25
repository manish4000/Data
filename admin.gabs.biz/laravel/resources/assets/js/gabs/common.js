// this is for success toast 


function successToast(message){
    Swal.fire({
            position: 'top-right',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: 3000
            }) ; 
}

function errorToast(message){
    Swal.fire({
            position: 'top-right',
            icon: 'error',
            title: message,
            showConfirmButton: false,
            timer: 3000
            }) ; 
}
  

function questionToast(message){
    Swal.fire(
        '',
        message,
        'info'
      );
}

//this is for select all check box 
$("#checkAll").change(function(){

    var checked = $(this).is(':checked');
    if(checked){
    $(".checkbox").each(function(){
        $(this).prop("checked",true);
    });
    }else{
    $(".checkbox").each(function(){
        $(this).prop("checked",false);
    });
    }

});


//this is for select a single checkbox

$(".checkbox").click(function(){

    if($(".checkbox").length == $(".checkbox:checked").length) {
        $("#checkAll").prop("checked", true);
    } else {
        $("#checkAll").prop("checked",false);
    }

 });
