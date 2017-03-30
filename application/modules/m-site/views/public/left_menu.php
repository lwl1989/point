<div class="span2 main-menu-span">
    <div class="well nav-collapse sidebar-nav">
        <?php foreach ($menus as $channel_key => $sub_menus):?>
        <ul id="channel_<?php echo $channel_key;?>_menus" class="nav nav-tabs nav-stacked main-menu" style="display: none;">
            <?php foreach($sub_menus as $sub_menu_name => $sub2_menus): ?>
                <li class="nav-header hidden-tablet"><?php echo $sub_menu_name;?></li>
                <?php foreach ($sub2_menus as $sub2_menu_name => $sub2_menu):?>
                <li>
                    <a class="ajax-link" href="<?php echo site_url($sub2_menu['url'])?>">
                       
                        <span class="hidden-tablet"> <?php echo $sub2_menu_name;?></span>
                    </a>
                </li>
                <?php endforeach;?>
            <?php endforeach;?>
        </ul>
        <?php endforeach;?>

        </ul>
        <!--<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox" checked="true"> 异步加载菜单</label>-->
    </div><!--/.well -->
</div><!--/span-->