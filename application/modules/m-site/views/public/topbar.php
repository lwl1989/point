<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo site_url('m-site/home')?>"> 
                <!-- <img alt="Charisma Logo" src="<?php echo $static;?>img/logo20.png" />  -->
                <span>学霸分站后台</span>
            </a>
            <div class="pull-left top-menu">
               <ul class="main-nav">
                   <div class="pull-left top-menu">
                       <ul class="main-nav">
                           <li id="channel_system" class="active">
                               <a href="javascript:void(0);" onclick="change_channel('system');">
                                   <span>系统设置</span>
                               </a>
                           </li>
                           <li id="channel_contents" class="">
                               <a href="javascript:void(0);" onclick="change_channel('contents');">
                                   <span>内容管理</span>
                               </a>
                           </li>
                           <li id="channel_marketing" class="">
                               <a href="javascript:void(0);" onclick="change_channel('marketing');">
                                   <span>营销管理</span>
                               </a>
                           </li>




                       </ul>
                   </div>




            </ul>
            </div>
            <!-- theme selector starts -->
<!--            <div class="btn-group pull-right theme-container" >-->
<!--                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">-->
<!--                    <i class="icon-tint"></i><span class="hidden-phone"> 换皮肤</span>-->
<!--                    <span class="caret"></span>-->
<!--                </a>-->
<!--                <ul class="dropdown-menu" id="themes">-->
<!--                    <li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>-->
<!--                    <li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>-->
<!--                    <li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>-->
<!--                    <li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>-->
<!--                    <li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>-->
<!--                    <li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>-->
<!--                    <li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>-->
<!--                    <li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>-->
<!--                    <li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>-->
<!--                </ul>-->
<!--            </div>-->
            <!-- theme selector ends -->

            <!-- user dropdown starts -->
            <div class="btn-group pull-right" >
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-user"></i><span class="hidden-phone"> <?php echo $site_admin['username'];?></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- <li><a href="#">个人资料</a></li> -->
                    <!-- <li class="divider"></li> -->
                    <li><a href="<?php echo site_url('auth/logout');?>">退出</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <div class="top-nav nav-collapse">
                <ul class="nav">
                    <!--<li class="active"><a href="#">基本设置</a></li>-->
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>