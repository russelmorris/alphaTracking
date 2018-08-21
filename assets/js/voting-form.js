$(document).ready(function () {
    $('.ticker_click').on("click", function(elem){

        $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
        $(this).addClass('rb-tab-active');
        $.post('/submit-voting', {
            ic_date: $('#voting_ic_date').val(),
            ticker: $('#ticker').val(),
            user_id: $('#user_id').val(),
            factor: $(this).attr("data-factor"),
            vote: $(this).attr("data-value"),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
        })
    });

    $('#save_vetoComment').on('click', function(){
        $.post('/submit-master-veto', {
            factor: 'veto',
            vote: $("#veto-data-value").attr("data-value"),
            comment: $("#textarea-veto").val(),
            user_id: $('#user_id').val(),
            ticker: $('#ticker').val(),
            ic_date: $('#voting_ic_date').val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            $('#veto-save-comment').removeClass('hidden');
            setTimeout(function () {
                $('#veto-save-comment').addClass('hidden');
            }, 3000);
        });

    });

    $('.veto_click').on("click", function(elem) {
           $('#veto').toggleClass(function () {
                $(this).find('span').text($(this).find('span').text() === 'No' ? 'Yes' : 'No');
                $(this).find(".rb-tab").attr("data-value", $(this).find(".rb-tab").attr("data-value") == 1 ? 0 : 1);
               $.post('/submit-master-veto', {
                   factor: 'veto',
                   vote: $("#veto-data-value").attr("data-value"),
                   comment: $("#veto-data-value").attr("data-value") ===  1 ? $("#textarea-veto").val() : null,
                   user_id: $('#user_id').val(),
                   ticker: $('#ticker').val(),
                   ic_date: $('#voting_ic_date').val(),
                   csnamerf: $.cookie('csrfcookiename')
               }).done(function (data) {
               });
                if ($(this).hasClass(".rb-tab-active")) {
                    return "";
                } else {
                    return "rb-tab-active";
                }
            });
            $(".veto_togle").toggleClass("hidden");
    });




    $('#deepDiveComment').on('click', function(){
        $.post('/submit-master-deep-dive', {
            factor: 'deepDive',
            vote: $("#deep-dive-data-value").attr("data-value"),
            comment: $("#textarea-deep-dive").val(),
            user_id: $('#user_id').val(),
            ticker: $('#ticker').val(),
            ic_date: $('#voting_ic_date').val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            $('#deep-dive-save-comment').removeClass('hidden');
            setTimeout(function () {
                $('#deep-dive-save-comment').addClass('hidden');
            }, 3000);
        });
    });

    $('.deep_dive_click').on("click", function(elem) {
        $('#deep-dive').toggleClass(function () {
            $(this).find('span').text($(this).find('span').text() === 'No' ? 'Yes' : 'No');
            $(this).find(".rb-tab").attr("data-value", $(this).find(".rb-tab").attr("data-value") == 1 ? 0 : 1);
            $.post('/submit-master-deep-dive', {
                factor: 'deepDive',
                vote:$("#deep-dive-data-value").attr("data-value"),
                comment: $("#deep-dive-data-value").attr("data-value") == 1 ? $("#textarea-deep-dive").val() : null,
                user_id: $('#user_id').val(),
                ticker: $('#ticker').val(),
                ic_date: $('#voting_ic_date').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            });
            if ($(this).hasClass(".rb-tab-active")) {
                return "";
            } else {
                return "rb-tab-active";
            }
        });
        $(".deep_dive_togle").toggleClass("hidden");
    });


});
