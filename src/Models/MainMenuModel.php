<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class MainMenuModel extends AbstractModel
{
  public function customerList()
  {
    $customerRows = $this->db->query("SELECT * FROM Customers");
    if (!$customerRows) die($this->db->errorInfo());

    $customers = [];
    foreach ($customerRows as $customerRow) {
      $customerNumber = htmlspecialchars($customerRow["customerNumber"]);
      $customerName = htmlspecialchars($customerRow["customerName"]);
      $customerAddress = htmlspecialchars($customerRow["customerAddress"]);
      $postalAddress = htmlspecialchars($customerRow["postalAddress"]);
      $phoneNumber = htmlspecialchars($customerRow["phoneNumber"]);
      $customer = [
        "customerNumber" => $customerNumber,
        "customerName" => $customerName,
        "customerAddress" => $customerAddress,
        "postalAddress" => $postalAddress,
        "phoneNumber" => $phoneNumber
      ];
    }

    return $customers;
  }
}
