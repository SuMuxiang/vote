<?php
session_start();
include_once('connect.php');

$case_num = $_POST['case_num'];
switch( $case_num ){

    case 1: // login ��¼

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

    case 2: // login ע��

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

    case 3: // index colors ǰ��

        $sql = 'select * from vote_object order by object_id desc limit 0,5';
        $result = mysql_query( $sql );
        $num = mysql_num_rows( $result );

        $i = 1;
        $colors = array();
        while( $color = mysql_fetch_array( $result ) ){  // $colors �Ǵ��� vote_object �Ķ�ά����
            $colors[$i] = $color;
            $i++;
        }

        if( $num ){
            echo json_encode( $colors );
        }
        exit;
        break;

    case 4: // index ͶƱ

        $object_id = $_POST['object_id'];

        $sql = 'select vote_num from vote_object where object_id = '.$object_id;
        $result = mysql_query( $sql );
        $vote_num = mysql_fetch_array( $result ); // ȡ�� vote_object �� vote_num
        $vote_num = $num['vote_num'];


        echo $result;




}




?>