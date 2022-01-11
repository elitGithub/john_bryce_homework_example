<?php

namespace Elit1\ObjectOriented\Controllers;

use Elit1\ObjectOriented\Database;
use Elit1\ObjectOriented\Models\ImageModel;
use Elit1\ObjectOriented\View;

class ImagesController
{

    private Database $db;
    private ImageModel $model;
    private View $view;

    public function __construct () {
        $this->db = new Database();
        $this->model = new ImageModel();
        $this->view = new View();
    }

    public function index() {

        $this->view->requireView('showFilesTable', ['images' => $this->model->findAll()]);
    }


}