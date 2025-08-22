$("#login").submit(function(e){
    e.preventDefault();
    form=$(this);

    formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: formData,
        // dataType: "json",
        contentType: false,
        processData: false,
        success: function(data) {
            document.location.href=".";
        },
        error: function(error) {
            console.log(error);
            toastr.error('Votre nom d\'usager ou votre mot de passe n\'est pas valide!','Erreur');
        },
    });
});

$("#formRetrievePassword").submit(function(e){
    e.preventDefault();
    form=$(this);

    formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: "php/web_service/requete.php",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function(data) {
            $("#retrievePassword").modal("hide");
            toastr.success('Un courriel avec votre nouveau mot de passe vous a Ã©tÃ© envoyÃ©','SuccÃ¨s');
        },
        error: function(error) {
            toastr.error('Votre courriel ou votre mot de passe n\'est pas valide!','Erreur');

        },
    });
});