<?php

class xlsAction extends Action
{
    public function app()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        extract($_GET);
        if ($godate && $todate) {
            $godate = $godate;
            $todate = $todate;
        } else {
            $gotime = time() - 86400 * 30;
            $date = plugin::getTheMonth(date('Y-m', $gotime));
            $godate = $date[0];
            $todate = $date[1];
        }
        $this->tpl->set('ngodate', $godate);
        $this->tpl->set('ntodate', $todate);

        $product = getModel('product');
        //品牌
        $brand = $product->brand();
        $this->tpl->set('brand', $brand);
        $this->tpl->display('xls.index.php');
    }

  	//导出区域
  	Public function areas()
  	{
    		$this->users->onlogin();	//登录判断
    		$this->users->pagelevel();	//权限判断
        $xls = getModel('xls');
        $data = array();
        $data[] = array("省份","城市","区域");
        $prov = $xls->areas("parentid=0");
        //print_r($prov);exit;
        foreach($prov AS $p){
            $provname = $p["name"];
            $provid   = $p["areaid"];
            $city = $xls->areas("parentid=$provid");
            foreach ($city AS $c) {
               $cityname = $c["name"];
               $cityid   = $c["areaid"];
               $area = $xls->areas("parentid=$cityid");
               foreach($area AS $a){
                  $areaname = $a["name"];
                  $data[]   = array($provname,$cityname,$areaname);
               }
            }
        }
        $excel = getFunc('excel');
        $excel->addArray($data);
        $excel->generateXML('areas');
    }

    //订单审核类
    public function orders()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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

            $rows = $xls->orders("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
            //print_r($rows);exit;
            if ($rows) {
                $arr = array();
                $arr[] = '订单编号';
                $arr[] = '订单来源';
                $arr[] = '订单类型';
                $arr[] = '是否出库';
                $arr[] = '订购时间';
                $arr[] = '订单金额';
                $arr[] = '安装费用';
                $arr[] = '快递费用';
                $arr[] = '优惠费用';
                $arr[] = '其他费用';
                $arr[] = '总金额';
                $arr[] = '收款方式';
                $arr[] = '安装方式';
                $arr[] = '合同编号';
                $arr[] = '销售部门';
                $arr[] = '销售人员';
                $arr[] = '省份';
                $arr[] = '城市';
                $arr[] = '区域';
                $arr[] = '订单录入时间';
                $arr[] = '审核完成时间';
                $arr[] = '审核人';
                $arr[] = '订单状态';
                $arr[] = '订购的商品';
                $data[] = $arr;

                $orders = getModel('orders');
                $excel = getFunc('excel');
                //订单类型
                $ordertype = $orders->ordertype();
                $statustype = $orders->statustype();
                $setuptype = $orders->setuptype();
                $paytype = $orders->paytype();

                $typename = ($rs['ctype'] == '6') ? '信用订单' : $ordertype[$rs['type']]['name'];

                foreach ($rows as $rs) {
                    $arr = array();
                    $arr[] = $rs['id'];
                    $arr[] = $rs['source'];
                    $arr[] = ($rs['ctype'] == '6') ? '信用订单' : $ordertype[$rs['type']]['name'];
                    $arr[] = ($rs['stored']=='1')? '是':'否';
                    $arr[] = $rs['datetime'];
                    $arr[] = $rs['price'];
                    $arr[] = $rs['price_setup'];
                    $arr[] = $rs['price_deliver'];
                    $arr[] = $rs['price_minus'];
                    $arr[] = $rs['price_other'];
                    $arr[] = $rs['price_all'];
                    $arr[] = $paytype[$rs['paytype']]['name'];
                    $arr[] = $setuptype[$rs['setuptype']]['name'];
                    $arr[] = $rs['contract'];
                    $arr[] = $rs['salesname'];
                    $arr[] = $rs['salesunname'];
                    $arr[] = $rs['provname'];
                    $arr[] = $rs['cityname'];
                    $arr[] = $rs['areaname'];
                    $arr[] = $rs['dateline'];
                    $arr[] = $rs['checkdate'];
                    $arr[] = $rs['checkuname'];
                    $arr[] = $statustype[$rs['status']]['name'];
                    if ($rs['product']) {
                        foreach ($rs['product'] as $rs) {
                            $arr[] = $rs['encoded'];
                            $arr[] = $rs['title'];
                        }
                    }
                    $data[] = $arr;
                }
                $excel->addArray($data);
                $excel->generateXML('orders');
            }
        } else {
        }
    }

    //订单状态
    public function status()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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

            $rows = $xls->status("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");

            if ($rows) {
                $excel = getFunc('excel');
                $orders = getModel('orders');

                $ordertype = $orders->ordertype();
                $statustype = $orders->statustype();
                $setuptype = $orders->setuptype();
                $paytype = $orders->paytype();

                $data[] = array('订单号', '订单类型', '客户编号', '订单来源', '订购日期', '合同编号', '销售部门', '销售人员', '录入时间', '提交审查时间', '订单提交人员', '订单审核时间',
                '审核人员', '物流增加时间', '物流增加人', '物流公司名', '物流签收时间', '第一次派工时间', '第一次派工人',
                '服务站', '派工确认时间', '派工确认人', '派工回执时间', '派工回执人', '入款时间', '款项录入人', '回访满意度时间', '回访人员',
                '预计安装日期', '派工预约日期', '派工实际日期', '订单状态', '订单金额', '入款金额', '已确认金额', );

                foreach ($rows as $rs) {
                    $typename = ($rs['ctype'] == '6') ? '信用订单' : $ordertype[$rs['type']]['name'];
                    $data[] = array(
                        $rs['id'], $typename, $rs['customsid'], $rs['source'], $rs['datetime'], $rs['contract'], $rs['salesname'], $rs['salesunname'], $rs['dateline'],
                        $rs['addcheckdate'], $rs['checkaddname'], $rs['checkdate'], $rs['checkuname'],
                        $rs['expaddtime'], $rs['expadduname'], $rs['expname'], $rs['exptime'],
                        $rs['jobaddtime'], $rs['jobaddname'], $rs['aftername'], $rs['checktime'], $rs['checkuname'],
                        $rs['worktime'], $rs['workuname'], $rs['chargetime'], $rs['chargeaddname'],
                        $rs['degreetime'], $rs['degreename'],
                        $rs['plansetup'], $rs['jobdatetime'], $rs['workdate'], $statustype[$rs['status']]['name'],
                        $rs['price'], $rs['charge'], $rs['encharge'],
                    );
                }

                $excel->addArray($data);
                $excel->generateXML('status');
            }
        } else {
        }
    }


    //订单导入
    public function import()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $orders = getModel('orders');
        //订单类型
        $ordertype = $orders->ordertype();
        $this->tpl->set("ordertype",$ordertype);
        //客户类型
        $customstype = $orders->customstype();
        $this->tpl->set("customstype",$customstype);

        //审核状态
        $checktype = $orders->checktype();
        $this->tpl->set("checktype",$checktype);
        //订单进度
        $statustype = $orders->statustype();
        $this->tpl->set("statustype",$statustype);

        $do = $_GET["do"];
        extract($_GET);
        if($do=="views"){
          if(isset($_POST)&&!empty($_POST))
          {
            extract($_POST);//print_r($dingdan);
            if($dingdan==""){return "不能为空";}
            $xls = trim($dingdan);//print_r($xls);exit;
            $orders = explode("\n",$xls);//print_r($orders);exit;
            $this->tpl->set("date", $orders);
          }
          $this->tpl->set("do", "views");

        }else{
            if(isset($_POST)&&!empty($_POST))
            {
              $xls = getModel('xls');
              $msg = $xls->orders_xls();
              if($msg=="1"){
                  echo "导入成功";exit;
                  exit;
                  //msgbox(S_ROOT."xls/import","导入订单成功");
              }else{
                  echo "导入订单失败";exit;
                  //msgbox(S_ROOT."xls/import","导入订单失败");
              }
            }
        }
        $this->tpl->display("orders.xls.php");

    }

    //预约
    public function feedback123()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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

            $rows = $xls->feedback("godate=$godate&todate=$todate");

            //print_r($rows);exit;
            if ($rows) {
                $data = array();
                $data[] = array('订单编号', '预约来源', '客户预约日期', '客户姓名',
                '购买渠道', '合同编号', '产品名称', '预约留言', '提交日期',
                '处理状态', '处理人姓名', '处理批注', '处理时间', );
                $excel = getFunc('excel');
                foreach ($rows as $rs) {
                    $checked = ($rs['checked']) ? '已处理' : '未处理';
                    $data[] = array(
                        $rs['ordersid'], $rs['source'], $rs['datetime'], $rs['name'],
                        $rs['itembuy'], $rs['itemcontract'], $rs['itemname'], $rs['detail'],
                        ($rs['checkdate']) ? date('Y-m-d H:i:s', $rs['checkdate']) : '',
                        $checked, $rs['checkname'], $rs['checkinfo'], ($rs['checkdate']) ? date('Y-m-d H:i:s', $rs['checkdate']) : '',
                    );
                }
                $excel->addArray($data);
                $excel->generateXML('feedback');
            }
        } else {
        }
    }

    //订单入款
    public function charge()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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

            $rows = $xls->charge("checkuserid=$checkuserid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid");
            //print_r($rows);exit;
            if ($rows) {
                $data = array();
                $data[] = array('确认状态', '类别', '款项类别', '收支帐号', '订单编号',
                '合同号', '订单类别', '销售部门', '销售人员',
                '付款方式', '工单号', '工单日期', '服务人员', '回执人员',
                '入款金额', '订单金额', '订购日期', '入款增加人', '入款时间',
                '审核人员', '审核时间', '退差返现', );
                $excel = getFunc('excel');
                $orders = getModel('orders');
                $charge = getModel('charge');
                //订单类型
                $ordertype = $orders->ordertype();
                $paytype = $orders->paytype();
                $cates = $charge->cates();
                foreach ($rows as $rs) {
                    $data[] = array($rs['checked'], $rs['chargetype'], $cates[$rs['cates']]['name'], $rs['payname'],
                    $rs['ordersid'], $rs['contract'], $ordertype[$rs['type']]['name'], $rs['sales'], $rs['saleuname'],
                    $paytype[$rs['paytype']]['name'], $rs['jobsid'], $rs['jobdate'], $rs['afuname'], $rs['workuname'],
                    $rs['callprice'], $rs['oprice'],
                    $rs['odate'], $rs['addname'], $rs['datetime'],
                    $rs['checkname'], $rs['checkdate'], $rs['handled'], );
                }
                //print_r($data);exit;
                $excel->addArray($data);
                $excel->generateXML('charge');
            }
        } else {
        }
    }

    //销售回款
    public function callpay()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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

            $rows = $xls->callpay("godate=$godate&todate=$todate");
            //print_r($rows);exit;
            if ($rows) {
                $data = array();
                $data[] = array('回款日期', 'YWS交易号', '金额', '支付信息', '回款批注', '回款时间', '录入人员');
                $excel = getFunc('excel');
                $orders = getModel('orders');
                //订单类型
                $ordertype = $orders->ordertype();
                $paytype = $orders->paytype();
                foreach ($rows as $rs) {
                    $checked = ($rs['checked']) ? '已确认' : '未确认';
                    $data[] = array($rs['datetime'], $rs['paynum'], $rs['price'], $rs['detail'], $rs['priceinfo'],
                    $rs['dateline'], $rs['addname'], );
                }
                //print_r($data);exit;
                $excel->addArray($data);
                $excel->generateXML('callpay');
            }
        } else {
        }
    }

    //满意度
    public function degree()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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
            $rows = $xls->degree("godate=$godate&todate=$todate");

            //print_r($rows);
            if ($rows) {
                $excel = getFunc('excel');
                $data = array();
                $data[] = array('0=不满意，1=差，2=一般，3满意，4=非常满意');
                $data[] = array('订单编号', '回访状态', '省份', '城市', '地区', '订购日期', '销售部门', '服务中心', '服务日期', '服务人员',
                '回访人员', '回访时间', '销售评分', '销售评价', '服务评分', '服务评价', '回访批注', );
                foreach ($rows as $rs) {
                    if ($rs['callno']) {
                        $status = '无需回访';
                    } else {
                        switch ($rs['checked']) {
                            case '2':$status = '无法回访';break;
                            case '1':$status = '回访成功';break;
                            default :$status = '等待回访';
                        }
                    }
                    $data[] = array($rs['ordersid'], $status, $rs['provname'], $rs['cityname'], $rs['areaname'], $rs['datetime'], $rs['salesname'], $rs['aftername'],
                    $rs['jobdate'], $rs['afteruname'], $rs['addname'], date('Y-m-d H:i:s', $rs['dateline']), $rs['sales'],
                    $rs['salesinfo'], $rs['after'], $rs['afterinfo'], $rs['detail'], );
                }
                $excel->addArray($data);
                $excel->generateXML('degree');
            }
        } else {
        }
    }

    //客户价值
    public function customs()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '2000M');
            $xls = getModel('xls');

            $rows = $xls->customs();
            if ($rows) {
                $excel = getFunc('excel');
                $data = array();
                $data[] = array('客户编号', '统计日期', '累计主订单', '累计订单数量', '累计耗材订单数量', '客户总收入', '客户总天数', '客户总毛利', '客户总上门次数',
                '客户总核算利润', '客户总投诉次数', '平均服务周期', '年贡献收入', '最近一年的订单数量', '最近一年的收入金额', '最近2年的订单数量', '最近2年的收入金额',
                '2年的订单数量', '2年前的收入金额', );
                foreach ($rows as $rs) {
                    $data[] = array($rs['customsid'], $rs['datetime'], $rs['ordernums'], $rs['allordernums'], $rs['filternums'], $rs['allprice'],
                    $rs['alldaynums'],
                    $rs['allprofit'], $rs['jobnums'], $rs['jobprofit'], $rs['complaint'], $rs['services'], $rs['allmoney'],
                    $rs['yearnums'], $rs['yearpice'], $rs['twonums'], $rs['twoprice'], $rs['agenums'], $rs['ageprice'], );
                }
                $excel->addArray($data);
                $excel->generateXML('customs');
            }
        } else {
        }
    }

    //发票
    public function invoice()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

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
            $gotime = strtotime($godate);
            $totime = strtotime($todate);
            $checkint = $totime - $gotime;

            $userid = $this->cookie->get("userid");
            if($userid<>9){
                if ($checkint > 86400 * 100) {
                    msgbox('', '抱歉，记录查询期限不能超过100天！');
                }
            }
            $rows = $xls->invoice("cateid=$cateid&godate=$godate&todate=$todate");
            //print_r($rows);
            if ($rows) {
                $excel = getFunc('excel');
                $invoice = getModel('invoice');

                $cates = $invoice->catetype();
                $works = $invoice->worktype();
                $check = $invoice->checktype();

                $data = array();
                $data[] = array('订购日期','申请日期', '订单编号', '开票类别', '开票公司', '发票金额', '销售部门', '申请人员',
                '审核状态', '审核时间', '审核人员', '开票状态', '发票编号', '开票时间', '开票人员', );
                foreach ($rows as $rs) {
                    $type = ($rs['type'] == '1') ? '增值税专用发票' : '增值税普通发票';
                    $data[] = array(
                        date('Y-m-d', $rs['odateline']), date('Y-m-d', $rs['dateline']), $rs['ordersid'], $type, $cates[$rs['cateid']]['name'], $rs['price'],
                        $rs['salesname'], $rs['addname'], $check[$rs['checked']]['name'],
                        ($rs['checkdate']) ? date('Y-m-d H:i', $rs['checkdate']) : '', $rs['checkname'], $works[$rs['worked']]['name'],
                        $rs['worknums'], ($rs['workdate']) ? date('Y-m-d H:i', $rs['workdate']) : '', $rs['workname'],
                    );
                }
                $excel->addArray($data);
                $excel->generateXML('invoice');
            }
        } else {
        }
    }

    public function yunlogs()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
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
                //msgbox("","抱歉，起始日期不能大于截止日期！");
            }
            $gotime = strtotime($godate);
            $totime = strtotime($todate);
            $checkint = $totime - $gotime;

            if ($checkint > 86400 * 100) {
                //msgbox("","抱歉，记录查询期限不能超过100天！");
            }

            $excel = getFunc('excel');

            $xls = getModel('xls');

            $rows = $xls->yunlogs("godate=$godate&todate=$todate");

            //print_r($rows);exit;

            if ($rows) {
                $data = array();

                $orders = getModel('orders');
                $statustype = $orders->statustype();

                $data[] = array('主订单号', '购买日期', '审核状态', '订单状态', '开始日期', '结束日期', '云净内容',
                '确认状态', '录入时间', '录入人员', );
                foreach ($rows as $rs) {
                    $checked = ($rs['checked'] == '1') ? '已审核' : '未审核';
                    $status = $statustype[$rs['status']]['name'];
                    $yunchecked = ($rs['yunstatus']) ? '已生效' : '未生效';
                    $data[] = array(
                        $rs['id'], date('Y-m-d', $rs['dateline']), $checked, $status, $rs['godate'], $rs['todate'], $rs['detail'],
                        $yunchecked, date('Y-m-d H:i', $rs['yundate']), $rs['yunname'],
                    );
                }

                $excel->addArray($data);
                $excel->generateXML('yunlogs');
            }
        } else {
        }
    }

    //姓名	手机号码	电邮地址	分组	性别	出生日期	单位	所在城市	部门	职位	办公电话	办公地址	家庭电话	住所地址	备注

    public function mobile()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
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
            $gotime = strtotime($godate);
            $totime = strtotime($todate);
            $checkint = $totime - $gotime;

            if ($checkint > 86400 * 100) {
                msgbox('', '抱歉，记录查询期限不能超过100天！');
            }

            $excel = getFunc('excel');

            $xls = getModel('xls');

            $rows = $xls->mobile("godate=$godate&todate=$todate&cateid=$cateid&brandid=$brandid");
            if ($rows) {
            } else {
            }
        } else {
        }
    }

    public function ocharge()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
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
            $gotime = strtotime($godate);
            $totime = strtotime($todate);
            $checkint = $totime - $gotime;

            if ($checkint > 86400 * 100) {
                msgbox('', '抱歉，记录查询期限不能超过100天！');
            }

            $xls = getModel('xls');

            $rows = $xls->ocharge("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&saleuserid=$saleuserid");
            if ($rows) {
                $excel = getFunc('excel');
                $data = array();

                $orders = getModel('orders');
                $customstype = $orders->customstype();
                $statustype = $orders->statustype();
                $charge = getModel('charge');
                $ccates = $charge->cates();

                $data[] = array('订单编号', '订单日期', '销售部门', '销售人员', '客户编号', '合同编号', '订单类型', '订单状态', '订单金额', '盈亏金额',
                '入款日期', '入款类型', '收款方式', '批注', '入款金额', '入款状态', '出库时间', '出库ERP号', '出库状态', '退差返现', );
                foreach ($rows as $rs) {
                    $ctype = $customstype[(int) $rs['ctype']]['name'];
                    $status = $statustype[(int) $rs['status']]['name'];
                    $chargetype = $ccates[(int) $rs['cateid']]['name'];

                    $data[] = array($rs['ordersid'], $rs['datetime'], $rs['salesname'], $rs['saleuname'], $rs['customsid'], $rs['contract'],
                    $ctype, $status, $rs['price'], $rs['payprice'],
                    date('Y-m-d H:i', $rs['chargetime']), $chargetype, $rs['payname'], $rs['chargeinfo'],
                    $rs['cprice'], $rs['cchecked'], $rs['erptime'], $rs['erpnum'], $echecked, $rs['handled'], );
                }
                $excel->addArray($data);
                $excel->generateXML('erplogs');
            }
        }
    }

    public function jobs()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            extract($_GET);
            if ($godate && $todate) {
                $godate = $godate;
                $todate = $todate;
            } else {
                $gotime = time() - 86400 * 30;
                $date = plugin::getTheMonth(date('Y-m', $gotime));
                $godate = $date[0];
                $todate = $date[1];
            }
            $xls = getModel('xls');

            $rows = $xls->jobs("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&brandid=$brandid&encoded=$encoded");
            if ($rows) {
                $excel = getFunc('excel');
                $data = array();

                $jobs = getModel("jobs");
                $jobstype = $jobs->jobstype();

                $data[] = array('订单编号', '购买日期', '购买渠道', '订单状态', '客户名称', '联系地址', '联系电话', '工单类型','工单编号','工单合同号',
                '结算金额', '结算说明', '预约安装时间', '备注', '工单状态', '工单回执',
                '编码/商品名称', );
                foreach ($rows as $rs) {
                    $data[] = array($rs['ordersid'], $rs['datetime'], $rs['salesname'], $rs['status'], $rs['name'], $rs['address'],
                        $rs['mobile'], $jobstype[(int)$rs['type']]["name"], $rs['jobsid'],$rs["contract"], $rs['charge'], $rs['chargeinfo'], $rs['setuptime'],
                        $rs['detail'], $rs['worked'], $rs['workinfo'],
                        $rs['plist'][0]['encoded'], $rs['plist'][0]['serials'], $rs['plist'][0]['title'],
                        $rs['plist'][1]['encoded'], $rs['plist'][1]['serials'], $rs['plist'][1]['title'],
                        $rs['plist'][2]['encoded'], $rs['plist'][2]['serials'], $rs['plist'][2]['title'],
                        $rs['plist'][3]['encoded'], $rs['plist'][3]['serials'], $rs['plist'][3]['title'],
                        $rs['plist'][4]['encoded'], $rs['plist'][4]['serials'], $rs['plist'][4]['title'],
                        $rs['plist'][5]['encoded'], $rs['plist'][5]['serials'], $rs['plist'][5]['title'],
                        $rs['plist'][6]['encoded'], $rs['plist'][6]['serials'], $rs['plist'][6]['title'],
                        $rs['plist'][7]['encoded'], $rs['plist'][7]['serials'], $rs['plist'][7]['title'],
                        $rs['plist'][8]['encoded'], $rs['plist'][8]['serials'], $rs['plist'][8]['title'],
                        $rs['plist'][9]['encoded'], $rs['plist'][9]['serials'], $rs['plist'][9]['title'],
                        $rs['plist'][10]['encoded'], $rs['plist'][10]['serials'], $rs['plist'][10]['title'],
                    );
                }
                $excel->addArray($data);
                $excel->generateXML('jobs');
            } else {
                echo '没有找到相关数据';
            }
        }
    }

    public function sales()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断

        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            extract($_GET);
            if ($godate && $todate) {
                $godate = $godate;
                $todate = $todate;
            } else {
                $gotime = time() - 86400 * 30;
                $date = plugin::getTheMonth(date('Y-m', $gotime));
                $godate = $date[0];
                $todate = $date[1];
            }
            $xls = getModel('xls');

            $rows = $xls->sales("godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&brandid=$brandid");

            if ($rows) {
                $orders = getModel('orders');
                $ostatus = $orders->statustype();
                $jobs = getModel('jobs');
                $worktype = $jobs->worktype();

                $excel = getFunc('excel');
                $data = array();

                $data[] = array('结算订单号', '订单编号', '订单状态', '购买日期', '购买渠道', '客户名称',
                    '省份', '城市', '区县', '联系地址', '手机号码', '其它电话', '订购金额',
                    '出库机身编码', '工单编号', '工单日期', '完成状态', '商品条码', '商品编码', '商品名称', );
                foreach ($rows as $rs) {
                    $data[] = array(
                        $rs['numbers'], $rs['ordersid'], $ostatus[$rs['status']]['name'], date('Y-m-d H:i', $rs['dateline']), $rs['salesname'], $rs['name'],
                        $rs['provname'], $rs['cityname'], $rs['areaname'], $rs['address'], $rs['mobile'], $rs['phone'], $rs['store_serial'],
                        $rs['jobsid'], $rs['jobdate'], $worktype[$rs['worked']]['name'],
                        $rs['store_barcode'], $rs['encoded'], $rs['pname'],
                    );
                }
                $excel->addArray($data);
                $excel->generateXML('orders');
            }
        }
    }

    public function notes()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            extract($_GET);
            if ($godate && $todate) {
                $gotime = strtotime($godate.' 00:00:00');
                $totime = strtotime($todate.' 23:59:59');
            } else {
                $gotime = time() - 86400 * 30;
                $totime = time();
            }
            if ($gotime > $totime) {
                msgbox('', '抱歉，起始日期不能大于截止日期！');
            }

            $checkint = $totime - $gotime;

            if ($checkint > 86400 * 100) {
                msgbox('', '抱歉，记录查询期限不能超过100天！');
            }

            $xls = getModel('xls');

            $rows = $xls->notes("gotime=$gotime&totime=$totime");
            //print_r($rows);
            if ($rows) {
                $excel = getFunc('excel');
                $data = array();
                $data[] = array('姓名', '工号', 'YWS未读', 'YOS未读');

                foreach ($rows as $rs) {
                    $data[] = array($rs['name'], $rs['worknum'], $rs['yws'], $rs['yos']);
                }
                $excel->addArray($data);
                $excel->generateXML('msgnums');
            }
        } else {
        }
    }

    public function userarea()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

            $rows = $xls->userarea();
            //print_r($rows);exit;
            $data = array();
            $data[] = array('所在省份', '所在城市', '所在地区', '订单总数', '有效订单数');
            foreach ($rows as $rs) {
                $data[] = array($rs['provname'], $rs['cityname'], $rs['areaname'], $rs['orderalls'], $rs['ordernums']);
            }
            $excel = getFunc('excel');
            $excel->addArray($data);
            $excel->generateXML('ordercustoms');
        }
    }

    public function userorders()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $show = $_GET['show'];
        if ($show == 'xls') {
            ini_set('memory_limit', '3000M');
            $xls = getModel('xls');

            $rows = $xls->userorders();
            //print_r($rows);exit;
            $data = array();
            $data[] = array('订单号', '客户名称', '客户类别', '类别', '地址', '手机', '电话', '商品');
            foreach ($rows as $rs) {
                switch ($rs['ctype']) {
                    case '2':$cname = '商用客户';break;
                    case '3':$cname = '云净家用';break;
                    case '4':$cname = '云净商用';break;
                    default :$cname = '家用客户';
                }
                if ($rs['ctype'] == '2') {
                    $yuntype = '';
                } else {
                    $yuntype = $rs['yuntype'];
                }
                $data[] = array($rs['ordersid'], $rs['name'], $cname, $yuntype, $rs['address'], $rs['mobile'], $rs['phone'],
                    $rs['plist'][0], $rs['plist'][1], $rs['plist'][2], $rs['plist'][3], $rs['plist'][4], $rs['plist'][5], );
            }

            $excel = getFunc('excel');
            $excel->addArray($data);
            $excel->generateXML('ordersall');
        }
    }

    //导出商品
    public function products()
    {
        $this->users->onlogin();    //登录判断
        $this->users->pagelevel();    //权限判断
        $show = $_GET['show'];
        if ($show == 'xls') {
            $xls  = getModel("xls");
            ini_set('memory_limit', '3000M');
            extract($_GET);
            if ($godate && $todate) {
                $gotime = strtotime($godate.' 00:00:00');
                $totime = strtotime($todate.' 23:59:59');
            } else {
                $gotime = time() - 86400 * 30;
                $totime = time();
            }
            $data = array();
            $data[] = array('订单编号','编码','订购日期', '省份', '城市', '区县', '类型', '品牌', '商品', '金额', '旧价');
            $rows = $xls->products("gotime=$gotime&totime=$totime");
            if($rows){
                foreach($rows AS $rs){
                    $datetime = date("Y-m-d",$rs["dateline"]);
                    if($rs["erpprice"] < $rs["memberprice"]){
                        $price = $rs["memberprice"];
                    }else{
                        $price = $rs["erpprice"];
                    }
                    $price = ($price)?$price:$rs["marketprice"];
                    //$mprice = $rs["marketprice"];
                    $mprice = ($rs["price"])?$rs["price"]:$rs["marketprice"];
                    if($rs["encoded"]=="000000"){
                        $productname = $rs["oititle"];
                    }else{
                        $productname = ($rs["erpname"])?$rs["erpname"]:$rs["encoded"];
                    }
                    $data[] = array($rs["ordersid"],$rs["encoded"],$datetime,$rs["provname"],$rs["cityname"],$rs["areaname"],
                    $rs["catename"],$rs["brandname"],$productname,$price,$mprice);
                }
            }
            $excel = getFunc('excel');
            $excel->addArray($data);
            $excel->generateXML('ordersall');
        } else {

        }
    }

  	//工单监控导出
  	Public function jobsmonitor()
  	{
    		$this->users->onlogin();	//登录判断
    		$this->users->pagelevel();	//权限判断
    		$show = $_GET["show"];
    		$xls = getModel("xls");
    		$jobs = getModel("jobs");
  			extract($_GET);

        if ($godate && $todate) {
            $gotime = strtotime($godate.' 00:00:00');
            $totime = strtotime($todate.' 23:59:59');
        } else {
            $gotime = time() - 86400 * 30;
            $totime = time();
        }
        if ($gotime > $totime) {
            msgbox('', '抱歉，起始日期不能大于截止日期！');
        }

        $checkint = $totime - $gotime;

        $userid = (int)$this->cookie->get("userid");
        if($userid<>"9"){
          if ($checkint > 86400 * 31) {
              msgbox('', '抱歉，记录查询期限不能超过一个月！');
          }
        }

    		$worktype = $jobs->worktype();

    		$jobstype = $jobs->jobstype();

  			$rows = $xls->jobsmonitor("provid=$provid&cityid=$cityid&areaid=$areaid&worked=$worked&ordersid=$ordersid&jobsid=$jobsid&godate=$godate&todate=$todate&salesarea=$salesarea&salesid=$salesid&afterarea=$afterarea&afterid=$afterid");

        $data = array();
        $data[] = array('工单类型', '工单编号', '工单合同号', '订单号', '服务供应商', '服务网点', '受派人',
         '派单日期', '预约日期', '超期','完成状态', '最后回执', '未响应时间', '催单', '投诉', '回访');
        if($rows){
            foreach($rows AS $rs){
                if($rs["datetime"] >= date("Y-m-d",time())){
                    echo "无";
                }else{
                    if($rs["worked"]=="0"){
                        $chaoqi = plugin::getTime(time()-strtotime($rs["datetime"]." 08:00:00"));
                    }else{
                        $chaoqi = plugin::getTime($rs["workdateline"]-(int)strtotime($rs["datetime"]." 08:00:00"));
                    }
                    $cqtime = $chaoqi["d"]."天".$chaoqi["h"]."时";
                }
                if($rs["logstime"]){
                  $logstime = plugin::getTime(time()-$rs["logstime"]);
                  $logsdate = $logstime["d"]."天".$logstime["h"]."时";
                }else{
                  $logsdate = "无";
                };
                $data[] = array($jobstype[(int)$rs["type"]]["name"],(int)$rs["jobsid"],$rs["contract"],(int)$rs["ordersid"],
                $rs["salesname"],$rs["aftername"],$rs["afteruname"],date("Y-m-d",$rs["dateline"]),$rs["datetime"],
                $cqtime,$worktype[(int)$rs["worked"]]["name"],date("Y-m-d H:i",$rs["logstime"]),$logsdate,(int)$rs["tourge"],(int)$rs["complaint"],(int)$rs["degree"]);
            }
            $excel = getFunc('excel');
            $excel->addArray($data);
            $excel->generateXML('jobsmonitor');
        }
  	}
    //预约
    public function feedback()
    {
      $this->users->onlogin();    //登录判断
      $this->users->pagelevel();    //权限判断

      $show = $_GET['show'];
      if ($show == 'xls') {
          ini_set('memory_limit', '3000M');
          $xls = getModel('xls');

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

          $checked  = (int)$_GET['status'];
          if($checked=="0"){
             $godate  = "";
             $todate  = "";
          }

          $rows = $xls->feedback("godate=$godate&todate=$todate&checked=$checked");
          //print_r($rows);exit;
          if ($rows) {
              $data = array();
              $data[] = array('信息类型', '当前状态', '操作人','操作时间', '受理批注',
              '生产日期', '安装日期', '客户姓名', '所在地区', '联系地址',
              '联系电话', '购买渠道', '产品编码', '产品名称','预约留言','预约时间', );
              $excel = getFunc('excel');
              foreach ($rows as $rs) {
                  switch($rs["type"]){
                  	case "1": $sotype = "安装"; break;
                  	case "2": $sotype = "报修"; break;
                  	default	: $sotype = "登记";
                  }
                  switch($rs["checked"]){
                  	case "1": $checked = "受理完成"; break;
                  	case "2": $checked = "预约取消"; break;
                  	default	: $checked = "等待处理";
                  }
                  $data[] = array(
                    $sotype,
                    $checked,$rs["checkuname"],($rs['checkdate']) ? date('Y-m-d H:i:s', $rs['checkdate']) : '',
                    $rs['checkinfo'],$rs['makedate'],$rs['setupdate'],
                    $rs['name'],$rs['provname']." ".$rs['cityname']." ".$rs['areaname'],$rs['address'],$rs['phone'],
                    $rs['itembuy'],$rs['itemcontract'],$rs['itemname'],$rs['detail'],
                    ($rs['dateline']) ? date('Y-m-d H:i:s', $rs['dateline']) : '',
                  );
              }
              $excel->addArray($data);
              $excel->generateXML('feedback');
          }
      } else {
      }
    }
}
