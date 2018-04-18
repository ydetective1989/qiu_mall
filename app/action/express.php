<?php

class expressAction extends Action
{
    public function app()
    //发货物流处理界面
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //登录判断
        $orders = getModel('orders');
        $show = $_GET['show'];
        if ($show == 'lists') {
            $id = (int) $_GET['ordersid'];

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
            //环路设置
            $looptype = $orders->looptype();
            $this->tpl->set('looptype', $looptype);

            //订单信息
            $info = $orders->getrow("id=$id");
            if (!$info) {
                msgbox('', '抱歉，你查询的订单信息不存在！');
            }
            $this->tpl->set('orderinfo', $info);

            if ($info['status'] == '7') {
                msgbox('', '此订单等待确认取消，如有问题请和制单人员进行确认！');
            }
            if ($info['checked'] == '3') {
                msgbox('', '此订单已作废，暂停发货！请先与制单人员联系并确认！');
            }

            //订购信息
            $orders_product = $orders->ordersinfo("ordersid=$id&group=true");
            $this->tpl->set('orders_product', $orders_product);

            $this->tpl->display('express.orders.php');
        } else {
            $this->tpl->display('express.index.php');
        }
    }

    //添加
    public function add()
    {
        $this->users->dialoglogin();        //登录判断
        $this->users->dialoglevel();        //权限判断
        $express = getModel('express');
        if (isset($_POST) && !empty($_POST)) {
            //$userid = (int)$this->cookie->get("userid");
            $ordersid = (int) base64_decode($_POST['ordersid']);
            $express->ordersid = $ordersid;
            $msg = $express->add();
            if ($msg == '1') {
                echo '1';
                exit;
            } else {
                echo $msg;
                exit;
            }
        } else {
            $ordersid = (int) base64_decode($_GET['id']);
            if ($ordersid == '8') {
                if ($_GET['definfo']) {
                    $definfo = $_GET['definfo'];
                }
                $this->tpl->set('definfo', $definfo);
            } else {
                //echo $ordersid;exit;
                $orders = getModel('orders');
                $info = $orders->getrow("id=$ordersid");
                if ((int) $info['checked'] == '0') {
                    if ($info['ctype'] != '6') {
                        dialog('此订单未审核，无法进行物流增加！');
                    }
                }
                if ($info['status'] == '7' || $info['status'] == '-1') {
                    dialog('订单已取消，无法增加物流记录！');
                }

                switch ($_GET['type']) {
                    case '2' : $definfo = '发票号码：'; break;
                    default: $definfo = '';
                }
            }
            //工单类型
            $cates = $express->cates();
            $this->tpl->set('cates', $cates);//expresstype
            $expresstype = $express->expresstype();
            $this->tpl->set('expresstype', $expresstype);
            $this->tpl->set('type', 'info');
            $this->tpl->display('express.dialog.php');
        }
    }

    //修改
    public function edit()
    {
        $this->users->dialoglogin();    //登录判断
        $express = getModel('express');
        if (isset($_POST) && !empty($_POST)) {
            $ordersid = (int) base64_decode($_POST['ordersid']);
            $express->ordersid = $ordersid;
            $id = (int) base64_decode($_POST['id']);
            $express->id = $id;
            $msg = $express->edit();
            if ($msg == '1') {
                echo '1';
                exit;
            } else {
                echo $msg;
                exit;
            }
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $express->getrow("id=$id");
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            $timeline = time() - 21600;    //计算前一天
            if ($info['userid'] == $userid && $info['dateline'] < $timeline) {
                dialog('抱歉，物流记录超过修改时间！');
            } else {
                if ($info['userid'] != $userid && !$islevel && $isadmin != 1) {
                    dialog('抱歉，你没有权限进行操作！');
                }
                if ($info['checked'] == '1' && $type == '1') {
                    dialog('抱歉，物流记录已经确认，无法进行修正！');
                }
            }
            $this->tpl->set('info', $info);
            $cates = $express->cates();
            $this->tpl->set('cates', $cates);
            $expresstype = $express->expresstype();
            $this->tpl->set('expresstype', $expresstype);
            $this->tpl->set('type', 'info');
            $this->tpl->display('express.dialog.php');
        }
    }

    //确认
    public function checked()
    {
        $this->users->dialoglogin();    //登录判断
        $this->users->dialoglevel();
        $express = getModel('express');

        if (isset($_POST) && !empty($_POST)) {
            $ordersid = (int) base64_decode($_POST['ordersid']);
            $express->ordersid = $ordersid;
            $id = (int) base64_decode($_POST['id']);
            $express->id = $id;
            $msg = $express->checked();
            echo $msg;
        } else {
            $id = (int) base64_decode($_GET['id']);
            $info = $express->getrow("id=$id");
            $ordersid = (int) $info['ordersid'];
            $orders = getModel('orders');
            //订单信息
            $orderinfo = $orders->getrow("id=$ordersid");
            if (!$orderinfo) {
                dialog('抱歉，你查询的订单信息不存在！');
            }
            if ($orderinfo['status'] == '7' || $orderinfo['status'] == '-1') {
                if ($orderinfo['ctype'] != '6') {
                    dialog('此订单等待确认取消，如有问题请和制单人员进行确认！');
                }
            }
            if($ordersid<>"8"){
              if ($orderinfo['checked'] == '0') {
                  if ($orderinfo['ctype'] != '6') {
                      dialog('此订单未审核，无法进行物流确认！');
                  }
              }
            }
            $userid = (int) $this->cookie->get('userid');
            $isadmin = $this->users->isadmin();        //判断是否管理员
            $islevel = $this->users->getlevel();    //判断页面权限
            $timeline = time() - 21600;    //计算前一天
            if ($info['userid'] != $userid && !$islevel && $isadmin != 1) {
                dialog('抱歉，你没有权限进行操作！');
            }
            if ($info['checked'] == '1') {
                dialog('抱歉，物流记录已经确认！');
            }
            $this->tpl->set('info', $info);
            $cates = $express->cates();
            $this->tpl->set('cates', $cates);
            $this->tpl->set('type', 'checked');
            $this->tpl->display('express.dialog.php');
        }
    }

    //删除
    public function del()
    {
        $this->users->dialoglogin();            //登录判断
        $express = getModel('express');
        $ordersid = (int) base64_decode($_GET['ordersid']);
        $id = (int) base64_decode($_GET['id']);
        $info = $express->getrow("id=$id");
        $userid = (int) $this->cookie->get('userid');
        $isadmin = $this->users->isadmin();        //判断是否管理员
        $islevel = $this->users->getlevel();    //判断页面权限
        $timeline = time() - 21600;    //计算前一天

        if ($info['userid'] != $userid && !$islevel && $isadmin != 1) {
            dialog('抱歉，你没有权限进行操作！');
        }
        if ($info['checked'] == 1 && $isadmin != 1 && $info['type'] == '1') {
            //if($info["dateline"]<$timeline){
            dialog('抱歉，物流记录已确认，无法进行操作！');
            //}
        }
        $express->ordersid = $info['ordersid'];
        $express->id = $id;
        $express->del();
        echo 1;
    }

    //查看
    public function views()
    {
        $this->users->dialoglogin();            //登录判断
        $express = getModel('express');
        $id = (int) base64_decode($_GET['id']);
        $info = $express->getrow("id=$id");
        //print_r($info);
        $key = 'e0eac430db9d40e7';
        $cateid = $info['cateid'];
        $com = $info['expapia'];
        $nums = $info['numbers'];
        $show = $_GET['show'];
        $cated = $info['expauthnum'];

        $urlto = "http://www.kuaidi100.com/chaxun?com=$com&nu=$nums";
        header("location:$urlto");
        exit;
        $curl = getFunc('curl');
        //$curl->ip = "218.188.".date("h").".".date("i");
        $rows = $curl->contents($urlto);
        $rows = json_decode($rows, true);
        //print_r($rows);
        $this->tpl->set('data', $rows);

        if ($rows['data']) {
            $exptime = strtotime($rows['updatetime']);
            $finished = (int) $rows['state'];
            $express->mupdate("id=$id&finished=$finished&exptime=$exptime");
        }

        $this->tpl->set('info', $info);
        //$this->tpl->set("authimg","http://api.kuaidi100.com/verifyCode?id=$key&com=$com&".time());
        $this->tpl->set('type', 'search');
        $this->tpl->display('express.dialog.php');
    }

    //列表
    public function lists()
    {
        extract($_GET);
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $express = getModel('express');
        $expresstype = $express->expresstype();
        $this->tpl->set('expresstype', $expresstype);
        $list = $express->getrows("page=1&nums=20&cateid=$cateid&ordersid=$ordersid");
        $this->tpl->set('list', $list['record']);
        $this->tpl->set('page', $list['pages']);
        $this->tpl->display('express.list.php');
    }

    public function xls()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        extract($_GET);
        $express = getModel('express');
        if ($godate && $todate) {
            $godate = $godate;
            $todate = $todate;
        } else {
            $date = plugin::getTheMonth(date('Y-m', time()));
            $godate = $date[0];
            $todate = $date[1];
        }

        if ((int) $xlstype == '1') {
            $cgodate = $godate;
            $ctodate = $todate;
            $godate = '';
            $todate = '';
        }
        $rows = $express->getrows("xls=1&order=datetime&desc=ASC&cateid=$cateid&ordersid=$ordersid&godate=$godate&todate=$todate&cgodate=$cgodate&ctodate=$ctodate&afterid=$afterid");
        if ($rows) {
            ini_set('memory_limit', '1000M');
            $expstate = $express->expstate();

            //print_r($rows);exit;
            $orders = getModel('orders');
            $xls = getFunc('excel');
            $data = array();
            $data[] = array('编号', '合同编号', '订购日期', '销售部门', '发货日期', '订单编号', '订单类型', '客户类型', '物流公司',
            '物流编号', '省份', '城市', '地区', '重量', '费用', '批注内容', '录入人', '录入时间',
            '物流状态', '确认时间', '签收时间', '派送天数', );
            foreach ($rows as $rs) {
                $ordersid = ($rs['ordersid']) ? $rs['ordersid'] : '普通工单';
                $checkdate = ($rs['checkdate']) ? date('Y-m-d H:i', $rs['checkdate']) : '';
                $outdate = ($rs['finishtime']) ? date('Y-m-d H:i', $rs['finishtime']) : '';
                $otypes = $orders->ordertype();
                $ctypes = $orders->customstype();
                $ordertype = $otypes[(int) $rs['ordertype']]['name'];
                $orderctype = $ctypes[(int) $rs['orderctype']]['name'];
                $finished = (int) $rs['finished'];
                if ($finished == '3' || $finished == '4') {
                    $expday = ceil(($rs['finishtime'] - $rs['checkdate']) / 86400);
                } else {
                    if ($rs['checkdate']) {
                        $expday = ceil((time() - $rs['checkdate']) / 86400);
                    } else {
                        $expday = ceil((time() - $rs['dateline']) / 86400);
                    }
                }
                $data[] = array($rs['id'], $rs['contract'], $rs['buydatetime'], $rs['salesname'], $rs['datetime'],
                        $ordersid, $ordertype, $orderctype, $rs['expname'], $rs['numbers'], $rs['provname'], $rs['cityname'], $rs['areaname'],
                        $rs['weight'], $rs['price'], $rs['detail'], $rs['addname'], date('Y-m-d H:i:s', $rs['dateline']),
                        $expstate[$finished]['name'], $checkdate, $outdate, $expday, );
            }
            //print_r($data);exit;
            $xls->addArray($data);
            $xls->generateXML($godate.'||'.$todate);
        } else {
            msgbox('', '导出失败');
        }
    }

}
