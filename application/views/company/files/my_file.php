<?php
/**
 * Created by PhpStorm.
 * User: o0无忧亦无佈(285753421@qq.com)
 * Date: 15-2-4
 * Time: 下午5:37
 */

?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta http-equiv="content-type" content="text/html;charset=utf-8">
<table>
    <tr>
        <th>文件名</th>
        <th>点赞数</th>
        <th>收藏数</th>
        <th>操作</th>
    </tr>
    <?php foreach($file_list as $file): ?>
    <tr>
        <td><?php echo $file['title'] ?></td>
        <td><?php echo $file['like'] ?></td>
        <td><?php echo $file['collect'] ?></td>
        <td><a href="del/<?php echo $file['id'] ?>"  >删除</a> </td>
    </tr>
    <?php endforeach ?>
</table>