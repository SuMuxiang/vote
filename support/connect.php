<?php
$connect = @mysql_connect('localhost','root','123456');
if( !$connect ){
    echo '连接数据库失败';
    exit;
}
mysql_select_db('vote');
mysql_query('set names utf8');
?>