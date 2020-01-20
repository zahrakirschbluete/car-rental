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

  public function removeCustomer($customerNumber) {
      $bookingQuery = "UPDATE Booking SET customerNumber = NULL, licensePlate = NULL " . 
      "WHERE customerNumber = :customerNumber";
      $bookingStatement = $this->db->prepare($bookingQuery);
      $bookingResult = $bookingStatement->execute(["customerNumber" => $customerNumber]);
      if (!$bookingResult) die($this->db->errorInfo()[2]);

      $customersQuery = "DELETE FROM Customers " . 
      "WHERE customerNumber = :customerNumber";
      $customersStatement = $this->db->prepare($customersQuery);
      $customersResult = $customersStatement->execute(["customerNumber" => $customerNumber]);
      if (!$customersResult) die($this->db->errorInfo()[2]);

  }  

}
