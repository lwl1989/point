/**
 * Created by Administrator on 2015/5/8.
 */

$(function(){
    $('#login_header').click(function(){
        var account=$('#account').val();
        var password = $('#password').val();
        $.ajax({
            url:'/auth/login/do_login',
            type:'post',
            data:{account:account,password:password},
            dataType:'json',
            success:function(json){
                if(json.status==true){
                    $('#bs-example-navbar-collapse-1 .login_before').html('');
                    str =' <ul class="nav navbar-nav navbar-right">'+
                    '<li class="dropdown" id="dropdown-toggle"><a class="dropdown-toggle" href="/user/account" >'+json.msg+'<strong class="caret"></strong></a>'+
                    '<ul class="dropdown-menu">'+
                    '<li><a href="/auth/logout">退出</a></li>'+
                    '</ul></li> <li><a class="btn btn-primary btn-sm" href="/upload" style="background:#32465D;color:white;padding:6px 15px;margin-top:10px;">上传文档</a></li> </ul>';
                    $('#bs-example-navbar-collapse-1 .login_before').html(str);
                    $('.theme-popover-mask').fadeOut(500);
                    $('#myModal').slideUp(200);
                    $('.theme-popover-mask').fadeOut(500);
                    $('.theme-popover').slideUp(200);
                }else{
                    $('.show_error').removeClass('hide');
                    $('.show_error').html(json.msg);
                    $('.show_error').fadeOut(3000);
                }
            }
        })
    });
    $("#index_login").validate({
        rules: {
            account: "required",
            password: {
                required: true,
                minlength: 5
            },
            remember:{}
        },
        messages: {
            account: "请输入账户",
            password: {
                required: "请输入密码",
                minlength: "密码不能小于6个字符"
            },
            remember:{}

        },
        submitHandler: function(form) {
            jQuery(form).ajaxSubmit({
                dataType:"json",
                success:function(json){
                    if(json.status==true){
                        window.location.href=json.data.url;
                    }else{
                        $('.submit_login_index').removeClass('hide');
                        $('.submit_login_index').html('登录失败');
                        $('.submit_login_index').fadeOut(2000);
                    }
                }
            });

        }
    });
    $(".table-hover tbody tr").mouseover(function(){
        $(this).find(".dropdown").css("display","block");
    }).mouseout(function(){
        $(this).find(".dropdown").css("display","none");
    });
    $('a[data-toggle="tab"]').on('show.bs.tab',function(e){
        if($(this).attr("href")=="#panel-1"){
            $(".tabbable .new-collect").css("display","block");
        }else{
            $(".tabbable .new-collect").css("display","none");
        }
    });
    $("#left-pic").mouseover(function(){
        $("#classifyBase").css("display","block");
    }).mouseout(function(){
        $("#classifyBase").css("display","none");
    });
    $("#dropdown-toggle").mouseover(function(){
        $(this).addClass("open");
    }).mouseout(function(){
        $(this).removeClass("open");
    }).click(function(){
        location.href = "";
    });
    var flag = 1;
    $(".changeColor").click(function(){
        if(flag==1){
            $(this).css("background-color","rgb(247, 247, 247)");
            flag=2;
        }else{
            $(this).css("background-color","#ff945c");
            flag=1;
        }
    });
    $('#keyword').keydown(function(e){
        if(e.keyCode==13){
            window.location.href='/search?keyword='+$(this).val();
        }
    });
    $('#search_button').click(function () {
        window.location.href='/search?keyword='+$('#keyword').val();
    });

});
function do_print(id){
    var file_num = 1;
    $.ajax({
        'url':'/public/cart/do_change_cart',
        'dataType':'json',
        'data':{file_id:id,file_num:file_num},
        'type':'post',
        'success':function(data){
            if(data.status==9){
                alert('请登录');
                window.location.href = '/auth/login';
            }else if(data.status==false){
                alert("加入打印序列失败");
            }else{
                alert("成功加入打印序列");
            }
        }
    });
}
function do_del_collect(id,type,obj){
    if(!confirm("确认要删除？")){
        window.event.returnValue = false;
    }else{
        $.ajax({
            'url':'/public/comment/do_del_collect',
            'dataType':'json',
            'data':{file_id:id,operate_type:type},
            'type':'post',
            'success':function(data){
                if(data.status==9){
                    alert('请登录');
                    window.location.href = '/auth/login';
                }else if(data.status==false){
                    alert("删除收藏失败");
                }else{
                    $(obj).parents("tr").fadeOut(1000);
                }
            }
        });
    }
}
function do_comment_for_document(id,content,user_id,score) {
    $.ajax({
        'url': '/api/user_operate/do_comment_for_document',
        'dataType': 'json',
        'data': {document_id: id, content: content,user_id:user_id,score:score},
        'type': 'post',
        'success': function (data) {
            if (data.status == 9) {
                alert('请登录');
                window.location.href = '/auth/login';
            } else if (data.status == false) {
                alert("评论失败");
            } else {
                alert("评论成功");
            }
        }
    });
}
function do_collect(id,type,obj){
    $.ajax({
        'url':'/public/comment/do_collect',
        'dataType':'json',
        'data':{file_id:id,operate_type:type},
        'type':'post',
        'success':function(data){
            if(data.status==9){
                alert('请登录');
                window.location.href = '/auth/login';
            }else if(data.status==false){
                alert("收藏失败");
            }else{
                alert("收藏成功");
            }
        }
    });
}
function user_del_document(id,obj){
    if(!confirm("确认要删除？")){
        window.event.returnValue = false;
    }else{
        $.ajax({
            'url':'/user/document/del/'+id,
            'dataType':'json',
            'type':'get',
            'success':function(data){
                if(data.status==9){
                    alert('请登录');
                    window.location.href = '/auth/login';
                }else if(data.status==false){
                    alert("删除失败");
                }else{
                    $(obj).parents("tr").fadeOut(1000);
                }
            }
        });
    }
}

function obj2string(o) {
    var r = [];
    if (typeof o == "string") {
        return "\""
            + o.replace(/([\'\"\\])/g, "\\$1").replace(/(\n)/g, "\\n")
                .replace(/(\r)/g, "\\r").replace(/(\t)/g, "\\t")
            + "\"";
    }
    if (typeof o == "object") {
        if (!o.sort) {
            for ( var i in o) {
                r.push(i + ":" + obj2string(o[i]));
            }
            if (!!document.all
                && !/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/
                    .test(o.toString)) {
                r.push("toString:" + o.toString.toString());
            }
            r = "{" + r.join() + "}";
        } else {
            for (var i = 0; i < o.length; i++) {
                r.push(obj2string(o[i]))
            }
            r = "[" + r.join() + "]";
        }
        return r;
    }
    return o.toString();
}

function do_place_again(order_id){
    if(!order_id){
        return false;
    }
    $.ajax({
        'url':'/api/order/do_order_again/'+order_id,
        'dataType':'json',
        'type':'get',
        'success':function(data){
            if(data.status==9){
                alert('请登录');
                window.location.href = '/auth/login';
            }else if(data.status==false){
                alert("提交失败");
            }else{
                alert("提交成功");
            }
        }
    });
}