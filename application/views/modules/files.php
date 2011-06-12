<?php defined('SYSPATH') or die('No direct script access.'); ?>

<script type="text/javascript">
$(document).ready(function() {});
</script>

<div id="downloads">
<?php if (count($files) == 0): ?>
Файлов не найдено
<?php else: ?>
<table cellspacing="0">
<?php 
$c = 0;
if (strlen($directories) > 0): ?>
    <tr class="odd">
        <td><img src="/media/img/icon_folder.gif" width="22" height="20" /></td>
        <td><a href="javascript:history.back(1)">..</a></td>
        <td>-</td>
        <td>-</td>
    </tr>
<?php 
$c++;
endif;

foreach ($files AS $file): 
    $c++;
    if ($file['type'] == 'dir') {
        $link = '/'.$uri.'?'.$directories.$file['file'];
    } else {
        $dir = str_replace('/', '_', substr($uri, 3));
        $link = '/download/'.$dir.'/'.$directories.$file['file'];
    }
    ?>
    <tr <?php echo (($c % 2) ? 'class="odd"' : ''); ?>>
        <td><img src="/media/img/<?php
        switch ($file['type']) {
            case 'zip': 
            case 'rar': 
            case '7z': 
                echo 'icon_zip.gif'; 
                break;
            case 'jpg': 
            case 'jpeg': 
            case 'gif': 
                echo 'icon_jpg.gif'; 
                break;
            case 'png': 
            case 'tif': 
                echo 'icon_png.png'; 
                break;
            case 'dir': 
                echo 'icon_folder.gif'; 
                break;
            default:
                echo 'icon_file.gif';
                break;
        }
        ?>" width="22" height="20" /></td>
        <td><a href="<?php echo $link; ?>"><?php echo $file['name']; ?></a></td>
        <td><?php 
        if ($file['type'] != 'dir') {
            $size = $file['size'] / 1024 / 1024;
            if ($size < 1) {
                $size = number_format(($size * 1024), 2).' KB';
            } else {
                $size = number_format(($size), 2).' MB';
            }
        } else {
            $size = '-';
        }
        echo $size; 
        ?></td>
        <td><?php echo $file['date']; ?></td>
    </tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
