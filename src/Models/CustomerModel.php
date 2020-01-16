<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CustomerModel extends AbstractModel {
  //functions which tells the database to insert a new customer row with the nextmentioned parameters
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
  }

// function which tells the database to update an already existing customer row with the nextmentioned parameters
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

  // function which tells the database to remove an already exisiting row
  public function removeCustomer($customerNumber) {
    // $carsQuery = "SELECT COUNT(*) FROM Cars WHERE customerNumber = :customerNumber";
    // $carsStatement = $this->db->prepare($carsQuery);
    // $carsResult = $carsStatement->execute(["customerNumber" => $customerNumber]);
    // if (!$carsResult) die($this->db->errorInfo()[2]);
    // $carsRows = $carsStatement->fetchAll();
    // $numberOfCars = htmlspecialchars($carsRows[0]["COUNT(*)"]);
    
    // if ($numberOfCars == 0) {

      $bookingQuery = "UPDATE Booking SET customerNumber = NULL, licensePlate = NULL WHERE customerNumber = :customerNumber";
      $bookingStatement = $this->db->prepare($bookingQuery);
      $bookingResult = $bookingStatement->execute(["customerNumber" => $customerNumber]);
      
      $customersQuery = "DELETE FROM Customers WHERE customerNumber = :customerNumber";
      $customersStatement = $this->db->prepare($customersQuery);
      $customersResult = $customersStatement->execute(["customerNumber" => $customerNumber]);
      if (!$customersResult) die($this->db->errorInfo()[2]);
    // }

    // return $numberOfCars;
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
