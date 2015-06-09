<!-----------------------footer---------------->      
		<div id="footer">
		  <div class="container">
		<!--        <p class="muted credit">&copy;Copyright DABCC, Inc. All Rights Reserved, 1999-2013. More information at: <a href="#">radio.dabcc.com</a></p>-->
		  </div>
		</div>
    </div>
	<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            {% } %}
        </td>
        <td>
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            </p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
        </td>
    </tr>
{% } %}
</script>
        
        <script src="<?php echo $base_url;?>public/js/vendor/jquery.ui.widget.js"></script>
        <script src="<?php echo $base_url;?>public/js/tmpl.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.blueimp-gallery.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.iframe-transport.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.fileupload.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.fileupload-process.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.fileupload-validate.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.fileupload-ui.js"></script>
        <script src="<?php echo $base_url;?>public/js/upload.js"></script>
		
        <script src="<?php echo $base_url;?>public/js/jquery.tablesorter.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.tablesorter.widgets.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.tablesorter.pager.js"></script>
        <script src="<?php echo $base_url;?>public/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo $base_url;?>public/js/common.js"></script>
</body>
</html>