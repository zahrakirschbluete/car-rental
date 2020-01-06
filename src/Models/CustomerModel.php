<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CustomerModel extends AbstractModel {
  public function addCustomer($customerNumber, $customerName, $customerAddress, $postalAddress, $phoneNumber) {
    $customersQuery = "INSERT INTO Customers(customerNumber, customerName, customerAddress, postalAddress, phoneNumber) " .
                      "VALUES (:customerNumber, :customerName, :customerAddress, :postalAddress, :phoneNumber)";
    $customersStatement = $this->db->prepare($customersQuery);
    $customersStatement->execute(["customerNumber" => $customerNumber,
    "customerName" => $customerName,
    "customerAddress" => $customerAddress,
    "postalAddress" => $postalAddress,
    "phoneNumber" => $phoneNumber]);
    if (!$customersStatement) die("Fatal error.");
    //usually you'd use the commented line beneath if the customerNumber was auto incremented, but in this case it's redundant
    // $customerNumber = $this->db->lastInsertId();
    // return $customerNumber;
  }


  public function editCustomer($customerNumber, $newCustomerName, $newCustomerAddress, $newPostalAddress, $newPhoneNumber) {
    $customersQuery = "UPDATE Customers SET customerName = :customerName, customerAddress = :customerAddress, postalAddress = :postalAddress, phoneNumber = :phoneNumber " .
                      "WHERE customerNumber = :customerNumber";
    $customersStatement = $this->db->prepare($customersQuery);
    $customersParameters = ["customerNumber" => $customerNumber,
                            "customerName" => $newCustomerName,
                            "customerAddress" => $newCustomerAddress,
                          "postalAddress" => $newPostalAddress,
                        "phoneNumber" => $newPhoneNumber];
    $customersResult = $customersStatement->execute($customersParameters);
    if (!$customersResult) die($this->db->errorInfo()[2]);
  }

  public function removeCustomer($customerNumber) {
    // $accountsQuery = "SELECT COUNT(*) FROM Accounts WHERE customerNumber = :customerNumber";
    // $accountsStatement = $this->db->prepare($accountsQuery);
    // $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // if (!$accountsResult) die($this->db->errorInfo()[2]);
    // $accountsRows = $accountsStatement->fetchAll();
    // $numberOfAccounts = htmlspecialchars($accountsRows[0]["COUNT(*)"]);
    
    // if ($numberOfAccounts == 0) {
      $customersQuery = "DELETE FROM Customers WHERE customerNumber = :customerNumber";
      $customersStatement = $this->db->prepare($customersQuery);
      $customersResult = $customersStatement->execute(["customerNumber" => $customerNumber]);
      if (!$customersResult) die($this->db->errorInfo()[2]);
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
