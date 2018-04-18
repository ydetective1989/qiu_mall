<?php

class mapsModules extends Modules
{

    public function orders($str = '')
    {
        $str = plugin::extstr($str);//处理字符串
        extract($str);
        if ($provid) {
            $provid = (int) $provid;
            $where .= " AND o.provid = $provid ";
        }
        if ($cityid) {
            $cityid = (int) $cityid;
            $where .= " AND o.cityid = $cityid ";
        }
        if ($areaid) {
            $areaid = (int) $areaid;
            $where .= " AND o.areaid = $areaid ";
        }
        if ($pointed) {
            $where .= " AND o.pointlng!='0' AND o.pointlng!='0' ";
        }
        if ($pointarr) {
            $parr = @explode('||', $pointarr);
            $where .= " AND o.pointlng >= '".$parr[0]."' AND o.pointlng <= '".$parr[1]."' AND o.pointlat >= '".$parr[2]."' AND o.pointlat <= '".$parr[3]."' ";
        }
        $query = "SELECT o.id AS ordersid,o.datetime,o.checked,o.detail,o.pointlng,o.pointlat,o.address,o.name,o.phone,o.mobile
        FROM ".DB_ORDERS.".orders AS o
        WHERE o.hide = 1 AND o.parentid = 0 $where ";
        return $this->db->getRows($query);
    }


}
