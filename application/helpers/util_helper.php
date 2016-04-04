<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    /*
 * buat paging plus ajax
 *
 *
 */
$global_companyName = "Arowana Venture Berhad";

if (! function_exists('getSettingXMLProperty')) {

    function getSettingXMLProperty($id = "")
    {
        $module = simplexml_load_file(base_url() . "assets/module/global-setting.xml");
        foreach ($module->children() as $child) {
            $arr = $child->children(); // returns an array
            if ($id = $arr[0]) {
                echo "<script>alert('" . $arr[1] . "');</script>";
                return $arr[1];
            }
        }
    }
}

if (! function_exists('get_uuid')) {

    function get_uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }
}

if (! function_exists('curPageURL')) {

    function curPageURL()
    {
        $pageURL = 'http';
        // if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
}

if (! function_exists('userPermission')) {

    function userPermission($permissionId)
    {
        $CI = & get_instance();
        if ($CI->session->userdata('currentUserId')) {
            $CI->load->model('user_m');
            $CI->user_m->userPermission($CI->session->userdata('currentUserId'), $permissionId);
        }
    }
}

if (! function_exists('userAdmin')) {

    function userAdmin($userId)
    {
        $CI = & get_instance();
        if ($CI->session->userdata('currentUserId')) {
            $CI->load->model('user_m');
            $CI->user_m->userAdmin($CI->session->userdata('currentUserId'), $userId);
        }
    }
}

if (! function_exists('isHavePermission')) {

    function isHavePermission($permissionId)
    {
        $CI = & get_instance();
        if ($CI->session->userdata('currentUserId')) {
            $CI->load->model('user_m');
            return $CI->user_m->isHavePermission($CI->session->userdata('currentUserId'), $permissionId);
        }
    }
}

if (! function_exists('userLogin')) {

    function userLogin()
    {
        $CI = & get_instance();
        if (! $CI->session->userdata('currentUserId')) {
            redirect('avbms/loginForm', 'refresh');
        }
    }
}

if (! function_exists('monthSelectBox')) {

    function monthSelectBox($name, $required, $selected = "")
    {
        $select[0] = "";
        for ($i = 1; $i <= 12; $i ++) {
            if ($selected == $i)
                $select[$i] = " selected='selected' ";
            else
                $select[$i] = "";
        }
        
        $req = "";
        if ($required)
            $req = "required";
        
        $sel = "<select name='$name' class='$req' >";
        $sel .= "<option value=''>-select month-</option>";
        $sel .= "<option value='1' $select[1] >January</option>";
        $sel .= "<option value='2' $select[2] >February</option>";
        $sel .= "<option value='3' $select[3] >March</option>";
        $sel .= "<option value='4' $select[4] >April</option>";
        $sel .= "<option value='5' $select[5] >May</option>";
        $sel .= "<option value='6' $select[6] >June</option>";
        $sel .= "<option value='7' $select[7] >July</option>";
        $sel .= "<option value='8' $select[8] >August</option>";
        $sel .= "<option value='9' $select[9] >September</option>";
        $sel .= "<option value='10' $select[10] >October</option>";
        $sel .= "<option value='11' $select[11] >November</option>";
        $sel .= "<option value='12' $select[12] >Desember</option>";
        $sel .= "</select>";
        return $sel;
    }
}

if (! function_exists('getMonthName')) {

    function getMonthName($month)
    {
        switch ($month) {
            case 1:
                return "January";
                break;
            case 2:
                return "February";
                break;
            case 3:
                return "March";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "May";
                break;
            case 6:
                return "June";
                break;
            case 7:
                return "July";
                break;
            case 8:
                return "August";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "October";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}
// Function to calculate date range
function dateDiff($d2, $d1)
{
    return round(abs(strtotime($d2) - strtotime($d1)) / 86400);
}

?>