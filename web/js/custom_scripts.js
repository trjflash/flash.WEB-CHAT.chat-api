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