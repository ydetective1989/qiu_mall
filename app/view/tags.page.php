<?php if($tagstpl=="tagtab"){?>

    <div class="tag-menu-wrap clear">
        <div class="fl">
            <ul class="tag-menu clear">
            <?php
            $nums = COUNT($tags);
            $i = 1;
            foreach($tags AS $rs){?>
            <li id="infoTab_<?php echo $i;?>" <?php if($i=="1"){ echo " class=\"cur\""; }?>>
            	<a href="javascript:void(0);" onclick="itemShow('taginfo_',<?php echo $i;?>,<?php echo $nums;?>,'infoTab_','cur|no');"><?php echo $rs["name"];?></a>
            </li>
            <?php $i++;}?>
            </ul>
        </div>
    </div>

    <?php
    $i = 1;
    foreach($tags AS $rs){?>
    <div class="tag-list-wrap bgwhite" id="taginfo_<?php echo $i;?>" <?php if($i>"1"){ echo"style=\"display:none\"";}?>>
        <div class="tag-list">
    	<?php if($rs["list"]){?>
	    	<?php foreach($rs["list"] AS $r){?>
	            <a href="javascript:void(0);" class="tag<?php if($mytags[$r["id"]]==$r["id"]||(!$islevel&&$r["admed"])){ echo " disable"; }?>" alt="<?php echo $r["id"]?>"><span><em class="icon-add"><?php if($r["admed"]){ echo "o"; }else{ echo "+"; }?></em><?php echo $r["name"]?></span></a>
	   		<?php }?>
   		<?php }else{?>
   		<div class="red">&nbsp;&nbsp;没有找到标签数据<br></div>
   		<?php }?>
        </div>
    </div>
    <?php $i++;}?>

<?php }elseif($tagstpl=="mytags"){?>

<?php if($mytags){?>
<?php foreach($mytags AS $rs){?>
<a href="javascript:void(0);" class="tag<?php if(!$islevel){ echo " disable"; }?>" alt="<?php echo $rs["id"]?>"><span><?php echo $rs["name"]?><?php if($islevel){?><em class="icon-close">x</em><?php }?></span></a>
<?php }?>
<?php }else{?>
还没有设置客户的标签
<?php }?>
<?php }else{?>

<script>
var tag_customsid = '<?php echo $customsid;?>';
</script>
<script type="text/javascript" src="<?php echo $S_ROOT;?>js/customs.tags.js?<?php echo date("Ymd");?>"></script>
<style>
.ctag-wrap .fl{float: left;}
.ctag-wrap .fr{float: right;}
.ctag-wrap .clear{ clear: both; zoom:1;}
.ctag-wrap .clear:after{ content: ""; display: block; clear: both; zoom:1; overflow: hidden;}

.ctag-wrap .icon{display: inline-block;width: 12px;height: 12px;background-repeat: no-repeat;}
.ctag-wrap .icon-close{background-position: -75px -25px;vertical-align: -2px;_vertical-align: 0;margin-left: 3px;}
.ctag-wrap .icon-change{background-position: -98px -125px;vertical-align: -2px;_vertical-align: 0;margin-right: 3px;}
.ctag-wrap .tag-list .tag.disable,.ctag-wrap .tag-list .tag.disable span,.ctag-wrap .tag-list .tag.disable .icon-add{color: #ccc;cursor: default;}

.ctag-wrap { width: 100%; margin: 0px auto;}
.ctag-wrap .tag-menu-wrap{border-bottom: solid 1px #498cac;}
.ctag-wrap .tag-menu-wrap ul.tag-menu{padding:0px 10px 0px 10px;}
.ctag-wrap .tag-menu-wrap ul.tag-menu li{float: left; list-style: none; font-size:12px; border: solid 1px #498cac; padding: 0px 10px; line-height: 26px; margin-right: 10px; border-bottom: 0px;}
.ctag-wrap .tag-menu-wrap ul.tag-menu li a{display: block;}
.ctag-wrap .tag-menu-wrap ul.tag-menu li.cur{ background: #498cac; color: #fff;}
.ctag-wrap .tag-menu-wrap ul.tag-menu li.cur a{color: #fff;}

.ctag-wrap .tag-my { padding: 8px 0px 8px 0px;}
.ctag-wrap .tag-my .tag{margin: 0px 0px 5px 0px;}
.ctag-wrap .tag-my .tag .icon-close{ font: bold 16px Arial;height: 16px;text-decoration: none;color: #fff;vertical-align:0px;margin-right:0px;font-weight:normal;}
.ctag-wrap .tag-my .tag span{white-space: nowrap;display: inline-block;border: 1px solid #d9d9d9;height: 20px;line-height: 20px;color: #fff; font-weight:bold; background-color: #f89f00;margin-left:8px;padding: 0 9px 0 7px;font-size: 12px;cursor: pointer; margin-bottom:5px;}
.ctag-wrap .tag-my .tag.disable,.ctag-wrap .tag-my .tag.disable span,.ctag-wrap .tag-my .tag.disable .icon-add{color: #FFF;cursor: default;}

.ctag-wrap .tag-list { padding: 8px 0px 3px 0px;}
.ctag-wrap .tag-list .tag{margin: 0px 0px 5px 0px;}
.ctag-wrap .tag-list .tag .icon-add{ font: bold 16px Arial;height: 16px;text-decoration: none;color: #FFA00A;vertical-align: -2px;margin-right:5px;}
.ctag-wrap .tag-list .tag span{white-space: nowrap;display: inline-block;border: 1px solid #d9d9d9;height: 20px;line-height: 20px;color: #333;background-color: #f9f9f9;margin-left:8px;padding: 0 9px 0 7px;font-size: 12px;cursor: pointer; margin-bottom:5px;}
</style>

<div class="ctag-wrap">
    <div class="tag-my" id="mytags_div">
    Loading...
    </div>
    <div id="tags_div">Loading...</div>
</div>
<script>
load_mytags();
load_tabtag();
</script>
<?php }?>
