<div class="level">
  <?php if($levels){ foreach($levels AS $rs){?>
  <?php if($rs["tree"]){ ?>
  <div>
    <span class="bold"><?php echo $rs["name"]?>：</span>
  </div>
  <div>
    <?php foreach($rs["tree"] AS $r){?>
    <span><input type="checkbox" name="grouplevel[]" value="<?php echo $r["id"];?>" <?php if($grouplevel[$r["id"]]==$r["id"]){ echo "checked"; }else{ if($userslevel[$r["id"]]==$r["id"]){ echo "checked"; }  }?> <?php if($grouplevel[$r["id"]]==$r["id"]){ echo "disabled='disabled'"; }?> /> <?php echo $r["name"];?></span>
    <?php }?>
  </div>
  <?php }?>
  <?php }}?>
</div>
