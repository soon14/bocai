<?php
function customError($errno, $errstr, $errfile, $errline)
{ 
 echo "<b>Error number:</b> [$errno],error on line $errline in $errfile<br />";
 die();
}
set_error_handler("customError",E_ERROR);
$getfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|\\s*onload\\b|\\s*document\\b|\\s*write\\b|\\s*fromCharCode\\b|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|\\s*onload\\b|\\s*document\\b|\\s*write\\b|\\s*fromCharCode\\b|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|\\s*onload\\b|\\s*document\\b|\\s*write\\b|\\s*fromCharCode\\b|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){  

if(is_array($StrFiltValue))
{
    $StrFiltValue=implode($StrFiltValue);
}  
if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){   
        //slog("<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"]."<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S")."<br>操作页面:".$_SERVER["PHP_SELF"]."<br>提交方式: ".$_SERVER["REQUEST_METHOD"]."<br>提交参数: ".$StrFiltKey."<br>提交数据: ".$StrFiltValue);
        print "notice:Illegal operation!";
        exit();
	}      
}  
foreach($_GET as $key=>$value){ 
	StopAttack($key,$value,$getfilter);
}
foreach($_POST as $key=>$value){ 
	StopAttack($key,$value,$postfilter);
}
foreach($_COOKIE as $key=>$value){ 
	StopAttack($key,$value,$cookiefilter);
}

if (!get_magic_quotes_gpc()) {
    !empty($_POST)     && Add_S($_POST);
    !empty($_GET)     && Add_S($_GET);
    !empty($_COOKIE) && Add_S($_COOKIE);
    !empty($_SESSION) && Add_S($_SESSION);
}
!empty($_FILES) && Add_S($_FILES);

function Add_S(&$array){
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $value=         @addslashes($value);
                $array[$key] =  @htmlspecialchars($value,ENT_QUOTES);
            } else {
                Add_S($array[$key]);
            }
        }
    }
}

//美东时间
$et_time = time()-1*12*3600;
$et_time_now = date("Y-m-d H:i:s",$et_time);
//北京时间
$bj_time_now = date("Y-m-d H:i:s",time());
$bj_time = time();

$C_Patch=$_SERVER['DOCUMENT_ROOT'];
@include_once($C_Patch."/app/member/include/mysql.php");
unset($mysqli);
//$mysqli	=	new MySQLi("localhost","root",$mysql_pass,"yl66y");
$mysqli	=	new MySQLi("localhost","root","root","yl66y");
$mysqli->query("set names utf8");

?>
