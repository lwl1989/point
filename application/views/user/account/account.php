<script src="<?php echo base_url()?>static/public/js/tab.js"></script>
<div class="row" style="margin-top:100px;">
    <?php require($views_path . 'public/user_leftmenu.php');?>
    <div class="col-md-9">
        <div class="colmdbtl rightTitle yj" style="right:40px;left:40px;">学生用户</div>
        <div class="col-md-9">
            <form class="form-horizontal" role="form" style="margin-top:60px;">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputNickname">昵称：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="昵称" id="inputNickname" type="text" />

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="sex3">性别：</label>
                    <div class="col-sm-8">
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="radioSex" value="1">男
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" name="radioSex" value="0">女
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
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
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="school">所在学校：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="所在学校" id="school" type="text" />
                    </div>
                </div>
                <div class="form-group">
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
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="hometown">故乡：</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option value="bj">北京</option>
                            <option value="2">2</option>
                        </select>
                        <select class="form-select1">
                            <option value="dcq">东城区</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="present-address">现居地：</label>
                    <div class="col-sm-8">
                        <select class="form-select">
                            <option value="bj">北京</option>
                            <option value="2">2</option>
                        </select>
                        <select class="form-select1">
                            <option value="dcq">东城区</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="contact-way">联系方式：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="联系方式" id="contact-way" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputEmail3">邮箱：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="邮箱" id="inputEmail3" type="email" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="qq">QQ：</label>
                    <div class="col-sm-8">
                        <input class="form-control" placeholder="QQ" id="qq" type="text" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="self-introduction">个人介绍：</label>
                    <div class="col-sm-8">
                        <textarea rows="6" class="form-control" placeholder="36氪创始人，前百度副总裁，连续创业者" id="self-introduction"></textarea></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8" style="text-align:center;">
                        <button class="btn btn-default" style="padding-left:40px;padding-right:40px;background:#32465D;color:white;" type="submit">保存</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>