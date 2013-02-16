<!DOCTYPE html>
<html>
<head>
<script>
function refresh(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("disp").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","ajax_test",true);
//<a href="logout">Log Out</a>
    xmlhttp.send();
}
function timeout_loop(){
    refresh();
    setTimeout('timeout_loop()', 1000);
}
function timeout_init() {
    document.getElementById("starter").disabled=true;
    timeout_loop();
}
</script>
</head>
<body>

<div id="disp"></div>
<button type="button" onclick="refresh()">Refresh/Update</button>
<button id="starter" type="button" onclick="timeout_init()">Start Auto Refresh/Update</button>

</body>
</html>

