<?php
namespace Carrental\Controllers;
use Carrental\Models\HistoryModel;

class HistoryController extends AbstractController {
  public function historyList(): string {
    $HistoryModel = new HistoryModel($this->db);
    $bookings = $HistoryModel->historyList();
    $properties = ["bookings" => $bookings];
    return $this->render("History.twig", $properties);
  }
}

