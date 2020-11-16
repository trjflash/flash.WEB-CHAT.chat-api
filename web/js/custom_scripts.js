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
});

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