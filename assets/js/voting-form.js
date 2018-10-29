$(document).ready(function () {
    $('.ticker_click').on("click", function(elem){
        if($('#is-finalised').val() !== '1' && $('#allow-edit').val() === '1'){
            $.post('/submit-voting', {
                ic_date: $('#voting_ic_date').val(),
                masterID: $('#masterID').val(),
                user_id: $('#user_id').val(),
                factor: $(this).attr("data-factor"),
                vote: $(this).attr("data-value"),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })
        }
    });


    $('#factor_5').on('change', function(){
        if($('#is-finalised').val() !== '1'  && $('#allow-edit').val() === '1') {
            $('#factor_label_5').html(Math.round($(this).val()));
            $.post('/submit-voting', {
                ic_date: $('#voting_ic_date').val(),
                masterID: $('#masterID').val(),
                user_id: $('#user_id').val(),
                factor: 5,
                vote: $(this).val() / 10,
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            })
        }
    });

    $('#save_vetoComment').on('click', function(){
        if($('#is-finalised').val() !== '1'  && $('#allow-edit').val() === '1') {
            $.post('/submit-master-veto', {
                factor: 'veto',
                vote: $("#veto-data-value").attr("data-value"),
                comment: $("#textarea-veto").val(),
                user_id: $('#user_id').val(),
                masterID: $('#masterID').val(),
                ic_date: $('#voting_ic_date').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
                $('#veto-save-comment').removeClass('hidden');
                setTimeout(function () {
                    $('#veto-save-comment').addClass('hidden');
                }, 3000);
            });
        }

    });

    //Switcher function:
    $("#voting-finalised").on('click', function () {
       // if( $('#allow-edit').val() === '1') {
            let isChecked  = $(this). prop("checked") == true ? 1:0;
            $.post('/submit-master-finalise', {
                finalised: isChecked,
                user_id: $('#user_id').val(),
                masterID: $('#masterID').val(),
                ic_date: $('#voting_ic_date').val(),
                csnamerf: $.cookie('csrfcookiename')
            }).done(function (data) {
            });

            location.reload();
       // }
    });

});
function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}
