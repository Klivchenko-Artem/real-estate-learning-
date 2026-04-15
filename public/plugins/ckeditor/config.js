CKEDITOR.editorConfig = function( config ) {
    config.toolbarGroups = [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] },
        { name: 'plugin', groups: [ 'plugin' ] },
        { name: 'video', groups: [ 'reka' ] },
    ];

    CKEDITOR.plugins.addExternal('plugin', '/plugins/ckeditor/plugins/plugin/');
    config.extraPlugins = ['plugin', 'reka'];
    config.height = eval(this.element.$.rows*40) + 'px';
    config.filebrowserBrowseUrl = '/plugins/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/plugins/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '/plugins/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json';
    config.filebrowserImageUploadUrl = '/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json';
    config.filebrowserFlashUploadUrl = '/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash&responseType=json';
    config.stylesSet = 'styles:/plugins/ckeditor/plugins/plugin/styles.js';

    config.removeButtons = 'Save,Templates,NewPage,ExportPdf,Preview,Print,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,Outdent,Indent,CreateDiv,BidiLtr,BidiRtl,Language,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Font,FontSize,TextColor,BGColor,ShowBlocks,About';
};
