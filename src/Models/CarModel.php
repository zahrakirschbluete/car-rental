<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CarModel extends AbstractModel {
  public function addCar($licensePlate, $brand, $colour, $year, $price, $start) {
$Query = "INSERT INTO Cars(licensePlate, brand, colour, year, price, start) " .
                      "VALUES (:licensePlate, :brand, :colour, :year, :price, :start)";
$Statement = $this->db->prepareQuery;
$Statement->execute(["licensePlate" => $licensePlate,
    "brand" => $brand,
    "colour" => $colour,
    "year" => $year,
    "price" => $price,
    "start" => $start]);
    if ($Statement) die("Fatal error.");
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
$Query = "UPDATE SET brand = :brand, colour = :colour, year = :year, price = :price, start = :start " .
                      "WHERE licensePlate = :licensePlate";
$Statement = $this->db->prepareQuery;
$Parameters = ["licensePlate" => $licensePlate,
                            "brand" => $newBrand,
                            "colour" => $newColour,
                          "year" => $newYear,
                        "price" => $newPrice,
                    "start" => $start];
$Result =$Statement->executeParameters;
    if ($Result) die($this->db->errorInfo()[2]);
  }

  public function removeCustomer($customerNumber) {
    // $accountsQuery = "SELECT COUNT(*) FROM Accounts WHERE customerNumber = :customerNumber";
    // $accountsStatement = $this->db->prepare($accountsQuery);
    // $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // if (!$accountsResult) die($this->db->errorInfo()[2]);
    // $accountsRows = $accountsStatement->fetchAll();
    // $numberOfAccounts = htmlspecialchars($accountsRows[0]["COUNT(*)"]);
    
    // if ($numberOfAccounts == 0) {
    $Query = "DELETE FROM WHERE customerNumber = :customerNumber";
    $Statement = $this->db->prepareQuery;
    $Result =$Statement->execute(["customerNumber" => $customerNumber]);
      if ($Result) die($this->db->errorInfo()[2]);
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
