<div class="teamlisted">
<?php if($list){ foreach($list AS $rs){?>
	<input type="hidden" name="<?php echo $val;?>[<?php echo $rs["id"];?>]" id="<?php echo $val;?>[<?php echo $rs["id"];?>]" value="<?php echo $rs["id"];?>">
	<h1><?php if($val=="orderteams"){?><input type="checkbox" name="<?php echo $val;?>ed[<?php echo $rs["id"];?>]" id="<?php echo $val;?>ed[<?php echo $rs["id"];?>]" value="<?php echo $rs["id"];?>" <?php if($teamed[$rs["id"]]==$rs["id"]){ echo "checked"; }?>><?php }?> <?php echo $rs["name"]?></h1>
	<ul>
	<?php if($rs["tree"]){ foreach($rs["tree"] AS $rw){?>
	<input type="hidden" name="<?php echo $val;?>[<?php echo $rw["id"];?>]" id="<?php echo $val;?>[<?php echo $rw["id"];?>]" value="<?php echo $rw["id"];?>">
	<li><input type="checkbox" name="<?php echo $val;?>ed[<?php echo $rw["id"];?>]" id="<?php echo $val;?>ed[<?php echo $rw["id"];?>]" value="<?php echo $rw["id"];?>" <?php if($teamed[$rw["id"]]==$rw["id"]){ echo "checked"; }?>> <?php echo $rw["numbers"];?> <?php echo $rw["name"]?></li>
	<?php }}?>
	</ul>
<?php }}?>
</div>