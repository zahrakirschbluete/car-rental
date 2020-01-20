<?php

namespace Carrental\Controllers;
use Carrental\Models\CustomerMenuModel;

class CustomersMenuController extends AbstractController {
  //funktion som listar alla kunder i kundmenyn
  public function customerList(): string {
    $CustomerMenuModel = new CustomerMenuModel($this->db);
    $customers = $CustomerMenuModel->customerList();
    $properties = ["customers" => $customers];
    return $this->render("CustomersMenu.twig", $properties);
  }
}
