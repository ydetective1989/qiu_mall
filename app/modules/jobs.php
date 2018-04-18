<?php

class jobsModules extends Modules
{
    public function getrow($str)
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        $id = (int) $id;
        $query = ' SELECT job.*,teams.parentid AS afterarea,teams.name AS afters,st.parentid AS salespid,
				au.name AS addname,afu.name AS aftername,awu.name AS workname,o.ordernum,
        cu.name AS checkuname
				FROM '.DB_ORDERS.'.job_orders AS job
				INNER JOIN '.DB_ORDERS.'.orders AS o ON o.id = job.ordersid
				INNER JOIN '.DB_ORDERS.'.users AS au ON job.adduserid = au.userid
        INNER JOIN '.DB_ORDERS.'.users AS cu ON job.checkuserid = cu.userid
				INNER JOIN '.DB_ORDERS.'.users AS afu ON job.afteruserid = afu.userid
				INNER JOIN '.DB_ORDERS.'.users AS awu ON job.workuserid = awu.userid
				INNER JOIN '.DB_ORDERS.'.config_teams AS teams ON job.afterid = teams.id
				INNER JOIN '.DB_ORDERS.".config_teams AS st ON o.salesid = st.id
				WHERE job.id = $id ";
        $jobsinfo = $this->db->getRow($query);
        return $jobsinfo;
    }

    public function getrows($str = '')
    {
        //echo $str."/n";
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($ordersid || $jobsid || $contract) {
            if ($ordersid) {
                $ordersid = (int) $ordersid;
                $where .= " AND job.ordersid = $ordersid ";
            }

            if ($jobsid) {
                $jobsid = (int)$jobsid;
                $where .= " AND job.id = $jobsid ";
            }

            if ($jobnum) {
                $jobnum = trim($jobnum);
                $where .= " AND job.jobnum = '$jobnum' ";
            }
            if ($contract!= '') {
                $contract = trim($contract);
                $where .= " AND job.contract like '%".$contract."'";
            }
        } else {
            if ($godate) {
                $where .= " AND job.datetime >= '".$godate."' ";
            }
            if ($todate) {
                $where .= " AND job.datetime <= '".$todate."' ";
            }
            if ($godate == '' && $todate == '') {
                $godate = $todate = date('Y-m-d');
                $where .= " AND job.datetime >= '".$godate."' ";
                $where .= " AND job.datetime <= '".$todate."' ";
            }
        }

        if ($type != '') {
            $type = (int) $type;
            $where .= " AND job.type = '".$type."'";
        }

        if ($worked != '') {
            $worked = (int) $worked;
            $where .= " AND job.worked = '".$worked."'";
        }

        $afterarea = (int) $afterarea;
        if ($afterarea) {
            $where .= " AND ct.parentid = '".$afterarea."'";
        }

        $afterid = (int) $afterid;
        if ($afterid) {
            if ($userid) {
                $where .= " AND (ct.id = '".$afterid."' OR job.afteruserid = '".$userid."' ) ";
            } else {
                $where .= " AND ct.id = '".$afterid."'";
            }
        }

        if ((int) $afteruserid) {
            $afteruserid = (int) $afteruserid;
            $where .= " AND job.afteruserid = '".$afteruserid."'";
        }

        if ($checked != '') {
            $checked = (int) $checked;
            $where .= " AND job.checked = '".$checked."'";
        }

        if ($otype != '') {
            $otype = (int) $otype;
            $where .= " AND o.type = '".$otype."'";
        }

        if ($delivertype) {
            $delivertype = (int) $delivertype;
            $where .= " AND o.delivertype = '".$delivertype."'";
        }

        if ($ochecked != '') {
            $ochecked = (int) $ochecked;
            $where .= " AND o.checked = '".$ochecked."'";
        }
        //销售区域
        $salesarea = (int) $salesarea;
        if ($salesarea) {
            $where .= " AND st.parentid = $salesarea ";
        }
        //销售中心
        $salesid = (int) $salesid;
        if ($salesid) {
            $where .= " AND st.id = $salesid ";
        }

        if ($ordered == '1') {
            $where .= ' AND o.status NOT IN(7,-1) ';
        }

        $asc = ($asc == 'DESC') ? 'DESC' : 'ASC';

        switch ($order) {
            case 'afteruserid'  : $order = " job.afteruserid $asc,";  break;
            case 'adduserid'    : $order = " job.adduserid $asc,";    break;
            case 'datetime'     : $order = " job.datetime $asc,";     break;
            default : $order = '';
        }

        if ($nums) {
            $nums = (int) $nums;
        } else {
            $nums = '10';
        }

        $joblist = (int) $joblist;
        if ($joblist == '0') {
            $userid = (int) $this->cookie->get('userid');
            $users = getModel('users');
            $userinfo = $users->getrow("userid=$userid");
            if ((int) $userinfo['jobsed'] == '0' && $userinfo['isadmin'] == '0') {
                if ($level) {
                    $owhere = '';
                    $query = ' SELECT t.id
          					FROM '.DB_ORDERS.'.config_teams AS t
          					INNER JOIN '.DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid
          					WHERE ctj.userid = $userid
          					ORDER BY t.id ASC ";
                    $rows = $this->db->getRows($query);
                    $idarr = array();
                    if ($rows) {
                        foreach ($rows as $rs) {
                            $arr[] = $rs['id'];
                        }
                        $idrows = implode(',', $arr);
                        $owhere = " OR job.afterid IN($idrows) ";
                    }
                }
                $where .= " AND ( job.afteruserid = $userid $owhere ) ";
            }
        }

        $show = (int) $show;
        $query = ' SELECT job.id,job.jobnum,job.ordersid,job.type,job.datetime,job.dateline,job.checked,job.worked,job.detail,
    		au.name AS addname,afu.name AS aftername,job.workdate,job.workdetail,job.workdateline,job.checkdate,
    		job.workdateline,o.pointlng,o.pointlat,st.name AS salesname,ct.name AS afters,o.delivertype,
    		pa.name AS provname,ca.name AS cityname,aa.name AS areaname,o.parentid,o.address,job.workto,
    		wu.name AS workuname
    		FROM '.DB_ORDERS.'.job_orders AS job
    		INNER JOIN '.DB_ORDERS.'.orders AS o ON o.id = job.ordersid
    		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
    		INNER JOIN '.DB_ORDERS.'.config_teams AS ct ON job.afterid = ct.id
    		INNER JOIN '.DB_ORDERS.'.users AS au  ON job.adduserid = au.userid
    		INNER JOIN '.DB_ORDERS.'.users AS afu ON job.afteruserid = afu.userid
    		INNER JOIN '.DB_ORDERS.'.users AS wu ON job.workuserid = wu.userid
    		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
    		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
    		INNER JOIN '.DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
    		WHERE job.openid = ".OPEN_ID." AND job.hide = 1 AND o.hide = 1 $where
    		ORDER BY $order job.datetime DESC,job.id DESC ";
        //if($this->cookie->get("userid")==9){ echo $query; }
        if ($page) {
            $this->db->keyid = 'job.id';
            $rows = $this->db->getPageRows($query, $nums, $show);
        } else {
            if ((int) $xls == '0') {
                $start = ($start) ? (int) $start : '0';
                $limt = " LIMIT $start,$nums ";
                $rows = $this->db->getRows($query.$limt);
            } else {
                $xdb = xdb();
                $rows = $xdb->getRows($query);
            }
        }
        //print_r($rows);
        return $rows;
    }

    //取得服务站信息
    public function aftergroup($str = '')
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        //用户ID
        $userid = (int) $this->cookie->get('userid');
        $users = getModel('users');
        $userinfo = $users->getrow("userid=$userid");

        if ($checked != '') {
            $checked = (int) $checked;
            $where .= " AND ct.checked = $checked ";
        }

        if (!$userinfo['isadmin'] && !$userinfo['jobsed'] && !(int) $listall) {
            $owhere = '';
            $query = ' SELECT t.id
      			FROM '.DB_ORDERS.'.config_teams AS t
      			INNER JOIN '.DB_ORDERS.".config_teams_jobs AS ctj ON t.id = ctj.teamid
      			WHERE t.openid = ".OPEN_ID." AND ctj.userid = $userid
      			ORDER BY t.id ASC ";
            $rows = $this->db->getRows($query);
            $idarr = array();
            if ($rows) {
                foreach ($rows as $rs) {
                    $arr[] = $rs['id'];
                }
                $idrows = implode(',', $arr);
                $where = " AND ct.id IN($idrows) ";
            } else {
                return false;
            }
        }

        $show = (int) $show;
        $query = ' SELECT ct.id,ct.name,ct.numbers
    		FROM '.DB_ORDERS.".config_teams AS ct
    		WHERE ct.openid = ".OPEN_ID." AND ct.type = 3 AND ct.hide = 1 AND ct.checked = 1  AND parentid<>0 $where
    		ORDER BY ct.numbers ASC,ct.orderd DESC ";
        return $this->db->getRows($query);
    }

    //添加工单记录
    public function add()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $userid = (int) $this->cookie->get('userid');

    		//生成流水号
    		$randstr  = str_pad(substr($this->cookie->get("userid"),-3),3,"0",STR_PAD_LEFT).rand(0,9);
    		$jobnum = date("YmdH",time()).$randstr;		//请与贵网站订单系统中的唯一订单号匹配

        $arr = array(
            'openid'  =>  OPEN_ID,
            'jobnum'  =>  $jobnum,
            'type'    => (int) $type,
            'erpnum'  => trim($erpnum),
            'ordersid' => $ordersid,
            'detail' => trim($detail),
            'datetime' => $datetime,
            'adduserid' => $userid,
            'dateline' => time(),
            'afterid' => (int)JOBS_ID
        );
        $this->db->insert(DB_ORDERS.'.job_orders', $arr);
        $id = (int) $this->db->getLastInsId();
        $logsarr .= plugin::arrtostr($arr);

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '增加工单#'.$id.'：['.$datetime.']'.plugin::cutstr($detail, 10),
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $this->db->insert(DB_ORDERS.'.orders_logs', $arr);

        //默认加入关注
        $focus = getModel('focus');
        $focus->addfav("cates=gd&id=$id&userid=$afteruserid");

        // if ($afteruserid) {
        //     $notes = getModel('notes');
        //     $notes->insert("type=1&ordersid=$ordersid&userid=$afteruserid&content=有一条来自订单[".$ordersid.']的新增派工信息：['.$datetime.']'.$detail);
        // }

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=insert&ordersid=$ordersid&name=工单信息[录入]&detail=录入订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    //修改工单记录
    public function edit()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $userid = (int) $this->cookie->get('userid');
        $where = array('id' => $id);
        $arr = array(
            'type' => (int) $type,
            'detail' => trim($detail),
            'datetime' => $datetime,
        );
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);

        // $arr = array(
        //     'ordersid' => (int) $ordersid,
        //     'type' => 0,
        //     'detail' => '修改工单#'.$id.'：['.$datetime.']'.$detail,
        //     'datetime' => date('Y-m-d'),
        //     'userid' => $userid,
        //     'dateline' => time(),
        // );
        // $logsarr .= plugin::arrtostr($arr);
        //$this->db->insert(DB_ORDERS.".orders_logs",$arr);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[更新]&detail=更新订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    public function transfer()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $where = array('id' => $id);
        $userid = (int) $this->cookie->get('userid');
        $arr = array(
            'afterid' => $afterid,
        );
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '移交工单#'.$id.'：'.$detail,
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $this->db->insert(DB_ORDERS.'.orders_logs', $arr);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[移交]&detail=转移订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");
    }

    public function revise()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $userid = (int) $this->cookie->get('userid');
        $where = array('id' => $id);
        $arr = array(
                'detail' => trim($detail),
                'datetime' => $datetime,
                'afteruserid' => $afteruserid,
        );
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);

        // if ($afteruserid) {
        //     $where = array('jobsid' => $id, 'hide' => 1);
        //     $this->db->delete(DB_FUWU.'.push_weixin', $where);
        //     $arr = array(
        //         'jobsid' => (int) $id,
        //         'userid' => $afteruserid,
        //         'dateline' => time(),
        //         'hide' => 1,
        //     );
        //     $logsarr .= plugin::arrtostr($arr);
        //     $this->db->insert(DB_FUWU.'.push_weixin', $arr);
        // }

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '分配工单#'.$id.'：['.$datetime.']'.$detail,
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        //$this->db->insert(DB_ORDERS.".orders_logs",$arr);

        // $notes = getModel('notes');
        // $notes->insert("type=1&ordersid=$ordersid&userid=$afteruserid&content=有一条来自订单[".$ordersid.']的分配派工信息：['.$datetime.']'.$detail);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[分配]&detail=分配订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    public function tofuwu()
    {
        extract($_POST);
        $info = $this->info;
        $id   = (int) $this->id;
        $ordersid = (int)$info["ordersid"];
        $orders = getModel("orders");
        $orderinfo = $orders->getrow("id=$ordersid");
        $orderlist = $orders->ordersinfo("ordersid=$ordersid&group=1");
        $userid = $this->cookie->get("userid");

        if(!$orderinfo){ return "订单信息不存在"; }
        if(!$orderlist){ return "订购信息不存在"; }

        $plist   = array();
        foreach($orderlist AS $rs){
            $plist[] = array("name"=>$rs["title"],"encoded"=>$rs["encoded"],"serial"=>"","nums"=>$rs["nums"]);
        }

        switch($info["type"]){
            case "2": $jobstype = "2"; break;
            case "5": $jobstype = "5"; break;
            case "6": $jobstype = "6"; break;
            default : $jobstype = "0";
        }
        $data   = array();
        $data["orderid"]  = "OWS||".$info["id"];
        $data["name"]     = $orderinfo["name"];
        $data["type"]     = $jobstype;
        $data["buydate"]  = $orderinfo["datetime"];
        $data["prov"]     = $orderinfo["provname"];
        $data["city"]     = $orderinfo["cityname"];
        $data["area"]     = $orderinfo["areaname"];
        $data["address"]  = $orderinfo["address"];
        $data["mobile"]   = $orderinfo["mobile"];
        $data["phone"]    = $orderinfo["phone"];
        $data["detail"]   = $orderinfo["detail"];
        $data["productinfo"]  = $plist;
        $data["datetime"] = ($datetime)?$datetime:date("Y-m-d");
        $data["jobsinfo"] = ($detail)?$detail:"OWS系统推送工单";

        $post = array();
        $dateline = date("Y-m-d H:i:s");
        $method = "jobs.add";
        $state = $userid;
        $bodyjson = json_encode($data);
        //echo FUWU_SECRET.FUWU_APPKEY.$state.$dateline.$bodyjson.$method.FUWU_APPKEY.FUWU_SECRET;exit;
        $sign = strtoupper(md5(FUWU_SECRET.FUWU_APPKEY.$state.$dateline.$bodyjson.$method.FUWU_APPKEY.FUWU_SECRET));
        //echo $sign;exit;
        $post["header"] = array(
            "appkey"  =>  FUWU_APPKEY,
            "method"  =>  $method,
            "dateline"=>  $dateline,
            "sign"    =>  $sign,
            "state"   =>  $state
        );
        $post["body"] =  json_encode($data);
        $postinfo = "data=".json_encode($post);
        $curl = getFunc("curl");
        $fuwuurl = FUWU_URLTO;
        $json = $curl->contents($fuwuurl,$postinfo);
        $rows = json_decode($json,true);
        if($rows["code"]=="200"){
            $fuwu_jobsid = $rows["data"]["jobsid"];
            $where = array("id"=>$id);
            $arr   = array("contract"=>$fuwu_jobsid,"worked"=>"1","workdate"=>date("Y-m-d"),
            "workuserid"=>$userid,"workdetail"=>"已交由无忧服务接单！#".$fuwu_jobsid,"workdateline"=>time());
            $this->db->update(DB_ORDERS.".job_orders",$arr,$where);
            return 1;
        }else{
            return $rows["message"];
        }
    }








    //删除工单记录
    public function del()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $where = array('id' => $id);
        $arr = array(
            'hide' => 0,
        );
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '删除工单#'.$id,
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $this->db->insert(DB_ORDERS.'.orders_logs', $arr);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=delete&ordersid=$ordersid&name=工单信息[删除]&detail=删除订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    //确认工单记录
    public function checked()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;

        $userid = (int) $this->cookie->get('userid');
        $where = array('id' => $id);
        $arr = array(
            'checked' => 1,
            'checkuserid' => $userid,
            'checkdate' => time(),
        );
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);

        // if($point){
        //     $parr = explode(',', $point);
        //     $arr = array('pointlng' => trim($parr[0]), 'pointlat' => trim($parr[1]));
        //     $where = array('id' => $ordersid);
        //     $this->db->update(DB_ORDERS.'.orders', $arr, $where);
        //     $logsarr .= plugin::arrtostr($arr);
        // }

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '确认工单#'.$id,
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $this->db->insert(DB_ORDERS.'.orders_logs', $arr);

        //0 = 等待接单 1 = 完成  2 = 等待上门  4 = 工单取消
        // $arr = array(
        //     'jobsid' => $id,
        //     'worked' => 2,
        //     'worktime' => time(),
        // );
        // $this->db->insert(DB_FUWU.'.push_jobs', $arr);

        //工单确认后，调整订单状态
        // $jobstype = $this->jobstype();
        // $query = ' SELECT type FROM '.DB_ORDERS.".job_orders WHERE id = $id ";
        // $row = $this->db->getRow($query);
        // $type = (int) $row['type'];
        // $status = (int) $jobstype[$type]['status'];
        //
        // $query = ' SELECT status FROM '.DB_ORDERS.".orders WHERE id = $ordersid ";
        // $orderinfo = $this->db->getRow($query);
        // if ($ordersinfo['status'] != '1' && $ordersinfo['status'] != '6') {
        //     $arr = array('status' => $status);
        //     $where = array('id' => $ordersid);
        //     $this->db->update(DB_ORDERS.'.orders', $arr, $where);
        //     $logsarr .= plugin::arrtostr($arr);
        // }
        // //控制中心
        // $this->monitor("show=checked&id=$id");

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[确认]&detail=确认订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    public function toall()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $userid = (int) $this->cookie->get('userid');
        $arr['afterid'] = (int) $afterid;
        $arr['afteruserid'] = '0';
        $arr['datetime'] = $datetime;
        $arr['detail'] = $detail;
        $logsarr .= plugin::arrtostr($arr);
        $where = array('id' => $id);
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);

        $arr = array(
            'ordersid' => (int) $ordersid,
            'type' => 0,
            'detail' => '变更工单#'.$id.'：'.$detail,
            'datetime' => date('Y-m-d'),
            'userid' => $userid,
            'dateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $this->db->insert(DB_ORDERS.'.orders_logs', $arr);
        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[变更]&detail=[高级接口]变更订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    //回执派工信息
    public function worked()
    {
        extract($_POST);
        $ordersid = (int) $this->ordersid;
        $id = (int) $this->id;
        $userid = (int) $this->cookie->get('userid');

        if ((int) $type == '0') {
            return '操作失败，因为你没有回执状态！';
        }

        $arr = array(
            'worked' => (int) $type,
            'workdate' => date('Y-m-d'),
            'workuserid' => (int) $userid,
            'workdetail' => $detail,
            'workdateline' => time(),
        );
        $logsarr .= plugin::arrtostr($arr);
        $where = array('id' => $id);
        $this->db->update(DB_ORDERS.'.job_orders', $arr, $where);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=update&ordersid=$ordersid&name=工单信息[回执]&detail=回执订单[".$ordersid.']的工单#'.$id."&sqlstr=$logsarr");

        return 1;
    }

    //统计当日派工量
    public function dayplan($str)
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        if ($id) {
            $where = " AND id != $id ";
        }
        $query = ' SELECT COUNT(id) AS total FROM '.DB_ORDERS.".job_orders WHERE hide = 1 AND afterid = $afterid AND datetime = '$datetime' $where ";//AND worked = 0
        $info = $this->db->getRow($query);

        return $info['total'];
    }

    //统计服务站最大派工量
    public function maxplan($str)
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        $query = ' SELECT maxplan,minplan FROM '.DB_ORDERS.".config_teams WHERE id = $afterid  ";
        $info = $this->db->getRow($query);
        $w = date('w', strtotime($datetime));
        if ($w == '6' || $w == '0') {
            return $info['maxplan'];
        } else {
            return $info['minplan'];
        }
    }

    public function maprows($str = '')
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        if ($ordersid) {
            $ordersid = (int) $ordersid;
            $where .= " AND jobs.ordersid != $ordersid ";
        }
        if ($afterid) {
            $afterid = (int) $afterid;
            $where .= " AND jobs.afterid = $afterid ";
        }
        if ($pointed) {
            $where .= " AND o.pointlng!='0' AND o.pointlng!='0' ";
        }
        if ($pointarr) {
            $parr = @explode('||', $pointarr);
            $where .= " AND o.pointlng >= '".$parr[0]."' AND o.pointlng <= '".$parr[1]."' AND o.pointlat >= '".$parr[2]."' AND o.pointlat <= '".$parr[3]."' ";
        }
        $query = 'SELECT jobs.id AS jobsid,jobs.datetime,jobs.type,jobs.ordersid,jobs.detail,o.pointlng,o.pointlat,
    		jobs.checked,jobs.worked
    		FROM '.DB_ORDERS.'.job_orders AS jobs
    		INNER JOIN '.DB_ORDERS.".orders AS o ON jobs.ordersid = o.id
    		WHERE jobs.hide = 1 AND jobs.datetime = '$datetime' AND jobs.worked = 0 AND jobs.id!='".(int) $jobsid."' $where ";

        return $this->db->getRows($query);
    }


    public function feedback($str = '')
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if($keywords != ''){
  					if($type=="phone"){
              $phone = trim($keywords);
              $where .= " AND phone = '$phone' ";
  					}elseif($type=="name"){
  							$where.=" AND name  like '".$keywords."%' ";
  					}else{
              $where.=" AND address  like '%".$keywords."%' ";
            }
  			}

        if ($godate) {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND dateline >= '$gotime'  ";
        }
        if ($todate){
            $totime = strtotime($totime.' 23:59:59');
            $where .= " AND dateline <= '$totime' ";
        }

        if ($checked != '') {
            $checked = (int) $checked;
            $where .= " AND checked = $checked ";
        }

        if ($nums) {
            $nums = (int) $nums;
        } else {
            $nums = '10';
        }

        $show = (int) $show;

        if ($order) {
            $desc = ($desc == 'ASC') ? $desc : 'DESC';
            switch ($order) {
                case 'dateline' : $orderd = 'dateline '.$desc.','; break;
                default : $orderd = '';
            }
        }
        $query = ' SELECT *
        FROM '.DB_ORDERS.".job_feedback
        WHERE openid = ".OPEN_ID." AND hide = 1 $where
		    ORDER BY $orderd id DESC ";
        if ($page) {
            $this->db->keyid = 'id';
            $rows = $this->db->getPageRows($query, $nums, $show);
        } else {
            if ((int) $xls == '0') {
                $start = ($start) ? (int) $start : '0';
                $limt = " LIMIT $start,$nums ";
                $rows = $this->db->getRows($query.$limt);
            } else {
                $xdb = xdb();
                $rows = $xdb->getRows($query);
            }
        }

        return $rows;
    }

    public function feedback_getrow($str = '')
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        $query = 'SELECT jf.*,cu.name AS checkuname,pa.name AS provname,ca.name AS cityname,aa.name AS areaname
    		FROM '.DB_ORDERS.'.job_feedback AS jf
    		INNER JOIN '.DB_ORDERS.".users AS cu ON cu.userid = jf.checkuserid
    		INNER JOIN ".DB_CONFIG.".areas AS pa ON jf.provid = pa.areaid
    		INNER JOIN ".DB_CONFIG.".areas AS ca ON jf.cityid = ca.areaid
    		INNER JOIN ".DB_CONFIG.".areas AS aa ON jf.areaid = aa.areaid
    		WHERE jf.id = $id AND jf.hide = 1
    		GROUP BY jf.id  ";
        $row = $this->db->getRow($query);
        if($row["openid"]<>OPEN_ID){ appError(); }
        return $row;
    }

    public function feedback_checked()
    {
        extract($_POST);
        $id = (int) $this->id;
        $where = array('id' => $id);
        $arr = array(
            'checked' => (int) $checked,
            'checkinfo' => $detail,
            'checkuserid' => (int) $this->cookie->get('userid'),
            'checkdate' => time(),
        );
        $this->db->update(DB_ORDERS.'.job_feedback', $arr, $where);
        $logsarr .= plugin::arrtostr($arr);
        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=delete&ordersid=$ordersid&name=服务预约[删除]&detail=处理服务预约信息#".$id."&sqlstr=$logsarr");

        return 1;
    }

    public function workto()
    {
        $ds = array();
        $ds[0] = array('id' => '0',    'name' => 'PAAS系统');
        $ds[1] = array('id' => '1',    'name' => 'PAASAPP');
        $ds[2] = array('id' => '2',    'name' => '服务平台');
        $ds[3] = array('id' => '3',    'name' => '微信平台');

        return $ds;
    }

    public function jobstype()
    {
        $ds = array();
        $ds[2] = array('id' => '2',    'name' => '安装',        'status' => '5',    'price' => '30',    'worked' => '6');
        //$ds[3]	= array('id' =>'3',	'name'	=> '送货',	'status' =>	'3',	'worked'=>'6');
        //$ds[1]	= array('id' =>'1',	'name'	=> '出库',	'status' =>	'2',	'worked'=>'2');
        $ds[5] = array('id' => '5',    'name' => '维修',        'status' => '6',    'price' => '20',    'worked' => '6');
        $ds[6] = array('id' => '6',    'name' => '耗材',        'status' => '6',    'price' => '20',    'worked' => '6');
        //$ds[4]	= array('id' =>'4',	'name'	=> '水质检测','status' =>	'6',	'worked'=>'6');
        //$ds[7]	= array('id' =>'7',	'name'	=> '收款',	'status' =>	'6',	'worked'=>'6');
        //$ds[8] = array('id' => '8',    'name' => '业务',        'status' => '6',    'price' => '0',    'worked' => '6');
        $ds[0] = array('id' => '0',    'name' => '其它',        'status' => '6',    'price' => '0',    'worked' => '6');

        return $ds;
    }

    public function worktype()
    {
        $ds = array();
        $ds[0] = array('id' => '0',    'name' => '等待处理',        'tname' => '待处理',    'hide' => '1',    'color' => 'red');
        $ds[2] = array('id' => '2',    'name' => '变更调整',        'tname' => '已变更',        'hide' => '0',    'color' => 'orange');
        $ds[1] = array('id' => '1',    'name' => '完成工单',        'tname' => '已完成',        'hide' => '1',    'color' => 'green');
        //$ds[3]	= array('id' =>'3',	'name'	=> '其它',		'tname'	=>	'其它',		'color'	=>	'green');
        $ds[4] = array('id' => '4',    'name' => '取消工单',        'tname' => '已取消',        'hide' => '1',    'color' => 'green');
        return $ds;
    }

}
