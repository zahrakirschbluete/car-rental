<?php

namespace Carrental\Models;

use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CarsMenuModel extends AbstractModel {
  public function carList() {
    // $carRows = $this->db->query("SELECT  from Cars left outer join Booking on Cars.licensePlate = Booking.licensePlate");
    $carRows = $this->db->query("SELECT * FROM Cars");
    $brandRows = $this->db->query("SELECT * FROM Brands");
    // $customerRows = $this->db->query("SELECT * FROM Cars join Customers WHERE Cars.customerNumber = Customers.customerNumber");
    if (!$carRows) die($this->db->errorInfo());
    if (!$brandRows) die($this->db->errorInfo());
      
    $cars = [];

    
    foreach ($carRows as $carRow) {
      $licensePlate = htmlspecialchars($carRow["licensePlate"]);
      $brand = htmlspecialchars($carRow["brand"]);
      $colour = htmlspecialchars($carRow["colour"]);
      $year = htmlspecialchars($carRow["year"]);
      $price = htmlspecialchars($carRow["price"]);
      $customerNumber = htmlspecialchars($carRow["customerNumber"]);
      $start = htmlspecialchars($carRow["start"]);
      $statusQuery = "SELECT * FROM Cars where start = :start";
      $statusStatement = $this->db->prepare($statusQuery);
      $statusResult = $statusStatement->execute(["start" => $start]);
      $statusRows = $statusStatement->fetchAll();
      $status = [];
      foreach ($statusRows as $statusRow) {
        $statusRented = htmlspecialchars($carRow["statusRented"]);

        $status = ["statusRented" => $statusRented];
      }

      $statusRented = $status["statusRented"] ?? "";
      $car = ["licensePlate" => $licensePlate,
                  "brand" => $brand,
                   "colour" => $colour,
                   "year" => $year,
                  "price" => $price,
                  "customerNumber" => $customerNumber,
                  "start" => $start,
                "statusRented" => $statusRented];      
      $cars[] = $car;
    }
      
    return $cars;
  }
}


    // SELECT Cars.licensePlate as license, 
    // Cars.brand ,  
    // colour,  
    // year , 
    // price,  
    // Booking.customerNumber , 

      
    //   bookingNumber , 
 
    //   start,  
    //   end 
    //   from Cars left join Booking on Cars.licensePlate = Booking.licensePlate
      
    //   where Booking.end IS NULL;
