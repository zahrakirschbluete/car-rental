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
    // if ($carsStatement) die("Fatal error.");
    //usually you'd use the commented line beneath if the customerNumber was auto incremented, but in this case it's redundant
    // $customerNumber = $this->db->lastInsertId();
    // return $customerNumber;
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


  public function editCar($licensePlate, $newBrand, $newColour, $newYear, $newPrice, $start) {
$carsQuery = "UPDATE SET brand = :brand, colour = :colour, year = :year, price = :price, start = :start " .
                      "WHERE licensePlate = :licensePlate";
$carsStatement = $this->db->prepareQuery;
$carsParameters = ["licensePlate" => $licensePlate,
                            "brand" => $newBrand,
                            "colour" => $newColour,
                          "year" => $newYear,
                        "price" => $newPrice,
                    "start" => $start];
$carsResult =$carsStatement->executeParameters;
    if ($carsResult) die($this->db->errorInfo()[2]);
  }

  public function removeCustomer($customerNumber) {
    // $accountsQuery = "SELECT COUNT(*) FROM Accounts WHERE customerNumber = :customerNumber";
    // $accountsStatement = $this->db->prepare($accountsQuery);
    // $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // if (!$accountsResult) die($this->db->errorInfo()[2]);
    // $accountsRows = $accountsStatement->fetchAll();
    // $numberOfAccounts = htmlspecialchars($accountsRows[0]["COUNT(*)"]);
    
    // if ($numberOfAccounts == 0) {
    $carsQuery = "DELETE FROM WHERE customerNumber = :customerNumber";
    $carsStatement = $this->db->prepareQuery;
    $carsResult =$Statement->execute(["customerNumber" => $customerNumber]);
      if ($carsResult) die($this->db->errorInfo()[2]);
    // }

    // return $numberOfAccounts;
  }  

  public function addAccount($customerNumber) {
    $accountsQuery = "INSERT INTO Accounts(customerNumber) VALUES(:customerNumber)";
    $accountsStatement = $this->db->prepare($accountsQuery);
    $accountsStatement->execute(["customerNumber" => $customerNumber]);
    if (!$accountsStatement) die($this->db->errorInfo()[2]);
    $accountNumber = $this->db->lastInsertId();
    return $accountNumber;
  }  
}
