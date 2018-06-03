<?php

  
  $host='mysql'; 
  $database='k3140_bak'; 
  $user='root'; 
  $pswd='123456';  
 
  $dbh = mysql_connect($host, $user, $pswd) ;
  if(!$dbh){
    echo ("Не могу соединиться с MySQL." . mysql_error());
    exit();
  }
  echo("Соединение с базой данных установлено<br>");
  
  mysql_select_db($database);
  
  $query ="SELECT schedule.date_of_departure, schedule.time_of_departure, station.name, station.location, train.type
    FROM schedule
    JOIN train ON schedule.id_train = train.id_train
    JOIN station ON schedule.id_place_of_departure = station.id_station;";
  /*
    $query ="SELECT schedule.date_of_departure, schedule.time_of_departure, station.name, station.location, train.type
    FROM schedule, train, station
    Where schedule.id_train = train.id_train ans schedule.id_place_of_departure = station.id_station;";
  */
  if (mysql_query($query)) {
    echo "Запрос выполнен<br>";
  } else {
    echo "Запрос не выполнен<br>" . mysql_error();
  }
  
  echo "<table border='1'>
  <tr> 
  <th>date_of_departure</th>
  <th>time_of_departure</th>
  <th>name</th>
  <th>location</th>
  <th>type</th>
  </tr>";

  $result = mysql_query($query);
  while($row = mysql_fetch_array($result))  {
    echo "<tr>";
    echo "<td>" . $row['date_of_departure'] . "</td>";
    echo "<td>" . $row['time_of_departure'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "</tr>";
  }  
  
  if(mysql_close($dbh)) {
    echo("Соединение с базой данных прекращено<br>");
  }
  else {
    echo("Не удалось завершить соединение<br>"  . mysql_error());
  }		

  echo('Вот и все)');  
?>