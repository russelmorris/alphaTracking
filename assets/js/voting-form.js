//Switcher function:
$(".rb-tab").click(function () {
    //Spot switcher:
    if ($(this).parent()[0].id !== 'rb-7' && $(this).parent()[0].id !== 'rb-8') {
        $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
        $(this).addClass("rb-tab-active");
    }
    else if ($(this).parent()[0].id === 'rb-7') {
        $('#rb-7').toggleClass(function () {
            $(this).find('span').text($(this).find('span').text() === 'No' ? 'Yes' : 'No');
            $(this).find(".rb-tab").attr("data-value", $(this).find(".rb-tab").attr("data-value") == 1 ? 0 : 1);
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
            if ($(this).hasClass(".rb-tab-active")) {
                return "";
            } else {
                return "rb-tab-active";
            }
        });
        if ($('#rb-8').find(".rb-tab").attr("data-value") == 1) {
            $('.rb-tab').each(function () {
                $(this).attr('disabled', 'disabled')
            })
        }

    }
});

//Save data:
$(".trigger").click(function () {
    //Empty array:
    let results = [], veto, finalise;
    //Push data:
    for (let i = 1; i <= $(".rb").length; i++) {
        let id = $("#rb-" + i);
        let rbValue = parseInt(id.find(".rb-tab-active").attr("data-value"));
        if (i === 6) {
            let text = id.find("input").val();
            let obj = {risk: {answer: rbValue, message: text}};
            results.push(JSON.stringify(obj));
        }
        else if (i === 7) {
            let text = id.find("textarea").val();
            rbValue = parseInt(id.find(".rb-tab").attr("data-value"));
            veto = JSON.stringify({answer: rbValue, message: text});
        }
        else if (i === 8) {
            rbValue = parseInt(id.find(".rb-tab").attr("data-value"));
            finalise = rbValue;
        }
        else {
            results.push(rbValue);
        }

    }

    $.post('/submit_voting', {
        results: JSON.stringify(results),
        user_id: $('#user_id').val(),
        ticker: $('#ticker').val(),
        veto: veto,
        finalise: finalise,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        console.log(data);
    })

});
