<?php require($views_path . 'public/header.php');?>
<!-- topbar starts -->
<?php require($views_path . 'public/topbar.php');?>
<!-- topbar ends -->
<div class="container-fluid">
    <div class="row-fluid">

        <!-- left menu starts -->
        <?php require($views_path . 'public/left_menu.php');?>
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block span10">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="span10">
        <!-- content starts -->
        <?php echo $layout_content;?>
        <!-- content ends -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->

<?php require($views_path . 'public/footer.php');?>


