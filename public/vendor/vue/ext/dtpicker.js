$(document).ready(function() {
    $( ".dtpicker" ).datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,
        weekStart: 1,
        pickerPosition: 'top-right'
    }).on('changeDate', function(e) {
        this.dispatchEvent(new Event('input'))
    });
});
