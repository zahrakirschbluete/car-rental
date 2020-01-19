<?php

namespace Carrental\Models;

use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class HistoryModel extends AbstractModel
{
  public function historyList()
  {
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




      $booking = [
        "licensePlate" => $licensePlate,
        "customerNumber" => $customerNumber,
        "start" => $start,
        "end" => $end,
        "days" => $days,
        "cost" => $cost
      ];

      $bookings[] = $booking;
    }

    return $bookings;
  }
}
