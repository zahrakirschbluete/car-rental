<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CarModel extends AbstractModel {
  public function addCar($licensePlate, $brand, $colour, $year, $price) {
$carsQuery = "INSERT INTO Cars(licensePlate, brand, colour, year, price) " .
                      "VALUES (:licensePlate, :brand, :colour, :year, :price)";
$carsStatement = $this->db->prepare($carsQuery);
$carsStatement->execute(["licensePlate" => $licensePlate,
    "brand" => $brand,
    "colour" => $colour,
    "year" => $year,
    "price" => $price]);
  }

  public function fetchColours() {
    $colourRows = $this->db->query("SELECT * FROM Colours");
    $colours = [];
    foreach ($colourRows as $colourRow) {
      $colours[] = $colourRow["colour"];
      // var_dump($colourRow);
      
    }
    // var_dump($colours);
    // var_dump($colourRows);
    return $colours;
  }

  public function fetchBrands() {
    $brandRows = $this->db->query("SELECT * FROM Brands");
    $brands = [];
    foreach ($brandRows as $brandRow) {
      $brands[] = $brandRow["brand"];
      // var_dump($colourRow);
      
    }
    // var_dump($colours);
    // var_dump($colourRows);
    return $brands;
  }

  public function fetchCustomers() {
    $customerRows = $this->db->query("SELECT * FROM Customers");
    $customers = [];
    
    foreach ($customerRows as $customerRow) {
      $customers[] = $customerRow;
      var_dump($customerRow["customerName"]);

    }
    return $customers;
  }

  
  public function fetchCars() {
    $carRows = $this->db->query("SELECT * FROM Cars");
    $cars = [];
    
    foreach ($carRows as $carRow) {
      $cars[] = $carRow;

    }
    return $cars;
  }

  public function editCar($licensePlate, $newBrand, $newColour, $newYear, $newPrice) {
$carsQuery = "UPDATE Cars SET brand = :brand, colour = :colour, year = :year, price = :price " . 
                  "WHERE licensePlate = :licensePlate";
$carsStatement = $this->db->prepare($carsQuery);
$carsParameters = ["licensePlate" => $licensePlate,
                            "brand" => $newBrand,
                            "colour" => $newColour,
                          "year" => $newYear,
                        "price" => $newPrice];
                        print_r($carsParameters);
$carsResult = $carsStatement->execute($carsParameters);
    if ($carsResult) die($this->db->errorInfo()[2]);
  }

  public function removeCar($licensePlate) {
    // $accountsQuery = "SELECT COUNT(*) FROM Accounts WHERE customerNumber = :customerNumber";
    // $accountsStatement = $this->db->prepare($accountsQuery);
    // $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // if (!$accountsResult) die($this->db->errorInfo()[2]);
    // $accountsRows = $accountsStatement->fetchAll();
    // $numberOfAccounts = htmlspecialchars($accountsRows[0]["COUNT(*)"]);
    
    // if ($numberOfAccounts == 0) {
    $carsQuery = "DELETE FROM Cars WHERE licensePlate = :licensePlate";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsResult =$carsStatement->execute(["licensePlate" => $licensePlate]);
      if ($carsResult) die($this->db->errorInfo()[2]);
    // }

    // return $numberOfAccounts;
  }  

  public function rentCar($customerNumber, $licensePlate) {

    // var_dump($customerNumber);
    // var_dump($licensePlate);
    $carsQuery = "INSERT INTO Booking(customerNumber, licensePlate) " .
                      "VALUES (:customerNumber, :licensePlate)";
$rentStatement = $this->db->prepare($carsQuery);

// $bookingRows = $this->db->query("SELECT * FROM Booking");

    // if ($carsStatement) die("Fatal error.");
    $properties = [":customerNumber" => $customerNumber,
    ":licensePlate" => $licensePlate];
    // var_dump($properties);
    $result = $rentStatement->execute($properties);
    // print_r($this->db->errorInfo());
    // print_r($rentStatement);
    // var_dump($result);
  $bookingNumber = $this->db->lastInsertId();
  // var_dump($this->db->errorinfo());
  // var_dump($bookingNumber);
  return $bookingNumber;
 
  } 
}
//   public function addAccount($customerNumber) {
//     $accountsQuery = "INSERT INTO Accounts(customerNumber) VALUES(:customerNumber)";
//     $accountsStatement = $this->db->prepare($accountsQuery);
//     $accountsStatement->execute(["customerNumber" => $customerNumber]);
//     if (!$accountsStatement) die($this->db->errorInfo()[2]);
//     $accountNumber = $this->db->lastInsertId();
//     return $accountNumber;
//   }  
// }
