<?php

class jobsAction extends Action
{
    public function app()
    {
    }

    //添加派工
    public function add()
    {
        $this->users->dialoglogin();        //登录判断
        $this->users->dialoglevel();        //权限判断
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $userid = (int) $this->cookie->get('userid');
            $ordersid = (int) base64_decode($_POST['ordersid']);
            $jobs->ordersid = $ordersid;
            $jobs->add();
            echo '1';
        } else {
            $orders = getModel('orders');
            $ordersid = (int) base64_decode($_GET['id']);
            $orderinfo = $orders->getrow("id=$ordersid");
            $provid = (int) $orderinfo['provid'];
            $cityid = (int) $orderinfo['cityid'];
            $areaid = (int) $orderinfo['areaid'];
            if (!$provid || !$areaid || !$cityid) {
                dialog('客户所在省份城市设置不正确，请先修改订单！');
            }
            $this->tpl->set('orderinfo', $orderinfo);
            $this->tpl->set('provid', $provid);
            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $this->tpl->set('type', 'jobsinfo');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //派工修改
    public function edit()
    {
        $this->users->dialoglogin();    //登录判断
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $userid = (int) $this->cookie->get('userid');
            $id = (int) base64_decode($_POST['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = $info['ordersid'];
            $jobs->ordersid = $ordersid;
            $jobs->id = $id;
            $jobs->edit();
            echo '1';
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = (int) $info['ordersid'];
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            //if(!$islevel){
            if ($info['adduserid'] != $userid) {
                dialog('你没有权限修改工单信息！');
            }
            //}
            if ($info['checked'] == 1) {
                dialog('派工已确定，无法进行修改！');
            }
            if ($info['worked'] != 0) {
                dialog('派工已操作，无法进行修改！');
            }
            $this->tpl->set('info', $info);

            $orders = getModel('orders');
            $orderinfo = $orders->getrow("id=$ordersid");
            $this->tpl->set('orderinfo', $orderinfo);

            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $this->tpl->set('type', 'jobsinfo');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //服务站调整
    public function toall()
    {
        $this->users->dialoglogin();    //登录判断
        $this->users->dialoglevel();    //判断页面权限
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $userid = (int) $this->cookie->get('userid');
            $id = (int) base64_decode($_POST['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = $info['ordersid'];
            $jobs->ordersid = $ordersid;
            $jobs->id = $id;
            $jobs->tofuwu();
            echo '1';
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = (int) $info['ordersid'];
            $userid = (int) $this->cookie->get('userid');
            $timeline = time() - 21600;//计算前一天
            if ($info['checked'] == 1) {
                //dialog("派工已确定，无法进行修改！");
            }
            if ($info['worked'] != 0) {
                dialog('派工已操作，无法进行修改！');
            }
            $this->tpl->set('info', $info);

            $orders = getModel('orders');
            $orderinfo = $orders->getrow("id=$ordersid");
            if ((int) $orderinfo['checked'] != '1') {
                dialog('订单没有审核，无法通过全局分配派工！');
            }
            $provid = (int) $orderinfo['provid'];
            $cityid = (int) $orderinfo['cityid'];
            $areaid = (int) $orderinfo['areaid'];
            if (!$provid || !$areaid || !$cityid) {
                dialog('客户所在省份城市设置不正确，请先修改订单！');
            }

            $teams = getModel('teams');
            $afterarea = $teams->getrows('checked=1&parentid=0&type=3');
            $this->tpl->set('afterarea', $afterarea);

            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $this->tpl->set('type', 'toall');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //派给无忧服务
    public function tofuwu()
    {
        $this->users->dialoglogin();    //登录判断
        $this->users->dialoglevel();    //判断页面权限
        $jobs = getModel('jobs');
        $id = (int) base64_decode($_GET['id']);
        $info = $jobs->getrow("id=$id");
        $ordersid = (int) $info['ordersid'];
        if (isset($_POST) && !empty($_POST)) {

            $jobs->info = $info;
            $jobs->id = $id;
            $msg = $jobs->tofuwu();
            echo $msg;

        } else {

            $userid = (int) $this->cookie->get('userid');
            $timeline = time() - 21600;    //计算前一天
            if ($info['checked'] != 1) {
                dialog('工单未确认，无法推送至无忧服务');
            }
            if ($info['worked'] != 0) {
                dialog('派工状态已操作，无法进行推送！');
            }
            $this->tpl->set('info', $info);

            $orders = getModel('orders');
            $orderinfo = $orders->getrow("id=$ordersid");
            if ((int) $orderinfo['checked'] != '1') {
                dialog('订单没有审核，无法推送派工！');
            }
            if ((int) $orderinfo['status'] == '-1') {
                dialog('订单已取消，无法推送派工！');
            }
            $provid = (int) $orderinfo['provid'];
            $cityid = (int) $orderinfo['cityid'];
            $areaid = (int) $orderinfo['areaid'];
            if (!$provid || !$areaid || !$cityid) {
                dialog('客户所在省份城市不完整，请先修改订单！');
            }
            $this->tpl->set('type', 'tofuwu');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //派工调整
    public function revise()
    {
        $this->users->dialoglogin();    //登录判断
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $userid = (int) $this->cookie->get('userid');
            $afteruserid = $_POST['afteruserid'];
            if ($userid == $afteruserid) {
                dialog('错误，你不能给自己派工');
            }
            $id = (int) base64_decode($_POST['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = $info['ordersid'];
            $jobs->ordersid = $ordersid;
            $jobs->id = $id;
            $jobs->revise();
            echo '1';
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
            if ($info['checked'] != 1 && $isadmin != 1) {
                dialog('工单没有确认，无法进行变更！');
            }
            if (!$islevel) {
                //if($info["afteruserid"]!=$userid){//
                    dialog('你没有权限调整工单信息！');
                //}
            }
            if ($info['worked'] != 0) {
                dialog('工单已完成，无法进行调整！');
            }
            $this->tpl->set('info', $info);
            $teams = getModel('teams');
            $afteruserinfo = $this->users->getrow('userid='.$info['afteruserid'].'');
            //print_r($afteruserinfo);
            $this->tpl->set('afteruserinfo', $afteruserinfo);
            $afterusers = $teams->users('type=3&checked=1&userid='.$info['afteruserid'].'&idno='.$info['afteruserid'].'&parentid='.$info['afterarea'].'&teamid='.$info['afterid'].'');
            $this->tpl->set('afterusers', $afterusers);
            //当前日期
            $offtime = strtotime(date('Y-m-d').' 16:00:00');
            if (time() > $offtime) {
                $minday = date('Y-m-d', time() + 86400);
            } else {
                $minday = date('Y-m-d');
            }
            $this->tpl->set('minday', $minday);
            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $this->tpl->set('type', 'reviseinfo');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //派工转移
    public function transfer()
    {
        $this->users->dialoglogin();    //登录判断
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $id = (int) base64_decode($_POST['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = $info['ordersid'];
            $jobs->ordersid = $ordersid;
            $jobs->id = $id;
            $jobs->transfer();
            echo '1';
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
            if ($info['checked'] == 1 && $isadmin != 1) {
                //dialog("工单已确认，无法进行移交！");
            }
            if (!$islevel) {
                dialog('你没有权限调整工单信息！');
            }
            if ($info['afteruserid'] != $userid && !$teamlevel) {
                //
                dialog('你没有权限调整此区域工单！');
            }
            if ($info['worked'] != 0) {
                dialog('工单已完成，无法进行调整！');
            }
            $this->tpl->set('info', $info);

            $afterid = (int) $info['afterid'];
            $teams = getModel('teams');
            $row = $teams->getrow("id=$afterid");
            $parentid = (int) $row['parentid'];
            $afters = $teams->getrows("parentid=$parentid");
            $this->tpl->set('afters', $afters);

            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $this->tpl->set('type', 'transfer');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //删除派工
    public function del()
    {
        $this->users->dialoglogin();            //登录判断
        $jobs = getModel('jobs');
        $ordersid = (int) base64_decode($_GET['ordersid']);
        $id = (int) base64_decode($_GET['id']);
        $info = $jobs->getrow("id=$id");
        $userid = (int) $this->cookie->get('userid');
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
        if (!$islevel) {
            if ($info['adduserid'] != $userid) {
                //
                dialog('抱歉，你没有权限删除工单信息！');
            }
        }
        if ($info['checked'] == 1 && !$islevel && $isadmin != 1) {
            dialog('派工已确定，无法进行修改！');
        }
        if ($info['worked'] != 0 && $isadmin != 1) {
            dialog('派工已操作，无法进行修改！');
        }
        $jobs->ordersid = $info['ordersid'];
        $jobs->id = $id;
        $jobs->del();
        echo 1;
    }

    //派工回执
    public function workjobs()
    {
        $this->users->dialoglogin();    //登录判断
        $jobs = getModel('jobs');
        if (isset($_POST) && !empty($_POST)) {
            $id = (int) base64_decode($_POST['id']);
            $info = $jobs->getrow("id=$id");
            $ordersid = $info['ordersid'];
            $jobs->ordersid = $ordersid;
            $jobs->id = $id;
            $jobs->worked();
            echo '1';
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            if ($info['checked'] != 1) {
                dialog('派工没有确认，无法回执处理！');
            }

            $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
            if (!$islevel) {
                if ($info['afteruserid'] != $userid && !$teamlevel) {
                    //
                    dialog('抱歉，你没有权限回执工单信息！');
                }
            }

            if (!$isadmin && $info['workdateline'] < $timeline && $info['chargechecked'] == '1') {
                dialog('派工结算已经审核，无法再更新！');
            }

            $timeline = time() - 86400 * 20;    //计算前一天
            if (!$isadmin && $info['worked'] != 0 && $info['workdateline'] < $timeline) {
                dialog('派工回执已处理过，请勿重复回执！');
            }

            //工单类型
            $worktype = $jobs->worktype();
            $this->tpl->set('worktype', $worktype);
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);

            $this->tpl->set('info', $info);

            $this->tpl->set('type', 'workjobs');
            $this->tpl->display('jobs.dialog.php');
        }
    }

    //派工确定
    public function checked()
    {
        $this->users->dialoglogin();    //登录判断
        $orders = getModel('orders');
        $jobs = getModel('jobs');
        $id = (int) base64_decode($_GET['id']);
        $info = $jobs->getrow("id=$id");
        $ordersid = (int) $info['ordersid'];
        $ordersinfo = $orders->getrow("id=$ordersid");
        $userid = (int) $this->cookie->get('userid');

        $salesid = $ordersinfo['salesid'];
        if ($ordersinfo['checked'] != '1') {
            dialog('订单没有审核，无法确认派工！');
        }
        $jobs->ordersid = $ordersid;
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        $teamid = $info['afterid'];
        $teamlevel = $this->users->teamed("teamid=$teamid");    //判断区域权限
        if (!$islevel) {
            if ($info['adduserid'] == $userid) {
                //dialog('你不能确认自己的派工！');
            }
            if ($info['afteruserid'] != $userid && !$teamlevel) {
                dialog('抱歉，你没有权限操作本工单信息！');
            }
        }
        if ($info['checked'] == 1 && $isadmin != 1) {
            dialog('抱歉，请勿重复确认！');
        }
        $jobs->id = $id;
        $jobs->ordersid = $ordersid;
        $jobs->checked();
        echo '1';
    }

    //工单列表
    public function lists()
    {
        extract($_GET);
        $this->users->onlogin();    //登录判断
        $jobs = getModel('jobs');
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        //工单类型
        $jobstype = $jobs->jobstype();
        $this->tpl->set('jobstype', $jobstype);
        //工单类型
        $worktype = $jobs->worktype();
        $this->tpl->set('worktype', $worktype);

        if ($godate && $todate) {
            $godate = $godate;
            $todate = $todate;
        } else {
            $godate = date('Y-m-d');
            $todate = date('Y-m-d');
        }

        if ($godate > $todate) {
            msgbox('', '抱歉，起始日期不能大于截止日期！');
        }

        $godateint = strtotime($godate);
        $todateint = strtotime($todate);
        $checkint = $todateint - $godateint;
        if ($checkint > 86400 * 100) {
            msgbox('', '抱歉，记录查询期限不能超过100天！');
        }

        if ($worked == '0') {
            $godate = '';
            $todate = $todate;
        }

        if ($views == 1) {
            $nums = 20;
        } else {
            $nums = 10;
        }

        //用户类型
        $usertype = $this->cookie->get('usertype');
        $this->tpl->set('usertype', $usertype);

        $list = $jobs->getrows("page=1&level=$islevel&ordered=1&order=$order&nums=$nums&type=$type&worked=$worked&afterarea=$afterarea&delivertype=$delivertype&contract=$contract&salesarea=$salesarea&salesid=$salesid&afterid=$afterid&afteruserid=$afteruserid&ordersid=$ordersid&jobsid=$jobsid&godate=$godate&todate=$todate&checked=$checked&ochecked=$ochecked&printed=$printed&otype=$otype");
        $this->tpl->set('list', $list['record']);
        $this->tpl->set('page', $list['pages']);
        $this->tpl->display('jobs.list.php');
    }

    //导出xls
    public function xls()
    {
        extract($_GET);
        $this->users->onlogin();    //登录判断
        $islevel = $this->users->getlevel();    //判断页面权限
        $jobs = getModel('jobs');    //工单类型
        $orders = getModel('orders');
        $jobstype = $jobs->jobstype();
        $this->tpl->set('jobstype', $jobstype);
        //工单类型
        $worktype = $jobs->worktype();
        $this->tpl->set('worktype', $worktype);

        if ($godate && $todate) {
            $godate = $godate;
            $todate = $todate;
        } else {
            $godate = date('Y-m-d');
            $todate = date('Y-m-d');
        }

        if ($godate > $todate) {
            msgbox('', '抱歉，起始日期不能大于截止日期！');
        }

        $godateint = strtotime($godate);
        $todateint = strtotime($todate);
        $checkint = $todateint - $godateint;
        if ($checkint > 86400 * 100) {
            msgbox('', '抱歉，记录查询期限不能超过100天！');
        }

        $rows = $jobs->getrows("xls=1&level=$islevel&ordered=1&type=$type&worked=$worked&afterarea=$afterarea&afterid=$afterid&afteruserid=$afteruserid&delivertype=$delivertype&salesarea=$salesarea&salesid=$salesid&salescode&ordersid=$ordersid&jobsid=$jobsid&godate=$godate&todate=$todate&checked=$checked");
        if ($rows) {

            //送货方式
            $delivertype = $orders->delivertype();
            $this->tpl->set('delivertype', $delivertype);

            $xls = getFunc('excel');
            $data = array();
            $data[] = array('工单编号', '工单类型', '送货方式', '订单号', '主订单号', '省份', '城市', '区域', '计划执行时间', '工单内容', '服务网点', '服务人员', '派工人员', '派工时间', '确认状态', '确认时间', '回执状态', '回执内容', '回执人员', '完成时间',
            '促单', '投诉', '回访', '回执方式', );
            foreach ($rows as $rs) {
                $type = $jobstype[$rs['type']]['name'];
                $worked = $worktype[$rs['worked']]['name'];
                if ($rs['checked']) {
                    $checked = '已确认';
                } else {
                    $checked = '未确认';
                }
                $checked = ($rs['checked']) ? '已确认' : '未确认';
                $ordersid = ($rs['ordersid']) ? $rs['ordersid'] : '普通工单';
                $checkdate = ($rs['checkdate']) ? date('Y-m-d H:i', $rs['checkdate']) : '';
                $workdate = ($rs['workdateline']) ? date('Y-m-d H:i', $rs['workdateline']) : '';
                $delivername = $delivertype[(int) $rs['delivertype']]['name'];
                $workuname = ($rs['worked']) ? $rs['workuname'] : '';
                $data[] = array($rs['id'], $type, $delivername, $ordersid, $rs['parentid'], $rs['provname'], $rs['cityname'], $rs['areaname'], $rs['datetime'], $rs['detail'], $rs['afters'], $rs['aftername'], $rs['addname'], date('Y-m-d H:i', $rs['dateline']), $checked, $checkdate, $worked,
                $rs['workdetail'], $workuname, $workdate,
                $rs['tourge'], $rs['complaint'], $rs['degree'], $rs['workto'], );
            }
            $xls->addArray($data);
            $xls->generateXML($godate.'-'.$todate);
        } else {
            msgbox('', '导出失败');
        }
    }

    public function tourge()
    {
        extract($_GET);
        $this->users->onlogin();    //登录判断
        $do = $_GET['do'];
        $jobs = getModel('jobs');
        if ($do == 'add') {
            $this->users->dialoglevel();
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $afteruserid = (int) $info['afteruserid'];
            if (!$afteruserid) {
                dialog('服务人员未设置,无法催单!');
            }
            if (isset($_POST) && !empty($_POST)) {
                $jobs->id = $id;
                $jobs->ordersid = (int) $info['ordersid'];
                $jobs->afteruserid = $afteruserid;
                $msg = $jobs->tourgeadd();
                echo $msg;
                exit;
            } else {
                $userid = (int) $this->cookie->get('userid');
                $this->tpl->set('info', $info);
                $this->tpl->set('pagetype', 'tourgeinfo');
                $this->tpl->display('jobs.tourge.dialog.php');
            }
        } elseif ($do == 'del') {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->tourgeinfo("id=$id");
            $userid = $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            $teamid = $info['afterid'];
            $teamlevel = $this->users->teamed("teamid=$teamid");    //判断区域权限
            if (!$islevel) {
                if ($info['adduserid'] != $userid) {
                    dialog('你不能删除非自己的催单！');
                }
            }
            $jobsid = (int) $info['jobsid'];
            $jobsinfo = $jobs->getrow("id=$jobsid");
            $ordersid = (int) $jobsinfo['ordersid'];
            $jobs->id = $id;
            $jobs->jobsid = $jobsid;
            $jobs->ordersid = $ordersid;
            $row = $jobs->tourgedel();
            echo $row;
            exit;
        } else {
            $id = (int) base64_decode($_GET['id']);
            $rows = $jobs->tourgelist("jobsid=$id");
            $this->tpl->set('rows', $rows);
            $this->tpl->set('pagetype', 'lists');
            $this->tpl->display('jobs.tourge.dialog.php');
        }
    }

    //结算审核
    public function charge()
    {
        extract($_GET);
        $this->users->onlogin();    //登录判断
        $do = $_GET['do'];
        $jobs = getModel('jobs');

        if ($do == 'lists') {
            $this->users->pagelevel();    //权限判断
            if ($godate && $todate) {
                $godate = $godate;
                $todate = $todate;
            } else {
                $date = plugin::getTheMonth(date('Y-m', time()));
                $godate = $date[0];
                $todate = $date[1];
            }
            switch ($checked) {
                case '1':   $checked = 0;   $fuwued = ''; break;
                case '2':   $checked = 1;   $fuwued = ''; break;
                case '3':   $fuwued = 0;   $checked = ''; break;
                case '4':   $fuwued = 1;   $checked = ''; break;
                default :   $checked = '';
            }

            $list = $jobs->charge("page=1&nums=20&order=workdate&desc=DESC&checked=$checked&fuwued=$fuwued&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid&afteruserid=$afteruserid&ordersid=$ordersid&pricetype=$pricetype");
            $this->tpl->set('list', $list['record']);
            $this->tpl->set('page', $list['pages']);
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $workto = $jobs->workto();
            $this->tpl->set('workto', $workto);
            //工单类型
            $worktype = $jobs->worktype();
            $this->tpl->set('worktype', $worktype);
            $this->tpl->display('jobs.charge.list.php');
        } elseif ($do == 'xls') {
            $this->users->pagelevel();    //权限判断
            if ($godate && $todate) {
                $godate = $godate;
                $todate = $todate;
            } else {
                $date = plugin::getTheMonth(date('Y-m', time()));
                $godate = $date[0];
                $todate = $date[1];
            }
            ini_set("memory_limit","500M");
            $list = $jobs->charge("xls=1&order=datetime&desc=ASC&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid&afteruserid=$afteruserid&ordersid=$ordersid");
            if ($list) {
                $jobstype = $jobs->jobstype();
                $worktype = $jobs->worktype();
                $workto = $jobs->workto();
                $xls = getFunc('excel');
                $data = array();
                $data[] = array('订单编号', '工单编号', '工单合同号', '预约日期', '派工类型', '完成状态', '完成时间', '服务内容', '收款金额', '回执批注',
                '归属部门', '服务站', '服务人员', '派工人员', '派工时间', '回执人', '回执操作时间', '回执方式',
                '预结金额', '预结批注', '结算状态', '服务结算', '结算说明', '服务补贴', '补贴说明','结算审核', '结算时间',
                '供应商结算', '结算费用说明','结算审核', '结算时间');
                foreach ($list as $rs) {
                    $chargecheckname = ($rs['changechecked']) ? '已结算' : '未结算';
                    $data[] = array(
                        $rs['ordersid'],
                        $rs['id'],
                        $rs['contract'],
                        $rs['datetime'],
                        $jobstype[$rs['type']]['name'],
                        $worktype[$rs['worked']]['name'],
                        $rs['workdate'],
                        $rs['detail'],
                        $rs['price'],
                        $rs['workdetail'],
                        $rs['salesname'],
                        $rs['afters'],
                        $rs['aftername'],
                        $rs['addname'],
                        date('Y-m-d H:i:s', $rs['dateline']),
                        $rs['workname'],
                        date('Y-m-d H:i:s', $rs['workdateline']),
                        $workto[(int) $rs['workto']]['name'],
                        $rs['charge'],
                        $rs['chargeinfo'],
                        $chargecheckname,
                        round($rs['encharge'], 2),
                        $rs['enchargeinfo'],
                        $rs['plus'],
                        $rs['plusinfo'],
                        $rs['changecheckname'],
                        date('Y-m-d H:i:s', $rs['changecheckdate']),
                        $rs['fuwu'],
                        $rs['fuwuinfo'],
                        $rs['fuwucheckname'],
                        date("Y-m-d H:i:s",$rs['fuwutime'])
                    );
                }
                $xls->addArray($data);
                $xls->generateXML(date('Y-m-d'));
            } else {
                msgbox('抱歉，没有可导出的信息！');
            }
        } elseif ($do == 'views') {
            $this->tpl->set('back', $this->cookie->get('lists'));

            $islevel = $this->users->getlevel();    //权限判断
            $jobs = getModel('jobs');
            $orders = getModel('orders');
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
            if (!$teamlevel && !$islevel && $isadmin != 1) {
                msgbox('', '抱歉，你没有权限查看结算信息！');
            }
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            $worktype = $jobs->worktype();
            $this->tpl->set('worktype', $worktype);
            $this->tpl->set('info', $info);
            $workto = $jobs->workto();
            $this->tpl->set('workto', $workto);
            //订购信息
            $ordersid = $info['ordersid'];
            $orders_product = $orders->ordersinfo("ordersid=$ordersid&group=1");
            $this->tpl->set('orders_product', $orders_product);

            $this->tpl->set('usertype', (int) $this->cookie->get('usertype'));

            $this->tpl->display('jobs.charge.views.php');
        } elseif ($do == 'allchecked') {
            $this->users->dialoglevel();    //权限判断
            $msg = $jobs->allchecked();
            if ($msg == '1') {
                echo '1';
            } else {
                echo $msg;
            }
            exit;
        } elseif ($do == 'checked') {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $dateline = time() - 10800;
            if ($info['worked'] == '0') {
                dialog('派工没有回执，无法进行结算！');
            }
            if ($info['chargechecked'] && $info['chargecheckdate'] < $dateline) {
                dialog('抱歉，审核完成已超过3小时，无法进行更改！');
            }
            if (isset($_POST) && !empty($_POST)) {
                $ordersid = (int) base64_decode($_GET['ordersid']);
                $jobs->id = $id;
                $jobs->ordersid = $ordersid;
                $jobs->enchecked();
                echo 1;
                exit;
            } else {
                $this->users->dialoglogin();    //登录判断
                $this->tpl->set('type', 'encharge');
                $this->tpl->set('info', $info);
                $orders = getModel('orders');
                $ordersid = (int) $info['ordersid'];
                $orderinfo = $orders->getrow("id=$ordersid");
                $this->tpl->set('orderinfo', $orderinfo);

                $fuwu = getModel('fuwu');
                $afteruserid = (int) $info['afteruserid'];
                $afteruserinfo = $fuwu->userinfo("userid=$afteruserid");
                $this->tpl->set('fuwuinfo', $afteruserinfo);

                $curl = getFunc('curl');
                $address = $orderinfo['address'];
                $city = $orderinfo['cityname'];
                $area = $orderinfo['areaname'];
                $data = array('address' => $address, 'city' => $city, 'area' => $area);
                $urlarr = http_build_query($data);
                $urlto = "http://fuwu.shui.cn/maps/getprice?$urlarr";
                $mapsnums = $curl->contents($urlto);
                $this->tpl->set('mapsnums', $mapsnums);
                $this->tpl->display('jobs.dialog.php');
            }
        } elseif ($do == 'plus') {
            exit;
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");
            $dateline = time() - 10800;
            if ($info['worked'] == '0') {
                dialog('派工没有回执，无法进行结算！');
            }
            if ($info['chargechecked'] == '0') {
                dialog('工单结算没有审核，无法提交补助费用！');
            }
            if ($info['plus'] && $info['plustime'] < $dateline) {
                dialog('抱歉，审核时间已超过3小时，无法进行更改！');
            }
            if (isset($_POST) && !empty($_POST)) {
                $ordersid = (int) base64_decode($_GET['ordersid']);
                $jobs->id = $id;
                $jobs->ordersid = $ordersid;
                $jobs->enplus();
                echo 1;
                exit;
            } else {
                $this->users->dialoglogin();    //登录判断
                $this->tpl->set('type', 'plusinfo');
                $this->tpl->set('info', $info);
                $this->tpl->display('jobs.dialog.php');
            }
        } elseif ($do == 'fuwu') {
            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->getrow("id=$id");

            if ($info['salespid'] != '164') {
                dialog('非供应商工单无需操作');
            }
            $dateline = time() - 10800;
            if ($info['worked'] == '0') {
                dialog('派工没有回执，无法进行结算！');
            }
            if ($info['chargefuwued'] && $info['fuwutime'] < $dateline) {
                dialog('抱歉，审核时间已超过3小时，无法进行更改！');
            }
            if (isset($_POST) && !empty($_POST)) {
                $ordersid = (int) base64_decode($_GET['ordersid']);
                $jobs->id = $id;
                $jobs->ordersid = $ordersid;
                $jobs->enfuwu();
                echo 1;
                exit;
            } else {
                $this->users->dialoglogin();    //登录判断
                $ordersid = (int) $info['ordersid'];
                $orders = getModel('orders');
                $orderinfo = $orders->getrow("id=$ordersid");
                $teamid = (int) $orderinfo['salesid'];
                $fuwu = getModel('fuwu');
                $teaminfo = $fuwu->userinfo("teamid=$teamid");
                $this->tpl->set('fuwuinfo', $teaminfo);

                $this->tpl->set('type', 'fuwuinfo');
                $this->tpl->set('info', $info);
                $this->tpl->display('jobs.dialog.php');
            }
        } else {
            $date = plugin::getTheMonth(date('Y-m', time()));
            $godate = $date[0];
            $todate = $date[1];
            $this->tpl->set('godate', $godate);
            $this->tpl->set('todate', $todate);
            $this->tpl->display('jobs.charge.php');
        }
    }

    //查看派工
    public function views()
    {
        $this->users->onlogin();    //登录判断
        $jobs = getModel('jobs');
        $orders = getModel('orders');
        $id = (int) base64_decode($_GET['id']);
        $info = $jobs->getrow("id=$id");
        if (!$info) {
            msgbox(S_ROOT.'pages', '工单不存在');
        }
        $ordersid = $info['ordersid'];
        if ($ordersid) {
            $orderinfo = $orders->getrow("id=$ordersid");
            $this->tpl->set('orderinfo', $orderinfo);
            if ($orderinfo['status'] == '7' || $orderinfo['status'] == '-1') {
                msgbox('', '订单已取消，无法进行操作！');
            }
        }
        $userid = (int) $this->cookie->get('userid');
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
        if (!$islevel) {
            if ($info['afteruserid'] != $userid && $ordersinfo['saleuserid'] != $userid && !$teamlevel) {
                //
                msgbox('', '抱歉，你没有权限查看工单信息！');
            }
        }
        $this->tpl->set('info', $info);
        //物流信息
        $express = getModel('express');
        $expinfo = $express->getrow("jobsid=$id");
        $this->tpl->set('expinfo', $expinfo);
        //用户类型
        $usertype = $this->cookie->get('usertype');
        $this->tpl->set('usertype', $usertype);
        //工单类型
        $jobstype = $jobs->jobstype();
        $this->tpl->set('jobstype', $jobstype);
        //工单状态
        $worktype = $jobs->worktype();
        $this->tpl->set('worktype', $worktype);
        $workto = $jobs->workto();
        $this->tpl->set('workto', $workto);
        //订单信息
        if ($ordersid) {
            //订单类型
            $ordertype = $orders->ordertype();
            $this->tpl->set('ordertype', $ordertype);
            //审核状态
            $checktype = $orders->checktype();
            $this->tpl->set('checktype', $checktype);
            //付款状态
            $paystatetype = $orders->paystatetype();
            $this->tpl->set('paystatetype', $paystatetype);
            //订单进度
            $statustype = $orders->statustype();
            $this->tpl->set('statustype', $statustype);
            //支付方式
            $paytype = $orders->paytype();
            $this->tpl->set('paytype', $paytype);
            //送货方式
            $delivertype = $orders->delivertype();
            $this->tpl->set('delivertype', $delivertype);
            //安装方式
            $setuptype = $orders->setuptype();
            $this->tpl->set('setuptype', $setuptype);
        }

        //已支付金额
        $paycharge = $orders->orders_charge("ordersid=$ordersid");
        $this->tpl->set('paycharge', $paycharge);

        //操作日志记录
        $logs = getModel('logs');
        $logs->insert("type=query&ordersid=$ordersid&name=订单操作[查看工单]&detail=查看订单[".$ordersid.']的工单#['.$id."]&sqlstr=$logsarr");

        $this->tpl->set('usertype', (int) $this->cookie->get('usertype'));
        $this->tpl->display('jobs.views.php');
    }

    //打印物流单
    public function printexp()
    {
        $this->users->onlogin();    //登录判断
        $show = $_GET['show'];
        $jobs = getModel('jobs');
        $orders = getModel('orders');
        $id = (int) base64_decode($_GET['id']);
        $info = $jobs->getrow("id=$id");
        $ordersid = (int) $row['ordersid'];

        $ordersid = $info['ordersid'];
        if ($ordersid) {
            $ordersinfo = $orders->getrow("id=$ordersid");
        }
        $userid = (int) $this->cookie->get('userid');
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        $teamlevel = $this->users->teamed('teamid='.$info['afterid'].'');    //判断区域权限
        if (!$islevel) {
            if ($info['afteruserid'] != $userid && $ordersinfo['saleuserid'] != $userid && !$teamlevel) {
                //
                msgbox('', '抱歉，你没有权限查看工单信息！');
            }
        }
        $this->tpl->set('info', $ordersinfo);

        //环路设置
        $looptype = $orders->looptype();
        $this->tpl->set('looptype', $looptype);

        $expaddress = $jobs->expaddress();
        $this->tpl->set('expaddress', $expaddress);
        $this->tpl->set('back', $this->cookie->get('views'));
        if ($show == 'yto') {  //圆通
            $this->tpl->display('express.print.yto.php');
        } elseif ($show == 'fedex') {    //联邦
            $this->tpl->display('express.print.fedex.php');
        } elseif ($show == 'zto') {        //中通
            $this->tpl->display('express.print.zto.php');
        } elseif ($show == 'yunda') {    //韵达
            $this->tpl->display('express.print.yunda.php');
        } else {
        }
    }

    //派工状态调用
    public function status()
    {
        $this->users->onlogin();    //登录判断
        $do = $_GET['do'];
        if ($do == 'maxplan') {    //最大派工量

            $jobs = getModel('jobs');
            $datetime = $_GET['datetime'];
            $afterid = $_GET['afterid'];
            $msg = $jobs->maxplan("datetime=$datetime&afterid=$afterid");
            echo (int) $msg;
        } elseif ($do == 'dayplan') {
            $jobs = getModel('jobs');
            $datetime = $_GET['datetime'];
            $afterid = $_GET['afterid'];
            $msg = $jobs->dayplan("datetime=$datetime&afterid=$afterid");
            echo (int) $msg;
        } elseif ($do == 'mapsper') {    //附近的派工

            $orders = getModel('orders');
            $jobs = getModel('jobs');
            $ordersid = ($_GET['ordersid']) ? (int) base64_decode($_GET['ordersid']) : '';
            $jobsid = ($_GET['jobsid']) ? (int) base64_decode($_GET['jobsid']) : '';
            if ($ordersid) {
                $ordersinfo = $orders->getrow("id=$ordersid");
                $this->tpl->set('ordersinfo', $ordersinfo);
            }
            if ($jobsid) {
                $jobsinfo = $jobs->getrow("id=$jobsid");
                $this->tpl->set('jobsinfo', $jobsinfo);
            }
            $datetime = $_GET['datetime'];
            $this->tpl->set('datetime', $datetime);
            $this->tpl->display('jobs.maps.php');
        } elseif ($do == 'maprows') {
            $ordersid = ($_GET['ordersid']) ? (int) base64_decode($_GET['ordersid']) : '0';
            $jobsid = ($_GET['jobsid']) ? (int) base64_decode($_GET['jobsid']) : '0';
            $datetime = $_GET['datetime'];
            $pointarr = $_GET['pointarr'];

            $jobs = getModel('jobs');
            $workrows = $jobs->maprows("ordersid=$ordersid&joblist=1&jobsid=$jobsid&afterid=$afterid&datetime=$datetime&pointarr=$pointarr");
            $arrs = '';
            if ($workrows) {
                $arra = array();
                foreach ($workrows as $rs) {
                    $rw = array();
                    $rw['title'] = $rs['datetime'].' 订单ID：'.(int) $rs['ordersid'];
                    $rw['content'] = $rs['detail'];
                    $rw['point'] = $rs['pointlng'].'|'.$rs['pointlat'];
                    $rw['isOpen'] = '0';
                    $rw['icon'] = array('t' => '0', 'w' => '15', 'h' => '23');
                    $arra[] = $rw;
                }
                $arrs = $arra;
            }
            $datetime = date('Y-m-d', strtotime($datetime) + 86400);
            $workrows = $jobs->maprows("ordersid=$ordersid&joblist=1&jobsid=$jobsid&afterid=$afterid&datetime=$datetime&pointarr=$pointarr");
            if ($workrows) {
                $arrb = array();
                foreach ($workrows as $rs) {
                    $rw = array();
                    $rw['title'] = $rs['datetime'].' 订单ID：'.(int) $rs['ordersid'];
                    $rw['content'] = $rs['detail'];
                    $rw['point'] = $rs['pointlng'].'|'.$rs['pointlat'];
                    $rw['isOpen'] = '0';
                    $rw['icon'] = array('t' => '1', 'w' => '15', 'h' => '23');
                    $arrb[] = $rw;
                }
                if ($arrb) {
                    if ($arrs) {
                        $arrs = array_merge($arrs, $arrb);
                    } else {
                        $arrs = $arrb;
                    }
                }
            }
            $datetime = date('Y-m-d', strtotime($datetime) + 86400);
            $workrows = $jobs->maprows("ordersid=$ordersid&joblist=1&jobsid=$jobsid&afterid=$afterid&datetime=$datetime&pointarr=$pointarr");
            if ($workrows) {
                $arrc = array();
                foreach ($workrows as $rs) {
                    $rw = array();
                    $rw['title'] = $rs['datetime'].' 订单ID：'.(int) $rs['ordersid'];
                    $rw['content'] = $rs['detail'];
                    $rw['point'] = $rs['pointlng'].'|'.$rs['pointlat'];
                    $rw['isOpen'] = '0';
                    $rw['icon'] = array('t' => '2', 'w' => '15', 'h' => '23');
                    $arrc[] = $rw;
                }
                if ($arrc) {
                    if ($arrs) {
                        $arrs = array_merge($arrs, $arrc);
                    } else {
                        $arrs = $arrc;
                    }
                }
            }
            if ($arrs) {
                echo json_encode($arrs);
            } else {
                echo '0';
            }
        } else {
            echo '';
        }
    }

    public function checkedplan()
    {
        $this->users->dialoglogin();    //登录判断
        $islevel = $this->users->getlevel();    //判断页面权限
        if (!$islevel) {
            $datetime = $_GET['datetime'];
            $afterid = $_GET['afterid'];
            if ($_GET['id']) {
                $id = (int) base64_decode($_GET['id']);
            }
            $jobs = getModel('jobs');
            $maxplan = $jobs->maxplan("datetime=$datetime&afterid=$afterid");
            if ($maxplan) {
                if ($id) {
                    $info = $jobs->getrow("id=$id");
                }
                if ($info['datetime'] != $datetime) {
                    $dayplan = $jobs->dayplan("id=$id&datetime=$datetime&afterid=$afterid");
                    if ($dayplan >= $maxplan) {
                        echo '1';
                        exit;
                    }
                }
            }
        }
    }

    public function feedback()
    {
        $do = $_GET['do'];
        $jobs = getModel('jobs');

        if ($do == 'checked') {
            $this->users->dialoglogin();        //登录判断
            $this->users->dialoglevel();        //权限判断

            $id = (int) base64_decode($_GET['id']);
            $info = $jobs->feedback_getrow("id=$id");
            $this->tpl->set('info', $info);
            $timeline = time() - 21600;    //计算前一天
            if ($info['checked']) {
                if ($timeline > $info['checkdate']) {
                    dialog('抱歉，预约已处理无法再次进行操作！');
                }
            }

            if (isset($_POST) && !empty($_POST)) {
                $jobs->id = $id;
                $msg = $jobs->feedback_checked();
                if ($msg == '1') {
                    echo '1';
                } else {
                    echo '处理失败，请重新尝试！';
                }
            } else {
                $this->tpl->set('tpl', 'checked');
                $this->tpl->display('jobs.feedback.dialog.php');
            }
        } else {
            $this->users->onlogin();        //登录判断
            $this->users->pagelevel();        //权限判断
            $mo = $_GET['mo'];
            if ($mo == 'lists') {
                $godate = $_GET['godate'];
                $todate = $_GET['todate'];
                if ($godate && $todate) {
                    $godate = $godate;
                    $todate = $todate;
                } else {
                    $godate = date('Y-m-d');
                    $todate = date('Y-m-d');
                }

                $checked  = (int)$_GET['status'];
                if($checked=="0"){
                   $godate  = "";
                   $todate  = "";
                }
                $type     = trim($_GET['type']);
                $keywords = trim($_GET['keywords']);
                $rows = $jobs->feedback("page=1&godate=$godate&todate=$todate&checked=$checked&type=$type&keywords=$keywords");
                $this->tpl->set('list', $rows['record']);
                $this->tpl->set('page', $rows['pages']);
                $this->tpl->display('jobs.feedback.lists.php');
            } elseif ($mo == 'views') {
                $id = (int) base64_decode($_GET['id']);
                $info = $jobs->feedback_getrow("id=$id");
                $this->tpl->set('info', $info);
                $this->tpl->display('jobs.feedback.views.php');
            } else {
                $date = plugin::getTheMonth(date('Y-m', time()));
                $godate = $date[0];
                $todate = $date[1];
                $this->tpl->set('godate', $godate);
                $this->tpl->set('todate', $todate);
                $this->tpl->display('jobs.feedback.index.php');
            }
        }
    }

    public function calladm()
    {
        $show = $_GET['show'];
        $jobs = getModel('jobs');
        $charge = getModel('charge');
        if ($show == 'lists') {
            extract($_GET);

            if ($godate && $todate) {
                $godate = $godate;
                $todate = $todate;
            } else {
                $date = plugin::getTheMonth(date('Y-m', time()));
                $godate = $date[0];
                $todate = $date[1];
            }

            if ($godate > $todate) {
                msgbox('', '抱歉，起始日期不能大于截止日期！');
            }

            $godateint = strtotime($godate);
            $todateint = strtotime($todate);
            $checkint = $todateint - $godateint;
            if ($checkint > 86400 * 100) {
                msgbox('', '抱歉，记录查询期限不能超过100天！');
            }

            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            //工单类型
            $worktype = $jobs->worktype();
            $this->tpl->set('worktype', $worktype);
            //费用类型
            $cates = $charge->cates();
            $this->tpl->set('cates', $cates);

            $rows = $jobs->calladm("nums=20&ordersid=$ordersid&jobsid=$jobsid&afterarea=$afterarea&afterid=$afterid&afteruserid=$afteruserid&type=$type&gotime=$godate&totime=$todate");
            $this->tpl->set('list', $rows['record']);
            $this->tpl->set('page', $rows['pages']);

            $this->tpl->set('show', $show);
            $this->tpl->display('jobs.calladm.php');
        } elseif ($show == 'update') {
            $this->tpl->display('jobs.dialog.php');
        } else {

            //工单类型
            $jobstype = $jobs->jobstype();
            $this->tpl->set('jobstype', $jobstype);
            //服务区域
            $aftergroup = $jobs->aftergroup();
            $this->tpl->set('aftergroup', $aftergroup);

            $date = plugin::getTheMonth(date('Y-m', time()));
            $godate = $date[0];
            $todate = $date[1];
            $this->tpl->set('godate', $godate);
            $this->tpl->set('todate', $todate);

            $this->tpl->set('show', $show);
            $this->tpl->display('jobs.calladm.php');
        }
    }

    //取得组织结构
    public function teams()
    {
        $this->users->onlogin();    //登录判断
        $type = (int) $_GET['type'];
        $provid = (int) $_GET['provid'];
        if ($type == '8') {    //非直营
            $provid = 0;
        }
        $teams = getModel('teams');
        $rows = $teams->areas("checked=1&provid=$provid&type=3");
        if (!$rows) {
            $rows = $teams->areas('checked=1&id=112&type=3');
        }
        foreach ($rows as $rs) {
            if ($numberd == 1) {
                $number = $rs['numbers'].'_';
            } else {
                $number = '';
            }
            $str .= '<option value="'.$rs['id'].'">'.$number.$rs['name'].'</option>';
        }
        echo $str;
        exit;
    }

    //获取前一天和后一天
    public function getdate()
    {
        $datetime = $_GET['datetime'];
        $do = $_GET['do'];
        if ($do == 'back') {
            $datetime = date('Y-m-d', strtotime($datetime) - 86400);
        } else {
            $datetime = date('Y-m-d', strtotime($datetime) + 86400);
        }
        echo $datetime;
    }

    public function errshow()
    {
        $jobs = getModel('jobs');
        $jobs->errshow();
    }
}
