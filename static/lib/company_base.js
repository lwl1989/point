/**
 * Created by Administrator on 2015/6/13.
 */
$(function() {
    $('#login_header').click(function () {
        var account = $('#account').val();
        var password = $('#password').val();
        $.ajax({
            url: '/api/company_operate/do_login',
            type: 'post',
            data: {account: account, password: password},
            dataType: 'json',
            success: function (json) {
                if (json.status == true) {
                   window.location.href='/company/account';
                } else {
                    $('.show_error').removeClass('hide');
                    $('.show_error').html(json.msg);
                    $('.show_error').fadeOut(3000);
                }
            }
        })
    });
    $(".table-hover tbody tr").mouseover(function(){
        $(this).find(".dropdown").css("display","block");
    }).mouseout(function(){
     //   $(this).find(".dropdown").css("display","none");
    });
    $('a[data-toggle="tab"]').on('show.bs.tab',function(e){
        if($(this).attr("href")=="#panel-1"){
            $(".tabbable .new-collect").css("display","block");
        }else{
            $(".tabbable .new-collect").css("display","none");
        }
    });
    $("#dropdown-toggle").mouseover(function(){
        $(this).addClass("open");
    }).mouseout(function(){
        $(this).removeClass("open");
    }).click(function(){
        location.href = "";
    });
});

function print_order(order_id,company_id,obj){
    $.ajax({
        url:'/api/company_operate/has_receive',
        type:'post',
        dataType:'json',
        data:{order_id:order_id,company_id:company_id},
    success:function(data){
        if(data.status==true){
            alert('接收到订单，开始打印');
            $(obj).parents('.order_list').fadeOut(1000);
        }else{
            alert(data.msg);
        }
    }
})
}

function printed_order(order_id,company_id,obj){
    $.ajax({
        url:'/api/company_operate/has_complete',
        type:'post',
        dataType:'json',
        data:{order_id:order_id,company_id:company_id},
        success:function(data){
            if(data.status==true){
                alert('接收到订单，开始打印');
                $(obj).parents('.order_list').fadeOut(1000);
            }else{
                alert(data.msg);
            }
        }
    })
}