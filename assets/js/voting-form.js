
if ($('#rb-8').find(".rb-tab").attr("data-value") == 1) {
    for (let i = 1; i < 8; i++) {
        $('#rb-' + i).addClass('disable-row');
    }
}
//Switcher function:
$(".rb-tab").click(function () {
    //Spot switcher:
    if ($(this).parent()[0].id !== 'rb-7' && $(this).parent()[0].id !== 'rb-8') {
        $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
        $(this).addClass("rb-tab-active");
        if ($(this).parent()[0].id === 'rb-1') {
            $.post('/submit_voting', {
                fc1: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })
        }
        if ($(this).parent()[0].id === 'rb-2') {
            $.post('/submit_voting', {
                fc2: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })

        }
        if ($(this).parent()[0].id === 'rb-3') {
            $.post('/submit_voting', {
                fc3: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })

        }
        if ($(this).parent()[0].id === 'rb-4') {
            $.post('/submit_voting', {
                fc4: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })

        }
        if ($(this).parent()[0].id === 'rb-5') {
            $.post('/submit_voting', {
                fc5: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })
        }
        if ($(this).parent()[0].id === 'rb-6') {
            $.post('/submit_voting', {
                fc6: $(this).attr('data-value'),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })
        }
    }
    else if ($(this).parent()[0].id === 'rb-7') {
        $('#rb-7').toggleClass(function () {
            $(this).find('span').text($(this).find('span').text() === 'No' ? 'Yes' : 'No');
            $(this).find(".rb-tab").attr("data-value", $(this).find(".rb-tab").attr("data-value") == 1 ? 0 : 1);

            $.post('/submit_voting', {
                veto: $(this).find(".rb-tab").attr("data-value"),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            });
            if ($(this).hasClass(".rb-tab-active")) {
                return "";
            } else {
                return "rb-tab-active";
            }
        });
        $(".tarea").toggleClass("hidden");

    }
    else if ($(this).parent()[0].id === 'rb-8') {
        $('#rb-8').toggleClass(function () {
            $(this).find('span').text($(this).find('span').text() === 'No' ? 'Yes' : 'No');
            $(this).find(".rb-tab").attr("data-value", $(this).find(".rb-tab").attr("data-value") == 1 ? 0 : 1);
            if ($('#rb-8').find(".rb-tab").attr("data-value") == 1) {
                for (let i = 1; i < 8; i++) {
                    $('#rb-' + i).addClass('disable-row');
                }
            }
            else{
                for (let i = 1; i < 8; i++) {
                    $('#rb-' + i).removeClass('disable-row');
                }

            }
            $.post('/submit_voting', {
                finalised: $(this).find(".rb-tab").attr("data-value"),
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            });
            if ($(this).hasClass(".rb-tab-active")) {
                return "";
            } else {
                return "rb-tab-active";
            }
        });
    }
});
