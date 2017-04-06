<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('lib/uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('lib/uploadify/uploadify.css') }}">







<form>
    <div id="queue"></div>
    <input id="file_upload" name="file_upload" type="file" multiple="true">
</form>

<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadify({
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '{{ asset('lib/uploadify/uploadify.swf') }}',
            'uploader' : '{{ route('upload') }}',
            'buttonText':'点击上传',
            'fileTypeDesc':'filetypedesc',
            'fileTypeExts':'*.gif; *.jpg; *.png'
        });
    });

</script>
