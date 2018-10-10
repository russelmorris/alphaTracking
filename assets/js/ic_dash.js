function final_value() {
    $('#prospectCount').html('');
    $('#portfolioCount').html('');
    $.post('/finalised-value', {
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        let returnData = JSON.parse(data);
        $('#finalised-label').text(returnData.percent + "% Finalised");
        $('#finalised-label-value').val(returnData.percent);
        $('#finalised-value').prop('aria-valuenow', returnData.percent).css('width', returnData.percent + '%');
        $('#prospectCount').html(returnData.prospectCount);
        $('#portfolioCount').html(returnData.portfolioCount);

        if (parseInt(returnData.percent) == 100){
            $('#finalize-all').val(' Unfinalize all');
        } else {
            $('#finalize-all').val('Finalize all');
        }

    }).fail(function (err) {

    });

}

function updateTicker(masterID, factor, value, element) {

    $.post('/update-factor', {
        masterID: masterID,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        factor: factor,
        value: value,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
       if (factor === 5) {
           $(element).siblings('span:first').html(value*10);
       } else {
           $(element).siblings('span:first').html(Math.round(value));
       }
        refreshTableData();
    }).fail(function (err) {

    });
};

function refreshTableData() {
    var oldOrder = table.order();
    table.destroy();
    table = $('#dataTables-example').DataTable({
        retrieve: true,
        responsive: false,
        paging: false,
        autoWidth: false,
        bAutoWidth: false,
        order: oldOrder

    });
}
function updateVeto(masterID, element) {
    $.post('/update-veto', {
        masterID: masterID,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        if (data == '0') {
            $(element).siblings('span:first').html('0');
            element.innerHTML = '<i class="fa"></i>';
        } else {
            $(element).siblings('span:first').html('1');
            element.innerHTML = '<i class="fa fa-check"></i>';
        }
        refreshTableData();
    }).fail(function (err) {

    });
};

function updateFinalise(masterID, element) {
    $.post('/update-finalise', {
        masterID: masterID,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        final_value();
        if (data == 0) {
            $(element).siblings('span:first').html('0');
            element.innerHTML = '<i class="fa"></i>';
            $(".ticker_" + ticker).prop('disabled', false);
            $('#tr_' + ticker).closest("tr").removeClass("row-finished");
        } else {
            $(element).siblings('span:first').html('1');
            element.innerHTML = '<i class="fa fa-check"></i>';
            $(".ticker_" + ticker).prop('disabled', true);
            $('#tr_' + ticker).closest("tr").addClass("row-finished");

        }
        refreshTableData();
    }).fail(function (err) {

    });
};


function reloadDashboard( orderBy = 0) {
    $('#dashboard-table-holder').html('' +
        '<div colspan="15" class="text-center">' +
        '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>' +
        '<span class="sr-only">Loading...</span>' +
        '</div>');

    var currentDate = new Date();
    var isDate = new Date($('.ic_dates').val()+' 23:59:59');
    var allow_edit = false;
    if(currentDate < isDate){
        allow_edit = true;
    }

    $.post('/dashboard-ajax', {
        ic_date: $('.ic_dates').val(),
        orderBy: orderBy,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dashboard-table-holder').html(data);
        final_value();
        if (!allow_edit && !$('#allow_edit_as_admin').val()) {
            $('.finalised').prop('disabled', true);
            $('.veto').prop('disabled', true);
            $('.business-model').prop('disabled', true);
            $('.business-valuation').prop('disabled', true);
            $('.digital-footprint').prop('disabled', true);
            $('.slider_5').prop('disabled', true);
            $('.uplift').prop('disabled', true);
            $('.competitor-analysis').prop('disabled', true);
            $('.risk').prop('disabled', true);
        }
    }).fail(function () {

    });
}

$(document).ready(function () {
    if ($('#dash_ajax').val() != undefined) {
        reloadDashboard();

        $('.ic_dates').change(function () {
            reloadDashboard();
        });

        $('.admin_users').change(function () {
            $('#user_name').text('Name: ' + $(this).find('option:selected').text().trim());
            reloadDashboard();
        });
    }
    $('#create-human-score').on('click', function(){
        $body = $("body");
        $body.addClass("loading");

        $('#create-human-score').attr('disabled', true);
        var icDate = $('#ic_dates').val();
        $.post('/create-human-score', {
            ic_date: icDate,
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
            $('#create-human-score').removeAttr('disabled');
            alert(data);
            $body.removeClass("loading");
            reloadDashboard(9);
        }).fail(function (err) {
            $('#create-human-score').removeAttr('disabled');
            alert(err);
            $body.removeClass("loading");
            reloadDashboard();

         });
    })

    $('#finalize-all').on('click', function(){
        $body = $("body");
        $body.addClass("loading");

        var icUser = $('.admin_users').val();
        var icDate = $('#ic_dates').val();
        var finalized = $('#finalised-label-value').val();
        $('#finalize-all').attr('disabled', true);
        $.post('/update-finalise-all', {
            ic_date: icDate,
            ic_user: icUser,
            finalized: finalized,
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {
           $('#finalize-all').removeAttr('disabled');
            $body.removeClass("loading");
            reloadDashboard();
        }).fail(function (err) {
            $('#finalize-all').removeAttr('disabled');
            alert(err);
            $body.removeClass("loading");
            reloadDashboard();

        });
    });

    $('#factorWeightIcMember').change(function(){
        $('#factorWeightIcUser').val($(this).val());
        $('#factorWeightIcUser').trigger('change');
    });

    $('#factorWeightIcUser').change(function(){
        $.get('/get-factors-weight/'+$(this).val()+'/'+$('#closestIcDate').val(), {})
            .done(function (data) {
                factors = JSON.parse(data);
                var arrayLength = factors.length;
                for (var i = 0; i < arrayLength; i++) {

                    $("#factor_"+factors[i].factorNo).val(factors[i].factorWeight*10);
                    $("#factor_label_"+factors[i].factorNo).html(factors[i].factorWeight);
                    //Do something
                }

        });
    });
    $('#factorWeightIcUser').trigger('change');

});




