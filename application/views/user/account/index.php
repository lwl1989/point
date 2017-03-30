<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/user_leftmenu.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">学生用户</div>
        <div class="col-md-9">
            <form class="form-horizontal" role="form" style="margin-top:60px;" name="update_user" id="update_user"
                  method="post" action="<?php echo site_url('user/account/do_update_info');?>">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputNickname">昵称：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="inputNickname" name="nickname" type="text" value="<?php echo $user['nickname'];?>" />
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $user_id;?>" />
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="sex3">性别：</label>
                    <div class="col-sm-8">
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="sex" value="1" <?php  if($user['sex']==1)echo 'checked="checked"'?>>男
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="sex" value="0" <?php  if($user['sex']==0)echo 'checked="checked"'?>>女
                            </label>
                        </div>
                    </div>
                </div>
            <!--    <div class="form-group">
                    <label class="col-sm-2 control-label" for="name3">真实姓名：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="真实姓名" id="name3" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="studentId">学号：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="学号" id="studentId" type="text" />
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="school">所在学校：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="school" type="text" />
                    </div>
                </div>
                <!--    <div class="form-group">
                    <label class="col-sm-2 control-label" for="college">所在学院：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="所在学院" id="college" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="major">所在专业：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="所在专业" id="major" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="classId">所在班级：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="所在班级" id="classId" type="text" />
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hometown">故乡：</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="province">
                            <option value="bj">北京</option>
                            <option value="2">2</option>
                        </select>
                        <select class="form-select1" name="city">
                            <option value="dcq">东城区</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="present-address">现居地：</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="province_now">
                            <option value="bj">北京</option>
                            <option value="2">2</option>
                        </select>
                        <select class="form-select1" name="city_now">
                            <option value="dcq">东城区</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact-way">详细地址：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="contact-way" type="text" name="address" value="<?php echo $user['address'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact-way">手机：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="contact-way" type="text"  name="mobile" value="<?php echo $user['mobile'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputEmail3">邮箱：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="inputEmail3" type="email" name="email"  value="<?php echo $user['email'];?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="qq">QQ：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="" id="qq" type="text" name="qq" value="<?php echo $user['qq'];?>" />
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="self-introduction">个人介绍：</label>
                        <div class="col-sm-8">
                        <textarea rows="6" name="introduce" class="form-control text-left" placeholder="" id="self-introduction">
                            <?php echo $user['introduce'];?>
                        </textarea>
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8" style="text-align:center;">
                        <div class="show_error hide"></div>
                        <button class="btn btn-default" style="padding-left:40px;padding-right:40px;background:#32465D;color:white;" type="submit">保存</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>
<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<script type="text/javascript">
    $().ready(function() {
        $("#update_user").validate({
            submitHandler: function(form) {
                jQuery(form).ajaxSubmit({
                    dataType:"json",
                    success:function(json){
                        if(json.status==true){
                            window.location.href='<?php site_url('user/account')?>';
                        }else{
                            $('.show_error').removeClass('hide');
                            $('.show_error').html('修改个人信息失败');
                            $('.show_error').fadeOut(2000);
                        }
                    }
                });
            }
        });
    });
</script>