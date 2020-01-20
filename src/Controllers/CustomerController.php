<?php

namespace Carrental\Controllers;

use Carrental\Exceptions\NotFoundException;
use Carrental\Models\CustomerModel;

class CustomerController extends AbstractController
{
  public function addCustomer()
  {
    return $this->render("AddCustomer.twig", []);
  }

  //function which picks up information from the form, sends it to the CustomerModel which in turn will store the information in the database.
  //Once this is done, the function will return this data to the view "CustomerAdded"
  public function customerAdded()
  {
    $form = $this->request->getForm();
    $customerName = $form["customerName"];
    $customerNumber = $form["customerNumber"];
    $customerAddress = $form["customerAddress"];
    $postalAddress = $form["postalAddress"];
    $phoneNumber = $form["phoneNumber"];

    $customerModel = new CustomerModel($this->db);
    $newCustomer = $customerModel->addCustomer($customerNumber, $customerName, $customerAddress, $postalAddress, $phoneNumber);

    $properties = [
      "customerNumber" => $customerNumber,
      "customerName" => $customerName,
      "customerAddress" => $customerAddress,
      "postalAddress" => $postalAddress,
      "phoneNumber" => $phoneNumber
    ];
    return $this->render("CustomerAdded.twig", $properties);
  }

  //function which enables the user to edit the customer information by returning the existing information to the view EditCustomer
  public function editCustomer($customerNumber, $customerName, $customerAddress, $postalAddress, $phoneNumber)
  {   
    $properties = [
      "customerNumber" => $customerNumber,
      "customerName" => $customerName,
      "customerAddress" => $customerAddress,
      "postalAddress" => $postalAddress,
      "phoneNumber" => $phoneNumber
    ];
    return $this->render("EditCustomer.twig", $properties);
  }

  //function which will pick up the updated information from the edit form and tell the CustomerModel to store the datat
  public function customerEdited($customerNumber, $oldCustomerName, $oldCustomerAddress, $oldPostalAddress, $oldPhoneNumber)
  {
    $form = $this->request->getForm();
    $newCustomerName = $form["customerName"];
    $newCustomerAddress = $form["customerAddress"];
    $newPostalAddress = $form["postalAddress"];
    $newPhoneNumber = $form["phoneNumber"];
    $customerModel = new CustomerModel($this->db);
    $customerModel->editCustomer($customerNumber, $newCustomerName, $newCustomerAddress, $newPostalAddress, $newPhoneNumber);
    $properties = [
      "customerNumber" => $customerNumber,
      "oldCustomerName" => $oldCustomerName,
      "newCustomerName" => $newCustomerName,
      "oldCustomerAddress" => $oldCustomerAddress,
      "newCustomerAddress" => $newCustomerAddress,
      "oldPostalAddress" => $oldPostalAddress,
      "newPostalAddress" => $newPostalAddress,
      "oldPhoneNumber" => $oldPhoneNumber,
      "newPhoneNumber" => $newPhoneNumber
    ];
    var_dump($form);
    var_dump($properties);
    return $this->render("CustomerEdited.twig", $properties);
  }

  public function removeCustomer($customerNumber) {
    $customerModel = new CustomerModel($this->db);
    $customerModel = $customerModel->removeCustomer($customerNumber);
    $properties = ["customerNumber" => $customerNumber];
    return $this->render("CustomerRemoved.twig", $properties);
  }
}
