<?php

namespace Carrental\Controllers;
use Carrental\Models\AccountModel;

class AccountController extends AbstractController {
  public function deposit($customerNumber, $customerName, $accountNumber) {
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return $this->render("Deposit.twig", $properties);
  }    

  public function depositDone($customerNumber, $customerName, $accountNumber) {
    $form = $this->request->getForm();
    $amount = $form["amount"];
    $accountModel = new AccountModel($this->db);
    $accountModel->deposit($accountNumber, $amount);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "amount" => $amount];
    return $this->render("DepositDone.twig", $properties);
  }
    
  public function withdraw($customerNumber, $customerName, $accountNumber) {
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber];
    return $this->render("Withdraw.twig", $properties);
  }    

  public function withdrawDone($customerNumber, $customerName, $accountNumber) {
    $form = $this->request->getForm();
    $amount = $form["amount"];
    $accountModel = new AccountModel($this->db);
    $accountModel->withdraw($accountNumber, $amount);
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "amount" => $amount];
    return $this->render("WithdrawDone.twig", $properties);
  }

  public function transfer($fromCustomerNumber, $fromCustomerName, $fromAccountNumber) {
    $accountModel = new AccountModel($this->db);
    $result = $accountModel->transfer($fromAccountNumber);
    $properties = ["fromCustomerNumber" => $fromCustomerNumber,
                   "fromCustomerName" => $fromCustomerName,
                   "fromAccountNumber" => $fromAccountNumber,
                   "accountInfoArray" => $result["accountInfoArray"]];
    return $this->render("Transfer.twig", $properties);
  }

  public function transferDone($fromCustomerNumber, $fromCustomerName, $fromAccountNumber) {
    $form = $this->request->getForm();
    $toAccountInfo = $form["toAccountInfo"];
    $amount = $form["amount"];
           
    $firstComma = strpos($toAccountInfo, ",");
    $lastComma = strrpos($toAccountInfo, ",");
    $toCustomerNumber = substr($toAccountInfo, 0, $firstComma);
    $toCustomerName = substr($toAccountInfo, $firstComma + 1, $lastComma - $firstComma - 1);
    $toAccountNumber = substr($toAccountInfo, $lastComma + 1);
      
    $accountModel = new AccountModel($this->db);
    $accountModel->transferDone($fromAccountNumber, $toAccountNumber, $amount);
    
    $properties = ["fromCustomerNumber" => $fromCustomerNumber,
                   "fromCustomerName" => $fromCustomerName,
                   "fromAccountNumber" => $fromAccountNumber,
                   "toCustomerNumber" => $toCustomerNumber,
                   "toCustomerName" => $toCustomerName,
                   "toAccountNumber" => $toAccountNumber,
                   "amount" => $amount];
    return $this->render("TransferDone.twig", $properties);
  }

  public function viewAccount($customerNumber, $customerName, $accountNumber) {
    $accountModel = new AccountModel($this->db);
    $result = $accountModel->viewAccount($accountNumber);
    $events = $result["events"];
    $accountBalance = $result["accountBalance"];
    
    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "accountEvents" => $result["events"],
                   "accountBalance" => $result["accountBalance"]];
    return $this->render("ViewAccount.twig", $properties);
  }

  public function removeAccount($customerNumber, $customerName, $accountNumber) {
    $customerModel = new AccountModel($this->db);
    $accountbalance = $customerModel->removeAccount($accountNumber);

    $properties = ["customerNumber" => $customerNumber,
                   "customerName" => $customerName,
                   "accountNumber" => $accountNumber,
                   "accountBalance" => $accountbalance];
    return $this->render("AccountRemoved.twig", $properties);
  }
}
