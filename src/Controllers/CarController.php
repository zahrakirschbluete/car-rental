<?php

namespace Carrental\Controllers;
use Carrental\Exceptions\NotFoundException;
use Carrental\Models\CarModel;

class CarController extends AbstractController {
  public function addCar() {
    return $this->render("AddCar.twig", []);
  }
    
  public function carAdded() {
    $form = $this->request->getForm();
    $licensePlate = $form["licensePlate"];
    $brand = $form["brand"];
    $colour = $form["colour"];
    $year = $form["year"];
    $price = $form["price"];
    $start = $form["start"];
    // // $customerName = $form["customerName"];
    $carModel = new CarModel($this->db);
    $newCar = $carModel->addCar($licensePlate, $brand, $colour, $year, $price, $start);
    // $customerNumber = $customerModel->addCustomer($customerName);
    // $customerAddress = $customerModel->addCustomer($customerName);
    // $postalAddress = $customerModel->addCustomer($customerName);
    // $phoneNumber = $customerModel->addCustomer($customerName);
    $properties = ["licensePlate" => $licensePlate,
                   "brand" => $brand,
                  "colour" => $colour,
                "year" => $year,
                "price" => $price,
              "start" => $start];
    return $this->render("CarAdded.twig", $properties);
  }    

  public function editCar($customerNumber, $customerName, $customerAddress, $postalAddress, $phoneNumber) {
    //$customerName = $map["customerName"];
    //$customerNumber = $map["customerNumber"];      
    $properties = ["customerNumber" => $customerNumber,
    "customerName" => $customerName,
   "customerAddress" => $customerAddress,
 "postalAddress" => $postalAddress,
"phoneNumber" => $phoneNumber];  
    return $this->render("EditCar.twig", $properties);
  }
    
  public function carEdited($customerNumber, $oldCustomerName, $oldCustomerAddress, $oldPostalAddress, $oldPhoneNumber) {
    $form = $this->request->getForm();
    $newCustomerName = $form["customerName"];
    $newCustomerAddress = $form["customerAddress"];
    $newPostalAddress = $form["postalAddress"];
    $newPhoneNumber = $form["phoneNumber"];
    $carModel = new CarModel($this->db);
    $carModel->editCar($customerNumber, $newCustomerName, $newCustomerAddress, $newPostalAddress, $newPhoneNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "oldCustomerName" => $oldCustomerName,
                   "newCustomerName" => $newCustomerName,
                  "oldCustomerAddress" => $oldCustomerAddress,
                "newCustomerAddress" => $newCustomerAddress,
              "oldPostalAddress" => $oldPostalAddress,
            "newPostalAddress" => $newPostalAddress,
          "oldPhoneNumber" => $oldPhoneNumber,
        "newPhoneNumber" => $newPhoneNumber];
    return $this->render("CarEdited.twig", $properties);
  }    
    
  public function removeCar($customerNumber, $customerName) {
    $carModel = new CarModel($this->db);
    $numberOfAccounts = $carModel->removeCar($customerNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "numberOfAccounts" => $numberOfAccounts];
    return $this->render("CarRemoved.twig", $properties);
  }

  public function addAccount($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $accountNumber = $customerModel->addAccount($customerNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return $this->render("AccountAdded.twig", $properties);
  }
}
