<?php
class authimgAction extends Action
{

	Public function app()
	{
		$img = getFunc("verifyimg");
		$img->text = $img->getRandNum();
		$img->create();
		$img->show();
	}
}
?>