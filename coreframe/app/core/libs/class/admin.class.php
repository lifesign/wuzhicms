<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 后台统一验证类
 */
define('IN_ADMIN',TRUE);
load_class('session');
class WUZHI_admin {
    public $lang_menu;
    public $_su;

    function __construct() {
        if(M =='core' && F =='index' && V === 'login') {
            return true;
        } else {
            if(!isset($_SESSION['uid']) || !$_SESSION['uid'] || !isset($_SESSION['role'])) MSG(L('admin_login'),'?m=core&f=index&v=login'.$this->su());
        }
        $this->logs();
    }

    //后台模版模版调用
    public function template($name,$m = '') {
        if(empty($m)) $m = M;
        return COREFRAME_ROOT.'app/'.$m.'/admin/template/'.$name.'.tpl.php';
    }

    final public function su($showmenu = TRUE) {
        static $su;
        if(empty($su) || !$showmenu) {
            $_su = isset($GLOBALS['_su']) ? $GLOBALS['_su'] : '';
            $su = '&_su='.$_su;
            if($showmenu===TRUE) {
                $_menuid = isset($GLOBALS['_menuid']) ? $GLOBALS['_menuid'] : '';
                $_submenuid = isset($GLOBALS['_submenuid']) ? $GLOBALS['_submenuid'] : '';
                $su .= '&_menuid='.$_menuid;
                if($_submenuid) $su .= '&_submenuid='.$_submenuid;
            }
        }
        return $su;
    }

    final public function menu($pid, $apend_str = '',$append_menu = '') {
        $pid = intval($pid);
        if(!$pid) return '';

        $su = $this->su();
        $lang = get_cookie('lang') ? get_cookie('lang') : LANG;
        require COREFRAME_ROOT.'languages/'.$lang.'/admin_menu.lang.php';
        $this->lang_menu = $MENU;
        $db = load_class('db');
        $result = $db->get_list('menu', 'pid='.$pid.' AND display=1', '*', 0, 100, 0, '', '', 'menuid');
        if(count($result) < 1) return '';
        $GLOBALS['_submenuid'] = isset($GLOBALS['_submenuid']) ? $GLOBALS['_submenuid'] : $pid;
        $rs = $db->get_one('menu', 'menuid='.$pid, '*');
        $rs = array(0=>$rs);
        $result = array_merge($rs,$result);
        $str = '<header class="panel-heading">';
        $objid = '';
        $j = 2;
        foreach($result as $r) {
            $button = 'default';
            $id = $r['menuid'];
            if($id == $GLOBALS['_submenuid']) {
                $button = 'info';
            }
            $tmpid = $r['f'].'-'.$r['v'];
            if($objid == $tmpid) {
                $objid = $objid.$j;
                $j++;
            } else {
                $objid = $tmpid;
            }
            $icon = strpos($r['v'],'add')===false ? '<i class="icon-gears2 btn-icon"></i>' : '<i class="icon-plus btn-icon"></i>';
            $str .= '<a href="?m='.$r['m'].'&f='.$r['f'].'&v='.$r['v'].'&'.$r['data'].$su.'&_submenuid='.$id.$apend_str.'" class="btn btn-'.$button.' btn-sm" id="'.$objid.'">'.$icon.$MENU[$id].'</a> ';
        }
        $str .= $append_menu;
        $str .= '</header>';
        return $str;
    }

    final private function logs() {
        $db = load_class('db');
        //权限检查
        if($_SESSION['role']!=1) {
            $keyid = substr(md5($_SESSION['role'].M.F.V),0,16);
            $r = $db->get_one('admin_private',array('keyid'=>$keyid),'chk');
            if(!$r || $r['chk']==0) {
                MSG(L('no_private'));
                exit;
            }
        }
        if(V=='listing' || M =='core' && F =='index' && V === 'keep_alive') return '';

        //后台管理日志配置
        include COREFRAME_ROOT.'configs/wz_config.php';

        if (defined('ADMIN_LOG') && 0 == ADMIN_LOG) {
            return '';
        }

        $formdata = array();
        $formdata['uid'] = $_SESSION['uid'];
        $formdata['m'] = M;
        $formdata['f'] = F;
        $formdata['v'] = V;
        $formdata['addtime'] = SYS_TIME;
        $formdata['ip'] = get_ip();
        $newdata = '';
        foreach($GLOBALS as $key=>$value) {
            if(in_array($key,array('m','f','v','_menuid','_submenuid','_su'))) continue;
            if($key=='page' && $value==0) continue;
            if(is_string($value)) {
                if(strlen($value) > 100) $value = '-MAX100-';
            } elseif(is_array($value)) {
                $value = '-array()-';
            }
            if($key=='password') $value = '***';
            $newdata .= $key.'='.$value."\r\n";
        }
        $formdata['data'] = $newdata;

        $db->insert('logs',$formdata);
    }

    /**
     * 编辑操作日志记录
     */
    public function editor_logs($action,$title,$url = '', $editurl = '') {
        if(empty($title)) return false;
        $formdata = array();
        $formdata['title'] = remove_xss($title);
        $formdata['url'] = $url;
        $formdata['editurl'] = $editurl;
        $formdata['username'] = get_cookie('username');
        $formdata['ip'] = get_ip();
        $formdata['action'] = $action;
        $formdata['addtime'] = SYS_TIME;
        $db = load_class('db');
        $db->insert('editor_log',$formdata);
    }
}