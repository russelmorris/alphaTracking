var ticker = null;
var icDate = $('.ic_dates').val();
var user_id = $('.admin_users').val();

var tickerFunc = function () {
    $('#dataTables-example').find('tr').mouseover(function () {
        ticker = $(this).find('.ticker').text().trim();
    });
};
var businessModel = function () {

    $('.business-model').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc1: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
var businessValuation = function () {
    $('.business-valuation').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc2: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
var digitalFootprint = function () {
    $('.digital-footprint').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc3: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });
};
var uplift = function () {
    $('.uplift').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc4: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });
};
var competitorAnalysis = function () {
    $('.competitor-analysis').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc5: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });

    });

};
var risk = function () {
    $('.risk').change(function () {
        $.post('populate_master', {
            ticker: ticker,
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            fc6: $(this).val(),
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
var veto = function () {
    $('.veto').click(function () {
        $(this).find('i').toggleClass(function () {
            if ($(this).hasClass(".fa-check")) {
                return "";
            } else {
                return "fa-check";
            }
        });
        $.post('populate_master', {
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            veto: $(this).find('i').hasClass('fa-check'),
            ticker: ticker,
            flag: 'veto',
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
    });
};
var finalised = function () {
    $('.finalised').click(function () {
        var final = $(this).find('i').toggleClass(function () {
            if ($(this).hasClass(".fa-check")) {
                return "";
            } else {
                return "fa-check";
            }
        });

        $.post('populate_master', {
            user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
            ic_date: $('.ic_dates').val(),
            ticker: ticker,
            finalised: $(this).find('i').hasClass('fa-check'),
            flag: 'finalised',
            csnamerf: $.cookie('csrfcookiename')
        }).done(function (data) {

        }).fail(function (err) {

        });
        $(final).closest("tr").toggleClass(function () {
            if ($(this).hasClass(".row-finished")) {
                return "";
            } else {
                return "row-finished";
            }
        });

        $(final).closest("tr").find('td').each(function () {
            $(this).toggleClass(function () {
                if (!$(this).hasClass("final")) {
                    return "disable-row";
                } else {
                    return "";
                }
            });

        });
    });
};


function updateTicker(ticker, factor, value) {
    $.post('update-factor', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        factor: factor,
        value: value,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {

    }).fail(function (err) {

    });
};

function updateVeto(ticker, element) {
    $.post('update-veto', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        if (data == '0'){
            element.innerHTML = '<i class="fa"></i>';
        } else {
            element.innerHTML = '<i class="fa fa-check"></i>';
        }
    }).fail(function (err) {

    });
};

function updateFinalise(ticker, element ) {
    $.post('update-finalise', {
        ticker: ticker,
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        ic_date: $('.ic_dates').val(),
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        if (data == 0){
            element.innerHTML = '<i class="fa"></i>';
            $(".ticker_"+ticker).prop('disabled', false);
            $('#tr_'+ticker).closest("tr").removeClass("row-finished");
        } else {
            element.innerHTML = '<i class="fa fa-check"></i>';
            $(".ticker_"+ticker).prop('disabled', true);
            $('#tr_'+ticker).closest("tr").addClass("row-finished");
        }
    }).fail(function (err) {

    });
};

function reloadDashboard(){
    $('#dashboard-table-holder').html('' +
        '<div colspan="15" class="text-center">' +
        '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>' +
        '<span class="sr-only">Loading...</span>' +
        '</div>');

    $.post('/dashboard_ajax', {
        ic_date: $('.ic_dates').val(),
        user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
        csnamerf: $.cookie('csrfcookiename')
    }).done(function (data) {
        $('#dashboard-table-holder').html(data);
    }).fail(function () {

    });
}
$(document).ready(function () {
    reloadDashboard();

    $('.ic_dates').change(function () {
        reloadDashboard();
    });


    // $('.ic_dates').change(function () {
    //     $('#empty').show();
    //     $('#dataTables-example').hide();
    //     var allow_edit = moment(new Date()).isBefore($(this).val());
    //     $.post('/dashboard_ajax', {
    //         ic_date: $(this).val(),
    //         user_id: $('#allow_edit_as_admin').val() ? $('.admin_users').val() : false,
    //         csnamerf: $.cookie('csrfcookiename')
    //     }).done(function (data) {
    //         if (data) {
    //             $('#empty').hide();
    //             $('#dataTables-example').show();
    //         }
    //
    //         var table = $('#dataTables-example');
    //         table.find('tbody').html($(data).find('#dataTables-example > tbody > *'));
    //         if (!allow_edit && !$('#allow_edit_as_admin').val()) {
    //             el.find('tr').each(function () {
    //                 if (!$(this).hasClass('row-finished')) {
    //                     $(this).children('td').toggleClass(function () {
    //                         if ($(this).hasClass("click")) {
    //                             return "";
    //                         } else {
    //                             return "disable-row";
    //                         }
    //                     });
    //                 }
    //                 else {
    //                     $(this).children('td').toggleClass(function () {
    //                         if ($(this).hasClass("final-dis")) {
    //                             return "disable-row";
    //                         } else {
    //                             return "";
    //                         }
    //                     });
    //                 }
    //             });
    //         }
    //
    //         table.find('tr').each(function () {
    //             if ($(this).hasClass("row-finished")) {
    //                 return "";
    //             } else {
    //                 return "row-finished";
    //             }
    //         });
    //         table.find('td').each(function () {
    //             $(this).toggleClass(function () {
    //                 if (!$(this).hasClass("final") && $(this).parent().hasClass("row-finished")) {
    //                     return "disable-row";
    //                 } else {
    //                     return "";
    //                 }
    //             });
    //         });
    //         // last_master = table.find('tr:last input').val();
    //         tickerFunc();
    //         businessModel();
    //         businessValuation();
    //         digitalFootprint();
    //         uplift();
    //         competitorAnalysis();
    //         risk();
    //         veto();
    //         finalised();
    //     }).fail(function () {
    //
    //     })
    // });

    $('.admin_users').change(function () {
        reloadDashboard();
    });
});


function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

