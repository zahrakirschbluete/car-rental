<?php
namespace Carrental\Controllers;
use Carrental\Models\HistoryModel;

class HistoryController extends AbstractController {
  public function customerList(): string {
    $HistoryModel = new HistoryModel($this->db);
    $customers = $HistoryModel->customerList();
    $properties = ["customers" => $customers];
    return $this->render("History.twig", $properties);
  }
}
