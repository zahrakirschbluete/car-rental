<?php

namespace Carrental\Controllers;

use Carrental\Exceptions\NotFoundException;
use Carrental\Models\CarModel;

class CarController extends AbstractController
{
  public function addCar()
  {
    $CarModel = new CarModel($this->db);
    $fetchColours = $CarModel->fetchColours();
    $fetchBrands = $CarModel->fetchBrands();
    return $this->render("AddCar.twig", ["colours" => $fetchColours, "brands" => $fetchBrands]);
  }

  public function carAdded()
  {
    $form = $this->request->getForm();
    $licensePlate = $form["licensePlate"];
    $brand = $form["brand"];
    $colour = $form["colour"];
    $year = $form["year"];
    $price = $form["price"];
    $carModel = new CarModel($this->db);
    $newCar = $carModel->addCar($licensePlate, $brand, $colour, $year, $price);
    $properties = [
      "licensePlate" => $licensePlate,
      "brand" => $brand,
      "colour" => $colour,
      "year" => $year,
      "price" => $price
    ];
    return $this->render("CarAdded.twig", $properties);
  }

  public function editCar($licensePlate, $brand, $colour, $year, $price)
  {
    $CarModel = new CarModel($this->db);
    $fetchColours = $CarModel->fetchColours();
    $fetchBrands = $CarModel->fetchBrands();
    $properties = [
      "licensePlate" => $licensePlate,
      "brands" => $fetchBrands,
      "colours" => $fetchColours,
      "brand" => $brand,
      "colour" => $colour,
      "year" => $year,
      "price" => $price
    ];
    return $this->render("EditCar.twig", $properties);
  }

  public function carEdited($licensePlate, $oldBrand, $oldColour, $oldYear, $oldPrice)
  {
    $form = $this->request->getForm();
    $newBrand = $form["brand"] ?? $oldBrand;
    $newColour = $form["colour"] ?? $oldColour;
    $newYear = $form["year"];
    $newPrice = $form["price"];
    $carModel = new CarModel($this->db);
    $carModel->editCar($licensePlate, $newBrand, $newColour, $newYear, $newPrice);
    $properties = [
      "licensePlate" => $licensePlate,
      "oldBrand" => $oldBrand,
      "newBrand" => $newBrand,
      "oldColour" => $oldColour,
      "newColour" => $newColour,
      "oldYear" => $oldYear,
      "newYear" => $newYear,
      "oldPrice" => $oldPrice,
      "newPrice" => $newPrice
    ];
    return $this->render("CarEdited.twig", $properties);
  }



  public function removeCar($licensePlate, $brand)
  {
    $carModel = new CarModel($this->db);
    $numberOfCars = $carModel->removeCar($licensePlate);
    $properties = [
      "licensePlate" => $licensePlate,
      "brand" => $brand
    ];
    return $this->render("CarRemoved.twig", $properties);
  }

  public function rentCar()
  {
    $carModel = new CarModel($this->db);
    $fetchCustomers = $carModel->fetchCustomers();
    // $fetchRentedCars = $carModel->fetchRentedCars();
    $fetchCars = $carModel->fetchCars();
    $properties = ["customers" => $fetchCustomers, "cars" => $fetchCars];
    return $this->render("RentCar.twig", $properties);
  }

  public function carRented()
  {
    $form = $this->request->getForm();
    $licensePlate = $form["licensePlate"];
    $customerNumber = $form["customerNumber"];
    $carModel = new CarModel($this->db);
    $carRented = $carModel->rentCar($customerNumber, $licensePlate);
    $properties = ["licensePlate" => $licensePlate, "customerNumber" => $customerNumber];
    return $this->render("CarRented.twig", $properties);
  }

  public function returnCar()
  {
    $carModel = new CarModel($this->db);
    $fetchRentedCars = $carModel->fetchRentedCars();
    $fetchCars = $carModel->fetchCars();
    $properties = ["rentedCars" => $fetchRentedCars];
    return $this->render("ReturnCar.twig", $properties);
  }

  public function carReturned()
  {
    $form = $this->request->getForm();
    $licensePlate = $form["licensePlate"];
    $carModel = new CarModel($this->db);
    $carRented = $carModel->returnCar($licensePlate);
    $properties = ["licensePlate" => $licensePlate];
    return $this->render("CarReturned.twig", $properties);
  }
}

