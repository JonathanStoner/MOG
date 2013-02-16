<div id="chat_log_window">
    <ul id="chat_log_target">
        <?php
        foreach($messages as $message):
//            echo "<li>$message[text]</li>";
            echo "<li>$message</li>";
        endforeach;
        ?>
    </ul>
    CHAT:<input type="text" name="chat_input" id="chat_input">
</div>
 
<script>
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
        //
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
//                alert('sent');
//                alert(xmlhttp.responseText);
            }
        }
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
    
    function timeout_loop(){
        chat_log_refresh();
        setTimeout('timeout_loop()', 1000);
    }
    timeout_loop();
    document.onkeydown=keyboard_input
</script>
