function warning(warn, state = 0, message = ""){
    if (state){
        if ($.isArray(warn)){
            warn[0].css("backgroundColor", "red");
            warn[1].text(message);
        }
        else warn.text(message);
    }
    else{
        if ($.isArray(warn)){
            warn[0].css("backgroundColor", "white");
            warn[1].text("");
        }
        else warn.text("");
    }
}
