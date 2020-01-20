<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CarModel extends AbstractModel
{
  //function which inserts a new car row in the Cars table with the mentioned values
  public function addCar($licensePlate, $brand, $colour, $year, $price)
  {
    $carsQuery = "INSERT INTO Cars(licensePlate, brand, colour, year, price) " .
      "VALUES (:licensePlate, :brand, :colour, :year, :price)";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsStatement->execute([
      "licensePlate" => $licensePlate,
      "brand" => $brand,
      "colour" => $colour,
      "year" => $year,
      "price" => $price
    ]);
  }
  //function which fetches all colours from the Colour table, loops through each and every single one of them and places them in an
  //array called $colours and then returns its value
  public function fetchColours()
  {
    $colourRows = $this->db->query("SELECT * FROM Colours");
    $colours = [];
    foreach ($colourRows as $colourRow) {
      $colours[] = $colourRow["colour"];
    }

    return $colours;
  }

  //hämtar ut alla bilmärken, loopar igenom de och tillsätter de i en tom array för att sedan kunna visa upp de i en
  //drop down lista
  public function fetchBrands()
  {
    $brandRows = $this->db->query("SELECT * FROM Brands");
    $brands = [];
    foreach ($brandRows as $brandRow) {
      $brands[] = $brandRow["brand"];
    }
    return $brands;
  }

  //hämtar ut alla kunder, loopar igenom de och tillsätter de i en tom array för att sedan kunna visa upp de i en
  //drop down lista
  public function fetchCustomers()
  {
    $customerRows = $this->db->query("SELECT * FROM Customers");
    $customers = [];

    foreach ($customerRows as $customerRow) {
      $customers[] = $customerRow;
    }
    return $customers;
  }


  public function fetchCars()
  {
    $carRows = $this->db->query("SELECT * FROM Cars");
    $cars = [];

    foreach ($carRows as $carRow) {
      $cars[] = $carRow;
    }
    return $cars;
  }

  public function editCar($licensePlate, $newBrand, $newColour, $newYear, $newPrice)
  {
    $carsQuery = "UPDATE Cars SET brand = :brand, colour = :colour, year = :year, price = :price, statusRented = 0, start = NULL " .
      "WHERE licensePlate = :licensePlate";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsParameters = [
      "licensePlate" => $licensePlate,
      "brand" => $newBrand,
      "colour" => $newColour,
      "year" => $newYear,
      "price" => $newPrice
    ];
    $carsResult = $carsStatement->execute($carsParameters);
    if ($carsResult) die($this->db->errorInfo()[2]);
  }

  public function removeCar($licensePlate)
  {

    $carsQuery = "DELETE FROM Cars WHERE licensePlate = :licensePlate";
    $carsStatement = $this->db->prepare($carsQuery);
    $carsResult = $carsStatement->execute(["licensePlate" => $licensePlate]);
    if ($carsResult) die($this->db->errorInfo()[2]);
  }

  public function rentCar($customerNumber, $licensePlate)
  {
    $rentQuery = "update Cars set statusRented = 1, customerNumber = :customerNumber, start = NOW() where licensePlate = :licensePlate ";
    $rentStatus = $this->db->prepare($rentQuery);
    $rentStatus->execute([":licensePlate" => $licensePlate, "customerNumber" => $customerNumber]);
  }



  public function fetchRentedCars()
  {
    $rentedRows = $this->db->query("SELECT * FROM Cars where statusRented = 1");
    $rentedCars = [];

    foreach ($rentedRows as $rentedRow) {
      $rentedCars[] = $rentedRow;
    }
    return $rentedCars;
  }

  public function returnCar($licensePlate)
  {
    $lookupQuery = "select customerNumber, start, price FROM Cars where licensePlate = :licensePlate";
    $lookup = $this->db->prepare($lookupQuery);
    $lookup->execute([":licensePlate" => $licensePlate]);
    $selectedRow = $lookup->fetch();
    $customerNumber = $selectedRow["customerNumber"];
    $start = $selectedRow["start"];
    $price = $selectedRow["price"];
    $statusQuery = "update Cars set statusRented = 0, customerNumber = NULL, start = NULL where licensePlate = :licensePlate ";
    $rentStatus = $this->db->prepare($statusQuery);
    $rentStatus->execute([":licensePlate" => $licensePlate]);


    $carsQuery = "INSERT into Booking(licensePlate, customerNumber, start, end, price)" .
      "VALUES (:licensePlate, :customerNumber, :start, NOW(), :price)";
    $rentStatement = $this->db->prepare($carsQuery);
    $properties = [
      "licensePlate" => $licensePlate,
      "customerNumber" => $customerNumber,
      "start" => $start,
      "price" => $price
    ];

    $result = $rentStatement->execute($properties);

    $bookingNumber = $this->db->lastInsertId();
    return $bookingNumber;
  }
}
