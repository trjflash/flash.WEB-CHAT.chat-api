function parseMessage(message) {
	switch(message.type) {
		case 'image':
			if(message.caption != undefined) return '<a target="_blank" href="' + message.body + '" class="lightbox" data-lightbox="img"><img src="' + message.body + '" class="mes-img"/></a>' + message.caption;
			else return '<a target="_blank" href="' + message.body + '" class="lightbox" data-lightbox="img"><img src="' + message.body + '" class="mes-img"/></a>';
			break;
		case 'ptt':
		case 'audio':
			return '<audio class="audio" src="' + message.body + '" controls=""></audio>';
			break;
		case 'chat':
			return message.body;
			break;
		case 'location':
			var location = message.body.split(';')
			return '<a target="_blank" href="https://www.google.com/maps?q=' + location[0] + ',' + location[1] + '&z=17&hl=ru">Геолокация</a>';
			break;
		case 'vcard':
			var vcard = vCardParser.parse(message.body);
			return "Парсер контакта подготовлен но пока не работает =(";
			break;
		case 'document':
			return '<a target="_blank" href="' + message.body + '">' + message.caption + '</a>';
			break;
		case 'video':
			return "Видео к сожалению не поддерживается =(";
			break;
	}
}

function parseQuotedMessage(message) {
	var quotedMessage = $("div[id='" + message.quotedMsgId + "'").children('.message-main-receiver').children('.receiver').children('.message-text').html();
	return "<div href='#" + message.quotedMsgId + "' class='quoted'>" + quotedMessage + "</div>" + message.body;
}

function parseForwardedMessage(message) {
	var forwardHead = "<div class=\"forwarded-message\">\n" + "    <span><i class=\"fa fa-share\" aria-hidden=\"true\"></i> Пересылаемое сообщение</span>";
	var forwardEnd = "</div>";
	switch(message.type) {
		case 'image':
			return forwardHead + '<a target="_blank" href="' + message.body + '" class="lightbox" data-lightbox="img"><img src="' + message.body + '" class="mes-img lightzoom"/></a>' + forwardEnd;
			break;
		case 'ptt':
		case 'audio':
			return forwardHead + '<audio class="audio" src="' + message.body + '" controls=""></audio>' + forwardEnd;
			break;
		case 'chat':
			return forwardHead + message.body + forwardEnd;
			break;
		case 'location':
			var location = message.body.split(';')
			return forwardHead + '<a target="_blank" href="https://www.google.com/maps?q=' + location[0] + ',' + location[1] + '&z=17&hl=ru">Геолокация</a>' + forwardEnd;
			break;
		case 'vcard':
			var vcard = vCardParser.parse(message.body);
			return forwardHead + "Парсер контакта подготовлен но пока не работает =(" + forwardEnd;
			break;
		case 'document':
			return forwardHead + '<a target="_blank" href="' + message.body + '">' + message.caption + '</a>' + forwardEnd;
			break;
		case 'video':
			return forwardHead + "Видео к сожалению не поддерживается =(" + forwardEnd;
			break;
	}
}
$(document).ready(function() {
	$('#main-page-carousel').owlCarousel({
		loop: true, //Зацикливаем слайдер
		margin: 50, //Отступ от элемента справа в 50px
		nav: false, //Отключение навигации
		dots: false,
		autoplay: true, //Автозапуск слайдера
		smartSpeed: 1000, //Время движения слайда
		autoplayTimeout: 3000, //Время смены слайда
		autoplayHoverPause: false,
		responsive: { //Адаптивность. Кол-во выводимых элементов при определенной ширине.
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
	$('.side .sideBar').on("click", ".sideBar-body", function() {
		$('.conversation').fadeOut(500);
		var chatId = $(this).attr('id');
		var chatName = $(this).children('.sideBar-main').children('.row').children('.sideBar-name').children('.name-meta').text();
		var chatImg = $(this).children('.sideBar-avatar').children('.avatar-icon').children('img').attr("src");
		var hasNew = ('.has-new');
		$(this).find(hasNew).css("display", 'none');
		getChatMessages(chatId, chatName, chatImg);
	});
	$('#new-chat-input').keydown(function(event) {
		if(event.keyCode == 13) {
			event.preventDefault();
			let number = $(this).val();
			if(number.length === 0 || isNaN(number) || number.length < 11) {
				VanillaToasts.create({
					title: 'Внимание',
					text: "Номер должен содержать 11 цифр первая 7",
					type: "info", // success, info, warning, error   / optional parameter
					icon: '', // optional parameter
					timeout: 5000, // hide after 5000ms, // optional paremter
					callback: function() {} // executed when toast is clicked / optional parameter
				});
				return false;
			} else {
				var chatId = number + '@c.us';
				var chatName = number;
				var chatImg = '<i class="fa fa-user-circle-o" aria-hidden="true"></i>';
				$(this).val('');
				getChatMessages(chatId, chatName, chatImg);
			}
		}
	})
	$(".reply-main textarea").keydown(function(event) {
		if(event.keyCode == 13) {
			event.preventDefault();
			sendMessage();
		}
	})
	$(".reply-send svg").click(function(e) {
		e.preventDefault();
		sendMessage();
	})
	$('#conversation').everyTime(5000, function() {
		if($('#conversation').hasClass('active')) {
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
				data: {
					action: 'getNewMessagesInChat',
					requestBody: data,
					_csrf: yii.getCsrfToken()
				},
				success: function(data) {
					var content = $.parseJSON(data);
					if(content.error != undefined) {
						if(content.error == true) {
							VanillaToasts.create({
								title: 'Внимание',
								text: $.parseJSON(content.mess),
								type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
								icon: '', // optional parameter
								timeout: 5000, // hide after 5000ms, // optional paremter
								callback: function() {} // executed when toast is clicked / optional parameter
							});
						} else {
							if(content.data != "NO MESSAGES (((") {
								var messages = content.data.messages;
								for(var i = 0; i < messages.length; i++) {
									//console.log(messages[i].fromMe);
									if(messages[i].fromMe == 0) {
										var date = new Date(messages[i].time * 1000);
										var formattedDate = date.format('d-m-Y h:i');
										var itemPreviewTemplate = '';
										itemPreviewTemplate = $('#conversation').children('.receiver-template').clone();
										itemPreviewTemplate.removeClass('receiver-template');
										itemPreviewTemplate.addClass('injected-message');
										itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.messenger-name').html(messages[i].senderName);
										if(messages[i].quotedMsgId != null) itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseQuotedMessage(messages[i]));
										else if(messages[i].isForwarded == 1) itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseForwardedMessage(messages[i]));
										else itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseMessage(messages[i]));
										itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-time').html(formattedDate);
										itemPreviewTemplate.appendTo('#conversation');
										$('.last-message').removeClass('last-message')
										if(i == messages.length - 1) {
											itemPreviewTemplate.addClass('last-message');
											itemPreviewTemplate.children('.raw-time').val(messages[i].time);
											itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);
										}
										$('#conversation').scrollTop(10000000);
									}
								}
							}
						}
					} else {
						console.log(data);
					}
				}
			});
		}
	})
	$('.sideBar').everyTime(5000, function() {
		var request = $.ajax({
			type: 'POST',
			url: '/post/request',
			data: {
				action: 'checkNewMessages',
				_csrf: yii.getCsrfToken()
			},
			success: function(data) {
				var content = $.parseJSON(data);
				if(content.error != undefined) {
					if(content.error == true) {
						VanillaToasts.create({
							title: 'Внимание',
							text: $.parseJSON(content.mess),
							type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
							icon: '', // optional parameter
							timeout: 5000, // hide after 5000ms, // optional paremter
							callback: function() {} // executed when toast is clicked / optional parameter
						});
					} else {
						if(content.data != "NO MESSAGES (((") {
							var messages = content.data.messages;
							for(var i = 0; i < messages.length; i++) {
								var chatBlock = $('[id = "' + messages[i].chatId + '"]');
								if(chatBlock.length != 0) {
									//console.log(chatBlock.length);
									chatBlock = $(chatBlock).clone();
									$('[id = "' + messages[i].chatId + '"]').remove();
									$(".sideBar").prepend(chatBlock);
									if($('.current-chat-id').val() != messages[i].chatId) {
										var hasNew = ('.has-new');
										$(chatBlock).find(hasNew).css("display", 'block');

									}
								} else {
									chatBlock = $('.sideBar-body')[0];
									chatBlock = $(chatBlock).clone();
									var data = {};
									data = {
										"chatId": messages[i].chatId
									};
									var request = $.ajax({
										type: 'POST',
										url: '/post/request',
										data: {
											action: 'getChatInfo',
											requestBody: data,
											_csrf: yii.getCsrfToken()
										},
										success: function(data) {
											var content = $.parseJSON(data);
											if(content.error != undefined) {
												if($('.current-chat-id').val() != content.data.id) {
													if(content.error == true) {
														VanillaToasts.create({
															title: 'Внимание',
															text: $.parseJSON(content.mess),
															type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
															icon: '', // optional parameter
															timeout: 5000, // hide after 5000ms, // optional paremter
															callback: function() {} // executed when toast is clicked / optional parameter
														});
													} else {
														$(chatBlock).children('.sideBar-avatar').children('.avatar-icon').children().attr('src', content.data.image);
														$(chatBlock).children('.sideBar-main').children('.row').children('.sideBar-name').children('.name-meta').html(content.data.name);
														$(chatBlock).attr(["id", content.data.id]);
														$('.sideBar').prepend(chatBlock);
														$('[id = "' + content.data.id + '"]').find(hasNew).css("display", 'block');
													}
												}
											} else {
												console.log(data);
											}
										}
									});
								}
							}
						}
					}
				} else {
					console.log(data);
				}
			}
		});

	})

	$('.popup-close').click(function() {
		$(this).parents('.popup-fade').fadeOut();
		return false;
	});
	$('.popup-fade').click(function(e) {
		if($(e.target).closest('.popup').length == 0) {
			$(this).fadeOut();
		}
	});

	$('.heading-dot').click(function() {
		$('.popup-fade').fadeIn();
		return false;
	});
	$('#upload-telephones').change(function(){
		files = this.files;

		var query = {};

		query['_csrf'] = yii.getCsrfToken();
		query['action'] = 'uploadPhonesList';

		var data = new FormData();
		$.each( files, function( key, value ){
			data.append( key, value );
		});
		$.each( query, function( key, value ){
			data.append( key, value );
		});
		var request = $.ajax({
			type: "POST",
			url: "/post/request",
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Не обрабатываем файлы (Don't process the files)
			contentType: false, // Так jQuery скажет серверу что это строковой запрос
			success: function(data) {
				$('#upload-telephones').prop('value', null);
				var content = $.parseJSON(data);
				if(content.error != undefined) {
					if(content.error == true) {
						VanillaToasts.create({
							title: 'Внимание',
							text: $.parseJSON(content.mess),
							type: $.parseJSON(content.error_level), // success, info, warning, error   / optional parameter
							icon: '', // optional parameter
							timeout: 5000, // hide after 5000ms, // optional paremter
							callback: function() {} // executed when toast is clicked / optional parameter
						});
					} else {
						console.log(content);

					}
				} else {
					console.log(data);
				}
			}
		});




	});



});

function sendMessage() {
	var message = $('#comment').val();
	var chatId = $('.current-chat-id').val();
	var query = {};
	query.action = 'sendMessInCHat';
	query.chatId = chatId;
	query.message = message;
	query._csrf = yii.getCsrfToken();

	var data = new FormData();

	if(message.length == 0 && $('.upload-file')[0].files[0] == undefined) {
		VanillaToasts.create({
			title: 'Внимание',
			text: "Сообщение не может быть пустым",
			type: "info", // success, info, warning, error   / optional parameter
			icon: '', // optional parameter
			timeout: 5000, // hide after 5000ms, // optional paremter
			callback: function() {} // executed when toast is clicked / optional parameter
		});
		return false;
	}
	$('#comment').val('');
	$.each(query, function(key, value) {
		data.append(key, value);
	});
	var files = [];
	$.each($('.upload-file')[0].files, function(i, element) {
		files.push(element);
	});
	$.each(files, function(key, value) {
		data.append(key, value);
	});
	var request = $.ajax({
		type: "POST",
		url: "/post/request",
		data: data,
		cache: false,
		dataType: 'json',
		processData: false, // Не обрабатываем файлы (Don't process the files)
		contentType: false, // Так jQuery скажет серверу что это строковой запрос
		success: function(data) {
			var content = data;
			if(content.error != undefined) {
				if(content.error == true) {
					VanillaToasts.create({
						title: 'Внимание',
						text: content.mess,
						type: content.error_level, // success, info, warning, error   / optional parameter
						icon: '', // optional parameter
						timeout: 5000, // hide after 5000ms, // optional paremter
						callback: function() {} // executed when toast is clicked / optional parameter
					});
				} else {
					$('.upload-file').prop('value', null);
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
			} else {
				console.log(data);
			}
		}
	});


}
$(function() {
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

function getChatMessages(chatId, chatName, chatImg) {
	$('.upload-file').prop('value', null);
	$('.conversation').fadeOut(500);
	var request = $.ajax({
		type: "POST",
		url: "/post/request",
		data: {
			action: 'getBotMessagesByCHatId',
			chatId: chatId,
			_csrf: yii.getCsrfToken()
		},
		success: function(data) {
			var content = $.parseJSON(data);
			if(content.error != undefined) {
				if(content.error == true) {
					VanillaToasts.create({
						title: 'Внимание',
						text: content.mess,
						type: content.error_level, // success, info, warning, error   / optional parameter
						icon: '', // optional parameter
						timeout: 5000, // hide after 5000ms, // optional paremter
						callback: function() {} // executed when toast is clicked / optional parameter
					});
				} else {
					var messages = content.data.messages;
					var conversationBlock = $('#conversation');
					$('.heading-name-meta').html(chatName);
					$('.current-chat-id').val(chatId);
					$('.heading-avatar-icon').children('img').attr("src", chatImg);
					//console.log(conversationBlock);
					$('.injected-message').remove();
					for(var i = 0; i < messages.length; i++) {
						var timestampInMilliSeconds = messages[i].time * 1000;
						var date = new Date(timestampInMilliSeconds);
						var formattedDate = date.format('d-m-Y h:i');
						var itemPreviewTemplate = '';
						if(messages[i].fromMe == true) {
							itemPreviewTemplate = conversationBlock.children('.sender-template').clone();
							itemPreviewTemplate.removeClass('sender-template');
							itemPreviewTemplate.addClass('injected-message');
							itemPreviewTemplate.attr('id', messages[i].id);
							itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.messenger-name').html(messages[i].senderName);
							if(messages[i].quotedMsgId != null) itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(parseQuotedMessage(messages[i]));
							else if(messages[i].isForwarded == 1) itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(parseForwardedMessage(messages[i]));
							else itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-text').html(parseMessage(messages[i]));
							itemPreviewTemplate.children('.message-main-sender').children('.sender').children('.message-time').html(formattedDate);
							itemPreviewTemplate.appendTo('#conversation');
							if(i == messages.length - 1) {
								itemPreviewTemplate.addClass('last-message');
								itemPreviewTemplate.children('.raw-time').val(timestampInMilliSeconds / 1000);
								itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);
							}
						} else {
							itemPreviewTemplate = conversationBlock.children('.receiver-template').clone();
							itemPreviewTemplate.removeClass('receiver-template');
							itemPreviewTemplate.addClass('injected-message');
							itemPreviewTemplate.attr('id', messages[i].id);
							itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.messenger-name').html(messages[i].senderName);
							if(messages[i].quotedMsgId != null) itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseQuotedMessage(messages[i]));
							else if(messages[i].isForwarded == 1) itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseForwardedMessage(messages[i]));
							else itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-text').html(parseMessage(messages[i]));
							itemPreviewTemplate.children('.message-main-receiver').children('.receiver').children('.message-time').html(formattedDate);
							itemPreviewTemplate.appendTo('#conversation');
							if(i == messages.length - 1) {
								itemPreviewTemplate.addClass('last-message');
								itemPreviewTemplate.children('.raw-time').val(timestampInMilliSeconds / 1000);
								itemPreviewTemplate.children('.last-message-id').val(messages[i].messageNumber);
							}
						}
					}
					$('.lightbox').lightBox();
					$('.chat-owerflow').fadeOut(500);
					$('.conversation').fadeIn(1000);
					conversationBlock.addClass('active');
					$('#conversation').scrollTop(999999999999);
				}
			} else {
				console.log(data);
			}
		}
	});
}