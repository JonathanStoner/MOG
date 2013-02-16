<html>
<head>
        
 <title>DB DUMP</title>

</head>
<body>

<?php
   $link = mysql_connect("mysql", "Qazebulon", "123qweasdzxc");
   mysql_select_db("MOG");

   $query = "SELECT * FROM characters";
   $result = mysql_query($query);
   print_r($result);

   foreach($result as $line):
      echo "$line<br>";
   endforeach;
/**/
   while ($line = mysql_fetch_array($result))
   {
      print_r($line);
      foreach ($line as $value)
       {
         print "$value\n";
      }
   }
/**/
    mysql_close($link);
?>

</body>
</html>


