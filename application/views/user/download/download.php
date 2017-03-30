<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-2-27
 * Time: 下午2:15
 * 
 */


    <table width="100%" border="1">
      <tr>
         <th style="width:10px;"><input type="checkbox" name="check_all" /></th>
         <th style="width:300px;">文档名称</th>
         <th style="width:30px;">&nbsp;</th>
         <th style="width:80px;">文档大小</th>
         <th style="width:165px;">评论</th>
         <th style="width:90px;">上传时间</th>
         <th>下载量</th>
         <th>打印量</th>
      </tr>
	  <?php foreach ($my_download as $download): ?>
    <tr>
        <td><?php echo $download['file_id'];?></td>
        <td><?php echo $download['place_time'];?></td>
        <td><a href="<?php echo(site_url('user/download/index').'/'.$download['file_id']);?>">下载</a></td>        
    </tr>
         
        <?php foreach ($download['message'] as $info): ?>
        <tr>
            <td>
                <?php echo $info['file_id']; ?>
            </td>
            <td>
                <?php echo $info['title']; ?>
            </td>
            <td>
                <?php echo $info['file_num']; ?>
            </td>
        </tr>
        <?php endforeach ?>
    <?php endforeach; ?>
   </table>