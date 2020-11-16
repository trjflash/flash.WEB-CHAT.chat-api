$(document).ready(function(){
    $('#main-menu li:has(ul)').click(function(e) {
        e.preventDefault();

        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).children('ul').slideUp();
        } else {
            $('.menu li ul').slideUp();
            $('.menu li').removeClass('active');
            $(this).addClass('active');
            $(this).children('ul').slideDown();
        }

        $('#main-menu li ul li a').click(function() {
            window.location.href = $(this).attr('href');
        })
    });

    $('#pagesList').change(function () {
        if ($('#pagesList').val() != undefined){

            var pageId = $("#pagesList option:selected").val();

            createEditor(pageId);

            $('.materialCard').fadeOut(1000)
            $('#'+$('#pagesList').val()).fadeIn(1000);
        }
    });

    $('.make_edit').click(function(e) {
        e.preventDefault();

        var form = $(this).parent();
        var action = 'editRoot';
        var mat_id = $(form).children('#mat-id').val();
        var page_type = $(this).parent().attr('formId');
        var page_type_name = $(form).children('#page_type_name').val();;
        var title = $(form).find(('.title')).val();
        var keywords = $(form).find(('.Keywords')).val();
        var description = $(form).find(('.Description')).val();
        var page_content = getDataFromMaterialsEditor();
        var activ = 0;
        var need_info_line = 0;
        var need_commnets = 0;

        if ($(form).find($('.isActive')).is(':checked'))
            activ = 1;
        if ($(form).find($('.isNeedCommnets')).is(':checked'))
            need_commnets = 1;
        if ($(form).find($('.isNeedInfoLine')).is(':checked'))
            need_info_line = 1;
        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: action,
                mat_id: mat_id,
                title: title,
                keywords: keywords,
                description: description,
                page_content: page_content,
                activ: activ,
                need_info_line: need_info_line,
                need_commnets: need_commnets,
                page_type: page_type,
                page_type_name: page_type_name,
                _csrf : yii.getCsrfToken()
            },
            success:function( data ) {
                var content = $.parseJSON(data);

                if(content['error'] != undefined ){
                    if(content['error'] == true) {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                    }
                    else{
                        //alert(data);
                        VanillaToasts.create({
                            title: content['title'],
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter

                        });
                        $('.materialCard').fadeOut(1000)
                        $("#pagesList").val("empty");
                    }

                }

                else{
                    console.log(data);
                }
            }
        });
    });

    $('#create_page').click(function(e) {
        e.preventDefault();

        $('.materialCard').fadeOut(1000)
        $("#new_page").fadeIn(1000);
    });

    $('#create_new_page').click(function(e) {
        e.preventDefault();
        var action = 'addRoot';
        var page_type = $('#new_page_type').val();
        var page_type_name = $("#new_page_type option:selected").text();
        var title = $('#new_page_title').val();
        var keywords = $('#new_page_Keywords').val();
        var description = $('#new_page_Description').val();
        var page_content = getDataFromNewEditor();
        var activ = 0;
        var need_info_line = 0;
        var need_commnets = 0;
        if ($('#new_page_activ').is(':checked'))
            activ = 1;
        if ($('#new_page_need_commnets').is(':checked'))
            need_commnets = 1;
        if ($('#new_page_need_info_line').is(':checked'))
            need_info_line = 1;

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: action,
                title: title,
                keywords: keywords,
                description: description,
                page_content: page_content,
                activ: activ,
                need_info_line: need_info_line,
                need_commnets: need_commnets,
                page_type: page_type,
                page_type_name: page_type_name,
                _csrf : yii.getCsrfToken()
            },
            success:function( data ) {
                var content = $.parseJSON(data);

                if(content['error'] != undefined ){
                    if(content['error'] == true) {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                    }
                    else{
                        //alert(data);
                        VanillaToasts.create({
                            title: content['title'],
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter

                        });
                        $('#new_page').fadeOut(1000);

                        window.location.replace('/adm/editors/root');

                    }

                }

                else{
                    console.log(data);
                }
            }
        });

    });

    $('.make_delete').click(function(e) {
        e.preventDefault();
        var action = 'dellRoot';
        var page_type = $(this).parent();
        var mat_id = $(page_type).children('#mat-id').val();
        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: action,
                mat_id: mat_id,
                _csrf : yii.getCsrfToken()
            },
            success:function( data ) {
                var content = $.parseJSON(data);

                if(content['error'] != undefined ){
                    if(content['error'] == true) {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                    }
                    else{
                        //alert(data);
                        VanillaToasts.create({
                            title: content['title'],
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter

                        });
                        $('.materialCard').fadeOut(1000);

                        $('#new_page_title').val("");
                        $('#new_page_Keywords').val("");
                        $('#new_page_Description').val("");

                        var carId = $(this).parent().attr('formId')+"_id_"+mat_id;
                        $("#"+carId).remove();
                        $("#pagesList  option:selected").remove();

                        $("#pagesList").val("empty");
                    }

                }

                else{
                    console.log(data);
                }
            }
        });

    })

    $('.add_menu_item').click(function(e) {
        e.preventDefault();
        var addedElement = undefined;
        $(".AJAX-loading").fadeIn(100);

        addedElement = $(".clear-menu-item").clone().appendTo(".menuForm");

        $(addedElement).addClass("menu-item");
        $(addedElement).removeClass("clear-menu-item");

        $(addedElement).children('.title-group').children(".title").val("");
        $(addedElement).children('.destinations-block').children(".destinationType option:selected").remove();
        $(addedElement).children('.destinations-block').children(".destinationPoint option:selected").remove();
        $(addedElement).children('.destinations-block').children(".destinationPoint").empty();
        $(addedElement).children('.destinations-block').children(".destinationPoint").prop('disabled', true);



        $(".AJAX-loading").fadeOut(100);


    })


    $( ".menuForm" ).on(
        "click", ".delete-menu-item", function() {
            var element = $(this).parent();
            element.remove();
            return false;
        }
    );


    $("#create_menu").click(function (e) {
        e.preventDefault();
        $('#create_menu').prop('disabled', true);
        $('.destinationType').empty();
        $('.destinationPoint').empty();


        $(".AJAX-loading").fadeIn(100);

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getFirstMenuLvl',
                _csrf : yii.getCsrfToken()
            },
            success:function( data ) {
                var content = $.parseJSON(data);

                if(content.error != undefined ){
                    if(content.error == true) {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                    }
                    else{
                        content = $.parseJSON(content.data);
                        $('.destinationType').append('<option value=""></option>');
                        $.each(content, function(index, value){
                            $('.destinationType').append('<option value="'+value.table_title+'">'+value.table_title+'</option>');
                        });
                        $(".destinationPoint").attr("disabled", "disabled");
                    }

                }

                else{
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);
        $("#add_menu").fadeIn(500);
        $("#add_menu").addClass('active');


    })

    $( ".menuForm" ).on(
        "change", ".destinationType", function() {
            if ($('.destinationType').val() != undefined){

                $(".AJAX-loading").fadeIn(100);

                var myform = $(this).parent();

                var materialName = $(myform).find($(".destinationType option:selected")).val();
                var request = $.ajax({
                    type: "POST",
                    url: "/post/request",

                    data:{
                        action: 'getSecondMenuLvl',
                        material: materialName,
                        _csrf : yii.getCsrfToken(),
                    },
                    success:function( data ) {
                        var content = $.parseJSON(data);

                        if(content.error != undefined ){
                            if(content.error == true) {
                                var toastTitle = "Внимание";
                                var toastTimeout = 5000;

                                makeToast(toastTitle, $.parseJSON(content['mess']), $.parseJSON(content['error_level']), toastTimeout);

                            }
                            else{
                                content = $.parseJSON(content.data);
                                $(myform).find($('.destinationPoint')).empty();
                                $.each(content, function(index, value){
                                    $(myform).find($('.destinationPoint')).append('<option value="'+value.title+'">'+value.title+'</option>');
                                });
                                $(myform).find($(".destinationPoint")).attr("disabled", false);
                            }

                        }

                        else{
                            console.log(data);
                        }
                    }
                });

                $(".AJAX-loading").fadeOut(100);
            }
        }
    );

    $("#menuList").change(function (e) {
        var pageId = $("#menuList option:selected").val();

        if (pageId != "empty"){
            $(".AJAX-loading").fadeIn(100);
            var request = $.ajax({
                type: "POST",
                url: "/post/request",

                data:{
                    action: 'editMenu',
                    menuName: pageId,
                    _csrf : yii.getCsrfToken()
                },
                success:function( data ) {
                    var content = $.parseJSON(data);

                    if(content.error != undefined ){
                        if(content.error == true) {
                            VanillaToasts.create({
                                title: 'Внимание',
                                text: $.parseJSON(content['mess']),
                                type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                                icon: '', // optional parameter
                                timeout: 5000, // hide after 5000ms, // optional paremter
                                callback: function() {

                                } // executed when toast is clicked / optional parameter
                            });
                            $("#menuList").append('<option value="'+urlLit(menuName,0)+'">'+menuName+'</option>');
                            cancellAddMenu();
                        }
                        else{
                            VanillaToasts.create({
                                title: 'Внимание',
                                text: $.parseJSON(content['mess']),
                                type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                                icon: '', // optional parameter
                                timeout: 5000, // hide after 5000ms, // optional paremter
                                callback: function() {

                                } // executed when toast is clicked / optional parameter
                            });
                        }

                    }

                    else{
                        console.log(data);
                    }
                }
            });


            $(".AJAX-loading").fadeOut(100);
        }
    })


    $("#add-new-menu").click(function (e) {
        e.preventDefault();
        var menu = {};

        var form = $(this).parent();
        var menuName = $(form).find($(".menu-name")).val();
        if (menuName == "undefined" || !menuName || menuName.length < 4){
            $(form).find($(".menu-name")).addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Название меню не может быть пустым или слишком коротко";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);

        }
        else{

            var items = $(form).find($(".menu-item"));
            var menuData = searchData(items);

            menu = {"name": menuName, items: menuData};
        }

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'addMenu',
                menuContent: JSON.stringify(menu),
                _csrf : yii.getCsrfToken()
            },
            success:function( data ) {
                var content = $.parseJSON(data);

                if(content.error != undefined ){
                    if(content.error == true) {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                        $("#menuList").append('<option value="'+urlLit(menuName,0)+'">'+menuName+'</option>');
                        cancellAddMenu();
                    }
                    else{
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content['mess']),
                            type: $.parseJSON(content['error_level']), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                    }

                }

                else{
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);


    })

    $(".menu-name").focus( function () {
        $(this).removeClass("is-invalid");
    });

    $( ".menuForm" ).on(
        "focus", ".title", function() {
            $(this).removeClass('is-invalid');
        }
    );

    $( ".menuForm" ).on(
        "focus", ".destinationType", function() {
            $(this).removeClass('is-invalid');
        }
    );
    $( ".menuForm" ).on(
        "focus", ".destinationPoint", function() {
            $(this).removeClass('is-invalid');
        }
    );
    $( ".menuForm" ).on(
        "click", ".add-sub-menu", function() {

            var myElement = $(this).parent();
            $(".AJAX-loading").fadeIn(100);

            console.log($(myElement).children(".sub-menu-item").length)

            if($(myElement).children(".sub-menu-item").length == 0){

                var addedElement = $(".clear-menu-item").clone().appendTo(myElement);

                $(addedElement).addClass("sub-menu-item");
                $(addedElement).removeClass("clear-menu-item");
                $(this).appendTo(myElement);

                $(addedElement).children('.title-group').children(".title").val("");
                $(addedElement).children('.destinations-block').children(".destinationType option:selected").remove();
                $(addedElement).children('.destinations-block').children(".destinationPoint option:selected").remove();
                $(addedElement).children('.destinations-block').children(".destinationPoint").empty();
                $(addedElement).children('.destinations-block').children(".destinationPoint").prop('disabled', true);

                addedElement = null;

            }
            else {
                console.log("ELSE")
                var addedElement =  $(".clear-menu-item").clone().appendTo(myElement);

                $(addedElement).addClass("sub-menu-item");
                $(addedElement).removeClass("clear-menu-item");

                $(this).appendTo(myElement);

                $(addedElement).children('.title-group').children(".title").val("");
                $(addedElement).children('.destinations-block').children(".destinationType option:selected").remove();
                $(addedElement).children('.destinations-block').children(".destinationPoint option:selected").remove();
                $(addedElement).children('.destinations-block').children(".destinationPoint").empty();
                $(addedElement).children('.destinations-block').children(".destinationPoint").prop('disabled', true);
                addedElement = null;
            }

            $(".AJAX-loading").fadeOut(100);
        }
    );


    $('#create_category').click(function (e) {
        e.preventDefault();
        $('.materialCard').fadeOut(500);
        $('#category_form').fadeIn(1000);
        $('#category_action').html('Новая категория');
        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getCategoriesNames',
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

                        $("#category_id").empty();
                        $("#category_id").append('<option value="empty"></option>');
                        $("#category_id").append(content.data);
                    }

                }

                else{
                    console.log(data);
                }
            }
        });


    })

    $('#category_make_edit').click(function (e) {
        e.preventDefault();
        var categoryId = $('#current_category_id').val();
        var categoryName = $('#category_name').val();
        var categoryKeyWords = $('#category_kw').val();
        var categoryDescriprion = $('#category_description').val();
        var categoryActive = '';
        var categoryParent = $("#category_id option:selected").text();
        if ($('#isCategoryActive').is(':checked'))
            categoryActive = 1;

        var category = {};

        if (categoryName == "undefined" || !categoryName || categoryName.length < 4){
            $('#category_name').addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Название категории не может быть пустым или слишком коротко";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);

        }
        else{
            $('#category_name').removeClass("is-invalid");
            category = {
                "categoryId": categoryId,
                "categoryName": categoryName,
                "categoryKeyWords": categoryKeyWords,
                "categoryDescriprion": categoryDescriprion,
                "categoryActive":categoryActive,
                "categoryParent":categoryParent
            };

            var request = $.ajax({
                type: "POST",
                url: "/post/request",

                data:{
                    action: 'addNewCat',
                    data: category,
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
                            VanillaToasts.create({
                                title: 'Внимание',
                                text: $.parseJSON(content.mess),
                                type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                                icon: '', // optional parameter
                                timeout: 5000, // hide after 5000ms, // optional paremter
                                callback: function() {

                                } // executed when toast is clicked / optional parameter
                            });
                            $("#categoryList option[value='empty']").attr("selected", "selected");
                            $('.materialCard').fadeOut(500);
                            $('#category_action').val('');
                            $('#category_name').val('');
                            $('#category_kw').val('');
                            $('#category_description').val('');
                            $("#category_id").empty();
                            $('#isCategoryActive').prop('checked', false);


                        }

                    }

                    else{
                        console.log(data);
                    }
                }
            });
        }

    })

    $('#category_make_delete').click(function (e) {
        e.preventDefault();
        var catId = $("#current_category_id").val();
        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'removeCat',
                data: catId,
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
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content.mess),
                            type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                        $('.materialCard').fadeOut(500);
                        $("#categoryList option[value='empty']").attr("selected", "selected");
                        $("#categoryList option[value='"+catId+"']").remove();

                    }

                }

                else{
                    console.log(data);
                }
            }
        });
    })

    $('#categoryList').change(function (e) {
        e.preventDefault();
        var categoryForEdit = $("#categoryList option:selected").val();

        if(categoryForEdit == "empty") {
            return false;
        }

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getCategoriesNames',
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

                        $("#category_id").empty();
                        $("#category_id").append('<option value="empty"></option>');
                        $("#category_id").append(content.data);
                    }

                }

                else{
                    console.log(data);
                }
            }
        });

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getCatForEdit',
                data: categoryForEdit,
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

                        $('.materialCard').fadeOut(500);
                        $('#category_form').fadeIn(1000);

                        $('#category_action').html("Редактируем категорю '"+content.data.category_name+"'");
                        $('#category_name').val(content.data.category_name);
                        $('#category_kw').val(content.data.keywords);
                        $('#category_description').val(content.data.description);
                        $("#current_category_id").val(content.data.id);
                        if(content.data.is_active == 1)
                            $('#isCategoryActive').prop('checked', true);
                        else
                            $('#isCategoryActive').prop('checked', false);

                        var id = content.data.parent_id;
                        if(content.data.is_parent == 1)
                            $("#category_id option[value='"+id+"']").attr("selected", "selected");

                    }

                }

                else{
                    console.log(data);
                }
            }
        });
    })

    $('#create_good').click(function (e) {
        e.preventDefault();
        $('.materialCard').fadeOut(500);
        $('#good_form').fadeIn(1000);
        $('#good_action').html('Новый товар');

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data:{
                action: 'getCategoriesNames',
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
                        $("#good_category").empty();
                        $("#good_category").append('<option value="empty"></option>');
                        $("#good_category").append(content.data);
                    }

                }

                else{
                    console.log(data);
                }
            }
        });

    })

    $('#good_make_edit').click(function (e) {
        e.preventDefault();
        var query = {};
        query.goodName = $('#good_name').val();
        query.photos = '';
        query.goodCategory = $('#good_category option:selected').val();
        query.goodPrice = $('#good_price').val();
        query.goodSelfPrice = $('#good_self_price').val();
        query.goodAnons = $('#good_anons').val();
        query.goodDescription = $('#good_description').val();
        query.goodMetaKw = $('#good_meta_kw').val();
        query.goodMetaDescription = $('#good_meta_description').val();

        query.activeGood = 0;
        query.topGood = 0;
        query.newGood = 0;
        query.isComments = 0;
        query.isInfoLine = 0;


        if ($('.isActive').is(':checked'))
            query.activeGood = 1;

        if ($('.is_top').is(':checked'))
            query.topGood = 1;


        if ($('.is_new').is(':checked'))
            query.newGood = 1;


        query.availability = $('#availability').val();

        if ($('.isComments').is(':checked'))
            query.isComments = 1;

        if ($('.isInfoLine').is(':checked'))
            query.isInfoLine = 1;

        query.currentGoodId =$('#current_good_id').val();
        query.action ='addNewGood';

        var good = new FormData();


        var files = [];

        jQuery.each(queue, function(key, element){
            files.push(element);
        })

        jQuery.each(files, function(i, file) {
            good.append(i, file);
        });

        $.each( query, function( key, value ){

            good.append( key, value );
        });


        var request = $.ajax({
            type: "POST",
            url: "/post/request",
            data: good,
            _csrf : yii.getCsrfToken(),
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос

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
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content.mess),
                            type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function() {

                            } // executed when toast is clicked / optional parameter
                        });
                        $('.materialCard').fadeOut(500);


                        $("#good_category option[value='empty']").attr("selected", "selected");
                        $('#good_name').val('');
                        $('#good_category option:selected').val('');
                        $('#good_price').val('');
                        $('#good_self_price').val('');
                        $('#good_anons').val('');
                        $('#good_description').val('');
                        $('#good_meta_kw').val('');
                        $('#good_meta_description').val('');
                        $('#current_good_id').val('');
                        $('.isActive').prop('checked', false);
                        $('.is_top').prop('checked', false);
                        $('.is_new').prop('checked', false);
                        $('#availability').val('');
                        $('.isComments').prop('checked', false);
                        $('.isInfoLine').prop('checked', false);
                        $('#current_good_id').val('');
                        $('#uploadImagesList').fadeOut(500);
                        $('#uploadImagesList li:not(:first)').remove();


                    }

                }

                else{
                    console.log(data);
                }
            }
        });


    })

    $('#create_delivery').click(function (e) {
        e.preventDefault();
        $('.materialCard').fadeOut(500);
        $('#delivery_form').fadeIn(1000);
        $('#delivery_action').html('Новый способ доставки');

    })

    $('.close').click(function (e) {
        e.preventDefault();
        $('.materialCard').fadeOut(500);
    })


    var queue = {};
    var imagesList = $('#uploadImagesList');

    $('#good_photos').change(function () {
        $('#uploadImagesList').fadeOut(500);
        var maxFileSize = 2 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
        var files = this.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                alert( 'Фотография должна быть в формате jpg, png или gif' );
                continue;
            }

            if ( file.size > maxFileSize ) {
                alert( 'Размер фотографии не должен превышать 2 Мб' );
                continue;
            }

            preview(files[i], i);
        }
    });

    // Удаление фотографий
    imagesList.on('click', '.delete-link', function () {
        var item = $(this).closest('.gallery-item'),
            id = item.data('id'),
            itemId = item.data('fileId');

        delete queue[id];

        item.remove();
        if($('.gallery-item').length == 1)
            $('#uploadImagesList').fadeOut(500);

    });

    function preview(file, fileId) {
        var itemPreviewTemplate = imagesList.find('.gallery-item.gallery-template').clone();
        itemPreviewTemplate.removeClass('gallery-template');

        var reader = new FileReader();
        reader.addEventListener('load', function(event) {
            var img = document.createElement('img');

            var itemPreview = itemPreviewTemplate.clone();

            itemPreview.find('.img-wrap img').attr('src', event.target.result);
            itemPreview.data('fileId', fileId);
            itemPreview.data('id', file.name);

            imagesList.append(itemPreview);

            queue[file.name] = file;

        });
        reader.readAsDataURL(file);
        $('#uploadImagesList').fadeIn(1000);
    }

} );




function searchData(items) {
    var out = [];
    $.each(items, function(index, value){
        var title = $(value).find($(".title")).val();
        var destinationType = $(value).find($(".destinationType option:selected")).val();
        var destinationPoint = $(value).find($(".destinationPoint option:selected")).val();
        var subItem = $(value).find($(".sub-menu-item"));
        if(title === "undefined" || !title || title.length < 3) {
            $(value).find($(".title")).addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Имя пунка пустое либо слишком короткое";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);
            return false;
        }
        else if(!destinationPoint){
            $(value).find($(".destinationType")).addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Не назначен переход";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);
            return false;
        }

        var data = {itemTitle: title,destinationType: destinationType, destinationPoint: destinationPoint}

        if(subItem.length > 0)
            out.push({menuData: data, subMenuData: searchData(subItem)});
        else
            out.push({menuData: data});


    });
    return out;
}

function makeToast(title,text,type,timeout){
    VanillaToasts.create({
        title: title,
        text: text,
        type: type, // success, info, warning, error   / optional parameter
        icon: '', // optional parameter
        timeout: timeout, // hide after 5000ms, // optional paremter
        callback: function () {

        } // executed when toast is clicked / optionmenuListal parameter
    });
}

$(".cancel-add-menu").click(function (e) {
    e.preventDefault();
    cancellAddMenu();
})

$(this).keydown(function(eventObject){
    if (eventObject.which == 27){
        cancellAddMenu();
    }
});

function clearNewMenu() {
    $('.menuForm .menu-item:not(:first)').remove();
    $('.menu-name').val('');
    $('.title').val('');
    $('.destinationType :first').attr("selected", "selected");
    $('.destinationPoint :first').attr("selected", "selected");
}

function cancellAddMenu() {

    $('#create_menu').prop('disabled', false)
    setTimeout( function(){
        $("#add_menu").fadeOut(500);
        setTimeout(function (){
            clearNewMenu();
        },500);
    },0);
    $("#add_menu").removeClass('active');

}

function createEditor(id){
    var idNum = (id.replace(/[^\d]/g, ''));
    let materialsEditor = null;

    $('.editorScriptBlock').empty();
    $('.ck').remove();
    var code = " <script>  ClassicEditor.create(document.querySelector('#page_content_id_" + idNum+"')).then(editor => {    materialsEditor = editor;}).catch(error => {    console.error(error);})<\/script>";
    $('.editorScriptBlock').append(code);
}

function getDataFromMaterialsEditor() {
    return materialsEditor.getData();
}

let newEditor;

ClassicEditor
    .create(document.querySelector('#new_page_content'))
    .then(editor => {
        newEditor = editor; // Save for later use.
    })
    .catch(error => {
        console.error(error);
    });

function getDataFromNewEditor() {
    return newEditor.getData();
}
function urlLit(w,v) {
    var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
    var ww=''; w=w.toLowerCase();
    for(i=0; i<w.length; ++i) {
        cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]);
        if(ch.length<3) ww+=ch; else ww+=eval(ch)[v];}
    return(ww.replace(/[^a-zA-Z0-9\-]/g,'-').replace(/[-]{2,}/gim, '-').replace( /^\-+/g, '').replace( /\-+$/g, ''));
}

