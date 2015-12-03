<?php
session_start();
include_once('connect.php');

$case_num = $_POST['case_num'];
switch( $case_num ){

    case 1: // login 登录

        $sign_in_email = $_POST['email'];
        $sign_in_pw = md5($_POST['pw']);

        $sql = "select * from users where email = '".$sign_in_email."' and pw = '".$sign_in_pw."'";
        $result = mysql_query( $sql );
        $user = mysql_num_rows( $result );

        if( $user ) {
            echo 1;
            $_SESSION['user'] = 1;
        }
        else{
            echo 0;
        }
        exit;
        break;

    case 2: // login 注册

        $sign_up_name = $_POST['name'];
        $sign_up_email = $_POST['email'];
        $sign_up_pw = $_POST['pw'];

        $sql = "insert into users(email,name,pw) value('".$sign_up_email."','".$sign_up_name."','".md5($sign_up_pw)."')";
        $result = mysql_query( $sql );

        if( mysql_affected_rows() > 0 ){
            $_SESSION['user'] = 1;
            $_SESSION['user_name'] = $sign_up_name;
            $_SESSION['user_email'] = $sign_up_email;
            echo 1;
        }
        else{
            echo 0;
        }

    case 3: // index colors 前五

        $sql = 'select * from vote_object order by object_id desc limit 0,5';
        $result = mysql_query( $sql );
        $num = mysql_num_rows( $result );

        $i = 1;
        $colors = array();
        while( $color = mysql_fetch_array( $result ) ){  // $colors 是存有 vote_object 的二维数组
            $colors[$i] = $color;
            $i++;
        }

        if( $num ){
            echo json_encode( $colors );
        }
        exit;
        break;

    case 4: // index 投票

        $object_id = $_POST['object_id'];

        $sql = 'select vote_num from vote_object where object_id = '.$object_id;
        $result = mysql_query( $sql );
        $vote_num = mysql_fetch_array( $result ); // 取出 vote_object 的 vote_num
        $vote_num = $num['vote_num'];


        echo $result;




}




?>