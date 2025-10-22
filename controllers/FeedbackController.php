<?php
require_once __DIR__ . '/../models/FeedbackModel.php';


class FeedbackController {
    private $model;

    public function __construct($conn) {
        $this->model = new FeedbackModel($conn);
    }

    public function handleRequest() {
        $filter = $_GET['filter'] ?? 'all';

        if (isset($_POST['respond'])) {
            $id = intval($_POST['id']);
            $response = $_POST['response'];
            $this->model->respond($id, $response);
            header("Location: index.php?action=manageFeedback&replied=true");
            exit;
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->delete($id);
            header("Location: index.php?action=manageFeedback");
            exit;
        }

        $result = $this->model->getAll($filter);
    include __DIR__ . '/../views/system_admin/manageFeedbackView.php';
    }
}
