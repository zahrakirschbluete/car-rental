<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class MainMenuModel extends AbstractModel {
  public function customerList() {
    $customerRows = $this->db->query("SELECT * FROM Customers");
    if (!$customerRows) die($this->db->errorInfo());
      
    $customers = [];
    foreach ($customerRows as $customerRow) {
      $customerNumber = htmlspecialchars($customerRow["customerNumber"]);
      $customerName = htmlspecialchars($customerRow["customerName"]);
      $customerAddress = htmlspecialchars($customerRow["customerAddress"]);
      $postalAddress = htmlspecialchars($customerRow["postalAddress"]);
      $phoneNumber = htmlspecialchars($customerRow["phoneNumber"]);
      $customer = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                  "customerAddress" => $customerAddress,
                "postalAddress" => $postalAddress,
              "phoneNumber" => $phoneNumber
            ];    
        
      $accountsQuery = "SELECT * FROM Accounts WHERE customerNumber = :customerNumber";
      $accountsStatement = $this->db->prepare($accountsQuery);
      $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
      if (!$accountsResult) die($this->db->errorInfo());
      $accountsRows = $accountsStatement->fetchAll();

      $accounts = [];
      foreach ($accountsRows as $accountRow) {
        $accountNumber = htmlspecialchars($accountRow["accountNumber"]);
        $account = ["accountNumber" => $accountNumber];
        
        $balanceQuery = "SELECT SUM(amount) FROM Events WHERE accountNumber = :accountNumber";
        $balanceStatement = $this->db->prepare($balanceQuery);
        $balanceResult = $balanceStatement->execute(["accountNumber" => $accountNumber]);
        if (!$balanceResult) die($this->db->errorInfo());

        $balanceRows = $balanceStatement->fetchAll();
        $accountBalance = htmlspecialchars($balanceRows[0]["SUM(amount)"]);
        
        if ($accountBalance === "") {
          $accountBalance = "0";
        }

        $account["accountBalance"] = $accountBalance;
        $accounts[] = $account;
      }

      $customer["accounts"] = $accounts;
      $customers[] = $customer;
    }
      
    return $customers;
  }
}
