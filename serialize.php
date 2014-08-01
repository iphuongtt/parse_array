<?php
$arr =

array(
"number_sheet" => "1"
,"begin_sheet" => "0"
,"merge" => "1"

,"sheets" =>

array(

"0" =>

array(
"number" => "0"
,"begin_row" => "11"
,"begin_col" => "2"
,"footer_row_number" => "22"
,"end_col" => "14")));

echo serialize($arr).'<br><br>';


$str = 'a:7:{s:12:"number_sheet";s:1:"4";s:11:"begin_sheet";s:1:"2";s:5:"merge";s:1:"1";s:15:"template_output";s:8:"2D.2.xls";s:6:"footer";a:3:{s:5:"sheet";i:4;s:4:"rows";i:22;s:7:"end_col";i:14;}s:6:"header";a:3:{s:5:"sheet";i:1;s:4:"rows";i:6;s:7:"end_col";i:14;}s:6:"sheets";a:4:{i:0;a:6:{s:6:"number";s:1:"1";s:9:"begin_row";s:2:"12";s:9:"begin_col";s:1:"2";s:7:"end_col";s:2:"14";s:17:"footer_row_number";s:1:"0";s:5:"title";s:52:"I. Danh sách HSSV đã tham gia năm học trước";}i:1;a:6:{s:6:"number";s:1:"2";s:9:"begin_row";s:1:"8";s:9:"begin_col";s:1:"2";s:7:"end_col";s:2:"14";s:17:"footer_row_number";s:1:"0";s:5:"title";s:86:"II. Danh sách HSSV đã tham gia năm học trước có thay đổi thông tin khác";}i:2;a:6:{s:6:"number";s:1:"3";s:9:"begin_row";s:1:"8";s:9:"begin_col";s:1:"2";s:7:"end_col";s:2:"14";s:17:"footer_row_number";s:1:"0";s:5:"title";s:63:"III. Danh sách HSSV tăng mới năm học eval(Y) - eval(Y+1)";}i:3;a:6:{s:6:"number";s:1:"4";s:9:"begin_row";s:1:"8";s:9:"begin_col";s:1:"2";s:7:"end_col";s:2:"14";s:17:"footer_row_number";s:2:"22";s:5:"title";s:63:"IV. Danh sách HSSV giảm hẳn năm học eval(Y) - eval(Y+1)";}}}';
parse_serialize_str($str);


$str = 'nam hoc:  eval(Y) - eval(Y+1)';

preg_match_all('/eval\(\S*\)/', $str, $arrcheckPer);
$params = array(
			'Y' => date('Y')
			,'M' => date('M')
			,'m' => date('m')
			,'G' => date('G')
			,'D' => date('D')
			,'d' => date('d')
	);
$arr_key_params = array_keys($params);
if($arrcheckPer[0] != '' && !empty($arrcheckPer[0])){
	$arrcheckPer = $arrcheckPer[0];
}
foreach($arrcheckPer as $value){
	$result = $value;
	foreach($arr_key_params as $key){
		$result = str_replace($key, $params[$key], $result);
	}
	$result = str_replace('eval','',$result);
	eval("\$result = " . $result .";");
	$str = str_replace($value, $result,$str);
}
echo '<br><br><br>'.$str;


function parse_serialize_str($str){
	$result = '';
	$arr = unserialize($str);
	$result  =  '$arr =  '. parse_array($arr) .';';
	$result .= ' var_dump($arr);';
	echo $result;
	$result = str_replace('<br>','',$result);
	eval($result);
	
}
function parse_array($arr){
	$result = '<br><br>array(';
	$i = 0;
	foreach($arr as $key=>$value){
		$comma = ',';
		if($i== 0)
			$comma = '';
		if(is_array($value))
			$result .= '<br><br>'.$comma.'"'.$key.'" => ' .parse_array($value);
		else{
			$result .= '<br>'.$comma.'"'.$key.'" => "' . $value . '"';
		}
		$i++;
	}
	return $result.')';
}