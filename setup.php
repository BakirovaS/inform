<?php

  
  require_once 'connection.php';
 
  $dbh = mysql_connect($host, $user, $pswd) ;
  if(!$dbh){
    echo ("Не могу соединиться с MySQL." . mysql_error());
    exit();
  }
  echo("Соединение с базой данных установлено<br>");

  function create_table($query) {
    if(mysql_query($query)) {
        echo ('Таблица создана<br>');
    }
    else {
        echo ('Ошибка в создании таблицы  ' . mysql_error());
        exit();
    }
  }

  function insert_table($query) {
    if(mysql_query($query)) {
        echo ('Таблица заполнена<br>');
    }
    else {
        echo ('Ошибка в заполнении таблицы ' . mysql_error());
        exit();
    }
  }

	$query = 'create database '.$database;
  if(mysql_query($query, $dbh)) {
    echo ('База данных создана<br>');
  }
  else {
    echo ('Ошибка в создании базы данных ' . mysql_error());
    exit();
  }

  $query = 'use '.$database;
  if(mysql_query($query, $dbh)) {
    echo ('База данных используется<br>');
  }
  else {
    echo ('Ошибка в использовании базы данных ' . mysql_error());
    exit();
  }
  
  $query = "create table passenger (
  id_passenger int(11) auto_increment,
  surname varchar(255) not null,
  name varchar(255) not null,
  passport varchar(255) not null,
  PRIMARY KEY (id_passenger)
  );";
	create_table($query);

  $query = "create table train (
  id_train int(11) auto_increment,
  type varchar(255) not null,
  speed varchar(255) null,
  PRIMARY KEY (id_train)
  );";
	create_table($query);

  $query = "create table carriage (
  id_carriage int(11) auto_increment,
  type varchar(255) not null,
  id_train int(11),
  PRIMARY KEY (id_carriage),
  FOREIGN KEY (id_train) REFERENCES train (id_train)
  );";
	create_table($query);
	
	$query = "create table station (
  id_station int(11) auto_increment,
  name varchar(255) not null,
  location varchar(255) not null,
  PRIMARY KEY (id_station)
  );";
	create_table($query);   
	
	$query = "create table schedule (
  id_schedule int(11) auto_increment,
  id_train int(11) not null,
  date_of_departure date not null,
  time_of_departure time not null,
  id_place_of_departure int(11) not null,
  date_of_arrival date not null,
  time_of_arrival time not null,
  id_place_of_arrival int(11) not null,
  PRIMARY KEY (id_schedule),
  FOREIGN KEY (id_train) REFERENCES train (id_train),
  FOREIGN KEY (id_place_of_departure) REFERENCES station (id_station),
  FOREIGN KEY (id_place_of_arrival) REFERENCES station (id_station)
  );";
	create_table($query);
	
	$query = "create table ticket (
  id_ticket int(11) auto_increment,
  id_passenger int(11) null,
  id_schedule int(11) not null,
  cost int(11) not null,
  seat int(11) not null,
  carriage int(11) not null,
  PRIMARY KEY (id_ticket),
  FOREIGN KEY (id_passenger) REFERENCES passenger (id_passenger),
  FOREIGN KEY (id_schedule) REFERENCES schedule (id_schedule)
  );";
  create_table($query);   
  
  $query = "create table worker (
  id_worker int(11) auto_increment,
  surname varchar(255) not null,
  name varchar(255) not null,
  position varchar(255) not null,
  date_of_birth date not null,
  passport varchar(255) not null,
  phone_number varchar(255),
  PRIMARY KEY (id_worker)
  );";
  create_table($query); 
    
  $query = "create table work_plan (
  id_schedule int(11),
  id_worker int(11),
  FOREIGN KEY (id_schedule) REFERENCES schedule (id_schedule),
  FOREIGN KEY (id_worker) REFERENCES worker (id_worker)
  );";  
  create_table($query);   

	$query = "INSERT INTO passenger (surname, name, passport) VALUES
  ('Kozlova', 'Daria', '1234988776'),
  ('Nekiforov','Sergei','7645873498'),
  ('Chernousov','Kirill','7645873498'),
  ('Kim','Anna','7634872398'),
  ('Ton','Inna','7645873498'),
  ('Zhukova','Daria','7645873498'),
  ('Sergeev','Anton','8734982309'),
  ('Prokophieva','Anna','8734983244')
  ;";
	insert_table($query);
	
	$query = "INSERT INTO train (type, speed) VALUES
  ('passengers',''),
  ('passengers','fast'),
  ('cargo-passenger','high-speed'),
  ('cargo',''),
  ('cargo and luggage','fast')
  ;";
	insert_table($query);

	$query = "INSERT INTO carriage (type, id_train) VALUES
  ('compartment', '1'),
  ('compartment', '1'),
  ('compartment', '2'),
  ('compartment', '2'),
  ('compartment', '2'),
  ('reserved seat', '1'),
  ('reserved seat', '1'),
  ('reserved seat', '1'),
  ('reserved seat', '1'),
  ('reserved seat', '2'),
  ('reserved seat', '2'),
  ('reserved seat', '3'),
  ('reserved seat', '3'),
  ('luggage', '3'),  
  ('luggage', '3'),
  ('luggage', '5'),
  ('luggage', '5'),
  ('tank waggon', '4'),
  ('tank waggon', '4'),
  ('tank waggon', '5'),
  ('wagon-thermos', '4'),
  ('wagon-thermos', '4')
  ;";
	insert_table($query);		
	
	$query = "INSERT INTO station (name, location) VALUES
  ('Ladozhsky Railway Station','St. Petersburg'),
  ('Vitebsk railway station','St. Petersburg'),
  ('Moscow station','St. Petersburg'),
  ('Leningrad Station','Moscow'),
  ('Kiev railway station','Moscow'),
  ('Kursky Railway Station','Moscow'),
  ('railway station of Kazan','Kazan'),
  ('train station Sochi','Sochi')
  ;";
	insert_table($query);		
	
	$query = "INSERT INTO schedule (id_train, date_of_departure, time_of_departure, id_place_of_departure, date_of_arrival, time_of_arrival, id_place_of_arrival) VALUES
  ('1', '2018-01-01', '20:20:00', '1', '2018-01-02', '06:00:00', '5'),
  ('2', '2018-03-01', '06:20:00', '4', '2018-03-01', '11:00:00', '3'),
  ('3', '2018-04-01', '08:00:00', '2', '2018-04-01', '11:00:00', '6'),
  ('4', '2018-01-01', '20:20:00', '1', '2018-01-02', '06:00:00', '8'),
  ('5', '2018-01-01', '20:20:00', '7', '2018-01-02', '06:00:00', '8')
  ;";
	insert_table($query);	
	
	$query = "INSERT INTO ticket (id_passenger, id_schedule, cost, seat, carriage) VALUES
  ('1', '1', '560', '1', '1'),
  ('2', '1', '120', '1', '2'),
  ('3', '1', '120', '2', '2'),
  ('4', '1', '560', '4', '4'),
  ('5', '2', '560', '5', '4'),
  ('6', '2', '560', '3', '1'),
  ('7', '3', '560', '4', '1'),
  ('8', '3', '560', '5', '1')
  ;";
	insert_table($query);	
	
	$query = "INSERT INTO worker (surname, name, position, date_of_birth, passport, phone_number) VALUES
  ('Matviyenko', 'Sergei', 'driver', '1996-01-01', '4556677889', '89677865645'),
  ('Poroshenko', 'Denis', 'driver', '1970-09-12', '6734782398', '89566784534'),
  ('Ivanova', 'Larissa', 'conductor', '1980-10-04', '9823913489', '89249878734'),
  ('Nosikov', 'Artur', 'conductor', '1981-09-12', '8967876323', '89678763423'),
  ('Shin', 'Kirill', 'driver', '1990-08-08', '5634762387', '89788767656'),
  ('Ton','Tatiana','conductor', '1970-08-08', '5634762387', ''),
  ('Zhukova','Daria','driver', '1979-08-08', '5634762387', ''),
  ('Sergeer','Anton','driver', '1980-08-08', '5634762387', '8734982309')
  ;";
	insert_table($query);	
	
	$query = "INSERT INTO work_plan (id_schedule, id_worker) VALUES
  ('1', '1'),
  ('1', '3'),
  ('2','2'),
  ('2','4'),
  ('2','6'),
  ('3','5'),
  ('4','7'),
  ('5','8')
  ;";
	insert_table($query);	
		
	if(mysql_close($dbh)) {
    echo("Соединение с базой данных прекращено<br>");
  }
  else {
    echo("Не удалось завершить соединение"  . mysql_error());
  }		

  echo('Вот и все)');
  
?>