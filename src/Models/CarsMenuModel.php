<?php

namespace Carrental\Models;

use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CarsMenuModel extends AbstractModel {
  public function carList() {
    $carRows = $this->db->query("SELECT * FROM Cars");
    if (!$carRows) die($this->db->errorInfo());
      
    $cars = [];
    foreach ($carRows as $carRow) {
      $licensePlate = htmlspecialchars($carRow["licensePlate"]);
      $brand = htmlspecialchars($carRow["brand"]);
      $colour = htmlspecialchars($carRow["colour"]);
      $price = htmlspecialchars($carRow["price"]);
      $start = htmlspecialchars($carRow["start"]);
      $end = htmlspecialchars($carRow["end"]);
      $car = ["brand" => $brand,
                   "colour" => $colour,
                  "price" => $price,
                  "start" => $start,
                  "end" => $end];      
        
    //   $accountsQuery = "SELECT * FROM Accounts WHERE customerNumber = :customerNumber";
    //   $accountsStatement = $this->db->prepare($accountsQuery);
    //   $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // //   if (!$accountsResult) die($this->db->errorInfo());
    //   $accountsRows = $accountsStatement->fetchAll();

    //   $accounts = [];
    //   foreach ($accountsRows as $accountRow) {
    //     $accountNumber = htmlspecialchars($accountRow["accountNumber"]);
    //     $account = ["accountNumber" => $accountNumber];
        
    //     $balanceQuery = "SELECT SUM(amount) FROM Events WHERE accountNumber = :accountNumber";
    //     $balanceStatement = $this->db->prepare($balanceQuery);
    //     $balanceResult = $balanceStatement->execute(["accountNumber" => $accountNumber]);
    //     if (!$balanceResult) die($this->db->errorInfo());

    //     $balanceRows = $balanceStatement->fetchAll();
    //     $accountBalance = htmlspecialchars($balanceRows[0]["SUM(amount)"]);
        
    //     if ($accountBalance === "") {
    //       $accountBalance = "0";
    //     }

    //     $account["accountBalance"] = $accountBalance;
    //     $accounts[] = $account;
    //   }

    //   $customer["accounts"] = $accounts;
      $cars[] = $car;
    }
      
    return $cars;
  }
}
