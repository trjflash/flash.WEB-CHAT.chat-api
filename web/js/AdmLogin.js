var home = 'http://chat.onclinic.local';

$('#adminLogin').click(function(event) {
    alert('AAAAAAAA');

    event.preventDefault();
    var action = 'login';
    var username = $('#username').val();
    var password = $('#password').val();
    var remember = '';
        if (remember == 'on')
            remember = true;
        else
            remember = false;
    var request = $.ajax({
        type: "POST",
        url: "/post/request",

        data:{
            username: username,
            password: password,
            remember: remember,
            action: action,
            _csrf : yii.getCsrfToken()
        },
        success:function( data ) {
            var content = $.parseJSON(data);

            if(content.error != undefined ){
                if(content.error == true) {
                    VanillaToasts.create({
                        title: 'Внимание',
                        text: $.parseJSON(content.mess),
                        type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                        icon: '', // optional parameter
                        timeout: 5000, // hide after 5000ms, // optional paremter
                        callback: function() {

                        } // executed when toast is clicked / optional parameter
                    });
                }
                else{
                    //alert(data);
                    VanillaToasts.create({
                        title: content.title,
                        text: $.parseJSON(content.mess),
                        type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                        icon: '', // optional parameter
                        timeout: 5000, // hide after 5000ms, // optional paremter
                        callback: function() {

                        } // executed when toast is clicked / optional parameter

                    });
                    window.location.replace(home);
                }

            }

            else{
                console.log(data);
            }
        }
    });
});