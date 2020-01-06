<?php
namespace Carrental\Controllers;
use Carrental\Models\CarsMenuModel;

class CarsMenuController extends AbstractController {
  public function carList(): string {
    $CarsMenuModel = new CarsMenuModel($this->db);
    $cars = $CarsMenuModel->carList();
    $properties = ["cars" => $cars];
    return $this->render("CarsMenu.twig", $properties);
  }
}
