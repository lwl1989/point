
        <div class="row"
             style="height: 380px; margin-top: 60px;">
            <div class="col-md-12" style="height:380px;background:#32465D;" id="left-pic">
                <div class="col-md-7 col-md-offset-1" style="margin-left:30px;margin-top:50px;">
                    <div style="margin-left:0px;"><img src="/static/public/images/11.png" /></div>
                    <div style="margin-left:80px;margin-top:20px;"><img src="/static/public/images/12.png" /></div>
                    <div style=" text-align:center;margin-top:47px;"> <img src="/static/public/images/13.png" /></div>
                    <div style=" text-align:center;margin-top:30px;"><a class="btn btn-primary btn-sm" href="/public/file/upload"
                                                                        style="border-radius:4px;;background-color:white;padding:6px 15px;font-weight:bolder;font-family:微软雅黑；">上传文档</a></div>
                </div>
                <div class="cfzxs" style="height:290px;margin-top:45px;margin-left:70px;border-radius:12px;background:white;">
                    <form class="form-horizontal" role="form">
                        <div class="form-group  has-feedback"style="margin-top:30px;">
                            <label class="cfzxss control-labels" for="inputEmail">邮箱</label>
                            <div class="colmd7">
                                <input class="form-control" placeholder="" id="inputEmail" type="text" />
                            </div>
                        </div>
                        <div class="form-group  has-feedback">
                            <label class="cfzxss control-labels" for="inputPassword3">密码</label>
                            <div class="colmd7">
                                <input class="form-control" placeholder="" type="password" name="password_email" id="password_email" />
                            </div>
                        </div>
                        <div class="form-group  has-feedback">
                            <label class="cfzxss control-labels" for="inputPassword3">重复密码</label>
                            <div class="colmd7">
                                <input class="form-control" placeholder=""  type="password" name="re_password_email" id="re_password" />
                            </div>
                        </div>
                        <div style="text-align:center;margin-top:10px;font-size:14px;font-weight:bold;">
                            点击注册，表示您同意学霸银行<a href="/user/pact"style="color:#17A8CD;">《服务协议》</a>
                        </div>
                        <div class="row" style="margin-top:20px;margin-bottom:40px;">
                            <div class="col-md-6 col-md-offset-3" ><a class="btn btn-block btn-default" href="javascript:void();" id="register_index">注&nbsp册</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row" style="text-align:center;">
            <?php foreach($classify as $val): ?>
                <div class="row col-md-1 " style="margin-top:30px;margin-left:5%;">
                    <a href="#" class="button button-glow button-border button-circle button-border button-primary"><div style="margin-top:20px; margin-left:10px; width:72px;"><?php echo $val['type']?></div></a>
                </div>
            <?php endforeach;  ?>

        </div>
    </div>
</div>
