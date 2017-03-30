
function Tree_selector(selector, ajax_url)
{
    var selector_id = selector;
    var selector_label = selector + '_label';
    var _selector = this;

    this.init = function () {
        $("#" + selector_id + " > select").change(
            this.selector_change
        ); // select的onchange事件
        $("#" + selector_id + " > input:button[class='edit_selector']").click(
            this.selector_edit
        ); // 编辑按钮的onclick事件
    };

    this.selector_change = function () {
        _selector.clear_label();

        // 删除后面的select
        $(this).nextAll("select").remove();
        // 计算当前选中到id和拼起来的name
        var selects = $(this).siblings("select").andSelf();

        var id, name;
        for (var i = 0; i < selects.length; i++){

            sel = selects[i];
            if (sel.value > 0){
                id = sel.value;
                name = sel.options[sel.selectedIndex].text;
            }
        }
        //console.log(selects);
        if (this.value > 0){

            var _self = this;
            $.getJSON(ajax_url, {'p_id':this.value}, function(res) {
                if(res.status) {
                    if(res.data.length > 0){

                        $("<select><option value='0'>请选择...</option></select>").change(
                            _selector.selector_change
                        ).insertAfter(_self);

                        var data  = res.data;
                        for (i = 0; i < data.length; i++)
                        {
                            $(_self).next("select").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                        }

                    }else {
                        //没有下级
                        _selector.write_label(id, name);
                    }
                }else if(!res.status){
                    alert(res.msg);
                }
                else{
                    alert('请求错误');
                }
            });
        }

    };
    this.write_label = function(selected_id, selected_label) {
        var label_obj = $('#' + selector_label);

        label_obj.find('.selected_id').val(selected_id);
        label_obj.find('.selected_label').text(selected_label)
            .removeClass('label-important')
            .addClass('label-success');
    };
    this.clear_label = function () {
        var label_obj = $('#' + selector_label);

        label_obj.find('.selected_id').val('');
        label_obj.find('.selected_label').text('未选择')
            .removeClass('label-success')
            .addClass('label-important');
    };

    this.resetSelector = function () {
        this.clear_label();
        $("#" + selector_id).find('.selector_root').nextAll("select").remove();

    };
}


function init_tree_selector(get_json_url , div_id , p_id , class_name , select){
    if(!arguments[2]) p_id = 0;
    if(!arguments[3]) class_name = "";
    if(!arguments[4]) select = '';

    var id_val = div_id + 'selector_init';
    var name_val = div_id + '_name[]';
    var selected_name_label = div_id + '_selected_name';
    var selected_id = div_id + '_selected_id';
    var not_edit_obj =  div_id + '_not_edit';

    $.getJSON(get_json_url, {'p_id':p_id}, function(res){
        if (res.status){
            if (res.data.length > 0){
                $("<select rel='init_selector' class='"+class_name+"' id='"+id_val+"' name='"+name_val+"'><option value=''>请选择...</option></select>").appendTo('#'+div_id);
                var data  = res.data;
                for (i = 0; i < data.length; i++){
                    $('#'+id_val).append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                }
                $('#'+div_id).append("<span class='label label-important' id='" + selected_name_label + "'>未选择</span>");
                $('#'+div_id).append("<input type='hidden' name='"+div_id+"' id='"+selected_id+"' value='0' />");

                //有初始值的时候显示初始值
                if(select != ''){
                    $('#'+id_val).hide();
                    $('#'+selected_name_label).hide();
                    $('#'+div_id).append("<input type='hidden' name='"+not_edit_obj+"' id='"+not_edit_obj+"' value='1' />");
                    var span_html = "<a rel='tree_selector_not_edit' href='javascript:;' style='display:none;' class='help-inline clearfix'>返回</a>" +
                        "<span rel='tree_selector'>"+select+"</span>" +
                        "<a rel='tree_selector_edit' href='javascript:;' class='help-inline'>修改</a>";
                    $('#'+div_id).append(span_html);
                    //span_html
                    //init_area_obj.hide();
                    $('#'+div_id).find("a[rel='tree_selector_edit']").click(function(){
                        $(this).hide();
                        $('#'+div_id).find("span[rel='tree_selector']").hide();
                        $('#'+selected_name_label).show();
                        $('#'+id_val).show();
                        $('#'+not_edit_obj).val(0);
                        $('#'+div_id).find("a[rel='tree_selector_not_edit']").show();
                    });

                    $('#'+div_id).find("a[rel='tree_selector_not_edit']").click(function(){
                        $(this).hide();
                        $('#'+div_id).find("select[rel='init_selector']").hide();
                        $('#'+div_id).find("a[rel='tree_selector_edit']").show();
                        $('#'+div_id).find("span[rel='tree_selector']").show();
                        $('#'+not_edit_obj).val(1);
                        $('#'+selected_name_label).hide();
                    });
                }
            }
        }
    });
    var init_selector_obj = $('#'+div_id).find("select[rel='init_selector']");
    init_selector_obj.live('change', function(){

        $('#'+selected_name_label).text('未选择')
            .removeClass('label-success')
            .addClass('label-important');

        $('#'+selected_id).val(0)

        $(this).nextAll("select").remove();
        var selects = $(this).siblings("select").andSelf();
        var c_id, c_name;
        for (i = 0; i < selects.length; i++){
            sel = selects[i];
            if (sel.value > 0){
                c_id = sel.value;
                c_name = sel.options[sel.selectedIndex].text;
            }
        }

        // ajax请求下级分类
        if (this.value != '' || this.value > 0){
            var _self = this;
            $.getJSON(get_json_url, {'p_id':this.value}, function(res){
                if (res.status){
                    if (res.data.length > 0){
                        $("<select rel='init_selector' class='"+class_name+"' name='"+name_val+"'>" +
                            "<option value=''>请选择</option>" +
                            "</select>").insertAfter(_self);
                        var data  = res.data;
                        for (i = 0; i < data.length; i++){
                            $(_self).next("select").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                        }
                    } else {
                        $('#'+selected_name_label).text(c_name)
                            .removeClass('label-important')
                            .addClass('label-success');
                        $('#'+selected_id).val(c_id)
                    }
                }
            });
        }
    });//end change

}