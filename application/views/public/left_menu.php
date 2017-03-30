
    <div class="col-md-3 yj">
        <div class="col-md-12">
        <div id="sidebar">
            <div class="mainNavs">
        <!--  -->      <?php foreach($classify as $key_type=>$type): ?>
                    <div class="menu_box" id="job_hopping">
                        <div class="menu_main" id="job_hopping">
                        <h2>
                            <?php echo $type['type']; ?><span></span>
                        </h2>
                        <?php foreach($type['hot'] as $hot):?>
                            <a href="/search?labelWords=label"><?php echo $hot;?></a>
                        <?php endforeach;?>
                            </div>
                        <div class="menu_sub hide">
                            <?php foreach($type['tags'] as $key_tag=>$tag):?>
                                <dl class="reset">
                                    <dt>
                                        <a href="/search?labelWords=classify"><?php echo $tag['tag']; ?>
                                        </a>
                                    </dt><dd>
                                    <?php foreach($tag['classify'] as $val):?>
                                            <a href="/search?labelWords=classify"><?php echo $val['name']; ?></a>
                                    <?php endforeach;?>
                                    </dd>
                                </dl>
                            <?php endforeach;?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                </div>
            </div>
        </div>
    </div>