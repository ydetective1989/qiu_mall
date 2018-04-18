<?php
class tagsAction extends Action {


	Public function tags() {
		extract($_GET);
		$customs = getModel("customs");
		$this->users->onlogin();
		if ($do == "mytags") {

			$islevel = $this->users->getlevel();
			$this->tpl->set("islevel", $islevel);
			$customsid = (int) base64_decode($customsid);
			$mytags = $customs->mytags("customsid=$customsid");
			$this->tpl->set("mytags", $mytags);

		} elseif ($do == "tagtab") {

			$islevel = $this->users->getlevel();
			$this->tpl->set("islevel", $islevel);
			$customsid = (int) base64_decode($customsid);
			$rows = $customs->tags("parentid=0");
			$arr = array();
			foreach ($rows AS $rs) {
				$id = (int) $rs["id"];
				$rs["list"] = $customs->tags("parentid=" . $id . "");
				$arr[] = $rs;
			}
			$rows = $arr;
			$this->tpl->set("tags", $rows);
			$mytags = $customs->mytags("customsid=$customsid");
			if ($mytags) {
				$arr = array();
				foreach ($mytags AS $rs) {
					$arr[$rs["id"]] = $rs["id"];
				}
				$mytags = $arr;
			}
			$this->tpl->set("mytags", $mytags);

		} elseif ($do == "add") {

			$customsid = (int) base64_decode($customsid);
			$ordersid = (int) base64_decode($ordersid);
			$rows = $customs->tagsed("do=add&ordersid=$ordersid&customsid=$customsid&tagid=$tagid");
			exit;

		} elseif ($do == "del") {

			$customsid = (int) base64_decode($customsid);
			$ordersid = (int) base64_decode($ordersid);
			$rows = $customs->tagsed("do=del&ordersid=$ordersid&customsid=$customsid&tagid=$tagid");
			exit;

		} else {
			exit;
		}

		$this->tpl->set("tagstpl", $do);
		$this->tpl->display("tags.page.php");

	}

}
?>
