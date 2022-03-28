$(function() {
    'use strict';

    if($('#datePickerEdit').length) {
        $('#datePickerEdit').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }

});
