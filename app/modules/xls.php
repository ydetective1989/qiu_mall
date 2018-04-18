<?php

class xlsModules extends Modules
{
    public function checktime()
    {
        $starid = date('w');
        $htime = date('H');
        $userid = $this->cookie->get('userid');
        if ($userid != '9') {
            if ($starid >= 1 && $starid <= 5 && $htime >= '9' && $htime <= '18') {
                dialog('周一~周五每天9点至18点,无法使用导出功能!');
                exit;
            }
        }
    }

    //订单审核类
    public function orders($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            //$gotime = strtotime($godate.' 00:00:00');
            $where .= " AND o.datetime >= '$godate' ";
        }
        if ($todate != '') {
            //$totime = strtotime($todate.' 23:59:59');
            $where .= " AND o.datetime <= '$todate' ";
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

        $query = ' SELECT o.id,o.customsid,o.type,o.ctype,o.datetime,o.dateline,st.name AS salesname,
     		su.name AS salesuname,o.price,o.price_setup,o.price_deliver,o.price_minus,o.price_other,o.price_all,o.paytype,o.setuptype,o.source,o.status,o.contract,
    		pa.name AS provname,ca.name AS cityname,aa.name AS areaname,o.checked,o.checkdate,o.checkuserid
    		FROM '.DB_ORDERS.'.orders AS o
    		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
    		INNER JOIN '.DB_ORDERS.'.users AS su ON o.saleuserid = su.userid
    		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
    		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
    		INNER JOIN '.DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
    		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where  ";
        $rows = $xdb->getRows($query);
        //print_r($rows);exit;
        if ($rows) {
            $arr = array();

            foreach ($rows as $o) {
                $on = array();
                $on['id'] = $o['id'];
                $on['customsid'] = $o['customsid'];
                $on['type'] = $o['type'];
                $on['ctype'] = $o['ctype'];
                $on['source'] = $o['source'];
                $on['status'] = $o['status'];
                $on['contract'] = $o['contract'];
                $on['datetime'] = $o['datetime'];
                $on['salesname'] = $o['salesname'];
                $on['salesunname'] = $o['salesuname'];
                $on['dateline'] = date('Y-m-d H:i:s', $o['dateline']);
                $on['provname'] = $o['provname'];
                $on['cityname'] = $o['cityname'];
                $on['areaname'] = $o['areaname'];
                $on['price'] = $o['price'];
                $on['price_setup'] = $o['price_setup'];
                $on['price_deliver'] = $o['price_deliver'];
                $on['price_minus'] = $o['price_minus'];
                $on['price_other'] = $o['price_other'];
                $on['price_all'] = $o['price_all'];
                $on['paytype'] = $o['paytype'];
                $on['setuptype'] = $o['setuptype'];
                $ordersid = $o['id'];

                //审核提交
                $query = ' SELECT au.name AS checkaddname,oc.dateline AS addcheckdate,oc.outed,oc.detail
        				FROM '.DB_ORDERS.'.orders_checked AS oc
        				INNER JOIN '.DB_ORDERS.".users AS au ON oc.userid = au.userid
        				WHERE oc.ordersid = $ordersid
        				ORDER BY oc.dateline DESC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $on['checkaddname'] = $row['checkaddname'];
                    $on['addcheckdate'] = date('Y-m-d H:i:s', $row['addcheckdate']);
                    $on['checkdetail'] = $row['detail'];
                }

                $sql="SELECT id FROM ".DB_ORDERS.".store  WHERE ordersid = $ordersid";//print_r($sql);exit;
                $row = $xdb->getRow($sql);//print_r($srow);print_r($sql);exit;exit;
                if ($row) {
                  $on['stored']=1;
                }else{
                  $on['stored']=0;
                }


                if($o['checked']) {
                    //审核时间及审核人
                    $on['checkdate'] = date('Y-m-d', $o['checkdate']);
                    $checkuserid = $o['checkuserid'];
                    $query = ' SELECT userid,worknum,name FROM '.DB_ORDERS.".users WHERE userid = $checkuserid ";
                    $row = $xdb->getRow($query);
                    $on['checkuname'] = $row['name'];
                }

                $query = ' SELECT encoded,title,nums
        				FROM '.DB_ORDERS.".ordersinfo WHERE ordersid = $ordersid
        				GROUP BY grouped ORDER BY grouped ASC ";
                $rows = $xdb->getRows($query);
                $on['product'] = $rows;

                $arr[] = $on;
            }
        }

        return $arr;
    }

    //订单状态
    public function status($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND o.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND o.dateline <= '$totime' ";
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

        //"订单号","订购日期","销售人员","录入时间","提交审查时间","审核提交人员","订单审核时间","审核人员",
        //"物流增加时间","物流增加人","物流公司名","物流签收时间","第一次派工时间","第一次派工人",
        //"派工确认时间","派工确认人","派工回执时间","派工回执人","入款时间","款项录入人","回访满意度时间","回访人员",
        //"预计安装日期","派工预约日期","派工实际日期"
        $query = ' SELECT o.id,o.customsid,o.type,o.ctype,o.datetime,o.source,o.dateline,o.contract,
    		o.status,o.checkdate,st.name AS salesname,su.name AS salesuname,
    		o.checked,o.checkuserid,o.plansetup,o.price
    		FROM '.DB_ORDERS.'.orders AS o
    		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
    		INNER JOIN '.DB_ORDERS.".users AS su ON o.saleuserid = su.userid
    		WHERE o.openid = ".OPEN_ID." AND o.hide = 1  $where
    		LIMIT 0,10000 ";
        $rows = $xdb->getRows($query);
        //print_r($rows);exit;
        if ($rows) {
            $arr = array();
            foreach ($rows as $o) {
                $on = array();
                $on['id'] = $o['id'];
                $on['customsid'] = $o['customsid'];
                $on['type'] = $o['type'];
                $on['ctype'] = $o['ctype'];
                $on['source'] = $o['source'];
                $on['status'] = $o['status'];
                $on['contract'] = $o['contract'];
                $on['price'] = $o['price'];
                $on['datetime'] = date('Y-m-d', $o['dateline']);
                $on['salesname'] = $o['salesname'];
                $on['salesunname'] = $o['salesuname'];
                $on['dateline'] = date('Y-m-d H:i:s', $o['dateline']);
                $on['plansetup'] = $o['plansetup'];
                $ordersid = $o['id'];

                //付款金额
                $query = 'SELECT SUM(price) AS price FROM '.DB_ORDERS.".orders_charge WHERE hide = 1 AND ordersid = $ordersid ";
                $row = $xdb->getRow($query);
                $on['charge'] = $row['price'];

                //已确认金额
                $query = 'SELECT SUM(price) AS price FROM '.DB_ORDERS.".orders_charge WHERE
	              hide = 1 AND checked = 1 AND ordersid = $ordersid ";
                $row = $xdb->getRow($query);
                $on['encharge'] = $row['price'];

                //审核提交
                $query = ' SELECT au.name AS checkaddname,oc.dateline AS addcheckdate,oc.outed
        				FROM '.DB_ORDERS.'.orders_checked AS oc
        				INNER JOIN '.DB_ORDERS.".users AS au ON oc.userid = au.userid
        				WHERE oc.ordersid = $ordersid
        				ORDER BY oc.dateline DESC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $on['checkaddname'] = $row['checkaddname'];
                    $on['addcheckdate'] = date('Y-m-d H:i:s', $row['addcheckdate']);
                }

                if ($o['checked']) {
                    //审核时间及审核人
                    $on['checkdate'] = date('Y-m-d H:i:s', $o['checkdate']);
                    $checkuserid = $o['checkuserid'];
                    $query = ' SELECT userid,worknum,name FROM '.DB_ORDERS.".users WHERE userid = $checkuserid ";
                    $row = $xdb->getRow($query);
                    $on['checkuname'] = $row['name'];
                }
                //物流信息
                $query = ' SELECT au.name AS addname,e.dateline AS dateline,e.finished,e.finishtime,
        				ce.name AS expname,e.numbers
        				FROM '.DB_ORDERS.'.express AS e
        				INNER JOIN '.DB_ORDERS.'.config_express AS ce ON e.cateid = ce.id
        				INNER JOIN '.DB_ORDERS.".users AS au ON e.userid = au.userid
        				WHERE e.type = 1 AND e.ordersid = $ordersid
        				ORDER BY e.dateline ASC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $on['expaddtime'] = date('Y-m-d H:i:s', $row['dateline']);
                    $on['expadduname'] = $row['addname'];
                    $on['expname'] = $row['expname'];
                    $on['expnums'] = $row['numbers'];
                    if ($row['finished'] == '3') {
                        $on['exptime'] = date('Y-m-d H:i:s', $row['finishtime']);
                    }
                }

                //工单信息
                $query = ' SELECT au.name AS addname,job.dateline,job.checked,job.worked,job.datetime,
        				job.checkuserid,job.checkdate,job.workdateline,job.workuserid,at.name AS aftername
        				FROM '.DB_ORDERS.'.job_orders AS job
        				INNER JOIN '.DB_ORDERS.'.config_teams AS at ON job.afterid = at.id
        				INNER JOIN '.DB_ORDERS.".users AS au ON job.adduserid = au.userid
        				WHERE job.type = 2 AND job.ordersid = $ordersid
        				ORDER BY job.dateline ASC ";
                $row = $xdb->getRow($query);
                //print_r($row);exit;
                if ($row) {
                    $on['aftername'] = $row['aftername'];
                    $on['jobdatetime'] = $row['datetime'];
                    $on['jobaddtime'] = date('Y-m-d H:i:s', $row['dateline']);
                    $on['jobaddname'] = $row['addname'];
                    if ($row['checked']) {
                        $on['checktime'] = date('Y-m-d H:i:s', $row['checkdate']);
                        $checkuserid = (int) $row['checkuserid'];
                        $query = ' SELECT userid,worknum,name FROM '.DB_ORDERS.".users WHERE userid = $checkuserid ";
                        $r = $xdb->getRow($query);
                        $on['checkuname'] = $r['name'];
                    }
                    if ($row['worked']) {
                        $on['workdate'] = date('Y-m-d', $row['workdateline']);
                        $on['worktime'] = date('Y-m-d H:i:s', $row['workdateline']);
                        $workuserid = (int) $row['workuserid'];
                        $query = ' SELECT userid,worknum,name FROM '.DB_ORDERS.".users WHERE userid = $workuserid ";
                        $r = $xdb->getRow($query);
                        $on['workuname'] = $r['name'];
                    }
                }
                $query = ' SELECT au.name AS addname,oc.dateline
				FROM '.DB_ORDERS.'.orders_charge AS oc
				INNER JOIN '.DB_ORDERS.".users AS au ON au.userid = oc.userid
				WHERE oc.hide = 1 AND oc.ordersid = $ordersid
				ORDER BY oc.dateline ASC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $on['chargetime'] = date('Y-m-d H:i:s', $row['dateline']);
                    $on['chargeaddname'] = ($row['addname']) ? $row['addname'] : '系统操作';
                }

                $query = 'SELECT cd.dateline,au.name AS addname
				FROM callback_degree AS cd
				INNER JOIN '.DB_ORDERS.".users AS au ON au.userid = oc.userid
				WHERE cd.ordersid = $ordersid
				ORDER BY cd.dateline ASC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $on['degreetime'] = date('Y-m-d H:i:s', $row['dateline']);
                    $on['degreename'] = ($row['addname']) ? $row['addname'] : '系统操作';
                }

                $arr[] = $on;
            }
            $rows = $arr;
        }

        return $rows;
    }


    /**************  订单导入   *************/
    //订单导入
    Public function orders_xls()
    {
        //处理字符串
        extract($_POST);
        if($dingdan==""){return "不能为空";}
        if($salesid==""){return "不能为空";}
        $xls = trim($dingdan);//print_r($xls);exit;

        /**
        1 = 普通订单 9 = 服务订单 3 = 耗材订单 2 = 维修订单 4 = 配件订单 6 = 无忧订单 7 = 云净业务 5 = 其他订单
        1 = 零售客户 2 = 商用客户 3 = 云净家用 4 = 云净商用 5 = 大客户&经销商 6 = 信用订单 7 = 服务供应商
        */
        $source	  = "fuwu";
        //$type	  = "9";
        //$ctype	  = "7";
        $checked  = $checked;
        $status	  = $status;
        $paystate = $paystate;
        $saleuserid = $this->cookie->get("userid");    //584 = 京东云净净水方案旗舰店

        $orders = explode("\n",$xls);

        foreach($orders AS $rs){

          $row = explode("	",$rs);
          //print_r($row);exit;
          $name		  = $row[0];
          $mobile		= $row[1];
          $phone		= $row[2];
          //$addr = explode(" ",$row[4]);
          //print_r($addr);exit;
          $provname	= trim($row[3]);
          $cityname	= trim($row[4]);
          $areaname	= trim($row[5]);
          $address	= trim($row[6]);
          $pcode		= ($row[7])?trim($row[7]):"000000";
          $nums		  = (int)$row[9];
          $pname		= $row[8];
          $price		= @round($row[10],2);
          $contract	= $row[11];
          $wangwang	= $row[12];
          $detail		= $row[14];
          $datetime	= ($row[12])?$row[12]:date("Y-m-d",time());
          $pid	  	= $this->pinfo($pcode);

          $provid 	= $this->getArea($provname);		//Prov
          $cityid 	= $this->getArea($cityname);		//City
          $areaid 	= $this->getArea($areaname);		//Area

          // //录入客户信息
          // $arr = array(
          //   'name'		=>	trim($name),
          //   'sex'	  	=>	(int)$sex,
          //   'provid'	=>	(int)$provid,
          //   'cityid'	=>	(int)$cityid,
          //   'areaid'	=>	(int)$areaid,
          //   'address'	=>	$address,
          //   'postnum'	=>	"",
          //   'phone'		=>	trim($phone),
          //   'mobile'	=>	trim($mobile),
          //   'email'		=>	"",
          //   'qq'		  =>	"",
          //   'wangwang'	=>	trim($wangwang),
          //   'im'		    =>	"",
          //   'adduserid' =>	"1",
          //   'upuserid'	=>	"1",
          //   'dateline'	=>	time(),
          //   'updateline'=>	time()
          // );
          // $this->odb->insert(DB_ORDERS.".customs",$arr);
          // $customsid = (int)$this->odb->getLastInsId();
          // $logsarr.= plugin::arrtostr($arr);

          //生成订单
          $ordernum = date("YmdHis",time())."001".rand(0,9);
          $arr = array(
            'openid'    =>OPEN_ID,
            'ordernum'	=>$ordernum,		//流水号
            'contract'	=>$contract,
            'parentid'	=>0,
            'source'		=>$source,			//yws为订单业务系统录入
            'type'			=>$type,
            'ctype'			=>$ctype,
            'customsid'	=>(int)$customsid,
            'name'			=>trim($name),
            'sex'				=>0,
            'provid'		=>(int)$provid,
            'cityid'		=>(int)$cityid,
            'areaid'		=>(int)$areaid,
            'address'		=>trim($address),
            'postnum'		=>"",
            'phone'			=>trim($phone),
            'mobile'		=>trim($mobile),
            'email'			=>"",
            'qq'				=>"",
            'wangwang'	=>trim($wangwang),
            'im'				=>"",
            'price'   		  => $price,
            'price_all'   	=> $price,
            'price_setup'   => 0,
            'price_deliver' => 0,
            'price_minus'   => 0,
            'price_other'   => 0,
            'price_detail'  => "",
            'paytype'	 			=> 0,
            'setuptype'	 		=> 1,
            'delivertype'		=> 5,
            'detail'	 			=> $detail." 服务承接安装订单",
            'salesid'	 			=> $salesid,
            'saleuserid' 		=> (int)$saleuserid,
            // 'afterid'	 => "0",
            // 'afteruserid'=> "0",
            'adduserid'  => "1",
            'datetime'	 => $datetime,
            'dateline'	 => time(),
            'plansend'	 => $datetime,
            'plansetup'	 => $datetime,
            'checked'	 	 => $checked,		//审核状态
            'checkdate'	 => time(),
            'checkuserid'=>	"1",
            'status'	 	 => $status,		//跟踪状态
            'paystate'	 => $paystate	  //是否已支付
          );
          $this->db->insert(DB_ORDERS.".orders",$arr);
          $ordersid = (int)$this->db->getLastInsId();
          $logsarr.= plugin::arrtostr($arr);

          $arr = array(
            'ordersid'	=>	$ordersid,
            'grouped'		=>	1,
            'productid'	=>	$pid,
            'price'			=>	$price,
            'erpprice'	=>	$price,
            'encoded'		=>	$pcode,
            'title'			=>	$pname,
            'nums'			=>	$nums,
            'detail'		=>	""
          );
          $this->db->insert(DB_ORDERS.".ordersinfo",$arr);
          $logsarr.= plugin::arrtostr($arr);
          echo $ordersid."<br>";
        }

        return 1;
    }

    Public function pinfo($encoded=""){

        $query = "SELECT productid FROM ".DB_PRODUCT.".product WHERE encoded = '$encoded' ";//print_r($query);exit;
        $row = $this->db->getRow($query);
        if($row){
          return (int)$row["productid"];
        }else{
          return "1061";
        }
    }

    Public function getArea($name="")
    {

        $query = "SELECT areaid FROM ".DB_CONFIG.".areas WHERE name = '$name' ";
        $row = $this->db->getRow($query);
        return (int)$row["areaid"];
    }


    //预约处理
    public function feedback($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($checked != '') {
            $checked = (int) $checked;
            $where .= " AND f.checked = $checked ";
        }

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND f.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND f.dateline <= '$totime' ";
        }
        //$data[] = array('信息类型', '当前状态', '受理操作', '受理批注','生产日期', '安装日期', '客户姓名', '所在地区', '联系地址',
        //'联系电话', '购买渠道', '产品编码', '产品名称','预约留言','预约时间', );
        $query = ' SELECT f.ordersid,f.source,f.datetime,f.name,f.itembuy,f.makedate,f.setupdate,f.phone,f.type,
    f.address,f.datetime,f.detail,f.itemcontract,f.itemname,f.detail,
		f.dateline,f.checked,f.checkinfo,f.checkdate,au.name AS checkname,pa.name AS provname,ca.name AS cityname,aa.name AS areaname
		FROM '.DB_ORDERS.'.job_feedback AS f
		INNER JOIN '.DB_ORDERS.".users AS au ON f.checkuserid = au.userid
    INNER JOIN ".DB_CONFIG.".areas AS pa ON f.provid = pa.areaid
    INNER JOIN ".DB_CONFIG.".areas AS ca ON f.cityid = ca.areaid
    INNER JOIN ".DB_CONFIG.".areas AS aa ON f.areaid = aa.areaid
		WHERE f.openid = ".OPEN_ID." AND f.hide = 1 $where
		ORDER BY f.dateline ASC ";
        //echo $query;exit;
        $rows = $xdb->getRows($query);

        return $rows;
    }

    //订单入款
    public function charge($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND c.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND c.dateline <= '$totime' ";
        }

        if ($checkuserid != '') {
            $checkuserid = (int) $checkuserid;
            $where .= " AND c.checkuserid = $checkuserid ";
        }

        if ($salesarea != '') {
            $salesarea = (int) $salesarea;
            $where .= " AND st.parentid = $salesarea ";
        }

        if ($salesid != '') {
            $salesid = (int) $salesid;
            $where .= " AND o.salesid = $salesid ";
        }

        if ($saleuserid != '') {
            $saleuserid = (int) $saleuserid;
            $where .= " AND o.saleuserid = $saleuserid ";
        }

        //$data[]= array("订单编号","订单类别","销售部门","付款方式","工单号","工单日期",
        //"入款金额","订单金额","订购日期","入款增加人","入款时间");

        $query = ' SELECT c.ordersid,c.type AS chargetype,o.type,st.name AS sales,o.paytype,
 		c.jobsid,c.price AS callprice,o.price AS oprice,
		c.checked,c.checkuserid,c.checkdate,ou.name AS saleuname,
		o.dateline AS odateline,au.name AS addname,c.dateline,o.contract,cct.name AS payname,c.cates
		FROM '.DB_ORDERS.'.orders_charge AS c
		INNER JOIN '.DB_ORDERS.'.orders AS o ON c.ordersid = o.id
		INNER JOIN '.DB_ORDERS.'.users AS au ON c.userid = au.userid
		INNER JOIN '.DB_ORDERS.'.users AS ou ON o.saleuserid = ou.userid
		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
		INNER JOIN '.DB_ORDERS.".config_charge_type AS cct ON c.payid = cct.id
		WHERE o.openid = ".OPEN_ID." AND c.hide = 1 $where
		GROUP BY c.id
		ORDER BY c.ordersid ";
        //echo $query;exit;
        $rows = $xdb->getRows($query);
        //print_r($rows);exit;
        if ($rows) {
            $arr = array();
            foreach ($rows as $rs) {
                $o = array();
                $o['ordersid'] = $rs['ordersid'];
                $ordersid = $rs['ordersid'];
                $o['contract'] = $rs['contract'];
                $o['type'] = $rs['type'];
                $o['sales'] = $rs['sales'];
                $o['paytype'] = $rs['paytype'];
                $o['cates'] = $rs['cates'];
                $o['payname'] = $rs['payname'];
                $o['jobsid'] = $rs['jobsid'];
                $o['callprice'] = $rs['callprice'];
                $o['oprice'] = $rs['oprice'];
                $o['saleuname'] = $rs['saleuname'];
                $o['checked'] = ($rs['checked']) ? '已确认' : '未确认';
                $o['addname'] = ($rs['addname']) ? $rs['addname'] : '系统入款';
                $o['odate'] = date('Y-m-d', $rs['odateline']);
                $o['datetime'] = date('Y-m-d H:i', $rs['dateline']);
                if ($rs['jobsid']) {
                    $jobsid = $rs['jobsid'];
                    $query = ' SELECT jobs.datetime,jobs.workdateline,afu.name AS afuname,wu.name AS workuname
					FROM '.DB_ORDERS.'.job_orders AS jobs
					INNER JOIN '.DB_ORDERS.'.users AS wu  ON jobs.workuserid = wu.userid
					INNER JOIN '.DB_ORDERS.".users AS afu ON jobs.afteruserid = afu.userid
					WHERE jobs.id = $jobsid ";
                    $row = $xdb->getRow($query);
                    if ($row) {
                        $o['jobdate'] = date('Y-m-d H:i', $row['workdateline']);
                        $o['afuname'] = $row['afuname'];
                        $o['workuname'] = $row['workuname'];
                    }
                }

                if ($rs['chargetype'] == '2') {
                    $query = ' SELECT id FROM '.DB_ORDERS.".orders_handle
					WHERE hide = 1 AND ordersid = $ordersid AND cateid = 2 ";
                    $row = $xdb->getRow($query);
                    if ($row) {
                        $o['handled'] = '是';
                    }
                    $o['chargetype'] = '退款';
                } else {
                    $o['chargetype'] = '入款';
                }

                if ($rs['checked'] == '1') {
                    $checkuserid = (int) $rs['checkuserid'];
                    $query = ' SELECT name FROM '.DB_ORDERS.".users WHERE userid = $checkuserid  ";
                    $row = $xdb->getRow($query);
                    $o['checkname'] = $row['name'];
                    $o['checkdate'] = date('Y-m-d H:i', $rs['checkdate']);
                }

                //print_r($o);
                $arr[] = $o;
            }
            //print_r($arr);exit;
            $rows = $arr;
        }

        return $rows;
    }

    public function ocharge($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND c.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND c.dateline <= '$totime' ";
        }

        if ($checkuserid != '') {
            $checkuserid = (int) $checkuserid;
            $where .= " AND c.checkuserid = $checkuserid ";
        }

        if ($salesarea != '') {
            $salesarea = (int) $salesarea;
            $where .= " AND st.parentid = $salesarea ";
        }

        if ($salesid != '') {
            $salesid = (int) $salesid;
            $where .= " AND o.salesid = $salesid ";
        }

        if ($saleuserid != '') {
            $saleuserid = (int) $saleuserid;
            $where .= " AND o.saleuserid = $saleuserid ";
        }

        //$data[] = array("订单编号","订单日期","销售部门","客户编号","合同编号","销售部门","销售人员","订单类型","订单状态","订单金额",
        //"入款日期","入款类型","收款方式","批注","入款金额","入款状态","出库时间","出库ERP号","出库状态");

        $query = ' SELECT c.ordersid,c.type AS chargetype,o.datetime,st.name AS salesname,o.customsid,o.contract,o.type,o.ctype,o.status,o.price,
		c.dateline AS chargetime,c.cates AS cateid,cct.name AS payname,c.detail AS chargeinfo,c.price AS cprice,
		c.checked AS cchecked,ou.name AS saleuname
		FROM '.DB_ORDERS.'.orders_charge AS c
		INNER JOIN '.DB_ORDERS.'.orders AS o ON c.ordersid = o.id
		INNER JOIN '.DB_ORDERS.'.users AS au ON c.userid = au.userid
		INNER JOIN '.DB_ORDERS.'.users AS ou ON o.saleuserid = ou.userid
		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
		INNER JOIN '.DB_ORDERS.".config_charge_type AS cct ON c.payid = cct.id
		WHERE o.openid = ".OPEN_ID." AND c.hide = 1 $where
		GROUP BY c.id
		ORDER BY c.ordersid ASC ";
        //echo $query;exit;
        $rows = $xdb->getRows($query);
        //print_r($rows);exit;
        if ($rows) {
            $arr = array();
            foreach ($rows as $rs) {
                $o = array();
                $o['ordersid'] = $rs['ordersid'];
                $o['datetime'] = $rs['datetime'];
                $o['salesname'] = $rs['salesname'];
                $o['customsid'] = $rs['customsid'];
                $o['contract'] = $rs['contract'];
                $o['type'] = $rs['type'];
                $o['ctype'] = $rs['ctype'];
                $o['status'] = $rs['status'];
                $price = round($rs['price'], 2);
                $o['price'] = $price;
                $o['chargetime'] = $rs['chargetime'];
                $o['cateid'] = $rs['cateid'];
                $o['payname'] = $rs['payname'];
                $o['chargeinfo'] = $rs['chargeinfo'];
                $o['cprice'] = $rs['cprice'];
                $o['cchecked'] = ($rs['cchecked']) ? '已确认' : '未确认';

                $ordersid = (int) $rs['ordersid'];

                if ($rs['chargetype'] == '2') {
                    $query = ' SELECT id FROM '.DB_ORDERS.".orders_handle
					WHERE hide = 1 AND ordersid = $ordersid AND cateid = 2 ";
                    $row = $xdb->getRow($query);
                    if ($row) {
                        $o['handled'] = '是';
                    }
                    $o['chargetype'] = '退款';
                } else {
                    $o['chargetype'] = '入款';
                }

                $query = ' SELECT SUM(price) AS total FROM '.DB_ORDERS.".orders_charge WHERE hide = 1 AND ordersid = $ordersid ";
                $row = $xdb->getRow($query);
                $payprice = @round($row['total'], 2);
                $okprice = @round($payprice - $price, 2);
                $o['payprice'] = $okprice;

                $query = ' SELECT * FROM '.DB_ORDERS.".store
				WHERE hide = 1 AND checked = 1 AND ordersid = $ordersid ORDER BY id ASC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $o['erptime'] = date('Y-m-d H:i', $row['dateline']);
                    $o['erpnum'] = $row['erpnum'];
                    $o['echecked'] = ($rs['cchecked']) ? '已确认' : '未确认';
                }
                $arr[] = $o;
            }
            $rows = $arr;
        }

        return $rows;
    }

    public function degree($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND d.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND d.dateline <= '$totime' ";
        }

        $query = ' SELECT d.ordersid,d.jobsid,o.datetime,pa.name AS provname,ca.name AS cityname,aa.name AS areaname,
		d.sales,d.salesinfo,d.after,d.afterinfo,d.detail,au.name AS addname,d.dateline,af.name AS afteruname,d.detail,
		st.name AS salesname,at.name AS aftername,job.datetime AS jobdate,d.callno,d.checked
		FROM '.DB_ORDERS.'.callback_degree AS d
		INNER JOIN '.DB_ORDERS.'.users AS au ON d.userid = au.userid
		INNER JOIN '.DB_ORDERS.'.users AS af ON d.afteruserid = af.userid
		INNER JOIN '.DB_ORDERS.'.config_teams AS at ON d.afterid = at.id
		INNER JOIN '.DB_ORDERS.'.orders AS o ON d.ordersid = o.id
		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
		INNER JOIN '.DB_CONFIG.'.areas AS aa ON o.areaid = aa.areaid
		INNER JOIN '.DB_ORDERS.".job_orders AS job ON d.jobsid = job.id
		WHERE o.openid = ".OPEN_ID." $where
		GROUP BY d.id
		ORDER BY d.id ASC ";
        $rows = $xdb->getRows($query);

        return $rows;
    }

    public function invoice($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND i.dateline >= '$gotime' ";
        }
        if ($todate != '') {
            $totime = strtotime($todate.' 23:59:59');
            $where .= " AND i.dateline <= '$totime' ";
        }
        if ($cateid != '') {
            $cateid = (int) $cateid;
            $where .= " AND i.cateid = $cateid ";
        }

        $query = ' SELECT i.*,o.dateline AS odateline,
        au.name AS addname,cu.name AS checkname,wu.name AS workname,ct.name AS salesname
    		FROM '.DB_ORDERS.'.invoice AS i
    		INNER JOIN '.DB_ORDERS.'.orders AS o ON o.id = i.ordersid
    		INNER JOIN '.DB_ORDERS.'.config_teams AS ct ON o.salesid = ct.id
    		INNER JOIN '.DB_ORDERS.'.users AS au ON i.userid = au.userid
    		LEFT JOIN '.DB_ORDERS.'.users AS cu ON i.checkuserid = cu.userid
    		LEFT JOIN '.DB_ORDERS.".users AS wu ON i.workuserid = wu.userid
    		WHERE o.openid = ".OPEN_ID." AND i.hide = 1 $where
    		GROUP BY i.id
    		ORDER BY $orderd i.dateline ASC ";
        $rows = $xdb->getRows($query);

        return $rows;
    }

    public function customs()
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        $query = ' SELECT datetime FROM '.DB_ORDERS.'.customs_counts
        WHERE o.openid = '.OPEN_ID.' ORDER BY datetime DESC ';
        $row = $xdb->getRow($query);
        $datetime = $row['datetime'];

        $query = ' SELECT * FROM '.DB_ORDERS.".customs_counts WHERE datetime = '$datetime' ";
        $rows = $xdb->getRows($query);

        return $rows;
    }

    public function yunlogs($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $where .= " AND yun.godate >= '$godate' ";
        }
        if ($todate != '') {
            $where .= " AND yun.godate <= '$todate' ";
        }

        $query = ' SELECT o.id,o.type,o.ctype,o.price,o.checked,o.status,o.dateline,
		yun.godate,yun.todate,yun.detail,yun.status AS yunstatus,yun.dateline AS yundate,yu.name AS yunname,
		pa.name AS provname,ca.name AS cityname,aa.name AS areaname
		FROM '.DB_ORDERS.'.yun_charge AS yun
		INNER JOIN '.DB_ORDERS.'.orders AS o ON yun.ordersid = o.id
		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
		INNER JOIN '.DB_CONFIG.'.areas AS aa ON o.areaid = aa.areaid
		INNER JOIN '.DB_ORDERS.".users AS yu ON yun.userid = yu.userid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND yun.hide = 1 $where
		ORDER BY o.id ASC ";
        //echo $query;exit;
        $rows = $xdb->getRows($query);

        return $rows;
    }

    public function mobile($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $where .= " AND o.datetime >= '$godate' ";
        }
        if ($todate != '') {
            $where .= " AND o.datetime <= '$todate' ";
        }
        if ($cateid != '') {
            $where .= " AND p.categoryid IN ($cateid) ";
        }
        if ($barndid != '') {
            $where .= " AND p.brandid IN ($brandid) ";
        }

        $query = ' SELECT o.ordersid,o.name,o.mobile
		FORM '.DB_ORDERS.'.orders AS o
		INNER JOIN '.DB_ORDERS.'.ordersinfo AS oi ON o.id = oi.ordersid
		INNER JOIN '.DB_PRODUCT.".product AS p ON oi.productid = p.productid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND o.status NOT IN(-1,7) $where
		GROUP BY o.mobile
		ORDER BY o.mobile ASC
		";
        $rows = $xdb->getRows($query);

        return $rows;
    }

    public function notes($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($gotime != '') {
            $where .= " AND dateline >= '$gotime' ";
        }
        if ($totime != '') {
            $where .= " AND dateline <= '$totime' ";
        }

        $arr = array();
        $query = ' SELECT userid,worknum,name FROM '.DB_ORDERS.'.users WHERE hide = 1 AND checked = 1 ORDER BY worknum ASC ';
        $rows = $xdb->getRows($query);
        //print_r($rows);exit;
        foreach ($rows as $rs) {
            $userid = (int) $rs['userid'];
            $query = ' SELECT COUNT(id) AS total
			FROM '.DB_ORDERS.".note WHERE checked = 0 AND hide = 1  AND userid = $userid $where ";
            $row = $xdb->getRow($query);
            $rs['yws'] = (int) $row['total'];

            $query = ' SELECT COUNT(id) AS total
			FROM '.DB_YOS.".config_note WHERE checked = 0 AND hide = 1  AND userid = $userid $where ";
            //echo $query;exit;
            $row = $xdb->getRow($query);
            $rs['yos'] = (int) $row['total'];
            $arr[] = $rs;
        }

        return $arr;
    }

    //工单结算
    public function jobs($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $godate = strtotime($godate.' 00:00:00');
            $where .= " AND job.workdateline >= '$godate' ";
        }

        if ($todate != '') {
            $todate = strtotime($todate.' 23:59:59');
            $where .= " AND job.workdateline <= '$todate' ";
        }

        if ($salesarea) {
            $salesarea = (int) $salesarea;
            $where .= " AND st.parentid = $salesarea ";
        }

        if ($salesid) {
            $salesid = (int) $salesid;
            $where .= " AND o.salesid = $salesid ";
        }

        if (!$salesarea && !$salesid) {
            $join = ' INNER JOIN '.DB_PRODUCT.'.product AS p ON oi.productid = p.productid ';
            if ($brandid) {
                $brandid = (int) $brandid;
                $where .= " AND p.brandid = $brandid ";
            }
            if ($encoded) {
                $where .= " AND p.encoded = '$encoded' ";
            }
        }

        $query = ' SELECT o.id,o.status,o.name,o.address,o.mobile,o.datetime,st.name AS salesname,o.wangwang,o.detail,
		job.worked AS worked,job.datetime AS setuptime,job.id AS jobsid,job.workdetail,job.workto,job.type,job.contract
		FROM '.DB_ORDERS.'.job_orders AS job
		INNER JOIN '.DB_ORDERS.'.orders AS o ON job.ordersid = o.id
		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
		INNER JOIN '.DB_ORDERS.".ordersinfo AS oi ON o.id = oi.ordersid
		$join
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 $where
		GROUP BY job.id
		ORDER BY job.datetime ASC ";
        $rows = $xdb->getRows($query);
        //INNER JOIN ".DB_ORDERS.".users AS cu ON fuwu_userid = cu.userid ,cu.name AS fuwucname
        if ($rows) {
            $data = array();

            $degree = getModel('degree');

            foreach ($rows as $rs) {
                $arr = array();

                if ($rs['status'] == '-1' || $rs['status'] == '7') {
                    $checked = '取消';
                } else {
                    $checked = '正常';
                }

                $ordersid = (int) $rs['id'];
                if ($salesarea || $salesid) {
                    $query = ' SELECT title,encoded,nums,serials
          					FROM '.DB_ORDERS.".ordersinfo
          					WHERE ordersid = $ordersid GROUP BY grouped ";
                } else {
                    if ($brandid) {
                        $brandid = (int) $brandid;
                        $pwhere .= " AND p.brandid = $brandid ";
                    }
                    if ($encoded) {
                        $pwhere .= " AND p.encoded = '$encoded' ";
                    }
                    $query = ' SELECT oi.title,oi.encoded,oi.nums,oi.serials
          					FROM '.DB_ORDERS.'.ordersinfo AS oi
          					INNER JOIN '.DB_PRODUCT.".product AS p ON oi.productid = p.productid
          					WHERE oi.ordersid = $ordersid $pwhere GROUP BY oi.productid ";
                }
                $plist = $xdb->getRows($query);
                //print_r($plist);exit;

                $jobsid = (int) $rs['jobsid'];

                $query = ' SELECT fuwu AS charge,fuwuinfo AS chargeinfo
        				FROM '.DB_ORDERS.".job_charge
        				WHERE jobsid = $jobsid ";
                $jobinfo = $xdb->getRow($query);

                switch ($rs['worked']) {
                    case '1'    :    $worked = '工单完成'; break;
                    case '0'    :    $worked = '等待安装'; break;
                    default        :    $worked = '状态未知'; break;
                }

                $arr['ordersid'] = $ordersid;
                $arr['status'] = $checked;
                $arr['jobsid'] = $rs['jobsid'];
                $arr['type'] = $rs['type'];
                $arr['name'] = $rs['name'];
                $arr['contract'] = $rs['contract'];
                $arr['address'] = $rs['address'];
                $arr['mobile'] = $rs['mobile'];
                $arr['datetime'] = $rs['datetime'];
                $arr['detail'] = $rs['detail'];
                $arr['salesname'] = $rs['salesname'];
                $arr['setuptime'] = $rs['setuptime'];
                $arr['fuwutime'] = $rs['fuwutime'];
                $arr['worked'] = $worked;
                $arr['workinfo'] = $rs['workdetail'];
                $arr['charge'] = $jobinfo['charge'];
                $arr['chargeinfo'] = $jobinfo['chargeinfo'];
                $arr['plist'] = $plist;
                $data[] = $arr;
            }
            $rows = $data;
        }
        //print_r($rows);
        //exit;

        return $rows;
    }

    //订购信息
    public function sales($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        if ($godate != '') {
            $where .= " AND o.datetime >= '$godate' ";
        }

        if ($todate != '') {
            $where .= " AND o.datetime <= '$todate' ";
        }

        if ($salesarea) {
            $salesarea = (int) $salesarea;
            $where .= " AND st.parentid = $salesarea ";
        }

        if ($salesid) {
            $salesid = (int) $salesid;
            $where .= " AND o.salesid = $salesid ";
        }

        if ($brandid) {
            $brandid = (int) $brandid;
            $where .= " AND p.brandid = $brandid ";
            $bwhere .= " AND p.brandid = $brandid ";
        }

        $query = ' SELECT oi.id AS oid,oi.encoded,oi.title AS pname,o.id AS ordersid,o.status,o.name,o.address,
 		o.mobile,o.dateline,st.name AS salesname,p.productid,
 		pa.name AS provname,ca.name AS cityname,aa.name AS areaname
		FROM '.DB_ORDERS.'.ordersinfo AS oi
		INNER JOIN '.DB_ORDERS.'.orders AS o ON oi.ordersid = o.id
		INNER JOIN '.DB_ORDERS.'.config_teams AS st ON o.salesid = st.id
		INNER JOIN '.DB_PRODUCT.'.product AS p ON oi.productid = p.productid
		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
		INNER JOIN '.DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
		WHERE o.openid = ".OPEN_ID." AND o.hide = 1 AND p.categoryid IN(1,2,10,3,4,7,11,6,13) $where
		ORDER BY o.datetime ASC ";
        $rows = $xdb->getRows($query);

        if ($rows) {
            $data = array();
            foreach ($rows as $rs) {
                $arr = array();

                $ordersid = (int) $rs['ordersid'];
                $productid = $rs['productid'];
                $oid = $rs['oid'];

                if ($ordersid == $backid) {
                    $i = $i + 1;
                } else {
                    $i = 1;
                }
                $numbers = $ordersid.'-'.$i;
                $rs['numbers'] = $numbers;

                $query = ' SELECT id AS jobsid,datetime AS jobdate,worked
				 FROM '.DB_ORDERS.".job_orders WHERE ordersid = $ordersid AND hide = 1
				 ORDER BY id ASC ";
                $row = $xdb->getRow($query);
                if ($row) {
                    $rs['jobsid'] = (int) $row['jobsid'];
                    $rs['jobdate'] = $row['jobdate'];
                    $rs['worked'] = $row['worked'];
                }

                $query = ' SELECT si.serial,so.barcode
				FROM '.DB_ORDERS.'.storeinfo_code AS so
				INNER JOIN '.DB_ORDERS.".storeinfo AS si ON si.id = so.id
				WHERE si.oid = $oid  ";
                $row = $xdb->getRows($query);
                $rs['store_serial'] = $row[$i - 1]['serial'];
                $rs['store_barcode'] = $row[$i - 1]['barcode'];

                $backid = $ordersid;

                $data[] = $rs;
            }
            $rows = $data;
        }

        return $rows;
    }

    public function userarea($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        $where = '';
        if ($godate) {
            $gotime = strtotime($godate.' 00:00:00');
            $where .= " AND o.dateline >= '$gotime' ";
        }
        if ($todate) {
            $totime = strtotime($todate.' 00:00:00');
            $where .= " AND o.dateline <= '$totime' ";
        }

        $query = ' SELECT o.areaid,pa.name AS provname,ca.name AS cityname,aa.name AS areaname
 		FROM '.DB_ORDERS.'.orders AS o
 		INNER JOIN '.DB_CONFIG.'.areas AS pa ON o.provid = pa.areaid
 		INNER JOIN '.DB_CONFIG.'.areas AS ca ON o.cityid = ca.areaid
 		INNER JOIN '.DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
		WHERE o.openid = ".OPEN_ID." AND o.parentid = 0 AND o.hide = 1 $where
		GROUP BY o.areaid ORDER BY o.areaid ASC ";
        $xdb->keyid = 'o.id';
        $rows = $xdb->getRows($query);
        if ($rows) {
            $arr = array();
            foreach ($rows as $rs) {
                $areaid = (int) $rs['areaid'];
                $query = ' SELECT COUNT(o.id) AS total
 				FROM '.DB_ORDERS.".orders AS o
 				WHERE areaid = $areaid AND o.parentid = 0 AND o.hide = 1 $where ";
                $row = $xdb->getRow($query);
                $rs['orderalls'] = (int) $row['total'];

                $query = ' SELECT COUNT(o.id) AS total
 				FROM '.DB_ORDERS.".orders AS o
 				WHERE areaid = $areaid AND o.parentid = 0 AND o.hide = 1 $where AND o.status NOT IN(-1,7) ";
                $row = $xdb->getRow($query);
                $rs['ordernums'] = (int) $row['total'];

                $arr[] = $rs;
            }
            $rows = $arr;
        }

        return $rows;
    }

    public function products($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        $where = '';
        if ($gotime) {
            $where .= " o.dateline >= '$gotime' AND ";
        }
        if ($totime) {
            $where .= " o.dateline <= '$totime' AND ";
        }

			 	$query = " SELECT o.id AS ordersid,o.dateline,pa.name AS provname,ca.name AS cityname,aa.name AS areaname,
				b.name AS brandname,c.name AS catename,p.encoded,p.erpname AS erpname,p.title AS title,oi.title AS oititle,
        oi.price AS price,p.price_users_a AS marketprice,p.price_users_c AS memberprice,oi.erpprice
				FROM ".DB_ORDERS.".ordersinfo AS oi
				INNER JOIN ".DB_ORDERS.".orders AS o ON o.id = oi.ordersid
				INNER JOIN ".DB_PRODUCT.".product AS p ON oi.productid = p.productid
				INNER JOIN ".DB_PRODUCT.".brand AS b ON p.brandid = b.brandid
				INNER JOIN ".DB_PRODUCT.".category AS c ON p.categoryid = c.categoryid
				INNER JOIN ".DB_CONFIG.".areas AS pa ON o.provid = pa.areaid
				INNER JOIN ".DB_CONFIG.".areas AS ca ON o.cityid = ca.areaid
				INNER JOIN ".DB_CONFIG.".areas AS aa ON o.areaid = aa.areaid
				WHERE o.openid = ".OPEN_ID." AND $where o.hide = 1 AND o.status NOT IN(7,-1)
				ORDER BY o.dateline ASC";
				$rows = $xdb->getRows($query);
      //  echo   $query;
      //  print_r($rows);exit;
				return $rows;
    }

    public function userorders($str = '')
    {
        $xdb = xdb();
        $str = plugin::extstr($str);//处理字符串
        extract($str);

        $query = ' SELECT o.id AS ordersid,o.customsid,o.name,o.ctype,o.address,o.phone,o.mobile
 				FROM '.DB_ORDERS.'.orders AS o
 				WHERE o.openid = '.OPEN_ID.' AND o.hide = 1 AND o.parentid = 0 AND o.type = 1 AND o.ctype IN(2,3,4) AND o.status IN(1,6) ';
        $rows = $xdb->getRows($query);
        $data = array();
        foreach ($rows as $rs) {
            $ordersid = $rs['ordersid'];
            $query = ' SELECT * FROM '.DB_ORDERS.".ordersinfo WHERE hide = 1 AND ordersid = $ordersid GROUP BY grouped  ";
            $row = $xdb->getRows($query);
            if ($row) {
                $arr = array();
                foreach ($row as $r) {
                    $arr[] = $r['title'];
                }
                $rs['plist'] = $arr;
            }
            $query = ' SELECT * FROM '.DB_ORDERS.".yun_charge WHERE ordersid = $ordersid ORDER BY todate DESC ";
            $row = $xdb->getRow($query);
            $rs['yuntype'] = ($row['type'] == '1') ? '包年' : '云净';
            $data[] = $rs;
        }

        return $data;
    }

  	Public function jobsmonitor($str="")
  	{
  		$xdb = xdb();
  		$str = plugin::extstr($str);//处理字符串
  		extract($str);

      if($worked==""){
        $worked = (int)$worked;
        //$where.=" job.worked = $worked AND ";
      }

      if($salesarea){
        $salesarea = (int)$salesarea;
        $where.=" sts.parentid = $salesarea AND ";
      }
      if($salesid){
        $salesid = (int)$salesid;
        $where.=" sts.id = $salesid AND ";
      }
      if($afterarea){
        $afterarea = (int)$afterarea;
        $where.=" ats.parentid = $afterarea AND ";
      }
      if($afterid){
        $afterid = (int)$afterid;
        $where.=" ats.id = $afterid AND ";
      }

      //省份
			$provid = (int)$provid;
			if($provid){  $where.= " o.provid = $provid AND "; }
			//城市
			$cityid = (int)$cityid;
			if($cityid){  $where.= " o.cityid = $cityid AND "; }
			//区域
			$areaid = (int)$areaid;
			if($areaid){  $where.= " o.areaid = $areaid AND "; }

			if($godate!=""){
				//时间范围
				if($godate!=""){
					$godate = trim($godate);
					$where.=" job.datetime >= '$godate' AND ";
				}
				if($todate!=""){
					$todate = trim($todate);
					$where.=" job.datetime <= '$todate' AND ";
				}
			}else{
				if($todate!=""){
					$todate = trim($todate);
					$where.=" job.datetime <= '$todate' AND ";
				}
				$jobdateline = time()-86400*31;
				$where.=" job.dateline => $jobdateline AND ";
			}

  		$query = " SELECT job.id AS jobsid,job.ordersid,job.type,job.dateline,job.datetime,job.afteruserid,job.worked,
   		sts.name AS salesname,ats.name AS aftername,au.name AS afteruname,job.workdateline,job.worked,job.contract
  		FROM ".DB_ORDERS.".job_orders AS job
  		INNER JOIN ".DB_ORDERS.".orders AS o ON job.ordersid = o.id
  		INNER JOIN ".DB_ORDERS.".config_teams AS sts ON o.salesid = sts.id
  		INNER JOIN ".DB_ORDERS.".config_teams AS ats ON job.afterid = ats.id
  		INNER JOIN ".DB_ORDERS.".users AS au ON job.afteruserid = au.userid
  		WHERE o.openid = ".OPEN_ID." AND $where o.status NOT IN(7,-1) AND job.hide = 1
  		ORDER BY job.datetime ASC,job.dateline ASC
  		";
  		$rows = $xdb->getRows($query);
  		//print_r($rows);
  		if($rows){
  			$arr = $data = array();
  			foreach($rows AS $rs)
  			{
  				$ordersid	= (int)$rs["ordersid"];
  				$jobsid		= (int)$rs["jobsid"];

  				//统计订单投诉数
  				$startime = strtotime($rs["datetime"]);
  				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".complaint WHERE ordersid = $ordersid
  				AND type = 4 AND hide = 1 AND dateline > $startime ";
  				$row   = $xdb->getRow($query);
  				$rs["complaint"]=	(int)$row["total"];

  				//统计工单催单数
  				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".job_tourge WHERE jobsid = $jobsid AND hide = 1 ";
  				$row   = $xdb->getRow($query);
  				$rs["tourge"]	=	(int)$row["total"];

  				//满意度回访
  				$query = " SELECT COUNT(id) AS total FROM ".DB_ORDERS.".callback_degree WHERE jobsid = $jobsid AND checked = 1";
  				$row  = $xdb->getRow($query);
  				$rs["degree"]	=	(int)$row["total"];

  				//最后操作时间
  				$query = " SELECT id,dateline FROM ".DB_ORDERS.".orders_logs WHERE ordersid = $ordersid AND hide = 1 ORDER BY dateline DESC ";
  				$row = $xdb->getRow($query);
  				$rs["logstime"] = $row["dateline"];

  				$data[]	= $rs;
  			}
  			$rows = $data;
  		}
  		return $rows;
  	}


  	//取得城市索引
  	public function areas($str="")
  	{
    		$str = plugin::extstr($str);//处理字符串
    		extract($str);
    		$parentid = (int)$parentid;
    		$sql  = "SELECT areaid,name FROM ".DB_CONFIG.".areas WHERE  areaid>0 AND parentid=$parentid ";
    		$data = $this->db->getRows($sql);
    		return $data;
  	}

}
