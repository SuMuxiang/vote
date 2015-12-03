<?php
session_start();
include_once('support/connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Practice</title>
    <link href="css/index.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
</head>
<body>

<div id="colors_back">

    <div id="condition_back">
        <button class="condition" id="colors_all">全部</button>
        <button class="condition" id="colors_top_five">前五</button>
        <button class="condition" id="colors_last_five">后五</button>
        <button class="condition" id="colors_no_num">未得票</button>
    </div>

    <div id="colors">

        <?php
        $sql = 'select * from vote_object';
        $result = mysql_query($sql);
        $i = 1;
        while( $v_o = mysql_fetch_array($result) ){ ?>

            <div class="color_back" id="color_back_<?php echo $v_o['object_id'] ?>">
                <div class="color" id="color_<?php echo $v_o['object_id'] ?>">
                    <img src="img/<?php echo $v_o['object_num'] ?>.jpg" alt="参选者图像" class="color_img" id="color_img_<?php echo $v_o['object_id'] ?>">
                    <div class="color_synopsis" id="synopsis_<?php echo $v_o['object_id'] ?>">
                        <p class="ranking"><?php echo $v_o['vote_num'] ?></p>
                        <p class="color_name"><?php echo $v_o['object_name'] ?></p>
                        <P class="synopsis_text_1"><?php echo $v_o['object_movie'] ?></P>
                        <p class="synopsis_text_2"><?php echo $v_o['object_motto'] ?></p>
                    </div>
                    <div class="color_buttons">
                        <a class="color_close">收起</a>
                        <a class="color_good" id="<?php echo $v_o['object_id'] ?>">支持</a>
                    </div>
                    <div class="cover"></div>
                </div>
            </div>

        <?php } ?>

        <div class="clear"></div>
    </div>
</div>


<script>
    $(function(){

        // 展开简介
        $(document).on('click','.cover',function(){
            var $color = $(this).parent();
            var $c_s = $color.children(".color_synopsis");

            $(this).hide();
            $color.animate({'width':460},'fast',function(){
                $color.animate({'width':450},'fast',function(){
                    $color.animate({'width':460},'fast',function(){
                    });
                    $c_s.show(0,function(){
                        $c_s.children(".ranking").animate({'margin-left':20,'opacity':1},'fast');
                        setTimeout(function(){$c_s.children('.color_name').animate({'margin-left':20,'opacity':1},'fast')},50);
                        setTimeout(function(){$c_s.children('.synopsis_text_1').animate({'margin-left':20,'opacity':1},'fast')},100);
                        setTimeout(function(){$c_s.children('.synopsis_text_2').animate({'margin-left':20,'opacity':1},'fast')},150);
                        setTimeout(function(){$color.children('.color_buttons').animate({'right':20,'opacity':1},'fast')},200);
                    });
                });
            });
        });

        // 关闭简介
        $(document).on('click','.color_close',function(){
            var $buttons = $(this).parent();
            var $color = $buttons.parent();
            //var $c_s = $color.children(".color_synopsis");
            var $s_t_1 = $(this).parent().parent().children('.color_synopsis').children('.synopsis_text_1');
            var $s_t_2 = $(this).parent().parent().children('.color_synopsis').children('.synopsis_text_2');
            var $c_n = $(this).parent().parent().children('.color_synopsis').children('.color_name');
            var $c_r = $(this).parent().parent().children('.color_synopsis').children('.ranking');

            $buttons.css({'opacity':0,'right':30});
            $s_t_1.css({'opacity':0,'margin-left':2});
            $s_t_2.css({'opacity':0,'margin-left':2});
            $c_n.css({'opacity':0,'margin-left':2});
            $c_r.css({'opacity':0,'margin-left':2});
            $color.animate({'width':225},'fast',function(){
                $(this).animate({'width':240},'fast',function(){
                    $(this).animate({'width':220},'fast');
                })
            });
            $color.children('.cover').show();

            /*
                    .children('.synopsis_text_2').css({'opacity':0,'margin-left':2})
                    .children('color_name').css({'opacity':0,'margin-left':2});*/
        });

        // 投票
        $(document).on('click','.color_good',function(){
            $.ajax({
                url:'support/check.php',
                data:{case_num:4,object_id:$(this).attr('id')},
                type:'POST',
                dataType:'text',
                success:function( data ){
                    alert(data);
                }
            });
        });

        // 前五
        $('#colors_top_five').click(function(){
            $.ajax({
                url:'support/check.php',
                data:{case_num:3},
                type:'POST',
                dataType:'json',
                success:function( data ){

                    var $colors = $('#colors');

                    $colors.children().remove();
                    for( i = 1;i < 6;i++ ){
                        $colors.append(
                            "<div class='color_back' id='color_back_"+ data[i].object_id +"'>"+
                            "<div class='color' id='color_"+ data[i].object_id +"'>"+
                            "<img src='img/"+ data[i].object_id +".jpg' alt='参选者图像' class='color_img' id='color_img_"+ data[i].object_id +"'>"+
                            "<div class='color_synopsis' id='synopsis_"+ data[i].object_id +"'>"+
                            "<p class='ranking'>"+ data[i].vote_num + "</p>"+
                            "<p class='color_name'>"+ data[i].object_name +"</p>"+
                            "<p class='synopsis_text_1'>"+ data[i].object_movie +"</p>"+
                            "<p class='synopsis_text_2'>"+ data[i].object_motto +"</p>"+
                            "</div>"+
                            "<div class='color_buttons'>"+
                            "<a class='color_close'>收起</a>"+
                            "<a class='color_good' id='"+ data[i].object_id +"'>支持</a>"+
                            "</div>"+
                            "<div class='cover'></div>"+
                            "</div>"
                        );
                    }
                    $colors.append("<div class='clear'></div>");


                    /*
                    <div class="color_back" id="color_back_<?php echo $v_o['object_id'] ?>">
                        <div class="color" id="color_<?php echo $v_o['object_id'] ?>">
                        <img src="img/<?php echo $v_o['object_num'] ?>.jpg" alt="参选者图像" class="color_img" id="color_img_<?php echo $v_o['object_id'] ?>">
                        <div class="color_synopsis" id="synopsis_<?php echo $v_o['object_id'] ?>">
                        <p class="ranking"><?php echo $v_o['vote_num'] ?></p>
                        <p class="color_name"><?php echo $v_o['object_name'] ?></p>
                        <P class="synopsis_text_1"><?php echo $v_o['object_movie'] ?></P>
                        <p class="synopsis_text_2"><?php echo $v_o['object_motto'] ?></p>
                        </div>
                        <div class="color_buttons">
                        <a class="color_close">收起</a>
                        <a class="color_good">支持</a>
                        </div>
                        <div class="cover" id="cover_1"></div>
                        </div>
                        </div>*/
                }
            })
        });

        /*
        $(".cover").click(function(){
            $(this).hide();
            var color = $(this).parent();
            var color_back = color.parent();
            var c_s = color.children(".color_synopsis");

            c_s.hide().children().hide();
            color_back.animate({'width':380,'height':500},'fast',function(){
                $(this).animate({'width':370,'height':490},'fast',function(){
                    $(this).animate({'width':380,'height':500},'fast');
                });
            });


            $(this).hide();
            var color = $(this).parent();
            var c_s = color.children(".color_synopsis");
            c_s.hide().children().hide();
            //c_s.attr('width','0');
            color.attr("z-index","10").animate({'top':30,'left':440,'width':375,'height':500},'fast',function(){
                color.animate({'top':25,'left':425},'fast',function(){
                    color.animate({'top':30,'left':440},'fast',function(){
                        color.animate({'width':900,'left':150},'fast');
                        c_s.show().animate({'width':525},'fast');
                    });
                    c_s.animate({'left':375,'bottom':0,'height':500,'width':0},0);
                });
            }).children(".color_img").animate({'width':375},'fast');
        });*/

    });
</script>
</body>
</html>