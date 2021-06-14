$(document).ready(function(){
    $(".file-drop").on("dragover", function(e){
        e.preventDefault();
        e.stopPropagation();
    });

    $(".file-drop").on("drop", fileDrop);
});

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
var test;
function fileDrop(e) {
    e.preventDefault();
    e.stopPropagation();

    if(e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length){
        var files = e.originalEvent.dataTransfer.files, verified = [];

        for (let i = 0; i < files.length; i++){
            if(!endsWithArr(files[i].name, [".png", ".jpg", ".jpeg", ".png"]))
                continue;
            verified.push(i);
        }
console.log(files);
        var fd = new FormData();
        for (let i = 0; i < (verified.length < 3 ? verified.length : 3); i++){test = files[0];
            //fd.append("file${i+1}", files[verified[i]]);
            //$('input[name="file${i+1}"]').prototype.append(files[verified[i]].File);
        }
    }
}//FIXME:None of this works because files can't be added dynamically,
    //need to work on a different method

function endsWithArr(str, list){
    for (let i in list)
        if(str.endsWith(list[i]))
            return true;
    return false;
}
