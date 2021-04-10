function init(){
    notification=document.getElementById("notification");
    fname=document.getElementById("fname");
    lname=document.getElementById("lname");
    id=document.getElementById("id");
    male=document.getElementById("male");
    female=document.getElementById("female");
    year=document.getElementById("year");
    department=document.getElementById("department");
    email=document.getElementById("email");
    password=document.getElementById("password");
    confirmPass=document.getElementById("confirmPass");
    signup=document.getElementById("signup");

    fname.addEventListener('keyup',checkFname,false);
    lname.addEventListener('keyup',checkLname,false);
    email.addEventListener('keyup',checkEmail,false);
    password.addEventListener('keyup',checkPassword,false);
    confirmPass.addEventListener('keyup',checkPassword,false);
    signup.addEventListener('click',checkData,false);
}

function checkFname(e){
    let regex=/^[a-zA-Z]+$/;
    if(fname.value!=""){
        if(!fname.value.match(regex)){
            e.preventDefault();
            notification.innerHTML="Invalid first name";
            fname.style.borderColor='#F4432F';
            return false;
        }
    else{
        notification.innerHTML="";
        fname.style.borderColor=' #cfcfcf';
        return true;
    }
    }
    else{
        notification.innerHTML="";
        fname.style.borderColor=' #cfcfcf';
    }
}
function checkLname(e){
    let regex=/^[a-zA-Z]+$/;
    if(lname.value!=""){
        if(!lname.value.match(regex)){
            e.preventDefault();
            notification.innerHTML="Invalid last name";
            lname.style.borderColor='#F4432F';
            return false;
        }
    else{
        notification.innerHTML="";
        lname.style.borderColor=' #cfcfcf';
        return true;
    }
    }
    else{
        notification.innerHTML="";
        lname.style.borderColor=' #cfcfcf';
    }
}
function checkEmail(e){
    let regex=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if(email.value!=""){
        if(!email.value.match(regex)){
            notification.innerHTML="Invalid email address";
            email.style.borderColor='#F4432F';
            return false;
        }
        else{
            notification.innerHTML="";
            email.style.borderColor=' #cfcfcf';
            return true;
        }
    }
    else{
        notification.innerHTML="";
        email.style.borderColor=' #cfcfcf';
    }
}
function checkPassword(e){
    if((password.value!=""&&confirmPass.value=="")||(password.value==""&&confirmPass.value!="")||(password.value!=""&&confirmPass.value!="")){
        if(password.value!=confirmPass.value){
            e.preventDefault();
            notification.innerHTML="The password you entered don't match";
            confirmPass.style.borderColor='#F4432F';
            return false;
        }
        else{
            notification.innerHTML="";
            confirmPass.style.borderColor='#cfcfcf';
            return true;
        }
    }
    else{
        notification.innerHTML="";
        confirmPass.style.borderColor='#cfcfcf';
    }
}
function checkData(e){
    if(fname.value==""||lname.value==""||email.value==""||password.value=="" ||(female.checked==false && male.checked==false)){
        e.preventDefault();
        notification.innerHTML="All fields required";
        return;
    }
    else{
        notification.innerHTML="";  
    }
    if(password.value.length<6){
        e.preventDefault();
        notification.innerHTML="Minimum password length  is 6";
        password.style.borderColor='#F4432F';
    }
    else{
        notification.innerHTML=""; 
        password.style.borderColor=' #cfcfcf';
    }
}

window.onload=init;
