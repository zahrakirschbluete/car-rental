<?php

namespace Carrental\Models;

use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class HistoryModel extends AbstractModel {
  public function historyList() {
    $bookingRows = $this->db->query("SELECT * FROM Booking");
    if (!$bookingRows) die($this->db->errorInfo());
    $bookings = [];
    
    foreach ($bookingRows as $bookingRow) {
      $licensePlate = htmlspecialchars($bookingRow["licensePlate"]);
      $customerNumber = htmlspecialchars($bookingRow["customerNumber"]);
      $start = htmlspecialchars($bookingRow["start"]);
      $end = htmlspecialchars($bookingRow["end"]);
      $bookingNumber = htmlspecialchars($bookingRow["bookingNumber"]);
      $lookupQuery = "select price from Booking where bookingNumber = :bookingNumber";
    $lookup = $this->db->prepare($lookupQuery);
    $lookup->execute(["bookingNumber" => $bookingNumber]);
    $selectedRow = $lookup->fetch();
    $price = $selectedRow["price"];
    
      $startDate = new \DateTime($start);
$endDate = new \DateTime($end);
$diff = $endDate->diff($startDate);

$days = $diff->days + 1;


$cost = $price * $days;



      $booking = ["licensePlate" => $licensePlate,
                  "customerNumber" => $customerNumber,
                   "start" => $start,
                  "end" => $end,
                "days" => $days,
              "cost" => $cost];      
        
    //   $accountsQuery = "SELECT * FROM Accounts WHERE customerNumber = :customerNumber";
    //   $accountsStatement = $this->db->prepare($accountsQuery);
    //   $accountsResult = $accountsStatement->execute(["customerNumber" => $customerNumber]);
    // //   if (!$accountsResult) die($this->db->errorInfo());
    //   $accountsRows = $accountsStatement->fetchAll();

    //   $accounts = [];
    //   foreach ($accountsRows as $accountRow) {
    //     $accountNumber = htmlspecialchars($accountRow["accountNumber"]);
    //     $account = ["accountNumber" => $accountNumber];
        
    //     $balanceQuery = "SELECT SUM(amount) FROM Events WHERE accountNumber = :accountNumber";
    //     $balanceStatement = $this->db->prepare($balanceQuery);
    //     $balanceResult = $balanceStatement->execute(["accountNumber" => $accountNumber]);
    //     if (!$balanceResult) die($this->db->errorInfo());

    //     $balanceRows = $balanceStatement->fetchAll();
    //     $accountBalance = htmlspecialchars($balanceRows[0]["SUM(amount)"]);
        
    //     if ($accountBalance === "") {
    //       $accountBalance = "0";
    //     }

    //     $account["accountBalance"] = $accountBalance;
    //     $accounts[] = $account;
    //   }

    //   $customer["accounts"] = $accounts;
      $bookings[] = $booking;
    }

    return $bookings;
  }
}
