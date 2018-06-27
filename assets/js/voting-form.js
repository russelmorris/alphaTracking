//Global:
let results = [];

//Switcher function:
$(".rb-tab").click(function () {
    //Spot switcher:
    $(this).parent().find(".rb-tab").removeClass("rb-tab-active");
    $(this).addClass("rb-tab-active");
    if ($(this).parent()[0].id === 'rb-6') {
        $(this).toggleClass('rb-tab-active');
        if($(this).hasClass('rb-tab-active')){
            $(this).removeClass("rb-tab-active");
        }
        else{
            $(this).addClass("rb-tab-active");
        }

        $(".tarea").toggleClass("hidden");
    }
});

//Save data:
$(".trigger").click(function () {
    //Empty array:
    results = [];
    //Push data:
    for (let i = 1; i <= $(".rb").length; i++) {
        let rbValue = parseInt($("#rb-" + i).find(".rb-tab-active").attr("data-value"));
        if (i === 5) {
            let text = $("#rb-" + i).find("input").val();
            results.push(JSON.stringify({answer: rbValue, message: text}));
        }
        else if (i === 6) {
            let text = $("#rb-" + i).find("textarea").val();
            results.push(JSON.stringify({answer: rbValue, message: text}));
        }
        else
            results.push(rbValue);
    }

    $.post('/submit_voting', {
        results: JSON.stringify(results),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        console.log(data);
    })

});
