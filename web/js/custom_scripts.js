$(document).ready(function(){

    $('#main-page-carousel').owlCarousel({
        loop:true, //Зацикливаем слайдер
        margin:50, //Отступ от элемента справа в 50px
        nav:false, //Отключение навигации
        dots: false,
        autoplay:true, //Автозапуск слайдера
        smartSpeed:1000, //Время движения слайда
        autoplayTimeout:3000, //Время смены слайда
        autoplayHoverPause: false,

        responsive:{ //Адаптивность. Кол-во выводимых элементов при определенной ширине.
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

    $(".sideBar-body").click(function (e) {
        e.preventDefault();
        var chatId = $(this).children('.sideBar-main').children('.row').children('.chat-id').val();

        var chatName = $(this).children('.sideBar-main').children('.row').children('.sideBar-name').children('.name-meta').text();
        var chatImg = $(this).children('.sideBar-avatar').children('.avatar-icon').children('img').attr("src");


        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getBotMessagesByCHatId',
                chatId: chatId,
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
                        var messages = content.data.messages;
                        var conversationBlock = $('#conversation');

                        $('.heading-name-meta').html(chatName);
                        $('.current-chat-id').val(chatId);
                        $('.heading-avatar-icon').children('img').attr("src",chatImg);
                        //console.log(conversationBlock);
                        conversationBlock.fadeOut(500);
                        $('.injected-message').remove();

                        for (var i = 0; i < messages.length; i++) {
                            var timestampInMilliSeconds = messages[i].time*1000;
                            var date = new Date(timestampInMilliSeconds);
                            var formattedDate = date.format('d-m-Y h:i');
                            var itemPreviewTemplate = '';

                            if(messages[i].fromMe == true){

                                itemPreviewTemplate = conversationBlock.children('.sender-template').clone();
                                itemPreviewTemplate.removeClass('sender-template');
                                itemPreviewTemplate.addClass('injected-message');
                                itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(messages[i].body);
                                itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-time').html(formattedDate);
                                itemPreviewTemplate.appendTo('#conversation');

                                if(i ==  messages.length - 1)
                                    itemPreviewTemplate.addClass('last-message');
                            }

                            else{
                                itemPreviewTemplate = conversationBlock.children('.receiver-template').clone();

                                itemPreviewTemplate.removeClass('receiver-template');
                                itemPreviewTemplate.addClass('injected-message');
                                itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-time').html(formattedDate);
                                itemPreviewTemplate.appendTo('#conversation');

                                if(i ==  messages.length - 1)
                                    itemPreviewTemplate.addClass('last-message');

                            }

                        }
                        $('.chat-owerflow').fadeOut(500);
                        conversationBlock.fadeIn(1000);
                        $('#conversation').scrollTop(10000000);
                    }

                }

                else{
                    console.log(data);
                }
            }
        });

    })

    $(".reply-main textarea" ).keypress(function(){
        if($( ".reply-main textarea" ).val().length > 0 ) {
            $('.reply-recording').css({"display": "none"});
            $('.reply-send').css({"display": "block"});
        }
        else{
            $('.reply-recording').css({"display": "block"});
            $('.reply-send').css({"display": "none"});

        }
    });

    $(".reply-main textarea").keydown(function (event) {

        if (event.keyCode == 13) {
            event.preventDefault();
            sendMessage();
        }
    })

    $(".reply-send svg").click(function (e) {
        e.preventDefault();
        sendMessage();

    })
});

function sendMessage(){
    var message = $('#comment').val();

    if (message.length == 0){
        VanillaToasts.create({
            title: 'Внимание',
            text: "Сообщение не может быть пустым",
            type: "info", // success, info, warning, error   / optional parameter
            icon: '', // optional parameter
            timeout: 5000, // hide after 5000ms, // optional paremter
            callback: function () {

            } // executed when toast is clicked / optional parameter
        });
        return false;
    }
    $('#comment').val('');
    var chatId = $('.current-chat-id').val();

    var request = $.ajax({
        type: "POST",
        url: "/post/request",

        data:{
            action: 'sendMessInCHat',
            chatId: chatId,
            message: message,
            _csrf : yii.getCsrfToken()
        },
        success:function( data ) {
            var content = $.parseJSON(data);


            if (content.error != undefined) {


                if (content.error == true) {
                    VanillaToasts.create({
                        title: 'Внимание',
                        text: $.parseJSON(content.mess),
                        type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                        icon: '', // optional parameter
                        timeout: 5000, // hide after 5000ms, // optional paremter
                        callback: function () {

                        } // executed when toast is clicked / optional parameter
                    });

                }
                else {

                    var itemPreviewTemplate = $('#conversation').children('.sender-template').clone();

                    var date = new Date();
                    var formattedDate = date.format('d-m-Y h:i');

                    itemPreviewTemplate.removeClass('sender-template');
                    $('.last-message').removeClass('last-message');
                    itemPreviewTemplate.addClass('injected-message');
                    itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(message);
                    itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-time').html(formattedDate);
                    itemPreviewTemplate.appendTo('#conversation');
                    $('#conversation').scrollTop(10000000);

                    itemPreviewTemplate.addClass('last-message');
                    $('#comment').val('');

                }

            }
            else{
                console.log(data);
            }
        }

    });
}

$(function(){
    $(".heading-compose").click(function() {
        $(".side-two").css({
            "left": "0"
        });
    });

    $(".newMessage-back").click(function() {
        $(".side-two").css({
            "left": "-100%"
        });
    });
})