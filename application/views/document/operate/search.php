<style type="text/css">
    .navbar-default {
        background: white;
    }

    .navbar-brand {
        padding-top: 5px;
    }

    .navbar-default .navbar-nav>li>a, .btn-default, .radio label, .checkbox label
    {
        color: #32465D;
        font-weight: bolder;
        font-size: 16px;
    }

    .btn {
        font-weight: bolder;
        font-size: 16px;
    }
    .title{
        margin-top:100px;
        background:#32465D;
        font-weight: bolder;
        font-size: 16px;
        color:white;
        height:45px;
        line-height:45px;
		width:100%;
    }
</style>
<div class="col-md-12 row title yj">
    <div class="col-md-2">
        所有文档
    </div>
    <div class="col-md-2 col-md-offset-8"style="right:-100px;">
        总数：XX个
    </div>
</div>
<?php foreach($search as $document): ?>
    <div class="row" style="border-bottom:solid 2px #32465D;">
        <div class="col-md-10">
            <div class="col-md-12">
                1.&nbsp;&nbsp;<?php echo $document['title'];?>&nbsp;&nbsp;|
                <?php echo $document['upload_time'];?>&nbsp;|
                &nbsp;共<?php echo $document['page'];?>页&nbsp;|
                &nbsp;<?php echo $document['download_count'];?>次下载&nbsp;|
                &nbsp;<?php echo $document['print_count'];?>次打印&nbsp;
            </div>
            <div class="col-md-12">
                &nbsp;&nbsp;<?php echo $document['intro'];?>
            </div>
        </div>
        <div class="col-md-2">
            <img src="<?php echo base_url()?>static/public/images/star.png"/>
        </div>
    </div>
<?php endforeach; ?>





