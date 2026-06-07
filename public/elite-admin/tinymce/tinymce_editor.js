$(document).ready(function () {
    setTimeout(function () { //$(".message").hide('blind', {}, 500)); 
        $(".message").slideUp(1000).hide(1000);
    }, 5000);

    tinymce.init({
        selector: '.tinymce',
        height: 300,
        menubar: true,
        plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
  ],

  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
        file_browser_callback: cmsmediaFileBrowser,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : false,
        content_css: [
            '//www.tinymce.com/css/codepen.min.css'
        ],
    });
    


// This must be set to the absolute path from the site root.
    var cmsmedia = global_url+'js/cmsmedia/index.html?integration=tinymce4';
    function cmsmediaFileBrowser(field_name, url, type, win) {
        var cmsURL = cmsmedia;  // script URL - use an absolute path!
        if (cmsURL.indexOf("?") < 0) {
            cmsURL = cmsURL + "?type=" + type;
        }
        else {
            cmsURL = cmsURL + "&type=" + type;
        }
        cmsURL += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
        tinyMCE.activeEditor.windowManager.open({
            file: cmsURL,
            title: 'cmsmedia File Browser',
            width: 850, // Your dimensions may differ - toy around with them!
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "yes", // This parameter only has an effect if you use the inlinepopups plugin!
            close_previous: "no"
        }, {
            window: win,
            input: field_name
        });
        return false;
    }
});
