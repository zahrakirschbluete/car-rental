<?php

namespace Carrental\Controllers;
use Carrental\Models\CustomerMenuModel;

class CustomersMenuController extends AbstractController {
  public function customerList(): string {
    $CustomerMenuModel = new CustomerMenuModel($this->db);
    $customers = $CustomerMenuModel->customerList();
    $properties = ["customers" => $customers];
    return $this->render("CustomersMenu.twig", $properties);
  }
}
