<?php

namespace Carrental\Models;

//use Bank\Domain\Bank;
use Carrental\Exceptions\DbException;
use Carrental\Exceptions\NotFoundException;
use PDO;

class AccountModel extends AbstractModel {
  public function deposit($accountNumber, $amount) {
    $customersQuery = "INSERT INTO Events(accountNumber, amount) " .
                      "VALUES(:accountNumber, :amount)";
    $customersStatement = $this->db->prepare($customersQuery);
    $customersParameters = ["accountNumber" => $accountNumber, "amount" => $amount];
    $customersResult = $customersStatement->execute($customersParameters);
    if (!$customersResult) die($this->db->errorInfo()[2]);
  }

  public function withdraw($accountNumber, $amount) {
    $customersQuery = "INSERT INTO Events(accountNumber, amount) " .
                      "VALUES(:accountNumber, :amount)";
    $customersStatement = $this->db->prepare($customersQuery);
    $negetiveAmount = -$amount;
    $customersParameters = ["accountNumber" => $accountNumber, "amount" => $negetiveAmount];
    $customersResult = $customersStatement->execute($customersParameters);
    if (!$customersResult) die($this->db->errorInfo()[2]);
  }

  public function viewAccount($accountNumber) {
    $eventsQuery = "SELECT * FROM Events WHERE accountNumber = :accountNumber";
    $eventsStatement = $this->db->prepare($eventsQuery);
    $eventsResult = $eventsStatement->execute(["accountNumber" => $accountNumber]);
    if (!$eventsResult) die($this->db->errorInfo()[2]);
//    $numberOfEvents = $eventsStatement->rowCount();
    $eventsRows = $eventsStatement->fetchAll();

    $events = [];
    foreach ($eventsRows as $eventsRow) {
      $time = htmlspecialchars($eventsRow["time"]);
      $amount = htmlspecialchars($eventsRow["amount"]);
      $events[] = ["time" => $time, "amount" => $amount];
    }
    
    if (count($events) > 0) {
      $balanceQuery = "SELECT SUM(amount) FROM Events WHERE accountNumber = :accountNumber";
      $balanceStatement = $this->db->prepare($balanceQuery);
      $balanceStatement->execute(["accountNumber" => $accountNumber]);
      if (!$balanceStatement) die($this->db->errorInfo());
      $balanceRows = $balanceStatement->fetchAll();
      $accountBalance = htmlspecialchars($balanceRows[0]["SUM(amount)"]);
    }
    else {
      $accountBalance = 0;
    }

    return ["events" => $events, "accountBalance" => $accountBalance];
  }

  public function transfer($fromAccountNumber) {
    $customersQuery = <<< __HTML
       SELECT CONCAT(customer.customerNumber, ',',
       customer.customerName, ',', account.accountNumber)
       FROM Customers customer JOIN Accounts account
       ON ((customer.customerNumber = account.customerNumber)
       AND (accountNumber != :fromAccountNumber));
__HTML;
    
    $customersStatement = $this->db->prepare($customersQuery);
    $customersResult = $customersStatement->execute(["fromAccountNumber" => $fromAccountNumber]);
    if (!$customersResult) die("Fatal error Transfer");
    $customersRows = $customersStatement->fetchAll(PDO::FETCH_NUM);

    $accountInfoArray = [];
    foreach ($customersRows as $customersRow) {
      $accountInfoArray[] = $customersRow[0];
    }

    return ["accountInfoArray" => $accountInfoArray];
  }

  public function transferDone($fromAccountNumber, $toAccountNumber, $amount) {
    $this->db->beginTransaction();
    
    $fromQuery = "INSERT INTO Events(accountNumber, amount) " .
                 "VALUES(:fromAccountNumber, :negativeAmount)";
    $fromStatement = $this->db->prepare($fromQuery);
    $negativeAmount = -$amount;
    $fromStatement->execute(["fromAccountNumber" => $fromAccountNumber,
                             "negativeAmount" => $negativeAmount]);
    if (!$fromStatement) {
      $this->db->rollBack();
      die("Fatal Error From");
    }

    $toQuery = "INSERT INTO Events(accountNumber, amount) " .
               "VALUES(:toAccountNumber, :amount)";
    $toStatement = $this->db->prepare($toQuery);
    $toStatement->execute(["toAccountNumber" => $toAccountNumber,
                           "amount" => $amount]);
    if (!$toStatement) {
      $this->db->rollBack();
      die("Fatal Error To");
    }

    $this->db->commit();
  }

  public function removeAccount($accountNumber) {
    $balanceQuery = "SELECT SUM(amount) FROM Events WHERE accountNumber = :accountNumber";
    $balanceStatement = $this->db->prepare($balanceQuery);
    $balanceStatement->execute(["accountNumber" => $accountNumber]);
    if (!$balanceStatement) die($this->db->errorInfo()[2]);
    $balanceRows = $balanceStatement->fetchAll();
    $accountBalance = htmlspecialchars($balanceRows[0]["SUM(amount)"]);
    
    if (($accountBalance == "") || ($accountBalance == 0)) {
      if ($accountBalance == 0) {
        $eventsQuery = "DELETE FROM Events WHERE accountNumber = :accountNumber";
        $eventsStatement = $this->db->prepare($eventsQuery);
        $eventsStatement->execute(["accountNumber" => $accountNumber]);
        if (!$eventsStatement) die($this->db->errorInfo()[2]);
      }

      $accountsQuery = "DELETE FROM Accounts WHERE accountNumber = :accountNumber";
      $accountsStatement = $this->db->prepare($accountsQuery);
      $accountsStatement->execute(["accountNumber" => $accountNumber]);
      if (!$accountsStatement) die($this->db->errorInfo()[2]);
    }

    if ($accountBalance == "") {
      $accountBalance = 0;
    }

    return $accountBalance;
  }  
}
