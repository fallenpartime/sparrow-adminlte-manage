@include('UEditor::head')
<script type="text/javascript">
    function initUEditor(ueId) {
        UE.getEditor(ueId).ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    }
</script>