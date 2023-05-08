

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



    function checkTextLimit(id){
        let totalCount = $('#'+id).val();
        let len = 0;
        if(totalCount.length>0) len = totalCount.length;
        $('#count_'+id).html(len);
    }

    function generate(id){
        let gen = document.getElementById(id);
         gen.value = generatePassword();
    }

    let gen = document.getElementById("gen");


    /* To toggle password visibility*/
    function pwdToggle(id, btnid) {
        let pwd = document.getElementById(id);
            if (pwd.type == "text"){ 
                pwd.type = "password";
                $('#'+btnid).html('<i class="fa fa-eye"></i>');
            }
            else{ 
                pwd.type = "text";
                $('#'+btnid).html('<i class="fa fa-eye-slash"></i>');
            }

        }
      
        /* To Generate the password*/
        function generatePassword() {
            let alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            let symbols = "%!@#$^&*-+=|\\(){}:\"';,?";
            let password = "";

            for (let i = 0; i < 3; i++) {
                let randomNumber = Math.floor(Math.random() * 10);
                let lowerCaseLetter = alphabet.charAt(Math.random() * 26).toLowerCase();
                let upperCaseLetter = alphabet.charAt(Math.random() * 26).toUpperCase();
                let specialChar = symbols.charAt(Math.random() * symbols.length);

                password += randomNumber + lowerCaseLetter + upperCaseLetter + specialChar;
            }
        return shuffle(password);
        }

        /* To shuffle the password string*/
        function shuffle(str) {
            let arr = str.split("");
            let n = arr.length;

            for (let i = 0; i < n; i++) {
                let j = Math.floor(Math.random() * n);

                let temp = arr[i];
                arr[i] = arr[j];
                arr[j] = temp;
            }
            return arr.join("");
        }




    function emailValidationChecker(id){

        let emailId = document.getElementById(id);
        // let errorMsg = document.getElementById("error-msg");
        let icon = document.getElementById(id+"icon");
    
        let mailRegex = /^[a-zA-Z][a-zA-Z0-9\-\_\.]+@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{2,}$/;
        icon.style.display="inline-block";
        if(emailId.value.match(mailRegex)){
            icon.innerHTML = '<i class="fas fa-check-circle"></i>';
            icon.style.color = '#2ecc71';
            // errorMsg.style.display = 'none';
            // emailId.style.border = '2px solid #2ecc71';
        }
        else if(emailId.value == ""){
            icon.style.display = 'none';
            // errorMsg.style.display = 'none';
            // emailId.style.border = '2px solid #d1d3d4';
        }
        else{
            icon.innerHTML = '<i class="fas fa-exclamation-circle"></i>';
            icon.style.color = '#ff2851';
            // errorMsg.style.display = 'block';
            // emailId.style.border = '2px solid #ff2851';
        }
    
        }
    


    


