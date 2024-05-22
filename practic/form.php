<?php 
   $host = 'localhost'; // адрес сервера
   $db_name = 'u67277'; // имя базы данных
   $user = 'u67277'; // имя пользователя
   $password = '7133721'; // пароль

   // создание подключения к базе   
      $connection = mysqli_connect($host, $user, $password, $db_name);
      $opt = $_POST['options'];
      
     

      if ($opt=="1") {
        if (isset($_POST['index'])) {
            $index = $_POST['index']; // Получаем значение индекса издания из формы
        
            // Запрос к базе данных для получения информации об издании с заданным индексом
            $query = "SELECT * FROM car
            WHERE model_car = 'Toyota Corolla'";/*
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $index); // Привязываем значение индекса к параметру запроса
            $stmt->execute();
            $result = $stmt->get_result();*/
            $result = mysqli_query($connection, $query);
            // Выводим информацию об издании в виде таблицы
            if (!empty($result)) {
                while($row = $result->fetch_assoc()){
                    echo  $row['id_car'] . ' - ' . $row['model_car']. ' - ' . $row['color_car'] . ' - ' . $row['year_car'] . ' - ' . $row['nomer_car'] . ' - ' . $row['insurance_car'] . ' - ' . $row['price_day_car'] ."<br>";
                  }
            } else {
                echo "Not found this mark.";
            }
        
          }
        
      }
      if ($opt=="2") {
        if (isset($_POST['index'])) {
            $index = $_POST['index']; // Получаем значение индекса издания из формы
        
            // Запрос к базе данных для получения информации об издании с заданным индексом
            $query = "SELECT * FROM car WHERE year_car < ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $index); // Привязываем значение индекса к параметру запроса
            $stmt->execute();
            $result = $stmt->get_result();
            // Выводим информацию об издании в виде таблицы
            if (!empty($result)) {
                while($row = $result->fetch_assoc()){
                    echo  $row['id_car'] . ' - ' . $row['model_car']. ' - ' . $row['color_car'] . ' - ' . $row['year_car'] . ' - ' . $row['nomer_car'] . ' - ' . $row['insurance_car'] . ' - ' . $row['price_day_car'] ."<br>";
                  }
            } else {
                echo "Not found car before this year.";
            }
        
            $stmt->close();
        }
       
      }
      if ($opt=="3") {
        if (isset($_POST['index'])) {
          $index = $_POST['index']; // Получаем значение индекса издания из формы
        
            // Запрос к базе данных для получения информации об издании с заданным индексом
            $query = "SELECT * FROM car
            WHERE model_car = ? AND year_car > 2020";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $index); // Привязываем значение индекса к параметру запроса
            $stmt->execute();
            $result = $stmt->get_result();
            // Выводим информацию об издании в виде таблицы
            if (!empty($result)) {
                while($row = $result->fetch_assoc()){
                    echo  $row['id_car'] . ' - ' . $row['model_car']. ' - ' . $row['color_car'] . ' - ' . $row['year_car'] . ' - ' . $row['nomer_car'] . ' - ' . $row['insurance_car'] . ' - ' . $row['price_day_car'] ."<br>";
                  }
            } else {
                echo "No publication found with this index.";
            }
        
            $stmt->close();
        }      
       
      }
      if ($opt=="4") {
        if (isset($_POST['index'])) {
            $index = $_POST['index']; // Получаем значение индекса издания из формы
        
            // Запрос к базе данных для получения информации об издании с заданным индексом
            $query = "SELECT * FROM car
            WHERE nomer_car = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $index); // Привязываем значение индекса к параметру запроса
            $stmt->execute();
            $result = $stmt->get_result();
            // Выводим информацию об издании в виде таблицы
            if (!empty($result)) {
                while($row = $result->fetch_assoc()){
                    echo  $row['id_car'] . ' - ' . $row['model_car']. ' - ' . $row['color_car'] . ' - ' . $row['year_car'] . ' - ' . $row['nomer_car'] . ' - ' . $row['insurance_car'] . ' - ' . $row['price_day_car'] ."<br>";
                  }
            } else {
                echo "Not found car before this year.";
            }
        
            $stmt->close();
        }
      }
      if ($opt=="5") {        
          $low = $_POST['rangelow'];
          $hight = $_POST['rangehight'];
      
          // Запрос к базе данных для получения информации об издании с заданным индексом
          $query = "SELECT c.name_client AS ClientName, 
          ca.model_car AS CarModel, 
          ca.nomer_car AS CarNumber, 
          p.start_day AS RentalStartDate
          FROM client c
          JOIN prokat p ON c.id_client = p.id_client
          JOIN car ca ON p.id_car = ca.id_car
          WHERE p.start_day BETWEEN = ? AND = ?";
          $stmt = $connection->prepare($query);
          $stmt->bind_param("ii", $low,$hight); // Привязываем значение индекса к параметру запроса
          $stmt->execute();
          $result = $stmt->get_result();
          // Выводим информацию об издании в виде таблицы
          if (!empty($result)) {
            while($row = $result->fetch_assoc()){
              echo  $row['ClientName'] . ' - ' . $row['CarModel'] . ' - ' . $row['CarNumber'] . ' - ' . $row['RentalStartDate']  . "<br>";
            }
          } else {
              echo "Not found prokat.";
          }
      
          $stmt->close();
      }      
      if ($opt==6) {
        // текст SQL запроса, который будет передан базе
        $query = "SELECT 
        ca.nomer_car AS CarNumber, 
        ca.model_car AS CarModel, 
        p.start_day AS RentalStartDate, 
        p.count_day AS RentalDays, 
        ca.price_day_car AS PriceDayCar,
        ca.price_day_car * p.count_day AS TotalRentalCost
    FROM 
        car ca
    JOIN 
        prokat p ON ca.id_car = p.id_car";
        
         // выполняем запрос к базе данных
        $result = mysqli_query($connection, $query);

        // выводим полученные данные
        while($row = $result->fetch_assoc()){
          echo  $row['CarNumber'] . ' - ' . $row['CarModel'] . ' - ' . $row['RentalStartDate'] . ' - ' . $row['PriceDayCar'] . ' - ' . $row['RentalDays'] . ' - ' . $row['TotalRentalCost']  . "<br>";
        }
      }
      if ($opt==7) {
       // текст SQL запроса, который будет передан базе
       $query = "SELECT 
       model_car, 
       AVG(insurance_car) AS AverageInsuranceCost
   FROM 
       car
   GROUP BY 
       model_car";
        
       // выполняем запрос к базе данных
      $result = mysqli_query($connection, $query);

      // выводим полученные данные
      while($row = $result->fetch_assoc()){
        echo  $row['model_car'] . ' - ' . $row['AverageInsuranceCost'] . "<br>";
      }
      }
      if ($opt==8) {
       // текст SQL запроса, который будет передан базе
       $query = "SELECT year_car, 
       MIN(price_day_car) AS MinDailyRentPrice, 
       MAX(price_day_car) AS MaxDailyRentPrice
   FROM 
       car
   GROUP BY 
       year_car";
        
       // выполняем запрос к базе данных
      $result = mysqli_query($connection, $query);

      // выводим полученные данные
      while($row = $result->fetch_assoc()){
        echo $row['year_car'] . ' - ' . $row['MinDailyRentPrice']. ' - ' . $row['MaxDailyRentPrice'] . "<br>";
      }
      }
      // закрываем соединение с базой
      mysqli_close($connection);
      ?>