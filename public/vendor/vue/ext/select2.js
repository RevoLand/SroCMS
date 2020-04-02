$(document).ready(function() {
    $( ".select2" ).select2({}).on('select2:select select2:unselect', function (e) {
        this.dispatchEvent(new Event('change'))
    });
});
