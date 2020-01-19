<?php
namespace Carrental\Controllers;

use Carrental\Core\Request;
use Carrental\Utils\DependencyInjector;

abstract class AbstractController {
    protected $request;
    protected $db;
    protected $config;
    protected $view;
    protected $log;
    protected $customerId;
    protected $di;

    //tanken med dependencyinjector är att programmet ska veta så lite 
    //som möjligt om de andra systemen som det kommuniceras med, ex att den inte behöver veta om databasen är SQL, mySQL, eller mongoDB.
    public function __construct(DependencyInjector $di, Request $request) {
        $this->request = $request;
        $this->di = $di;
        $this->db = $di->get("PDO");
        $this->log = $di->get("Logger");
        $this->view = $di->get("Twig_Environment");
        $this->config = $di->get('Utils\Config');
    }

    public function setCustomerId(int $customerId) {
        $this->customerId = $customerId;
    }

    protected function render(string $template, array $params): string {
        return $this->view->loadTemplate($template)->render($params);
    }
}
