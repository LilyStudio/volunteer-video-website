<?php
require_once('global.php');
require_once('common.php');

function rand_str($length,$p='all')
{  
    $nums = '0123456789';  
    $lowers = 'abcdefghijklmnopqrstuvwxyz';  
    $uppers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
    if ($p == 'all') {  
        $src = $nums.$lowers.$uppers;  
    } else {  
        $src = '';  
        if (strpos($p, 'num') !== false)  
            $src .= $nums;  
        if (strpos($p, 'lower') !== false)  
            $src .= $lowers;  
        if (strpos($p, 'upper') !== false)  
            $src .= $uppers;  
    }  
    return $src? substr(str_shuffle($src), 0, $length) : $src;  
} 

IsLoginNeeded();
if(isset($_GET['vid']))
{
	$_SESSION['vid']=$_GET['vid'];
	$vid=$_GET['vid'];
	$key=rand_str(32);
	$_SESSION['key']=$key;
	$_SESSION['time']=time();

	echo $key;
}
