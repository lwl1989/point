/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'do_upload',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|txt|doc|docx|ppt|pptx|xls|xlsx|pdf)$/i,
        maxFileSize: 500000000
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
        // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
    });

    /*$('#fileupload').bind('fileuploaddestroy', function (e, data) {
     $.ajax({
     url: 'do_del',
     dataType: 'json',
     context: $('#fileupload')[0]
     })

     });*/

    $('#sure').click(function(){
       // window.location='/public/file/sure_upload';
        var num =$(".files").children("tr").length;
        //alert(num);
        var i=0;
        var myArray=new Array();
        for(;i<num;i++){
            //alert($(".files tr").eq(i).find("a").html());
            var title = $(".files tr").eq(i).find("a").html();
            var file_classify =  $(".files tr").eq(i).find("select").val();
            var file_size = $(".files tr").eq(i).find(".size").val();
            var intro =  $(".files tr").eq(i).find("textarea").val();
            myArray[i] = { title:title,file_classify:file_classify,intro:intro,file_size:file_size }
        }
        var postData = $.toJSON(myArray);
        //alert(postData);
        $.ajax({
          'url':'sure_upload',
          'dataType':'json',
            'data':{files:postData},
           'type':'post',
            'success':function(data){
                if(data.state){
                    alert("上传完成");
                    window.location.href="http://www.xuebabank.com/public/file/upload";
                }
            },
            'error':function(){

            }
        });
       // alert($(".files tr").eq(1).find("a").html());

    });

});
