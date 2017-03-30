<div class="row" style="margin-top: 100px;">


    <div class="col-lg-12" style="text-align: center;">
        <div class="bg-warning">
            <h2 style="padding: 5px 5px 5px 5px;">登录</h2>
        </div>
        <form class="form-horizontal" role="form" action="/api/company_operate/do_login" method="post" id="index_login">
            <div class="form-group">
                <label for="account" class="col-md-3 control-label">用户名</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="" name="account" placeholder="请输入你的用户名">
                </div>
            </div>
            <div class="form-group" style="margin-top:30px;">
                <label for="password" class="col-md-3 control-label">密码</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password" placeholder="请输入你的密码">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" value="1">记住密码
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-8">
                    <div class="error hide submit_login_index"></div>
                    <button type="submit" class="btn btn-default" id="login"
                            style="border:solid 2px #2F507B;padding-left:50px;padding-right:50px;">
                        提交</button>
                </div>
            </div>
        </form>
    </div>
</div>