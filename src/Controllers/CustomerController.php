<?php

namespace Carrental\Controllers;

use Carrental\Exceptions\NotFoundException;
use Carrental\Models\CustomerModel;

class CustomerController extends AbstractController {
  public function addCustomer() {
    return $this->render("AddCustomer.twig", []);
  }
    
  public function customerAdded() {
    $form = $this->request->getForm();
    $customerName = $form["customerName"];
    $customerNumber = $form["customerNumber"];
    $customerAddress = $form["customerAddress"];
    $postalAddress = $form["postalAddress"];
    $phoneNumber = $form["phoneNumber"];
    // // $customerName = $form["customerName"];
    $customerModel = new CustomerModel($this->db);
    $newCustomer = $customerModel->addCustomer($customerNumber, $customerName, $customerAddress, $postalAddress, $phoneNumber);
    // $customerNumber = $customerModel->addCustomer($customerName);
    // $customerAddress = $customerModel->addCustomer($customerName);
    // $postalAddress = $customerModel->addCustomer($customerName);
    // $phoneNumber = $customerModel->addCustomer($customerName);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                  "customerAddress" => $customerAddress,
                "postalAddress" => $postalAddress,
              "phoneNumber" => $phoneNumber];
    return $this->render("CustomerAdded.twig", $properties);
  }    

  public function editCustomer($customerName, $customerAddress, $postalAddress, $phoneNumber) {
    //$customerName = $map["customerName"];
    //$customerNumber = $map["customerNumber"];      
    $properties = [
    "customerName" => $customerName,
   "customerAddress" => $customerAddress,
 "postalAddress" => $postalAddress,
"phoneNumber" => $phoneNumber];  
    return $this->render("EditCustomer.twig", $properties);
  }
    
  public function customerEdited($oldCustomerName, $oldCustomerAddress, $oldPostalAddress, $oldPhoneNumber) {
    $form = $this->request->getForm();
    $newCustomerName = $form["customerName"];
    $newCustomerAddress = $form["customerAddress"];
    $newPostalAddress = $form["postalAddress"];
    $newPhoneNumber = $form["phoneNumber"];
    $customerModel = new CustomerModel($this->db);
    $customerModel->editCustomer($newCustomerName, $newCustomerAddress, $newPostalAddress, $newPhoneNumber);
    $properties = [
                   "oldCustomerName" => $oldCustomerName,
                   "newCustomerName" => $newCustomerName,
                  "oldCustomerAddress" => $oldCustomerAddress,
                "newCustomerAddress" => $newCustomerAddress,
              "oldPostalAddress" => $oldPostalAddress,
            "newPostalAddress" => $newPostalAddress,
          "oldPhoneNumber" => $oldPhoneNumber,
        "newPhoneNumber" => $newPhoneNumber];
    return $this->render("CustomerEdited.twig", $properties);
  }    
    
  public function removeCustomer($customerNumber, $customerName) {
    $customerModel = new CustomerModel($this->db);
    $numberOfAccounts = $customerModel->removeCustomer($customerNumber);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "numberOfAccounts" => $numberOfAccounts];
    return $this->render("CustomerRemoved.twig", $properties);
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
