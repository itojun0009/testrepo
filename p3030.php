<?php
/*
company: クイック・ガーデニング
program: 営業管理システム
creator: ポータルシステム株式会社　鄭 智允
create date: 2014/03/25 17:06
modified date: 2020/03/02 14:36
comment: p3030 見積登録
*/




if ($_tpl->value['ios']['prcss_version'] == 1) {
///// prcss_version 1 start /////

define('IOS_ERROR_BASE_LOGIC', 130300000);

require_once(DIR_AUTO . '/' . AUTO_CREATED . '_homedmnd.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_krtcode.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_homecode.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_schecode.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_mins_time2.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_at.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_sikutyouson.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_closed_sikutyouson.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_cn.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_bl.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_cs.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_ss.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_dg.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_ds.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_dk.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_ex.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_kk.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_ks.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_pi.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_pm.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_pp.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_py.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_sf.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_tc.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_tk.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_te.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_vt.php');
//require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_yr.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_fx.php');
require_once(DIR_AUTO . '/' . AUTO_CREATED . '_codede_fi.php');

define('FILENAME_PREFIX', 'i');

$_json_string = array();
if (isset($_POST['json_string'])) {
    $_json_string = json_decode($_POST['json_string'], true);
    if (is_null($_json_string)) {
        $_json_string = array();
    } elseif (! is_array($_json_string)) {
        $_json_string = array();
    }
}
//file_put_contents('/var/www/vhosts/919g.co.jp/json_string.txt', var_export($_json_string, true));
/*
{"terminal_ts_estimate":"2017-04-19 14:36:35"
,"amt_sales":11112
,"cd_ds":1000
,"rate_tax":8
,"home_code":55
,"amtax_discount":0
,"cd_tk":2
,"yn_dis_cons_prohibit":1
,"dt_acc":"20170419"
,"tax_sales":888
,"predetermined_amtax_dmnd":11112
,"amtax_sales":12000
,"yn_dis_cons_ipad_readonly":1
,"server_estimate_date":"2017-04-19 11:17:52"
,"amtax_discount_hc":0
,"list_dmnd":[
    {"krt_code03":null
    ,"krt_name03":""
    ,"krt_cnt03":null
    ,"krt_code04":null
    ,"krt_name04":""
    ,"rs_e":1
    ,"home_code":55
    ,"cd_tk":2
    ,"rs_t":1
    ,"krt_cnt02":null
    ,"krt_cnt04":null
    ,"any_dmnd":11112
    ,"qty":4
    ,"dmnd_code":5510101
    ,"dmnd_cont":"剪定、低木、～3m未満、本"
    ,"label_cd_kk":"剪定、低木"
    ,"cd_kk":101,"rs_d":""
    ,"sq_seq":1
    ,"note":""
    ,"any_price":2778
    ,"unit":"本"
    ,"krt_code01":null
    ,"krt_name01":""
    ,"krt_cnt01":null
    ,"krt_code02":null
    ,"krt_name02":""
    }
]
,"amtax_discount_rest":0
,"consesti_note130":""
,"dis_cons_value":0
,"yn_fax_estimate":1
,"consesti":
{"fi130":
    {"yn_change_consesti":true
    ,"width":null
    ,"nm_upfile":"20170419143635.115.219759.pdf"
    ,"cd_fi":130
    ,"no_prcss":null
    ,"lat":null
    ,"yn_ios":true
    ,"file_name":null
    ,"consesti_number":"20170419143635.115.219759"
    ,"height":null
    ,"no_upfile":null
    ,"lng":null
    ,"ts_latlng":null
    ,"note_fx":null
    ,"cd_fx":null
    ,"sq_send":0}
}
,"no_cons":263703
,"estimate_no_prcss":null
}
*/

$_tpl->value['cd_tk'] = isset($_json_string['cd_tk']) && $_json_string['cd_tk'] == 2 ? 2 : 1; // 1;"税込" 2;"税抜"
if ($_tpl->value['cd_tk'] == 2) {
    $_tpl->value['label_cd_tk'] = getCode($_auto['codede']['tk'], 2);
} else {
    $_tpl->value['label_cd_tk'] = getCode($_auto['codede']['tk'], 1);
}

$_req->addItems(array
    ( array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'no_cons', 'label' => '案件番号', 'vacant' => false, 'min' => 1)
    , array('type' => 'STRING_DATE', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'dt_acc', 'label' => '経理基準日', 'vacant' => false)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'cd_tk', 'label' => '税込・税抜', 'vacant' => false, 'lists' => array_keys($_auto['codede']['tk']))
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'rate_tax', 'label' => '消費税率', 'vacant' => false, 'lists' => array(5, 8, 10))
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'predetermined_amtax_dmnd', 'vacant' => false, 'label' => '請求項目合計(税込)', 'min' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amt_sales', 'label' => '売上総額(税抜)', 'vacant' => false, 'min' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'tax_sales', 'label' => '売上総額(消費税)', 'vacant' => false, 'min' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_sales', 'label' => '売上総額(税込)', 'vacant' => false, 'min' => 0)
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_dis_cons_prohibit', 'label' => '割引禁止')
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_dis_cons_ipad_readonly', 'label' => 'IPAD割引修正禁止有無')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'cd_ds', 'label' => '割引設定', 'vacant' => false, 'lists' => array_keys($_auto['codede']['ds']))
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'dis_cons_value', 'label' => '割引設定値', 'vacant' => false)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_discount', 'label' => '割引(本部)(税込)', 'vacant' => false, 'max' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_discount_hc', 'label' => 'ベネフィット割引(税込)', 'vacant' => false, 'max' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_discount_rest', 'label' => 'コメリ端数割引(税込)', 'vacant' => false, 'max' => 0)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'home_code', 'label' => 'HC区分', 'vacant' => false, 'lists' => array_keys($_auto['homecode']))
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'server_estimate_date', 'label' => '見積修正日時(サーバー側)')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'estimate_no_prcss', 'label' => '見積番号')
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'terminal_ts_estimate', 'label' => '見積修正日時(IPAD側)', 'vacant' => false)
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_fax_estimate', 'label' => '見積ファクス必要有無')
    //, array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_reqest_estimate_fax', 'label' => '見積ファクス要請有無')
    //, array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_estimate_terminal_to_server', 'label' => 'yn_estimate_terminal_to_server')
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'consesti_note130', 'label' => '備考(見積)', 'max_len' => 200)
    ));
//$_req->copyRequests();

$_req_dmnd = new ClassRequestRows(array('default_source_type' => $_req_options['default_source_type'], 'charset_html' => $_req_options['charset_html'], 'word' => 'dmnd', 'word_label' => '請求項目'));
$_req_dmnd->addItems(array
    ( array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_TYPE, 'label' => 'ROW_STATUS_TYPE', 'vacant' => false, 'lists' => array(ROW_STATUS_TYPE_DB, ROW_STATUS_TYPE_JS))
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_EDIT, 'label' => 'ROW_STATUS_EDIT')
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_DELETE, 'label' => 'ROW_STATUS_DELETE')

    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'sq_seq', 'label' => '順番', 'vacant' => false, 'min' => 1)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'dmnd_code', 'label' => '請求項目コード', 'vacant' => false, 'lists' => array_keys($_auto['homedmnd']))
    //, array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_direct', 'label' => '直接入力')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'any_price', 'label' => '単価(' . $_tpl->value['label_cd_tk'] . ')', 'vacant' => false)
    , array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'qty', 'label' => '数量', 'vacant' => false, 'min' => 0)
    , array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'any_dmnd', 'label' => '金額(' . $_tpl->value['label_cd_tk'] . ')', 'vacant' => false)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'cd_tk', 'label' => '税込・税抜', 'vacant' => false, 'lists' => array_keys($_auto['codede']['tk']))
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_spec', 'label' => '特別費用(税込)', 'vacant' => false)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_hc', 'label' => 'HC手数料(税込)', 'vacant' => false)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_hc_real', 'label' => '実のHC手数料(税込)', 'vacant' => false)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'amtax_cd', 'label' => 'CD手数料(税込)', 'vacant' => false)
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'note', 'label' => '備考', 'max_len' => 200)

    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_code01', 'label' => 'カルテコード01', 'lists' => array_keys($_auto['krtcode']))
    , array('type' => 'NONE', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_name01', 'label' => 'カルテ名01')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_cnt01', 'label' => 'カルテ数量01', 'min' => 1)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_code02', 'label' => 'カルテコード02', 'lists' => array_keys($_auto['krtcode']))
    , array('type' => 'NONE', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_name02', 'label' => 'カルテ名02')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_cnt02', 'label' => 'カルテ数量02', 'min' => 1)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_code03', 'label' => 'カルテコード03', 'lists' => array_keys($_auto['krtcode']))
    , array('type' => 'NONE', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_name03', 'label' => 'カルテ名03')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_cnt03', 'label' => 'カルテ数量03', 'min' => 1)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_code04', 'label' => 'カルテコード04', 'lists' => array_keys($_auto['krtcode']))
    , array('type' => 'NONE', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_name04', 'label' => 'カルテ名04')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'krt_cnt04', 'label' => 'カルテ数量04', 'min' => 1)

    //, array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'home_code', 'label' => 'HC区分', 'vacant' => false, 'lists' => array_keys($_auto['homecode']))
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'dmnd_cont', 'label' => '請求項目名', 'vacant' => false)

    //, array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'any_price_def', 'label' => '単価(デフォールト)')
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'rate_spec', 'label' => '特別費用転換率', 'vacant' => false, 'min' => 0., 'max' => 100.)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'rate_hc', 'label' => 'HC手数料率', 'vacant' => false, 'min' => 0., 'max' => 100.)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'rate_hc_real', 'label' => '実のHC手数料率', 'vacant' => false, 'min' => 0., 'max' => 100.)
    //, array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'rate_cd', 'label' => 'CD手数料率', 'vacant' => false, 'min' => 0., 'max' => 100.)
    ));
//$_req_dmnd->copyRequests();

$_req_consesti = new ClassRequestRows(array('default_source_type' => $_req_options['default_source_type'], 'charset_html' => $_req_options['charset_html'], 'word' => 'consesti', 'word_label' => '見積ファイル'));
$_req_consesti->addItems(array
    ( array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_TYPE, 'label' => 'ROW_STATUS_TYPE', 'vacant' => false, 'lists' => array(ROW_STATUS_TYPE_DB, ROW_STATUS_TYPE_JS))
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_EDIT, 'label' => 'ROW_STATUS_EDIT')
    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => ROW_STATUS_DELETE, 'label' => 'ROW_STATUS_DELETE')

    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'no_prcss', 'label' => '見積番号')
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'cd_fi', 'label' => 'ファイル区分', 'vacant' => false, 'lists' => array_keys($_auto['codede']['fi']))
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'no_upfile', 'label' => 'ファイル番号', 'min_len' => 20, 'max_len' => 20)
    , array('type' => 'INTEGER', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'sq_send', 'label' => '順番', 'min' => 1)
// consesti_note -> cons.consesti_note130
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'consesti_number', 'label' => 'consesti_number', 'max_len' => 50)

    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'nm_upfile', 'label' => 'ファイル名', 'max_len' => 50)
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'file_name', 'label' => 'ファイル名', 'max_len' => 50)
// yn_ios -> 1
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'lat', 'label' => '緯度')
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'lng', 'label' => '経度')
    , array('type' => 'STRING', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'ts_latlng', 'label' => '時間')
    , array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'width', 'label' => '幅', 'min' => 1)
    , array('type' => 'FLOAT', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'height', 'label' => '高さ', 'min' => 1)

// note_fx
// cd_fx

    , array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_change_consesti', 'label' => 'yn_change_consesti')
    //, array('type' => 'BOOL', 'error_no' => IOS_ERROR_BASE_LOGIC + __LINE__, 'name' => 'yn_from_server_to_terminal', 'label' => 'yn_from_server_to_terminal')

    ));

if ($_json_string) {
    //JEONG DEBUG 分析のため
    //file_put_contents(PORTAL_IOS_LOG . '/' . $prcss_file_prefix . '.p3030.txt', print_r($_POST['json_string'], true));

    //ob_start();var_export($_json_string);file_put_contents('/var/www/html/temp01.txt', ob_get_contents());ob_end_clean();
    foreach ($_req->items as $r) {
        $key = $r['name'];
        $_req->setRequestValue($key, isset($_json_string[$key]) && ! is_null($_json_string[$key]) ? $_json_string[$key] : '');
    }
    if (isset($_json_string['list_dmnd']) && is_array($_json_string['list_dmnd'])) {
        $i = 0;
        foreach ($_json_string['list_dmnd'] as $row) {
            $i ++;
            foreach ($_req_dmnd->items as $r) {
                $key = $r['name'];
                $_req_dmnd->setRequestValue($i, $key, isset($row[$key]) && ! is_null($row[$key]) ? $row[$key] : '');
            }
        }
    }

    if (isset($_json_string['consesti']) && is_array($_json_string['consesti'])) {
        $i = 0;
        foreach ($_json_string['consesti'] as $row) {
            $i ++;
            foreach ($_req_consesti->items as $r) {
                $key = $r['name'];
                $_req_consesti->setRequestValue($row['cd_fi'], $key, isset($row[$key]) && ! is_null($row[$key]) ? $row[$key] : '');
            }
        }
    }
    //ob_start();var_export(array($_req->requests, $_req_dmnd->requests, $_req_consesti->requests, 'FILES' => $_FILES));file_put_contents('/var/www/html/temp03.txt', ob_get_contents());ob_end_clean();
}

$_req->checkRequests();
$_req_dmnd->checkRequests();

if ($_err->isOk()) {
    $temp = '';
    if (! empty($_req_dmnd->requests)) {
        $sum_any_dmnd = 0;
        foreach ($_req_dmnd->requests as $rownum => $row) {
            if (strval($row['any_price'] * $row['qty']) == $row['any_dmnd']) { // PHP の FLOATIN POINT NUMBER 問題の解決
                $sum_any_dmnd += $row['any_dmnd'];
            } else {
                $temp .= "\n" . $rownum . '番目の請求項目の掛け算';
            }
        }
    }
    if ($temp === '') {
        if ($_tpl->value['cd_tk'] == 2) { // 税抜
            if (TAX_RATE == -1 || abs($_req->getRequestValue('predetermined_amtax_dmnd') / (1 + TAX_RATE) - $sum_any_dmnd) > 1) { // round, floor まだ分からない
                $temp .= "\n" . '請求項目の合算と定価の差が1円以上(税抜)';
            }
        } else { // 1 税込
            if (abs($_req->getRequestValue('predetermined_amtax_dmnd') - $sum_any_dmnd) > 1) { // round, floor まだ分からない
                $temp .= "\n" . '請求項目の合算と定価の差が1円以上(税込)';
            }
        }
    }
    if ($temp > '') {
        //@mail('jeong@por.co.jp', 'p3030', $temp . chr(10) . print_r(array('no_cons' => $_req->getRequestValue('no_cons'), 'cd_tk' => $_req->getRequestValue('cd_tk'), 'predetermined_amtax_dmnd' => $_req->getRequestValue('predetermined_amtax_dmnd'), 'sum_any_dmnd' => $sum_any_dmnd, 'requests' => $_req_dmnd->requests), true));
    }

    $temp = '';
    if ($_req->getRequestValue('yn_dis_cons_prohibit')) {
        if (! $_req->getRequestValue('yn_dis_cons_ipad_readonly')) {
            $temp .= ($temp === '' ? '' : "\n") . 'IPAD割引修正禁止有無をチェックしてください。';
        }
        if ($_req->getRequestValue('cd_ds') != 1000) { // 無し
            $temp .= ($temp === '' ? '' : "\n") . '割引設定を【無し】にしてください。';
        }
        if ($_req->getRequestValue('dis_cons_value') != '0') {
            $temp .= ($temp === '' ? '' : "\n") . '割引設定値は０を入力してください。';
        }
    } else {
        if ($_req->getRequestValue('cd_ds') == 2005) { // ５％
            $_req->setRequestValue('dis_cons_value', 5);

        } elseif ($_req->getRequestValue('cd_ds') == 2900) { // ％で
            if (intval($_req->getRequestValue('dis_cons_value')) < 0 || intval($_req->getRequestValue('dis_cons_value')) > 30) {
                $temp .= ($temp === '' ? '' : "\n") . '割引設定値は０～３０を入力してください。';
            }
        } elseif ($_req->getRequestValue('cd_ds') == 3000) { // 金額
            if (intval($_req->getRequestValue('dis_cons_value')) > 0) {
                $_req->setRequestValue('dis_cons_value', -1 * intval($_req->getRequestValue('dis_cons_value')));
            }
        } else { // 1000 無し
            $_req->setRequestValue('dis_cons_value', 0);
        }
    }
    //if ($temp > '') {
    //    $_err->addError(__LINE__, $temp);
    //}
    if (! empty($_req_dmnd->requests)) {
        foreach ($_req_dmnd->requests as $rownum => $row) {
            if ($row['dmnd_code'] == 1012201 && $row['any_price'] != 0) { // 麻袋コンポスト設置（材料代、作業代すべて含む）
                $temp .= "\n" . $rownum . '番目の麻袋の金額は0円です。';
            }
        }
    }

    if ($_req->getRequestValue('amtax_discount') == '') {
        $_req->setRequestValue('amtax_discount', 0);
    }

    if ($_req->getRequestValue('home_code') == 19) {
        if ($_req->getRequestValue('amtax_sales') % 10 != 0) {
            $temp .= "\n" . 'コメリ案件は、1円単位の端数を割引（端数）に入力';
        }
    }
    if ($temp > '') {
        $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '下記の内容を確認してください。' . $temp);
    }
}

if ($_err->isOk()) {
    $_output['ret'] = array
        ( 'tuple' => array()
        , 'cnt_rows' => 0
        , 'row' => array()
        , 'consimg' => array()
        );

    if ($_err->isOk()) {
        $_dbk = new ClassDbBackup($_dbk_options);
        $_dbk->addBackupTables(array('cons', 'dmnd', 'dmndkrt'));

        $tuple = $_db->selectRow
            ( 'with temp_cdpay_cons as ('
            . 'select q.no_cdpay'
            . '     , case when q.no_cons is null then 1'
            . '            when q.no_cdpay is null then 2'
            . '            when q.no_cdpay is not null and q.yn_fix = 0 then 3'
            . '            else 4 end::smallint as status_cdpay_cons'
            . '  from (select ' . $_db->paramInteger($_req->getRequestValue('no_cons')) . ' as no_cons) p left outer join cdpay_cons q on q.no_cons = p.no_cons'
            . ') '
            . 'select a.no_cons, a.dt_acc, a.cd_tk, a.rate_tax'
            . '     , yn_dis_cons_prohibit, yn_dis_cons_ipad_readonly, cd_ds, dis_cons_value'
            . '     , a.home_code, a.server_estimate_date, a.estimate_no_prcss'
            . '     , a.terminal_ts_estimate, a.yn_protect, a.update_no_emp, a.update_date'
            . '     , (select z.cd_tz from homecode z where z.home_code = a.home_code) as cd_tz'
            . '     , ' . $_db->paramString($_tpl->value['ios']['ts_current']) . '::timestamp without time zone as today_date'
            . '     , ' . $_db->paramString(substr($_tpl->value['ios']['ts_current'], 0, 4) . substr($_tpl->value['ios']['ts_current'], 5, 2) . substr($_tpl->value['ios']['ts_current'], 8, 2)) . ' as dt_today'
            . '     , case when a.no_cd = ' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD]) . ' then 0 else 1 end as yn_different_cd'

            . '     , case when exists('
            . 'select *'
            . '  from nissen_response'
            . ' where no_response in (select no_response from nissen where no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons')) . ' and yn_ok = 1)'
            . "   and api_name = 'autotransaction'"
            . "   and response_result = 'OK'"
            . "   and author_result = 'OK'"
            . '     ) then 1 else 0 end as yn_exst_nissen_author_ok'

            . '     , q.no_cdpay, q.status_cdpay_cons'
            . '  from cons a, temp_cdpay_cons q'
            . ' where a.no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons'))
            );
        if (empty($tuple)) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '存在しない案件です。');
        } elseif ($tuple['status_cdpay_cons'] > 1) { //
            $_tpl->value['list_status_cdpay_cons'] = array(1 => '作業中', 2 => '承認', 3 => '仮締切', 4 => '本締切');
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, getCode($_tpl->value['list_status_cdpay_cons'], $tuple['status_cdpay_cons']) . 'の案件は修正できません。');
        } elseif (! empty($tuple['terminal_ts_estimate']) &&
                  $tuple['terminal_ts_estimate'] == $_req->getRequestValue('terminal_ts_estimate')) {
            // no operation 変更なし
        } elseif ($tuple['server_estimate_date'] > '' && $tuple['server_estimate_date'] != $_req->getRequestValue('server_estimate_date')) {
//            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, $tuple['update_no_emp'] . '番社員が' . $tuple['update_date'] . 'に修正しました。');
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, $tuple['server_estimate_date'] . 'に修正しました。');
            setErrorLevel(1);
        } elseif ($tuple['yn_different_cd']) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '担当CDではありません。');
        } elseif ($tuple['yn_exst_nissen_author_ok']) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '決済済みなので修正できません。(コンビニ後払い)');
        } elseif ($tuple['yn_protect']) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '保護されているデータは修正できません。');
        } elseif ($tuple['cd_tk'] != $_req->getRequestValue('cd_tk')) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '税込・税抜を確認してください。');
        } elseif ($tuple['dt_acc'] != $_req->getRequestValue('dt_acc')) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '会計基準日が異なります。');
        } elseif ($tuple['rate_tax'] != $_req->getRequestValue('rate_tax')) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '消費税率が異なります。');
        } elseif ($tuple['home_code'] != $_req->getRequestValue('home_code')) {
            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ホームセンターが異なります。');
        } elseif (($tuple['yn_dis_cons_prohibit'] ? true : false) !== ($_req->getRequestValue('yn_dis_cons_prohibit') ? true : false)) {
            $_err->addError(__LINE__, '修正できません。(割引禁止)');
        } elseif ($tuple['yn_dis_cons_ipad_readonly'] && ($tuple['cd_ds'] != $_req->getRequestValue('cd_ds') || $tuple['dis_cons_value'] != $_req->getRequestValue('dis_cons_value'))) {
            $_err->addError(__LINE__, '修正できません。(割引)');
        } else { // empty($tuple['server_estimate_date']) || $tuple['server_estimate_date'] == $_req->getRequestValue('server_estimate_date')
            $list_consesti = array();
            if ($tuple['estimate_no_prcss'] > '') {
                $sql = 'select a.cd_fi, a.no_upfile, a.sq_send, a.consesti_note, a.consesti_number'
                     . '     , b.nm_upfile, b.file_name, b.img_width, b.img_height, b.yn_ios'
                     . '     , b.lat, b.lng, b.ts_latlng'
                     . '     , z.cd_fx, z.note_fx'
                     . '  from consesti a left outer join consestifax z on z.no_cons = a.no_cons and z.no_prcss = a.no_prcss and z.sq_send = a.sq_send'
                     . '      , upfile b'
                     . ' where a.no_upfile = b.no_upfile'
                     . '   and a.no_cons = ' . $_db->paramInteger($tuple['no_cons'])
                     . '   and a.no_prcss = ' . $_db->paramInteger($tuple['estimate_no_prcss'])
                     . ' order by a.cd_fi';
                $_db->select($sql);
                while ($row = $_db->fetchAssoc()) {
                    $list_consesti[$row['cd_fi']] = $row;
                }
            }

            $_db->begin();

            $list_new_no_upfile = array();
            //$sql_upfile = '';
            foreach (array('s' => '110', 'n' => '120') as $word_char => $cd_fi) {
                if ($_req_consesti->getRequestValue($cd_fi, 'yn_change_consesti')) {
////////////////////////////////////////
                    if ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_OK) {
                        if (is_uploaded_file($_FILES['nm_upfile' . $cd_fi]['tmp_name'])) {
                            if (checkSymbol($_FILES['nm_upfile' . $cd_fi]['name'], '\\/:*?"<>|;\'&%#!')) {
                                if (checkFileExtension($_FILES['nm_upfile' . $cd_fi]['name'], array('gif','jpg','png'))) {
                                    // 2019-10-17 ローカル保存後ネットワークエラーが発生したら no_prcss が null になり yn_change_consesti が true になってしまい
                                    // 同じファイル名の nm_upfile が重複する。ipad 内の唯一なファイル名ではなくなる。
                                    if (isset($list_consesti[$cd_fi]) && $list_consesti[$cd_fi]['nm_upfile'] == $_FILES['nm_upfile' . $cd_fi]['name']) {
                                        continue;
                                    }

                                    $tuple_image = array('today_date' => $tuple['today_date']);
                                    $tuple_image['str_today'] = getNumberFromString($tuple_image['today_date']);
                                    $tuple_image['dir'] = substr($tuple_image['str_today'], 0, 6);
                                    if (is_dir(DIR_UPLOAD . '/' . $tuple_image['dir']) || mkdir(DIR_UPLOAD . '/' . $tuple_image['dir'])) {
                                        $tuple_image['no_upfile']
                                            = FILENAME_PREFIX . $tuple_image['str_today']
                                            . $word_char
                                            . str_pad(($_tpl->value['ios']['no_prcss'] % 10000), 4, '0', STR_PAD_LEFT);
                                        $tuple_image['filename'] = $tuple_image['no_upfile'] . '.' . strtolower(getFileExtension($_FILES['nm_upfile' . $cd_fi]['name']));
                                        if (move_uploaded_file($_FILES['nm_upfile' . $cd_fi]['tmp_name'], DIR_UPLOAD . '/' . $tuple_image['dir'] . '/' . $tuple_image['filename'])) {
                                            if (strpos($_FILES['nm_upfile' . $cd_fi]['type'], 'image/') === 0) {
                                                $temp = getimagesize(DIR_UPLOAD . '/' . $tuple_image['dir'] . '/' . $tuple_image['filename']);
                                                if ($temp === false) {
                                                    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '正しい映像ファイルではありません。');
                                                } else {
                                                    $tuple_image['img_width'] = intval($temp[0]);
                                                    $tuple_image['img_height'] = intval($temp[1]);

                                                    $original_date = '';
                                                    if (function_exists('exif_imagetype') && function_exists('exif_read_data') &&
                                                        is_readable(DIR_UPLOAD . '/' . $tuple_image['dir'] . '/' . $tuple_image['filename']) &&
                                                        exif_imagetype(DIR_UPLOAD . '/' . $tuple_image['dir'] . '/' . $tuple_image['filename']) == IMAGETYPE_JPEG) {
                                                        $temp = @exif_read_data(DIR_UPLOAD . '/' . $tuple_image['dir'] . '/' . $tuple_image['filename']);
                                                        if (isset($temp['DateTimeOriginal']) && preg_match('/^([2][0-9]{3})[^0-9]([0][1-9]|[1][0-2])[^0-9]([0][1-9]|[12][0-9]|[3][01])[^0-9]([01][0-9]|[2][0-3])[^0-9]([0-5][0-9])[^0-9]([0-5][0-9])$/', $temp['DateTimeOriginal'], $matches)) {
                                                            $original_date = $matches[1] . '-' . $matches[2] . '-' . $matches[3] . ' ' . $matches[4] . ':' . $matches[5] . ':' . $matches[6];
                                                        }
                                                    }

                                                    if ($tuple_image['img_width'] > 1600 && $tuple_image['img_height'] > 1600) {
                                                        $max_factor_downsize = 16;
                                                    } elseif ($tuple_image['img_width'] > 800 && $tuple_image['img_height'] > 800) {
                                                        $max_factor_downsize = 8;
                                                    } elseif ($tuple_image['img_width'] > 400 && $tuple_image['img_height'] > 400) {
                                                        $max_factor_downsize = 4;
                                                    } elseif ($tuple_image['img_width'] > 200 && $tuple_image['img_height'] > 200) {
                                                        $max_factor_downsize = 2;
                                                    } else {
                                                        $max_factor_downsize = 1;
                                                    }

                                                    $list_new_no_upfile[$cd_fi] = $tuple_image['no_upfile'];

                                                    $sql = 'insert into upfile (no_upfile, nm_upfile, file_size, file_name, file_type'
                                                         . ', img_width, img_height, factor_downsize, factor_rotate, org_file_size'
                                                         . ', org_file_name, org_file_type, org_img_width, org_img_height, max_factor_downsize'
                                                         . ', cd_fd, original_date, yn_ios, no_prcss, no_cons'
                                                         . ', cd_im, no_key, current_device_name, lat, lng'
                                                         . ', ts_latlng, no_machine'
                                                         . ', insert_no_emp, insert_date, update_no_emp, update_date) '

                                                         . '     values (' . $_db->paramString($tuple_image['no_upfile'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['name'])
                                                         . ',' . intval($_FILES['nm_upfile' . $cd_fi]['size'])
                                                         . ',' . $_db->paramString($tuple_image['dir'] . '/' . $tuple_image['filename'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['type'])

                                                         . ',' . $_db->paramInteger($tuple_image['img_width'])
                                                         . ',' . $_db->paramInteger($tuple_image['img_height'])
                                                         . ',1' // factor_downsize
                                                         . ',0' // factor_rotate
                                                         . ',' . intval($_FILES['nm_upfile' . $cd_fi]['size'])

                                                         . ',' . $_db->paramString($tuple_image['dir'] . '/' . $tuple_image['filename'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['type'])
                                                         . ',' . $_db->paramInteger($tuple_image['img_width'])
                                                         . ',' . $_db->paramInteger($tuple_image['img_height'])
                                                         . ',' . $_db->paramInteger($max_factor_downsize)

                                                         . ',2' // image
                                                         . ',' . $_db->paramString($original_date)
                                                         . ',1' // yn_ios
                                                         . ',' . $_db->paramInteger($_tpl->value['ios']['no_prcss'])
                                                         . ',' . $_db->paramInteger($_req->getRequestValue('no_cons'))

                                                         . ',null' // cd_im
                                                         . ',null' // no_key
                                                         . ',' . $_db->paramString($_tpl->value['ios']['current_device_name'])
                                                         . ',' . $_db->paramFloat($_req->getRequestValue('lat'))
                                                         . ',' . $_db->paramFloat($_req->getRequestValue('lng'))

                                                         . ',' . $_db->paramString($_req->getRequestValue('ts_latlng'))
                                                         . ',0' // no_machine

                                                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                                                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                                                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                                                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                                                         . ')';
                                                    $_db->execute($sql);

                                                    //$sql_upfile .= '     , ' . $cd_fi . '_no_upfile = ' . $_db->paramString($tuple_image['no_upfile']);
                                                }
                                            } else {
                                                $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '映像ファイルではありません。');
                                            }
                                        } else {
                                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイル移動失敗です。');
                                        }
                                    } else {
                                        $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ディレクトリーが作られません。');
                                    }
                                } else {
                                    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'アップロードできない拡張子です。');
                                }
                            } else {
                                $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイル名に記号が含まれています。');
                            }
                        } else {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '正しいファイルではありません。');
                        }
                    } else {
                        if ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_INI_SIZE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルサイズエラーです。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_FORM_SIZE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルサイズエラーです。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_PARTIAL) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'アップロード中断されました。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_NO_FILE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルを選択してください。');
                        } else {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルアップロード失敗です。');
                        }
                    }

////////////////////////////////////////

                }
            }

            foreach (array('m' => '130', 'o' => '131', 'c' => '132') as $word_char => $cd_fi) {
                if ($_req_consesti->getRequestValue($cd_fi, 'yn_change_consesti')) {
////////////////////////////////////////
                    if ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_OK) {
                        if (is_uploaded_file($_FILES['nm_upfile' . $cd_fi]['tmp_name'])) {
                            if (checkSymbol($_FILES['nm_upfile' . $cd_fi]['name'], '\\/:*?"<>|;\'&%#!')) {
                                if (checkFileExtension($_FILES['nm_upfile' . $cd_fi]['name'], $cd_fi == '132' ? array('jpg') : array('jpg', 'pdf'))) {
                                    // 2019-10-17 ローカル保存後ネットワークエラーが発生したら no_prcss が null になり yn_change_consesti が true になってしまい
                                    // 同じファイル名の nm_upfile が重複する。ipad 内の唯一なファイル名ではなくなる。
                                    if (isset($list_consesti[$cd_fi]) && $list_consesti[$cd_fi]['nm_upfile'] == $_FILES['nm_upfile' . $cd_fi]['name']) {
                                        continue;
                                    }

                                    $tuple_pdf = array('today_date' => $tuple['today_date']);
                                    $tuple_pdf['str_today'] = getNumberFromString($tuple_pdf['today_date']);
                                    $tuple_pdf['dir'] = substr($tuple_pdf['str_today'], 0, 6);
                                    if (is_dir(DIR_UPLOAD . '/' . $tuple_pdf['dir']) || mkdir(DIR_UPLOAD . '/' . $tuple_pdf['dir'])) {
                                        $tuple_pdf['no_upfile']
                                            = FILENAME_PREFIX . $tuple_pdf['str_today']
                                            . $word_char
                                            . str_pad(($_tpl->value['ios']['no_prcss'] % 10000), 4, '0', STR_PAD_LEFT);
                                        $tuple_pdf['filename'] = $tuple_pdf['no_upfile'] . '.' . strtolower(getFileExtension($_FILES['nm_upfile' . $cd_fi]['name']));
                                        if (move_uploaded_file($_FILES['nm_upfile' . $cd_fi]['tmp_name'], DIR_UPLOAD . '/' . $tuple_pdf['dir'] . '/' . $tuple_pdf['filename'])) {
                                            if (in_array($_FILES['nm_upfile' . $cd_fi]['type'], $cd_fi == '132' ? array('image/jpeg') : array('image/jpeg', 'application/pdf'))) {
                                                //$temp = getimagesize(DIR_UPLOAD . '/' . $tuple_pdf['dir'] . '/' . $tuple_pdf['filename']);
                                                //if ($temp === false) {
                                                //    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '正しいPDFファイルではありません。');
                                                //} else {
                                                //    $tuple_pdf['img_width'] = intval($temp[0]);
                                                //    $tuple_pdf['img_height'] = intval($temp[1]);

                                                //    $original_date = '';
                                                //    if (function_exists('exif_pdftype') && function_exists('exif_read_data') &&
                                                //        is_readable(DIR_UPLOAD . '/' . $tuple_pdf['dir'] . '/' . $tuple_pdf['filename']) &&
                                                //        exif_pdftype(DIR_UPLOAD . '/' . $tuple_pdf['dir'] . '/' . $tuple_pdf['filename']) == IMAGETYPE_JPEG) {
                                                //        $temp = @exif_read_data(DIR_UPLOAD . '/' . $tuple_pdf['dir'] . '/' . $tuple_pdf['filename']);
                                                //        if (isset($temp['DateTimeOriginal']) && preg_match('/^([2][0-9]{3})[^0-9]([0][1-9]|[1][0-2])[^0-9]([0][1-9]|[12][0-9]|[3][01])[^0-9]([01][0-9]|[2][0-3])[^0-9]([0-5][0-9])[^0-9]([0-5][0-9])$/', $temp['DateTimeOriginal'], $matches)) {
                                                //            $original_date = $matches[1] . '-' . $matches[2] . '-' . $matches[3] . ' ' . $matches[4] . ':' . $matches[5] . ':' . $matches[6];
                                                //        }
                                                //    }

                                                //    if ($tuple_pdf['img_width'] > 1600 && $tuple_pdf['img_height'] > 1600) {
                                                //        $max_factor_downsize = 16;
                                                //    } elseif ($tuple_pdf['img_width'] > 800 && $tuple_pdf['img_height'] > 800) {
                                                //        $max_factor_downsize = 8;
                                                //    } elseif ($tuple_pdf['img_width'] > 400 && $tuple_pdf['img_height'] > 400) {
                                                //        $max_factor_downsize = 4;
                                                //    } elseif ($tuple_pdf['img_width'] > 200 && $tuple_pdf['img_height'] > 200) {
                                                //        $max_factor_downsize = 2;
                                                //    } else {
                                                //        $max_factor_downsize = 1;
                                                //    }

                                                    $list_new_no_upfile[$cd_fi] = $tuple_pdf['no_upfile'];

                                                    $sql = 'insert into upfile (no_upfile, nm_upfile, file_size, file_name, file_type'
                                                         . ', img_width, img_height, factor_downsize, factor_rotate, org_file_size'
                                                         . ', org_file_name, org_file_type, org_img_width, org_img_height, max_factor_downsize'
                                                         . ', cd_fd, original_date, yn_ios, no_prcss, no_cons'
                                                         . ', cd_im, no_key, current_device_name, lat, lng'
                                                         . ', ts_latlng, no_machine'
                                                         . ', insert_no_emp, insert_date, update_no_emp, update_date) '

                                                         . '     values (' . $_db->paramString($tuple_pdf['no_upfile'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['name'])
                                                         . ',' . intval($_FILES['nm_upfile' . $cd_fi]['size'])
                                                         . ',' . $_db->paramString($tuple_pdf['dir'] . '/' . $tuple_pdf['filename'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['type'])

                                                         . ',null' //. $_db->paramInteger($tuple_pdf['img_width'])
                                                         . ',null' //. $_db->paramInteger($tuple_pdf['img_height'])
                                                         . ',1' // factor_downsize
                                                         . ',0' // factor_rotate
                                                         . ',' . intval($_FILES['nm_upfile' . $cd_fi]['size'])

                                                         . ',' . $_db->paramString($tuple_pdf['dir'] . '/' . $tuple_pdf['filename'])
                                                         . ',' . $_db->paramString($_FILES['nm_upfile' . $cd_fi]['type'])
                                                         . ',null' //. $_db->paramInteger($tuple_pdf['img_width'])
                                                         . ',null' //. $_db->paramInteger($tuple_pdf['img_height'])
                                                         . ',0' //. $_db->paramInteger($max_factor_downsize)

                                                         . ',1' // file
                                                         . ',null' //. $_db->paramString($original_date)
                                                         . ',1' // yn_ios
                                                         . ',' . $_db->paramInteger($_tpl->value['ios']['no_prcss'])
                                                         . ',' . $_db->paramInteger($_req->getRequestValue('no_cons'))

                                                         . ',null' // cd_im
                                                         . ',null' // no_key
                                                         . ',' . $_db->paramString($_tpl->value['ios']['current_device_name'])
                                                         . ',' . $_db->paramFloat($_req->getRequestValue('lat'))
                                                         . ',' . $_db->paramFloat($_req->getRequestValue('lng'))

                                                         . ',' . $_db->paramString($_req->getRequestValue('ts_latlng'))
                                                         . ',0' // no_machine

                                                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                                                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                                                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                                                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                                                         . ')';
                                                    $_db->execute($sql);

                                                    //$sql_upfile .= '     , ' . $cd_fi . '_no_upfile = ' . $_db->paramString($tuple_pdf['no_upfile']);
                                                //}
                                            } else {
                                                $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, ($cd_fi == '132' ? 'JPEG' : 'JPEG・PNG・PDF') . 'ファイルではありません。');
                                            }
                                        } else {
                                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイル移動失敗です。');
                                        }
                                    } else {
                                        $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ディレクトリーが作られません。');
                                    }
                                } else {
                                    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'アップロードできない拡張子です。');
                                }
                            } else {
                                $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイル名に記号が含まれています。');
                            }
                        } else {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '正しいファイルではありません。');
                        }
                    } else {
                        if ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_INI_SIZE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルサイズエラーです。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_FORM_SIZE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルサイズエラーです。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_PARTIAL) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'アップロード中断されました。');
                        } elseif ($_FILES['nm_upfile' . $cd_fi]['error'] === UPLOAD_ERR_NO_FILE) {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルを選択してください。');
                        } else {
                            $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'ファイルアップロード失敗です。');
                        }
                    }

////////////////////////////////////////

                }
            }

            foreach ($_req_consesti->requests as $cd_fi => $row) {
                if (isset($list_new_no_upfile[$cd_fi])) {
                    $no_upfile = $list_new_no_upfile[$cd_fi];
                } elseif (isset($list_consesti[$cd_fi]['no_upfile'])) { // isset(null) => false
                    $no_upfile = $list_consesti[$cd_fi]['no_upfile'];
                } else {
                    $no_upfile = '';
                }
                if ($no_upfile > '') {
                    $sql = 'insert into consesti (no_cons, no_prcss, cd_fi, no_upfile, sq_send, consesti_note, consesti_number, insert_no_emp, insert_date, update_no_emp, update_date) '
                         . '      values (' . $_db->paramInteger($_req->getRequestValue('no_cons'))
                         . ',' . $_db->paramInteger($_tpl->value['ios']['no_prcss'])
                         . ',' . $_db->paramInteger($cd_fi)
                         . ',' . $_db->paramString($no_upfile)
                         . ',0'
                         . ',' . ($cd_fi == 130 ? $_db->paramString($_req->getRequestValue('consesti_note130')) : 'null')
                         . ',' . $_db->paramString($row['consesti_number'])
                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                         . ',' . $_db->paramInteger($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                         . ',' . $_db->paramString($_tpl->value['ios']['ts_current'])
                         . ')';
                    $_db->execute($sql);
                }
            }

            // 新プリンターにファイルフォーマットが jpg になったため
            if ($tuple['home_code'] == 45) { //　カインズ
                $_db->execute
                    ( 'delete from consesti'
                    . ' using ('
                    . 'select b.no_cons, b.no_prcss'
                    . '  from cons a, consesti b, upfile c'
                    . ' where a.no_cons = b.no_cons'
                    . '   and ' . $_db->paramInteger($_tpl->value['ios']['no_prcss']) . ' = b.no_prcss'
                    . '   and b.no_upfile = c.no_upfile'
                    . '   and a.no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons'))
                    . '   and a.home_code = 45'
                    . '   and b.cd_fi = 130'
                    . "   and c.nm_upfile like '%.jpg'"
                    . '     ) z'
                    . ' where consesti.no_cons = z.no_cons'
                    . '   and consesti.no_prcss = ' . $_db->paramInteger($_tpl->value['ios']['no_prcss'])
                    . '   and consesti.cd_fi = 132'
                    );
            }

            $sql = 'update cons'
                 . '   set cd_ds = ' . $_db->paramInteger($_req->getRequestValue('cd_ds'))
                 . '     , dis_cons_value = ' . $_db->paramInteger($_req->getRequestValue('dis_cons_value'))

                 // 見積もり登録後 iPad 割引修正不可にする。
                 //. '     , yn_dis_cons_ipad_readonly = 1'

// amtax_discount 自動計算
                 . '     , terminal_ts_estimate = ' . $_db->paramString($_req->getRequestValue('terminal_ts_estimate'))
                 //. $sql_upfile
                 . '     , estimate_no_prcss = ' . $_db->paramInteger($_tpl->value['ios']['no_prcss'])
                 . '     , report_no_prcss = null' // 見積を再作成すると報告書は無効になる。
                 . '     , server_estimate_date = ' . $_db->paramString($tuple['today_date'])
                 . '     , update_no_emp = ' . intval($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                 . '     , update_date = ' . $_db->paramString($tuple['today_date'])
                 . ' where no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons'));
            $_db->execute($sql);


            if ($tuple['cd_tz'] == 2) { // 1;"round" 2;"floor"
                function function_number($param) {
                    return floor($param);
                }
            } else {
                function function_number($param) {
                    return round($param);
                }
            }

            // 2019/03/05
            // [iPad] dataGlobal.dictionaryCurrentConsEstimate.list_dmnd.3
            // any_dmnd: 53383.898438
            // qty: 11.530000
            // json 変換後 POST の内容
            // ,"any_dmnd":53383.8984375,"qty":11.529999732971191
            // 臨時で php で round($row['qty'], 2) にする

            $_db->execute('delete from dmndkrt where no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons')));
            $_db->execute('delete from dmnd where no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons')));
            if (! empty($_req_dmnd->requests)) {
                $sq_seq = 0;
                foreach ($_req_dmnd->requests as $row) {
                    $sq_seq ++;

                    $affected_rows = $_db->execute
                        ( 'insert into dmnd (no_cons, sq_seq, dmnd_code, cd_tk, yn_direct'
                        . ', any_price, amtax_price, qty, any_dmnd, amtax_dmnd'
                        . ', any_spec, amtax_spec, any_hc, amtax_hc, any_hc_real'
                        . ', amtax_hc_real, any_cd, amtax_cd, note'
                        . ', insert_no_emp, insert_date, update_no_emp, update_date) '
                        . 'select ' . $_db->paramInteger($_req->getRequestValue('no_cons'))
                        . '     , ' . $sq_seq
                        . '     , ' . $_db->paramInteger($row['dmnd_code'])
                        . '     , ' . $_db->paramInteger($row['cd_tk'])
                        . '     , k.yn_direct'

                        . '     , ' . $_db->paramInteger($row['any_price'])
                        . '     , ' . $_db->paramInteger($row['any_price']) . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(' . $_db->paramInteger($row['any_price']) . ' * ' . $tuple['rate_tax'] . ' / 100.)' : '')
                        . '     , ' . $_db->paramFloat(round($row['qty'], 2))
                        . '     , k.any_dmnd'
                        . '     , k.any_dmnd' . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(k.any_dmnd * ' . $tuple['rate_tax'] . ' / 100.) as amtax_dmnd' : '')

                        . '     , k.any_spec'
                        . '     , k.any_spec' . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(k.any_spec * ' . $tuple['rate_tax'] . ' / 100.) as amtax_spec' : '')
                        . '     , k.any_hc'
                        . '     , k.any_hc' . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(k.any_hc * ' . $tuple['rate_tax'] . ' / 100.) as amtax_hc' : '')
                        . '     , k.any_hc_real'

                        . '     , k.any_hc_real' . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(k.any_hc_real * ' . $tuple['rate_tax'] . ' / 100.) as amtax_hc_real' : '')
                        . '     , k.any_cd'
                        . '     , k.any_cd' . ($tuple['cd_tk'] == 2 ? ' + ' . ($tuple['cd_tz'] == 2 ? 'floor' : 'round') . '(k.any_cd * ' . $tuple['rate_tax'] . ' / 100.) as amtax_cd' : '')
                        . '     , ' . $_db->paramString($row['note'])
                        . '     , ' . intval($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                        . '     , ' . $_db->paramString($tuple['today_date'])
                        . '     , ' . intval($_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD])
                        . '     , ' . $_db->paramString($tuple['today_date'])
                        . '  from ('
                        . 'select case when any_price = ' . $_db->paramInteger($row['any_price']) . ' then 0 else 1 end::smallint as yn_direct'
                        . '     , round(' . $_db->paramInteger($row['any_price']) . ' * ' . $_db->paramFloat(round($row['qty'], 2)) . ', 2)::numeric(12,2) as any_dmnd'
                        . '     , round(' . $_db->paramInteger($row['any_price']) . ' * ' . $_db->paramFloat(round($row['qty'], 2)) . ' * rate_spec / 100., 2)::numeric(12,2) as any_spec'
                        . '     , round(' . $_db->paramInteger($row['any_price']) . ' * ' . $_db->paramFloat(round($row['qty'], 2)) . ' * rate_hc / 100., 2)::numeric(12,2) as any_hc'
                        . '     , round(' . $_db->paramInteger($row['any_price']) . ' * ' . $_db->paramFloat(round($row['qty'], 2)) . ' * rate_hc_real / 100., 2)::numeric(12,2) as any_hc_real'
                        . '     , round(' . $_db->paramInteger($row['any_price']) . ' * ' . $_db->paramFloat(round($row['qty'], 2)) . ' * rate_cd / 100., 2)::numeric(12,2) as any_cd'
                        . '  from dmndcode'
                        . ' where dmnd_code = ' . $_db->paramInteger($row['dmnd_code'])
                        . '   and ' . $_db->paramString($tuple['dt_acc']) . ' between dt_acc_fr and dt_acc_to'
                        . '     ) k'
                        );
                    if ($affected_rows == 1) {
                        foreach ($row as $key => $val) {
                            if (preg_match('/^krt_code([0-9]+)$/', $key, $matches) && $val > '') {
                                $j = $matches[1];
                                $_db->execute('insert into dmndkrt (no_cons, sq_seq, krt_idx, krt_code, krt_cnt)'
                                            . ' values (' . $_db->paramInteger($_req->getRequestValue('no_cons'))
                                            . ', ' . $_db->paramInteger($sq_seq)
                                            . ', ' . $_db->paramInteger($j)
                                            . ', ' . $_db->paramInteger($val)
                                            . ', ' . $_db->paramInteger($row['krt_cnt' . $j])
                                            . ')');
                            }
                        }
                    } else {
                        $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '存在しない請求項目です。');
                        break;
                    }
                }
            }

            $no_cons = $_db->paramInteger($_req->getRequestValue('no_cons'));
            $tuple['function_number'] = $tuple['cd_tz'] == 2 ? 'floor' : 'round';
            $_db->execute('update cons'
                        . '   set amtax_discount = calc_amtax_discount'
                        . '     , amtax_discount_hc = calc_amtax_discount_hc'
                        . '     , amtax_discount_rest = calc_amtax_discount_rest'
                        . '     , amt_dmnd = calc_amt_dmnd'
                        . '     , tax_dmnd = calc_amtax_dmnd - calc_amt_dmnd'
                        . '     , amtax_dmnd = calc_amtax_dmnd'
                        . '     , amt_sales = calc_amt_sales'
                        . '     , tax_sales = calc_amtax_sales - calc_amt_sales'
                        . '     , amtax_sales = calc_amtax_sales'
                        . '     , amt_hc = calc_amt_hc'
                        . '     , tax_hc = calc_amtax_hc - calc_amt_hc'
                        . '     , homerate_rate_hc_real = calc_homerate_rate_hc_real'
                        . '     , amtax_hc = calc_amtax_hc'
                        . '     , amtax_expe = calc_amtax_expe'
                        . '     , amtax_spec = calc_amtax_spec'
                        . '     , amtax_income = calc_amtax_income'
                        . '     , amtax_cd = calc_amtax_cd'
                        . '     , amtax_919g = calc_amtax_919g'
                        . '     , amtax_dayfee = calc_amtax_dayfee'
                        . '     , amtax_gain = calc_amtax_gain'
                        . '     , amt_demand = calc_amt_demand'
                        . '     , tax_demand = calc_amtax_demand - calc_amt_demand'
                        . '     , amtax_demand = calc_amtax_demand'
                        . '     , com_pay = calc_com_pay'
                        . '     , sum_pay = calc_sum_pay'
                        . '     , cd_pp = case when calc_com_pay = calc_sum_pay then 2'
                        . '                    when calc_com_pay > calc_sum_pay then 1'
                        . '                    else 3 end'
                        . '     , no_sche = calc_no_sche'
                        . '     , rate_3star = calc_rate_3star'
                        . '     , amtax_3star = calc_amtax_3star'
// 注意 cd_ks なし dt_acc 変更不可
                        //. ($_req->getRequestValue('cd_ks') == 1 ? '' : '     , dt_acc = ' . $_db->paramString($_req->getRequestValue('dt_acc')))
// 注意 changed_dmnd なし
                        //. ($tuple['changed_dmnd']
                        //  ? '     , server_estimate_date = update_date'
                        //  . '     , estimate_no_prcss = null'
                        //  . '     , server_report_date = update_date'
                        //  . '     , report_no_prcss = null'
                        //  : ''
                        //  )
                        . '  from ('
                                . "
-----5
select q.no_cons as calc_no_cons
     , q.amtax_dmnd as calc_amtax_dmnd
     , q.amt_dmnd as calc_amt_dmnd
     , q.amtax_discount as calc_amtax_discount
     , q.amtax_discount_hc as calc_amtax_discount_hc
     , q.amtax_discount_rest as calc_amtax_discount_rest
     , q.amtax_sales as calc_amtax_sales
     , case when q.amtax_discount + q.amtax_discount_hc + q.amtax_discount_rest = 0 then q.amt_dmnd
            else q.amtax_sales - " . $tuple['function_number'] . "(q.amtax_sales * q.rate_tax / (100. + q.rate_tax)) end as calc_amt_sales
     , q.homerate_rate_hc_real as calc_homerate_rate_hc_real
     , q.amtax_hc as calc_amtax_hc
     , q.amtax_hc - " . $tuple['function_number'] . "(q.amtax_hc * q.rate_tax / (100. + q.rate_tax)) as calc_amt_hc
     , q.amtax_cd as calc_amtax_cd
     , q.amtax_spec as calc_amtax_spec
     , q.amtax_expe as calc_amtax_expe
     , q.sum_pay as calc_sum_pay
     , q.amtax_dayfee as calc_amtax_dayfee
     , q.no_sche as calc_no_sche
     , q.rate_3star as calc_rate_3star
     , q.amtax_3star as calc_amtax_3star
     , " . $tuple['function_number'] . "(q.amtax_sales - q.amtax_hc - q.amtax_spec - q.amtax_expe) as calc_amtax_income
     , q.amtax_sales - q.amtax_cd as calc_amtax_919g
     , q.amtax_sales - q.amtax_hc - q.amtax_cd - q.amtax_dayfee as calc_amtax_gain
     , q.amtax_sales - q.amtax_hc as calc_amtax_demand
     , q.amtax_sales - q.amtax_hc - " . $tuple['function_number'] . "((q.amtax_sales - q.amtax_hc) * q.rate_tax / (100. + q.rate_tax)) as calc_amt_demand
     , case when q.cd_tt = 3 then q.amtax_sales when q.cd_tt = 2 then q.amtax_sales - q.amtax_hc - " . $tuple['function_number'] . "((q.amtax_sales - q.amtax_hc) * q.rate_tax / (100. + q.rate_tax)) else " . $tuple['function_number'] . "(q.amtax_sales - q.amtax_hc) end as calc_com_pay
  from (
-----4
select p.no_cons, p.cd_tt, p.rate_tax
     , p.sum_amtax_dmnd as amtax_dmnd, p.sum_amt_dmnd as amt_dmnd
     , p.amtax_discount
     , p.amtax_discount_hc
     , p.amtax_discount_rest
     , p.sum_amtax_dmnd + p.amtax_discount + p.amtax_discount_hc + p.amtax_discount_rest as amtax_sales
     , p.homerate_rate_hc_real
     , p.amtax_hc
     , p.amtax_cd + case when p.amtax_3star < 0 then 0 when p.amtax_3star > p.sum_amtax_dmnd - p.amtax_hc - p.amtax_cd - p.sum_amtax_dayfee then p.sum_amtax_dmnd - p.amtax_hc - p.amtax_cd - p.sum_amtax_dayfee else p.amtax_3star end as amtax_cd
     , p.sum_amtax_spec as amtax_spec
     , p.sum_amtax_expe as amtax_expe
     , p.sum_sum_pay as sum_pay
     , p.sum_amtax_dayfee as amtax_dayfee
     , (select max(g.no_sche) from sche g where g.no_cons = p.no_cons) as no_sche
     , p.rate_3star
     , case when p.amtax_3star < 0 then 0 when p.amtax_3star > p.sum_amtax_dmnd - p.amtax_hc - p.amtax_cd - p.sum_amtax_dayfee then p.sum_amtax_dmnd - p.amtax_hc - p.amtax_cd - p.sum_amtax_dayfee else p.amtax_3star end as amtax_3star
  from (
-----3
select o.no_cons, o.cd_tk, o.cd_tt, o.rate_tax
     , o.sum_amt_dmnd, o.sum_amtax_dmnd
     , o.amtax_discount
     , o.amtax_discount_hc
     , case when o.home_code = 19 and (o.sum_amtax_dmnd + o.amtax_discount + o.amtax_discount_hc) % 10 <> 0 then -1 * ((o.sum_amtax_dmnd + o.amtax_discount + o.amtax_discount_hc) % 10) else 0 end as amtax_discount_rest
     , o.homerate_rate_hc_real
     , o.amtax_hc
     , o.amtax_cd
     , o.sum_amtax_spec, o.sum_amtax_expe, o.sum_sum_pay, o.sum_amtax_dayfee, o.rate_3star
     , " . $tuple['function_number'] . "((o.sum_amtax_dmnd_over + o.sum_amtax_dmnd_under * case when o.home_code = 10 then 1. else 0.9 end - o.sum_amtax_spec - o.sum_amtax_expe) * o.rate_3star / 100.) as amtax_3star
  from (
-----2
select n.no_cons, n.home_code, n.cd_tk, n.cd_tt, n.rate_tax
     , n.sum_amt_dmnd, n.sum_amtax_dmnd
     , n.sum_amt_dmnd_over, n.sum_amtax_dmnd_over
     , n.sum_amt_dmnd_under, n.sum_amtax_dmnd_under
     , case when n.yn_dis_cons_prohibit = 1 then 0
            when n.cd_ds = 1000 then 0
            when n.cd_ds = 2005 then -1 * coalesce(" . $tuple['function_number'] . "(n.sum_amtax_dmnd * 5. / 100.), 0)
            when n.cd_ds = 2900 then -1 * coalesce(" . $tuple['function_number'] . "(n.sum_amtax_dmnd * n.dis_cons_value / 100.), 0)
            when n.cd_ds = 3000 then n.dis_cons_value
            else 0 end as amtax_discount
     , n.amtax_discount_hc
     , n.homerate_rate_hc_real
     , case when n.yn_direct_hc = 1 then n.amtax_hc
            when n.sum_amtax_dmnd = 0 then 0
            when n.homerate_rate_hc_real is not null then floor(n.sum_amtax_dmnd * n.homerate_rate_hc_real / 100.)
            else n.sum_amtax_hc_real end as amtax_hc
     , case when n.yn_direct_cd = 1 then n.amtax_cd
            else " . $tuple['function_number'] . "(n.sum_amtax_cd + (n.sum_amtax_spec + n.sum_amtax_expe) * 0.5) end as amtax_cd
     , n.sum_amtax_spec, n.sum_amtax_expe, n.sum_sum_pay, n.sum_amtax_dayfee, n.rate_3star
  from (
-----1
select a.no_cons, a.home_code, a.cd_tk, v.cd_tt, a.rate_tax
     , a.yn_dis_cons_prohibit, a.cd_ds, a.dis_cons_value
     , case when v.cd_tc = 2 then coalesce(" . $tuple['function_number'] . "(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_dmnd) end * v.rate_discount / 100.), 0) else 0 end as amtax_discount_hc
     , (select z.rate_hc_real from homerate z where z.home_code = a.home_code and a.dt_acc between z.dt_acc_fr and z.dt_acc_to and z.cd_tk = a.cd_tk) as homerate_rate_hc_real
     , a.yn_direct_hc, a.amtax_hc
     , a.yn_direct_cd, a.amtax_cd
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd) else " . $tuple['function_number'] . "(z.sum_any_dmnd) - " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd) * a.rate_tax / (100. + a.rate_tax)) end, 0) as sum_amt_dmnd
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_dmnd) end, 0) as sum_amtax_dmnd
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd_over) else " . $tuple['function_number'] . "(z.sum_any_dmnd_over) - " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd_over) * a.rate_tax / (100. + a.rate_tax)) end, 0) as sum_amt_dmnd_over
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd_over) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd_over) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_dmnd_over) end, 0) as sum_amtax_dmnd_over
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd_under) else " . $tuple['function_number'] . "(z.sum_any_dmnd_under) - " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd_under) * a.rate_tax / (100. + a.rate_tax)) end, 0) as sum_amt_dmnd_under
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_dmnd_under) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_dmnd_under) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_dmnd_under) end, 0) as sum_amtax_dmnd_under
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_spec) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_spec) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_spec) end, 0) as sum_amtax_spec
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_hc_real) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_hc_real) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_hc_real) end, 0) as sum_amtax_hc_real
     , coalesce(case when a.cd_tk = 2 then " . $tuple['function_number'] . "(z.sum_any_cd) + " . $tuple['function_number'] . "(" . $tuple['function_number'] . "(z.sum_any_cd) * a.rate_tax / 100.) else " . $tuple['function_number'] . "(z.sum_any_cd) end, 0) as sum_amtax_cd
     , coalesce(y.sum_amtax_expe, 0) as sum_amtax_expe
     , coalesce(x.sum_sum_pay, 0) as sum_sum_pay
     , coalesce(w.sum_amtax_dayfee, 0) as sum_amtax_dayfee
     , case when a.yn_direct_cd = 1 then 0 else coalesce((
select j.rate_3star
  from sche i, cd3star j
 where i.no_cons = a.no_cons
   and i.sche_code = 91
   and j.no_cd = a.no_cd
   and i.dt_sche between j.dt_3star_fr and j.dt_3star_to
 limit 1
       ), 0) end as rate_3star
  from cons a left outer join (
select no_cons
     , sum(any_dmnd) as sum_any_dmnd
     , sum(case when any_dmnd = 0 then 0 when any_cd / any_dmnd > 0.6 then any_dmnd else 0 end) as sum_any_dmnd_over
     , sum(case when any_dmnd = 0 then 0 when any_cd / any_dmnd > 0.6 then 0 else any_dmnd end) as sum_any_dmnd_under
     , sum(any_spec) as sum_any_spec
     , sum(any_hc_real) as sum_any_hc_real
     , sum(any_cd) as sum_any_cd
  from dmnd
 where no_cons = " . $no_cons . "
 group by no_cons
     ) z on z.no_cons = a.no_cons
              left outer join (
select no_cons
     , sum(amtax_expe) as sum_amtax_expe
  from expe
 where no_cons = " . $no_cons . "
 group by no_cons
     ) y on y.no_cons = a.no_cons
              left outer join (
select no_cons
     , sum(sum_pay) as sum_sum_pay
  from pay
 where no_cons = " . $no_cons . "
 group by no_cons
     ) x on x.no_cons = a.no_cons
              left outer join (
select no_cons
     , sum(amtax_dayfee) as sum_amtax_dayfee
  from dayfee
 where no_cons = " . $no_cons . "
 group by no_cons
     ) w on w.no_cons = a.no_cons
     , homecode v
 where a.home_code = v.home_code
   and a.yn_protect = 0
   and a.no_cons = " . $no_cons . "
-----1
     ) n
-----2
     ) o
-----3
     ) p
-----4
     ) q
-----5
"
                        . '     ) calc'
                        . ' where no_cons = calc_no_cons'
                        . '   and yn_protect = 0');

            // 最終テスト IPAD とサーバーのデータが一致？
            if ($_err->isOk()) {
                $row = $_db->selectRow
                    ( 'select a.amtax_dmnd as predetermined_amtax_dmnd, a.amt_sales'
                    . '     , a.tax_sales, a.amtax_sales, a.amtax_discount'
                    . '     , a.amtax_discount_hc, a.amtax_discount_rest'
                    . '  from cons a'
                    . ' where a.no_cons = ' . $_db->paramInteger($_req->getRequestValue('no_cons'))
                    );
                $temp = '';
                if ($_req->getRequestValue('predetermined_amtax_dmnd') != $row['predetermined_amtax_dmnd']) {
                    $temp .= ($temp === '' ? '' : "\n") . '請求項目の合算「' . $_req->getRequestValue('predetermined_amtax_dmnd') . ' - ' . $row['predetermined_amtax_dmnd'] . ' = ' . ($_req->getRequestValue('predetermined_amtax_dmnd') - $row['predetermined_amtax_dmnd']) . '」';
                }
                if ($_req->getRequestValue('amt_sales') != $row['amt_sales']) {
                    $temp .= ($temp === '' ? '' : "\n") . '総計（税抜）「' . $_req->getRequestValue('amt_sales') . ' - ' . $row['amt_sales'] . ' = ' . ($_req->getRequestValue('amt_sales') - $row['amt_sales']) . '」';
                }
                if ($_req->getRequestValue('tax_sales') != $row['tax_sales']) {
                    $temp .= ($temp === '' ? '' : "\n") . '総計（税）「' . $_req->getRequestValue('tax_sales') . ' - ' . $row['tax_sales'] . ' = ' . ($_req->getRequestValue('tax_sales') - $row['tax_sales']) . '」';
                }
                if ($_req->getRequestValue('amtax_sales') != $row['amtax_sales']) {
                    $temp .= ($temp === '' ? '' : "\n") . '総計「' . $_req->getRequestValue('amtax_sales') . ' - ' . $row['amtax_sales'] . ' = ' . ($_req->getRequestValue('amtax_sales') - $row['amtax_sales']) . '」';
                }
                if ($_req->getRequestValue('amtax_discount') != $row['amtax_discount']) {
                    $temp .= ($temp === '' ? '' : "\n") . '割引（本部）「' . $_req->getRequestValue('amtax_discount') . ' - ' . $row['amtax_discount'] . ' = ' . ($_req->getRequestValue('amtax_discount') - $row['amtax_discount']) . '」';
                }
                if ($_req->getRequestValue('amtax_discount_hc') != $row['amtax_discount_hc']) {
                    $temp .= ($temp === '' ? '' : "\n") . '割引（HC）「' . $_req->getRequestValue('amtax_discount_hc') . ' - ' . $row['amtax_discount_hc'] . ' = ' . ($_req->getRequestValue('amtax_discount_hc') - $row['amtax_discount_hc']) . '」';
                }
                if ($_req->getRequestValue('amtax_discount_rest') != $row['amtax_discount_rest']) {
                    $temp .= ($temp === '' ? '' : "\n") . '割引（端数）「' . $_req->getRequestValue('amtax_discount_rest') . ' - ' . $row['amtax_discount_rest'] . ' = ' . ($_req->getRequestValue('amtax_discount_rest') - $row['amtax_discount_rest']) . '」';
                }
                if ($temp > '') {
                    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, '金額不一致(管理者に連絡して下さい)' . $temp);
                }
            }

            if ($_err->isOk()) {
                $_dbk->backupRow('cons', array(array('no_cons' => array('val' => $_req->getRequestValue('no_cons'), 'type' => 1))), 'U', $_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD] . ' ' . $_tpl->value['ios']['prcss_id'] . ' ' . __LINE__);
                $_dbk->backupRow('dmnd', array(array('no_cons' => array('val' => $_req->getRequestValue('no_cons'), 'type' => 1))), 'U', $_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD] . ' ' . $_tpl->value['ios']['prcss_id'] . ' ' . __LINE__);
                $_dbk->backupRow('dmndkrt', array(array('no_cons' => array('val' => $_req->getRequestValue('no_cons'), 'type' => 1))), 'U', $_tpl->value['ios'][PORTAL_USER_DEFAULT_NO_CD] . ' ' . $_tpl->value['ios']['prcss_id'] . ' ' . __LINE__);
                $_db->commit();
            } else {
                $_db->rollback();
            }
        }

        $_dbk->clearBackupTables();

        if ($_err->isOk()) {
            $_tpl->value['yn_omit_all'] = true;
            require_once('p3010.inc.php');
        }
    }
}

///// prcss_version 1 end /////
} else {
    $_err->addError(IOS_ERROR_BASE_LOGIC + __LINE__, 'プログラムをアップデートしてください。');
}
