function tb(block) {
    $('#block'+block).slideToggle('fast');
    $('#block'+block).parent().find('h4 span').toggleClass('opened');
}
function createUploader(elem){
    var uploader = new qq.FileUploader({
        element: document.getElementById(elem),
        action: '/admin/ajax/upload',
        onComplete: function(id, fileName, responseJSON){
            if (responseJSON.success == true) {
				id = id+"";
                fileId = id.replace('qq-upload-handler-iframe', '');
                switch(responseJSON.type) {
                    case 'photos':
                        $('#photos-list')
                            .append('<li id="photo'+fileId+'">'+
                                '<img src="/vendor/thumb.php?src=/'+responseJSON.path+'&w=50&h=35&zc=1" /><br/>'+
                                '<a href="javascript:deleteMediaFile('+fileId+',\'photo\')">Delete</a>'+
                                '<input type="hidden" name="photo'+fileId+'" value="photo|'+responseJSON.hash+'|'+responseJSON.filename+'|'+responseJSON.extension+'|'+responseJSON.path+'" />'+
                                '</li>');
                        break;
                    case 'documents':
                        $('#documents-list')
                            .append('<li id="document'+fileId+'"><b>'+fileName+'</b><br/>'+
                                '<a href="javascript:deleteMediaFile('+fileId+',\'document\')">Delete</a>'+
                                '<input type="hidden" name="document'+fileId+'" value="document|'+responseJSON.hash+'|'+responseJSON.filename+'|'+responseJSON.extension+'|'+responseJSON.path+'" />'+
                                '</li>');
                        break;
                }
            }
        }
    });
}
function deleteMediaFile(id, type) {
    var elem = id+"";
    id = elem.replace('/qq-upload-handler-iframe/', '');
    $('#' + type + id).remove();
}
function pages(id, language, action) {
    var hrefAttr = "javascript:pages(" + id + "," + language + ",'action')";
    var srcAttr = "/media/img/admin/image.gif";
    var link = 'loadpages/' + id + '/' + language;
    switch (action) {
        case 'show':
            $.ajaxSetup ({cache: false});
            $.get('/admin/ajax/' + link, null,
                function(responseText) {
                    $('#page' + id + ' a.page_action img').attr('src', srcAttr.replace('image', 'arrow_opened'));
                    $('#page' + id + ' a.page_action').attr('href', hrefAttr.replace('action', 'hide'));
                    if (responseText != 'false') {
                        $('#page' + id).append(responseText);
                    }
                }, 'html');
            break;
        case 'hide':
            $('#page' + id + ' ul.pages').remove();
            $('#page' + id + ' a.page_action img').attr('src', srcAttr.replace('image', 'arrow_closed'));
            $('#page' + id + ' a.page_action').attr('href', hrefAttr.replace('action', 'show'));
            break;
        default:
            break;
    }
}
function deleteMedia(id) {
    $.ajaxSetup({cache: false});
    $.get('/admin/ajax/deletemedia/' + id, null, function(responseText) {
            if (responseText=='true') {$('#file' + id).remove();}
            else {alert('ERROR!');}
        }, 'html');
}