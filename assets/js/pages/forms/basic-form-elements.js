$(function () {
    //Textare auto growth
    if (typeof autosize !== 'undefined') {
        autosize($('textarea.auto-growth'));
    }

    if ($.fn.bootstrapMaterialDatePicker) {
        //Datetimepicker plugin
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm',
            clearButton: true,
            weekStart: 1
        });

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            clearButton: true,
            date: false
        });
    }
});