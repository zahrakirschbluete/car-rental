<?php

namespace Carrental\Models;

use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class CustomerMenuModel extends AbstractModel
{
  public function customerList()
  {
    $customerRows = $this->db->query("SELECT * FROM Customers");
    if (!$customerRows) die($this->db->errorInfo());

    $customers = [];
    //loopar igenom alla kundrader i tabellen Customers och sätter dom i en tom sträng för att sedan kunna använda mig av detta i vyn
    // och visa samtliga kunder och deras respektive information
    foreach ($customerRows as $customerRow) {


      $customerNumber = htmlspecialchars($customerRow["customerNumber"]);
      $customerName = htmlspecialchars($customerRow["customerName"]);
      $customerAddress = htmlspecialchars($customerRow["customerAddress"]);
      $postalAddress = htmlspecialchars($customerRow["postalAddress"]);
      $phoneNumber = htmlspecialchars($customerRow["phoneNumber"]);
      $carQuery = "SELECT * FROM Cars where customerNumber = :customerNumber";
      $carStatement = $this->db->prepare($carQuery);
      $carResult = $carStatement->execute(["customerNumber" => $customerNumber]);
      $carRows = $carStatement->fetchAll();
      $car = [];
      foreach ($carRows as $carRow) {
        $statusRented = htmlspecialchars($carRow["statusRented"]);

        $car = ["statusRented" => $statusRented];
      }

      $statusRented = $car["statusRented"] ?? 0;
      $customer = [
        "customerNumber" => $customerNumber,
        "customerName" => $customerName,
        "customerAddress" => $customerAddress,
        "postalAddress" => $postalAddress,
        "phoneNumber" => $phoneNumber,
        "statusRented" => $statusRented
      ];

      $customers[] = $customer;
    }

    return $customers;
  }
}
