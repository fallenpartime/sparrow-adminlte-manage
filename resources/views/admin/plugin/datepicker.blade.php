<link rel="stylesheet" href="/assets/admin/css/daterangepicker.css">
<script src="/assets/admin/js/moment.min.js"></script>
<script src="/assets/admin/js/daterangepicker.js"></script>
<script>
    // 'YYYY-MM-DD HH:mm:ss'
    function initDaterangepicker(id, format)
    {
        $('#'+id).daterangepicker({
            "timePicker": true,
            "timePickerSeconds": true,
            "singleDatePicker": true,
            "timePicker24Hour": true,
            "linkedCalendars": false,
            "autoUpdateInput": false,
            "locale": {
                format: format,
                applyLabel: "应用",
                cancelLabel: "取消",
                resetLabel: "重置",
            }
        }, function(start, end, label) {
            if(!this.startDate){
                this.element.val('');
            }else{
                this.element.val(this.startDate.format(this.locale.format));
            }
        });
    }
    function initSimpleDaterangepicker(id, format)
    {
        $('#'+id).daterangepicker({
            "timePicker": false,
            "timePickerSeconds": false,
            "singleDatePicker": true,
            "timePicker24Hour": false,
            "linkedCalendars": false,
            "autoUpdateInput": false,
            "locale": {
                format: format,
                applyLabel: "应用",
                cancelLabel: "取消",
                resetLabel: "重置",
            }
        }, function(start, end, label) {
            if(!this.startDate){
                this.element.val('');
            }else{
                this.element.val(this.startDate.format(this.locale.format));
            }
        });
    }
</script>