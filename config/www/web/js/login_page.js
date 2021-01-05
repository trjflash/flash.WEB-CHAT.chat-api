$(function() {
    checkLogin("#login");
});

//validaciones
var emailPattern = "^[a-zA-Z0-9]+$";

function checkInput(idInput, pattern) {
    return $(idInput).val().match(pattern) ? true : false;
}

function checkLongInput(idInput){
    return $(idInput).val().length >= 5 ? true : false;
}

function enableSubmit (idForm) {
    $(idForm + " input.submit").removeAttr("disabled");
}

function disableSubmit (idForm) {
    $(idForm + " input.submit").attr("disabled", "disabled");
}

function checkLogin(idForm){
    $(idForm + " *").on("change keydown", function() {
        if (checkInput("#loginLogin", emailPattern) &&
            checkLongInput("#loginPassword"))
        {
            enableSubmit(idForm);
        } else {
            disableSubmit(idForm);
        }
    });
}