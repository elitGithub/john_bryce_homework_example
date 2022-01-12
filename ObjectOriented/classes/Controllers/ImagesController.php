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
        $args = func_get_args();
        if (!empty($args[0]['user_id'])) {
            $this->view->requireView('showFilesTable', ['images' => $this->model->findByUserId($args[0]['user_id'])]);
        }
    }


}