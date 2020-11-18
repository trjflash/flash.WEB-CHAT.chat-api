var audio = [
    'ogg',
    'mp3',
    'wave'
];
var img =[
  'jpeg',
  'gif',
  'jpg',
  'bmp',
  'png'
];
var video = [
    'mp4',
    'avi',
    'wmv'
];


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
        $('.conversation').fadeOut(500);
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

                                var exetention = messages[i].body.split('.').pop();

                                if(audio.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }
                                else if(img.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html('<img src="'+messages[i].body+'" class="mes-img"/>');
                                }
                                else if (video.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }
                                else{
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }

                                itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-time').html(formattedDate);
                                itemPreviewTemplate.appendTo('#conversation');

                                if(i ==  messages.length - 1) {
                                    itemPreviewTemplate.addClass('last-message');
                                    itemPreviewTemplate.children('.raw-time').val(timestampInMilliSeconds/1000);
                                    itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);

                                }
                            }

                            else{

                                itemPreviewTemplate = conversationBlock.children('.receiver-template').clone();

                                itemPreviewTemplate.removeClass('receiver-template');
                                itemPreviewTemplate.addClass('injected-message');

                                var exetention = messages[i].body.split('.').pop();

                                if(audio.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }
                                else if(img.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html('<img src="'+messages[i].body+'" class="mes-img"/>');
                                }
                                else if (video.indexOf(exetention) != -1 ){
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }
                                else{
                                    itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                }

                                itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-time').html(formattedDate);
                                itemPreviewTemplate.appendTo('#conversation');

                                if(i ==  messages.length - 1) {
                                    itemPreviewTemplate.addClass('last-message');
                                    itemPreviewTemplate.children('.raw-time').val(timestampInMilliSeconds/1000);
                                    itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);
                                }
                            }

                        }
                        $('.chat-owerflow').fadeOut(500);
                        $('.conversation').fadeIn(1000);
                        conversationBlock.addClass('active');
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

    $('#conversation').everyTime(10000,function () {
        if($('#conversation').hasClass('active')){
            var lastMessageId = $('#conversation').find('.last-message').find('.last-message-id').val();
            var chatId = $('.current-chat-id').val();

            var data = {};
            data = {
                "lastMessageId": lastMessageId,
                "chatId": chatId
            };

            var request = $.ajax({
                type: 'POST',
                url: '/post/request',
                data:{
                    action: 'getNewMessagesInChat',
                    requestBody: data,
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

                            if(content.data != "NO MESSAGES ((("){
                                var messages = content.data.messages;
                                for (var i = 0; i < messages.length; i++){
                                    if(!messages[i].fromMe){

                                        var date = new Date(messages[i].time*1000);
                                        var formattedDate = date.format('d-m-Y h:i');
                                        var itemPreviewTemplate = '';
                                        itemPreviewTemplate = $('#conversation').children('.receiver-template').clone();

                                        itemPreviewTemplate.removeClass('receiver-template');
                                        itemPreviewTemplate.addClass('injected-message');

                                        if(audio.indexOf(messages[i].body.split('.').pop()) != -1 ){
                                            itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                        }
                                        else if(img.indexOf(messages[i].body.split('.').pop()) != -1 ){
                                            itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html('<img src="'+messages[i].body+'" class="mes-img"/>');
                                        }
                                        else if (video.indexOf(messages[i].body.split('.').pop()) != -1 ){
                                            itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                        }
                                        else{
                                            itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(messages[i].body);
                                        }

                                        itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-time').html(formattedDate);
                                        itemPreviewTemplate.appendTo('#conversation');
                                        $('.last-message').removeClass('last-message')

                                        if(i ==  messages.length - 1) {
                                            itemPreviewTemplate.addClass('last-message');
                                            itemPreviewTemplate.children('.raw-time').val(messages[i].time);
                                            itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);
                                        }
                                        $('#conversation').scrollTop(10000000);
                                    }
                                }
                            }

                        }

                    }
                    else{
                        console.log(data);
                    }
                }

            });
        }
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
                    var lastMessage = Number($('#conversation').find('.last-message').find('.last-message-id').val());
                    $('.last-message').removeClass('last-message');
                    itemPreviewTemplate.addClass('injected-message');
                    itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(message);
                    itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-time').html(formattedDate);
                    itemPreviewTemplate.appendTo('#conversation');
                    $('#conversation').scrollTop(10000000);

                    $('#conversation').find('.last-message').find('.last-message-id').val("")
                    itemPreviewTemplate.addClass('last-message');
                    $('#conversation').find('.last-message').find('.last-message-id').val(lastMessage)


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