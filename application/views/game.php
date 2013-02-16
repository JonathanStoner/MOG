<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" media='all and (min-width: 769px)' href="../application/views/css/map_style.css" type="text/css" media="screen,projection" /> 
</head>
<body>
    <header><h1>MOG -- Multi-player Online Game</h1></header>
    <hr>
    <div id="online_players_window">
        <h2>- Online Players -</h2>
        <ul id="online_players_target"></ul>
    </div>
    <hr>
    <div id="chat_log_window">
        <h2>- Chat Log -</h2>
        <ul id="chat_log_target"></ul>
        Type here -><input type="text" name="chat_input" id="chat_input">
    </div>

    
    <hr class="clear">
    <?php
        generate_map1();
    ?>
    <hr class="clear">
    <?php
        generate_map2();
    ?>
    <hr class="clear">
    <?php
        generate_map3();
    ?>
    <hr class="clear">
<!--
    <div class="zone grass"></div>
    <div class="zone mountain"></div>
    <div class="zone water"></div>
    <div class="zone village"></div>
-->    

<a href="logout">Log Out</a>
    
</body>

<script>
    //CHAT LOG SCRIPTS: chat_log_
    function chat_log_refresh(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("chat_log_target").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","game-chat_log_u",true);
        xmlhttp.send();
    }
    function log_message(){
        var m = document.getElementById("chat_input").value;
        var em = "message="+encodeURIComponent(m);
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.open("POST","game-chat_log_u-p",false);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(em);
    }
    function keyboard_input(e){
        var unicode=e.keyCode? e.keyCode : e.charCode;
  	if(unicode == 10 || unicode == 13){
            log_message();
            document.getElementById("chat_input").value = "";
        }
    }
    document.onkeydown=keyboard_input

    //online_players_
    function online_players_refresh(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("online_players_target").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","game-online_players_u",true);
        xmlhttp.send();
    }

    //REFRESH LOOP -- ALL
    function timeout_loop(){
        online_players_refresh();
        chat_log_refresh();
        setTimeout('timeout_loop()', 500);
    }
    timeout_loop();//start the cycle
</script>

</html>
<?php
function generate_map1()
{
        $zone = array(
            '0' => "village",
            '1' => "grass",
            '2' => "water",
            '3' => "mountain"
        );
        echo '<div class="zone village"></div>';
        for($row=1;$row<12;$row++)
        {
            $rand = rand(1, 3);
            echo '<div class="zone '.$zone[$rand].'"></div>';
        }
        echo'<br class="clear">';
        for($col=1;$col<7;$col++)
        {
            for($row=0;$row<12;$row++)
            {
                $rand = rand(1, 3);
                echo '<div class="zone '.$zone[$rand].'"></div>';
            }
            echo'<br class="clear">';
        }
        for($row=0;$row<11;$row++)
        {
            $rand = rand(1, 3);
            echo '<div class="zone '.$zone[$rand].'"></div>';
        }
        echo '<div class="zone village"></div>';
}
function generate_map2()
{
        $zone = array(
            '0' => "village",
            '1' => "grass",
            '2' => "grass",
            '3' => "grass",
            '4' => "grass",
//            '4' => "water",
            '5' => "mountain"
        );
        echo '<div class="zone village"></div>';
        for($row=1;$row<12;$row++)
        {
            $rand = rand(1, 5);
            echo '<div class="zone '.$zone[$rand].'"></div>';
        }
        echo'<br class="clear">';
        for($col=1;$col<7;$col++)
        {
            for($row=0;$row<12;$row++)
            {
                $rand = rand(1, 5);
                echo '<div class="zone '.$zone[$rand].'"></div>';
            }
            echo'<br class="clear">';
        }
        for($row=0;$row<11;$row++)
        {
            $rand = rand(1, 5);
            echo '<div class="zone '.$zone[$rand].'"></div>';
        }
        echo '<div class="zone village"></div>';
}
function generate_map3()
{
        $type = array(
            '0' => "village",
            '1' => "grass",
            '2' => "water",
            '3' => "mountain"
        );
        $zone = array(//initialize all to mountain
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
            array('3','3','3','3','3','3','3','3','3','3','3','3'),
        );
        
        //place sp
        $zone[d8()][d12()] = 0;
        
        for($col=0;$col<8;$col++)
        {
            for($row=0;$row<12;$row++)
            {
                echo '<div class="zone '.$type[$zone[$col][$row]].'"></div>';
            }
            echo'<br class="clear">';
        }
}
function d4(){return rand(0,3);}
function d8(){return rand(0,7);}
function d12(){return rand(0,11);}
?>