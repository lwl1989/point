<?php require_once(APPPATH. "views/public/base.php"); ?>
<div class="row" style="text-align:center;color:#a2a2a2;font-weight:bolder;margin-top:40px;">
            <span><?php echo $message;?></span>
</div>
<script>
    $(function() {
        setTimeout("window.location.href = '/'",2000);
    });
</script>