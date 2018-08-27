$(document).ready(function () {
    $('#factorWeightIcDate').change(function () {
        window.location.replace("/factor-weights/"+$(this).val());
    })
});
