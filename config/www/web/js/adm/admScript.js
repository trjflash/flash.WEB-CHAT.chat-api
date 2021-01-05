$(document).ready(function() {

    //Боковое меню админки
    $('#main-menu li:has(ul)').click(function (e) {
        e.preventDefault();

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).children('ul').slideUp();
        } else {
            $('.instance li ul').slideUp();
            $('.instance li').removeClass('active');
            $(this).addClass('active');
            $(this).children('ul').slideDown();
        }

        $('#main-menu li ul li a').click(function () {
            window.location.href = $(this).attr('href');
        })
    });

    //Парс урла инстанса, вытаскиваем ID
    $('#instance-id').click(function(e){
        e.preventDefault();

        var url = $('#api-url').val();
        var token = $('#token').val();

        if(url.length > 30 && token.length > 10){
            var parser = parse_url(url);
            var instanceId  = parser.pathname;

            $('#instance-id').val(instanceId.replace(/[^+\d]/g, ''));
        }

    })

    //Кнопка добавить инстанс
    $("#create_instance").click(function (e) {
        e.preventDefault();
        $('.instance-name').val('');
        $('#api-url').val('');
        $('#token').val('');
        $('#instance-id').val('');


        $(".AJAX-loading").fadeIn(100);

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data: {
                action: 'getFirstinstanceLvl',
                _csrf: yii.getCsrfToken()
            },
            success: function (data) {
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
                    } else {

                    }

                } else {
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);
        $("#add_instance").fadeIn(500);
        $("#add_instance").addClass('active');
        $("#remove-instance").prop('disabled', true);


    })

    //Добавление инстанса
    $("#add-new-instance").click(function (e) {
        e.preventDefault();
        var instance = {};
        var instanceName = $(".instance-name").val();


        if (instanceName == "undefined" || !instanceName || instanceName.length < 4) {
            $(".instance-name").addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Название инстанса не может быть пустым или слишком коротко";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);
            return false;

        } else {

            instance = {
                "name": instanceName,
                "apiUrl": $('#api-url').val(),
                "token" : $('#token').val(),
                "instanceId" : $('#instance-id').val()

            };
        }

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data: {
                action: 'addinstance',
                instanceContent: JSON.stringify(instance),
                _csrf: yii.getCsrfToken()
            },
            success: function (data) {
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

                        if(!$('#instanceList option[value="' + urlLit(instanceName, 0) + '"]')){
                            $("#instanceList").append('<option value="' + urlLit(instanceName, 0) + '">' + instanceName + '</option>');

                        }
                        cancellAddinstance();

                    } else {
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

                } else {
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);


    })

    //Удаление инстанса
    $("#remove-instance").click(function (e) {
        e.preventDefault();
        var instance = {};

        var form = $(this).parent();
        var instanceName = $(form).find($(".instance-name")).val();


        instance = {
            "name": instanceName,
            "apiUrl": $('#api-url').val(),
            "token" : $('#token').val(),
            "instanceId" : $('#instance-id').val()

        };


        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data: {
                action: 'delinstance',
                instanceContent: JSON.stringify(instance),
                _csrf: yii.getCsrfToken()
            },
            success: function (data) {
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



                    } else {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content.mess),
                            type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function () {

                            } // executed when toast is clicked / optional parameter
                        });
                        $("#instanceList option:selected").remove();

                        cancellAddinstance();

                    }

                } else {
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);


    })

    //Выбор инстанса для редактирования
    $("#instanceList").change(function (e) {

        var instanceId = $("#instanceList option:selected").val();
        $('.instance-name').val('');
        $('#api-url').val('');
        $('#token').val('');
        $('#instance-id').val('');

        if (instanceId != "empty") {

            var instance ={};

            instance = {
                "instanceId": instanceId
            };

            $(".AJAX-loading").fadeIn(100);
            var request = $.ajax({
                type: "POST",
                url: "/post/request",

                data: {
                    action: 'editinstance',
                    instanceContent: JSON.stringify(instance),
                    _csrf: yii.getCsrfToken()
                },
                success: function (data) {
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
                        } else {

                            $(".AJAX-loading").fadeOut(100);
                            $("#add_instance").fadeIn(500);


                            $('.instance-name').val($("#instanceList option:selected").text());
                            $('#api-url').val(content.instanceData.link);
                            $('#token').val(content.instanceData.token);
                            $('#instance-id').val(content.instanceData.instance);

                            $("#add_instance").addClass('active');

                        }

                    } else {
                        console.log(data);
                    }
                }
            });


            $(".AJAX-loading").fadeOut(100);
            $("#remove-instance").prop('disabled', false);
        }
    })

    //Кнопка создать пользователя
    $('#create_user').click(function (e) {

        e.preventDefault();

        $("#user_display_name").val('');
        $("#login").val('');
        $("#password").val('');
        $('#instanceoption:first').prop('selected', true);
        $('#role option:first').prop('selected', true);

        $('.materialCard').fadeOut(1000)
        $("#user").fadeIn(1000);
        $("#remove-user").prop('disabled', true);

    });

    //Добавление пользователя
    $('#add-new-user').click(function (e) {
        e.preventDefault();
        var user = {};
        var userName = $("#user_display_name").val();
        var userLogin = $("#login").val();
        var userPass = $("#password").val();
        var userInstance = $("#instance").val();
        var userRole = $("#role").val();



        if (userName == "undefined" || !userName || userName.length < 4 || userLogin == "undefined" || !userLogin || userLogin.length < 4 || userPass == "undefined" || !userPass || userPass.length < 4) {
            $(".instance-name").addClass("is-invalid");

            var toastTitle = "Внимание";
            var toastText = "Имя, логин или пароль пусты или короче 4х символов";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);
            return false;

        }
        else if(userInstance == 0 || userRole == 0){
            var toastTitle = "Внимание";
            var toastText = "Инстанс и роль должны быть выбраны";
            var toastType = "warning";
            var toastTimeout = 5000;

            makeToast(toastTitle, toastText, toastType, toastTimeout);
            return false;
        }
        else {

            user = {
                "userName": userName,
                "userLogin": userLogin,
                "userPass" : userPass,
                "userInstance" : userInstance,
                "userRole" : userRole

            };
        }

        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data: {
                action: 'adduser',
                userContent: JSON.stringify(user),
                _csrf: yii.getCsrfToken()
            },
            success: function (data) {
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
                    } else {
                        //alert(data);
                        VanillaToasts.create({
                            title: content['title'],
                            text: $.parseJSON(content.mess),
                            type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function () {

                            } // executed when toast is clicked / optional parameter

                        });
                        if(!$('#usersList option[value="' + urlLit(userName, 0) + '"]')){
                            $("#instanceList").append('<option value="' + urlLit(userLogin, 0) + '">' + userName + '</option>');

                        }
                        cancellAddUser();

                    }

                } else {
                    console.log(data);
                }
            }
        });

        $("#usersList:first").prop('selected', true);

    });

    //Выбор пользователя для редактирования
    $("#usersList").change(function (e) {

        var userName = $("#usersList option:selected").val();


        $("#user_display_name").empty();
        $("#login").empty();
        $("#password").empty();

        $("#instance").empty();
        $("#role").empty();

        $('#instance').append('<option value=""></option>');
        $('#role').append('<option value=""></option>');

        $("#instance:first").prop('selected', true);
        $("#role:first").prop('selected', true);

        if (userName != "empty") {

            var user ={};

            user = {
                "userName": userName
            };

            $(".AJAX-loading").fadeIn(100);
            var request = $.ajax({
                type: "POST",
                url: "/post/request",

                data: {
                    action: 'edituser',
                    userContent: JSON.stringify(user),
                    _csrf: yii.getCsrfToken()
                },
                success: function (data) {
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
                        } else {


                            $(".AJAX-loading").fadeOut(100);
                            $("#user").fadeIn(500);


                            $("#user_display_name").val(content.data.userData.displayName);
                            $("#login").val(content.data.userData.login);
                            $("#password").val(content.data.userData.pass);

                            for (var i = 0;i < content.data.instances.length; i++){
                                $('#instance').append('<option value="'+content.data.instances[i].name+'">'+content.data.instances[i].display_name+'</option>');
                            }

                            for (var i = 0;i < content.data.roles.length; i++){
                                $('#role').append('<option value="'+content.data.roles[i].roleName+'">'+content.data.roles[i].displayName+'</option>');
                            }

                            for (var i = 0;i < content.data.userData.activInstances.length; i++){

                                var val = content.data.userData.activInstances[i].inst_name;
                                $('#instance option[value= '+val+']').prop('selected', true);
                            }


                            $('#role option[value= '+content.data.userData.activRole+']').prop('selected', true);


                            $("#user").addClass('active');

                        }

                    } else {
                        console.log(data);
                    }
                }
            });


            $(".AJAX-loading").fadeOut(100);
            $("#remove-instance").prop('disabled', false);
        }
    });

    //Удаление пользователя
    $('#remove-user').click(function(e){
        e.preventDefault();
        var user = {};

        user = {
            "name": $("#user_display_name").val(),
            "login": $("#login").val()

        };


        var request = $.ajax({
            type: "POST",
            url: "/post/request",

            data: {
                action: 'deluser',
                userContent: JSON.stringify(user),
                _csrf: yii.getCsrfToken()
            },
            success: function (data) {
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



                    } else {
                        VanillaToasts.create({
                            title: 'Внимание',
                            text: $.parseJSON(content.mess),
                            type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
                            icon: '', // optional parameter
                            timeout: 5000, // hide after 5000ms, // optional paremter
                            callback: function () {

                            } // executed when toast is clicked / optional parameter
                        });
                        $("#instanceList option:selected").remove();

                        cancellAddUser();
                        $("#usersList option:selected").remove();
                        $("#usersList:first").prop('selected', true);

                    }

                } else {
                    console.log(data);
                }
            }
        });


        $(".AJAX-loading").fadeOut(100);


    });


    // Не итспользуемые...вроде как....
    //
    // $('#pagesList').change(function () {
    //     if ($('#pagesList').val() != undefined) {
    //
    //         var pageId = $("#pagesList option:selected").val();
    //
    //         createEditor(pageId);
    //
    //         $('.materialCard').fadeOut(1000)
    //         $('#' + $('#pagesList').val()).fadeIn(1000);
    //     }
    // });
    //
    // $('.make_edit').click(function (e) {
    //     e.preventDefault();
    //
    //     var form = $(this).parent();
    //     var action = 'editRoot';
    //     var mat_id = $(form).children('#mat-id').val();
    //     var page_type = $(this).parent().attr('formId');
    //     var page_type_name = $(form).children('#page_type_name').val();
    //     ;
    //     var title = $(form).find(('.title')).val();
    //     var keywords = $(form).find(('.Keywords')).val();
    //     var description = $(form).find(('.Description')).val();
    //     var page_content = getDataFromMaterialsEditor();
    //     var activ = 0;
    //     var need_info_line = 0;
    //     var need_commnets = 0;
    //
    //     if ($(form).find($('.isActive')).is(':checked'))
    //         activ = 1;
    //     if ($(form).find($('.isNeedCommnets')).is(':checked'))
    //         need_commnets = 1;
    //     if ($(form).find($('.isNeedInfoLine')).is(':checked'))
    //         need_info_line = 1;
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: action,
    //             mat_id: mat_id,
    //             title: title,
    //             keywords: keywords,
    //             description: description,
    //             page_content: page_content,
    //             activ: activ,
    //             need_info_line: need_info_line,
    //             need_commnets: need_commnets,
    //             page_type: page_type,
    //             page_type_name: page_type_name,
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content['error'] != undefined) {
    //                 if (content['error'] == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //                 } else {
    //                     //alert(data);
    //                     VanillaToasts.create({
    //                         title: content['title'],
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //
    //                     });
    //                     $('.materialCard').fadeOut(1000)
    //                     $("#pagesList").val("empty");
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    // });
    //
    //
    //
    // $('.make_delete').click(function (e) {
    //     e.preventDefault();
    //     var action = 'dellRoot';
    //     var page_type = $(this).parent();
    //     var mat_id = $(page_type).children('#mat-id').val();
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: action,
    //             mat_id: mat_id,
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content['error'] != undefined) {
    //                 if (content['error'] == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //                 } else {
    //                     //alert(data);
    //                     VanillaToasts.create({
    //                         title: content['title'],
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //
    //                     });
    //                     $('.materialCard').fadeOut(1000);
    //
    //                     $('#new_page_title').val("");
    //                     $('#new_page_Keywords').val("");
    //                     $('#new_page_Description').val("");
    //
    //                     var carId = $(this).parent().attr('formId') + "_id_" + mat_id;
    //                     $("#" + carId).remove();
    //                     $("#pagesList  option:selected").remove();
    //
    //                     $("#pagesList").val("empty");
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    //
    // })
    //
    // $(".instance-name").focus(function () {
    //     $(this).removeClass("is-invalid");
    // });
    //
    // $(".instanceForm").on(
    //     "focus", ".title", function () {
    //         $(this).removeClass('is-invalid');
    //     }
    // );
    //
    // $(".instanceForm").on(
    //     "focus", ".destinationType", function () {
    //         $(this).removeClass('is-invalid');
    //     }
    // );
    // $(".instanceForm").on(
    //     "focus", ".destinationPoint", function () {
    //         $(this).removeClass('is-invalid');
    //     }
    // );
    // $(".instanceForm").on(
    //     "click", ".add-sub-instance", function () {
    //
    //         var myElement = $(this).parent();
    //         $(".AJAX-loading").fadeIn(100);
    //
    //         console.log($(myElement).children(".sub-instance-item").length)
    //
    //         if ($(myElement).children(".sub-instance-item").length == 0) {
    //
    //             var addedElement = $(".clear-instance-item").clone().appendTo(myElement);
    //
    //             $(addedElement).addClass("sub-instance-item");
    //             $(addedElement).removeClass("clear-instance-item");
    //             $(this).appendTo(myElement);
    //
    //             $(addedElement).children('.title-group').children(".title").val("");
    //             $(addedElement).children('.destinations-block').children(".destinationType option:selected").remove();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint option:selected").remove();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint").empty();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint").prop('disabled', true);
    //
    //             addedElement = null;
    //
    //         } else {
    //             console.log("ELSE")
    //             var addedElement = $(".clear-instance-item").clone().appendTo(myElement);
    //
    //             $(addedElement).addClass("sub-instance-item");
    //             $(addedElement).removeClass("clear-instance-item");
    //
    //             $(this).appendTo(myElement);
    //
    //             $(addedElement).children('.title-group').children(".title").val("");
    //             $(addedElement).children('.destinations-block').children(".destinationType option:selected").remove();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint option:selected").remove();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint").empty();
    //             $(addedElement).children('.destinations-block').children(".destinationPoint").prop('disabled', true);
    //             addedElement = null;
    //         }
    //
    //         $(".AJAX-loading").fadeOut(100);
    //     }
    // );
    //
    //
    // $('#create_category').click(function (e) {
    //     e.preventDefault();
    //     $('.materialCard').fadeOut(500);
    //     $('#category_form').fadeIn(1000);
    //     $('#category_action').html('Новая категория');
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: 'getCategoriesNames',
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //
    //                     $("#category_id").empty();
    //                     $("#category_id").append('<option value="empty"></option>');
    //                     $("#category_id").append(content.data);
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    //
    //
    // })
    //
    // $('#category_make_edit').click(function (e) {
    //     e.preventDefault();
    //     var categoryId = $('#current_category_id').val();
    //     var categoryName = $('#category_name').val();
    //     var categoryKeyWords = $('#category_kw').val();
    //     var categoryDescriprion = $('#category_description').val();
    //     var categoryActive = '';
    //     var categoryParent = $("#category_id option:selected").text();
    //     if ($('#isCategoryActive').is(':checked'))
    //         categoryActive = 1;
    //
    //     var category = {};
    //
    //     if (categoryName == "undefined" || !categoryName || categoryName.length < 4) {
    //         $('#category_name').addClass("is-invalid");
    //
    //         var toastTitle = "Внимание";
    //         var toastText = "Название категории не может быть пустым или слишком коротко";
    //         var toastType = "warning";
    //         var toastTimeout = 5000;
    //
    //         makeToast(toastTitle, toastText, toastType, toastTimeout);
    //
    //     } else {
    //         $('#category_name').removeClass("is-invalid");
    //         category = {
    //             "categoryId": categoryId,
    //             "categoryName": categoryName,
    //             "categoryKeyWords": categoryKeyWords,
    //             "categoryDescriprion": categoryDescriprion,
    //             "categoryActive": categoryActive,
    //             "categoryParent": categoryParent
    //         };
    //
    //         var request = $.ajax({
    //             type: "POST",
    //             url: "/post/request",
    //
    //             data: {
    //                 action: 'addNewCat',
    //                 data: category,
    //                 _csrf: yii.getCsrfToken()
    //             },
    //             success: function (data) {
    //                 var content = $.parseJSON(data);
    //
    //                 if (content.error != undefined) {
    //                     if (content.error == true) {
    //                         VanillaToasts.create({
    //                             title: 'Внимание',
    //                             text: $.parseJSON(content.mess),
    //                             type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                             icon: '', // optional parameter
    //                             timeout: 5000, // hide after 5000ms, // optional paremter
    //                             callback: function () {
    //
    //                             } // executed when toast is clicked / optional parameter
    //                         });
    //
    //                     } else {
    //                         VanillaToasts.create({
    //                             title: 'Внимание',
    //                             text: $.parseJSON(content.mess),
    //                             type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                             icon: '', // optional parameter
    //                             timeout: 5000, // hide after 5000ms, // optional paremter
    //                             callback: function () {
    //
    //                             } // executed when toast is clicked / optional parameter
    //                         });
    //                         $("#categoryList option[value='empty']").attr("selected", "selected");
    //                         $('.materialCard').fadeOut(500);
    //                         $('#category_action').val('');
    //                         $('#category_name').val('');
    //                         $('#category_kw').val('');
    //                         $('#category_description').val('');
    //                         $("#category_id").empty();
    //                         $('#isCategoryActive').prop('checked', false);
    //
    //
    //                     }
    //
    //                 } else {
    //                     console.log(data);
    //                 }
    //             }
    //         });
    //     }
    //
    // })
    //
    // $('#category_make_delete').click(function (e) {
    //     e.preventDefault();
    //     var catId = $("#current_category_id").val();
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: 'removeCat',
    //             data: catId,
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //                     $('.materialCard').fadeOut(500);
    //                     $("#categoryList option[value='empty']").attr("selected", "selected");
    //                     $("#categoryList option[value='" + catId + "']").remove();
    //
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    // })
    //
    // $('#categoryList').change(function (e) {
    //     e.preventDefault();
    //     var categoryForEdit = $("#categoryList option:selected").val();
    //
    //     if (categoryForEdit == "empty") {
    //         return false;
    //     }
    //
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: 'getCategoriesNames',
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //
    //                     $("#category_id").empty();
    //                     $("#category_id").append('<option value="empty"></option>');
    //                     $("#category_id").append(content.data);
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    //
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: 'getCatForEdit',
    //             data: categoryForEdit,
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //
    //                     $('.materialCard').fadeOut(500);
    //                     $('#category_form').fadeIn(1000);
    //
    //                     $('#category_action').html("Редактируем категорю '" + content.data.category_name + "'");
    //                     $('#category_name').val(content.data.category_name);
    //                     $('#category_kw').val(content.data.keywords);
    //                     $('#category_description').val(content.data.description);
    //                     $("#current_category_id").val(content.data.id);
    //                     if (content.data.is_active == 1)
    //                         $('#isCategoryActive').prop('checked', true);
    //                     else
    //                         $('#isCategoryActive').prop('checked', false);
    //
    //                     var id = content.data.parent_id;
    //                     if (content.data.is_parent == 1)
    //                         $("#category_id option[value='" + id + "']").attr("selected", "selected");
    //
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    // })
    //
    // $('#create_good').click(function (e) {
    //     e.preventDefault();
    //     $('.materialCard').fadeOut(500);
    //     $('#good_form').fadeIn(1000);
    //     $('#good_action').html('Новый товар');
    //
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //
    //         data: {
    //             action: 'getCategoriesNames',
    //             _csrf: yii.getCsrfToken()
    //         },
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //                     $("#good_category").empty();
    //                     $("#good_category").append('<option value="empty"></option>');
    //                     $("#good_category").append(content.data);
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    //
    // })
    //
    // $('#good_make_edit').click(function (e) {
    //     e.preventDefault();
    //     var query = {};
    //     query.goodName = $('#good_name').val();
    //     query.photos = '';
    //     query.goodCategory = $('#good_category option:selected').val();
    //     query.goodPrice = $('#good_price').val();
    //     query.goodSelfPrice = $('#good_self_price').val();
    //     query.goodAnons = $('#good_anons').val();
    //     query.goodDescription = $('#good_description').val();
    //     query.goodMetaKw = $('#good_meta_kw').val();
    //     query.goodMetaDescription = $('#good_meta_description').val();
    //
    //     query.activeGood = 0;
    //     query.topGood = 0;
    //     query.newGood = 0;
    //     query.isComments = 0;
    //     query.isInfoLine = 0;
    //
    //
    //     if ($('.isActive').is(':checked'))
    //         query.activeGood = 1;
    //
    //     if ($('.is_top').is(':checked'))
    //         query.topGood = 1;
    //
    //
    //     if ($('.is_new').is(':checked'))
    //         query.newGood = 1;
    //
    //
    //     query.availability = $('#availability').val();
    //
    //     if ($('.isComments').is(':checked'))
    //         query.isComments = 1;
    //
    //     if ($('.isInfoLine').is(':checked'))
    //         query.isInfoLine = 1;
    //
    //     query.currentGoodId = $('#current_good_id').val();
    //     query.action = 'addNewGood';
    //
    //     var good = new FormData();
    //
    //
    //     var files = [];
    //
    //     jQuery.each(queue, function (key, element) {
    //         files.push(element);
    //     })
    //
    //     jQuery.each(files, function (i, file) {
    //         good.append(i, file);
    //     });
    //
    //     $.each(query, function (key, value) {
    //
    //         good.append(key, value);
    //     });
    //
    //
    //     var request = $.ajax({
    //         type: "POST",
    //         url: "/post/request",
    //         data: good,
    //         _csrf: yii.getCsrfToken(),
    //         cache: false,
    //         dataType: 'json',
    //         processData: false, // Не обрабатываем файлы (Don't process the files)
    //         contentType: false, // Так jQuery скажет серверу что это строковой запрос
    //
    //         success: function (data) {
    //             var content = $.parseJSON(data);
    //
    //             if (content.error != undefined) {
    //                 if (content.error == true) {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //
    //                 } else {
    //                     VanillaToasts.create({
    //                         title: 'Внимание',
    //                         text: $.parseJSON(content.mess),
    //                         type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
    //                         icon: '', // optional parameter
    //                         timeout: 5000, // hide after 5000ms, // optional paremter
    //                         callback: function () {
    //
    //                         } // executed when toast is clicked / optional parameter
    //                     });
    //                     $('.materialCard').fadeOut(500);
    //
    //
    //                     $("#good_category option[value='empty']").attr("selected", "selected");
    //                     $('#good_name').val('');
    //                     $('#good_category option:selected').val('');
    //                     $('#good_price').val('');
    //                     $('#good_self_price').val('');
    //                     $('#good_anons').val('');
    //                     $('#good_description').val('');
    //                     $('#good_meta_kw').val('');
    //                     $('#good_meta_description').val('');
    //                     $('#current_good_id').val('');
    //                     $('.isActive').prop('checked', false);
    //                     $('.is_top').prop('checked', false);
    //                     $('.is_new').prop('checked', false);
    //                     $('#availability').val('');
    //                     $('.isComments').prop('checked', false);
    //                     $('.isInfoLine').prop('checked', false);
    //                     $('#current_good_id').val('');
    //                     $('#uploadImagesList').fadeOut(500);
    //                     $('#uploadImagesList li:not(:first)').remove();
    //
    //
    //                 }
    //
    //             } else {
    //                 console.log(data);
    //             }
    //         }
    //     });
    //
    //
    // })
    //
    // $('#create_delivery').click(function (e) {
    //     e.preventDefault();
    //     $('.materialCard').fadeOut(500);
    //     $('#delivery_form').fadeIn(1000);
    //     $('#delivery_action').html('Новый способ доставки');
    //
    // })
    //
    $('.close').click(function (e) {
        e.preventDefault();
        $('.materialCard').fadeOut(500);
    })

});

var queue = {};


function makeToast(title,text,type,timeout){
    VanillaToasts.create({
        title: title,
        text: text,
        type: type, // success, info, warning, error   / optional parameter
        icon: '', // optional parameter
        timeout: timeout, // hide after 5000ms, // optional paremter
        callback: function () {

        } // executed when toast is clicked / optioninstanceListal parameter
    });
}

$(".cancel-add-instance").click(function (e) {
    e.preventDefault();
    cancellAddinstance();
})



$(this).keydown(function(eventObject){
    if (eventObject.which == 27){
        cancellAddinstance();
    }
});

function clearNewinstance() {
    $('.instanceForm .instance-item:not(:first)').remove();
    $('.instance-name').val('');
    $('.title').val('');
    $('.destinationType :first').attr("selected", "selected");
    $('.destinationPoint :first').attr("selected", "selected");
}

function cancellAddinstance() {

    $('#create_instance').prop('disabled', false)
    setTimeout( function(){
        $("#add_instance").fadeOut(500);
        setTimeout(function (){
            clearNewinstance();
        },500);
    },0);
    $("#add_instance").removeClass('active');

}

function cancellAddUser() {

    $('#create_user').prop('disabled', false)
    setTimeout( function(){
        $("#user").fadeOut(500);
        setTimeout(function (){
            clearNewinstance();
        },500);
    },0);
    $("#user").removeClass('active');

}


function urlLit(w,v) {
    var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
    var ww=''; w=w.toLowerCase();
    for(i=0; i<w.length; ++i) {
        cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]);
        if(ch.length<3) ww+=ch; else ww+=eval(ch)[v];
    }
    return(ww.replace(/[^a-zA-Z0-9\-]/g,'-').replace(/[-]{2,}/gim, '-').replace( /^\-+/g, '').replace( /\-+$/g, ''));

}

function parse_url(url){
    // example 1: parse_url('http://example.com:3000/pathname/?search=test#hash');
    // returns 1: {protocol: 'http:', hostname: 'example.com', port: '3000', pathname: '/pathname/', search: '?search=test', hash: '#hash', host: 'example.com:3000'}

    var parser = document.createElement('a');
    parser.href = url;

    return parser;
}

