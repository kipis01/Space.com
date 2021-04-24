var nickname, pass, pass2, warn1, warn2, warn3, taken_usernames, action;


function warning(warn, state = 0, message = ""){
    if (state){
        if (Array.isArray(warn)){
            warn[0].style.backgroundColor = "red";
            warn[1].innerHTML = message;
        }
        else warn.innerHTML = message;
    }
    else{
        if (Array.isArray(warn)){
            warn[0].style.backgroundColor = "white";
            warn[1].innerHTML = "";
        }
        else warn.innerHTML = "";
    }
}

function checkInput(){
    if (taken_usernames.includes(nickname.value))
        warning(warn1, 1, "The username already exists");
    else warning(warn1);

    if (pass.value != pass2.value)
        warning(warn2, 1, "The passwords don't match");
    else warning(warn2);
}

function submition(){
    if (nickname.value != "" && !taken_usernames.includes(nickname.value) && pass.value != '' && pass.value == pass2.value){
        document.getElementById("register").action = action;
        document.getElementById("register").submit();
    }
    else if(nickname.value == "" || pass.value != '')
        warning(warn3, 1, "All fields must be filled!");
}
