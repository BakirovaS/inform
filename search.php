<html>
<body>
	<form action = 'search.php' method = 'get'>
	<table>
	<tr><strong>Enter:</strong></tr>
	<tr><td>Surname: <input name = 'surname' type = 'text' value='<?=@$_GET['surname']?>' ></td></tr>
	<tr><td>Schedule number: <input name = 'schedule' type = 'text' value='<?=@$_GET['schedule']?>' ></td></tr>
	</table>
	<br/>
	<input type = 'submit' name = 'button' value = 'Search'>
	</form>
</body>
</html>

<?php

  include 'connection.php';

  $dbh = mysql_connect($host, $user, $pswd) ;
  if(!$dbh){
    echo ("no connect MySQL." . mysql_error());
    exit();
  }

  
  mysql_select_db($database);
  
  if(isset($_GET['surname']) or isset($_GET['schedule'])) {
    $surname = trim($_GET['surname']);
    $schedule = trim($_GET['schedule']);
      
    $query = "SELECT worker.surname, schedule.id_schedule FROM work_plan
      JOIN worker ON work_plan.id_worker = worker.id_worker
      JOIN schedule ON work_plan.id_schedule = schedule.id_schedule
      WHERE  worker.surname LIKE '%" . $surname . "%' 
      AND schedule.id_schedule LIKE '%" . $schedule. "%' ";

	

    echo "<table border='1'>
    <tr> 
    <th>surname</th>
    <th>schedule</th>
    </tr>";
  
    $result = mysql_query($query);
    while($row = mysql_fetch_array($result))  {
      echo "<tr>";
      echo "<td>" . $row['surname'] . "</td>";
      echo "<td>" . $row['id_schedule'] . "</td>";
      echo "</tr>";
    }  
  }
  
  if(!mysql_close($dbh)) {
    echo("failed<br>"  . mysql_error());
  }		


 
?>
