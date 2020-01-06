<?php

namespace Carrental\Controllers;
use Carrental\Models\CustomerMenuModel;

class MainMenuController extends AbstractController {
  public function customerList(): string {
    $CustomerMenuModel = new CustomerMenuModel($this->db);
    $customers = $CustomerMenuModel->customerList();
    $properties = ["customers" => $customers];
    return $this->render("MainMenu.twig", $properties);
  }
}
