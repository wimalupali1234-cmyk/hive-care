<?php
require_once __DIR__ . '/../models/Announcement.php';


class AnnouncementController {
    private $model;

    public function __construct($db){
        $this->model = new Announcement($db);
    }

    public function handleRequest() {
        // Handle create
        if (isset($_POST['upload'])) {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $event_date = $_POST['event_date'] ?? '';
            if($title && $description && $event_date){
                $this->model->create($title, $description, $event_date);
                header("Location: index.php?action=manageAnnouncements&uploaded=true");
                exit;
            }
        }

        // Handle delete
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->delete($id);
            header("Location: index.php?action=manageAnnouncements");
            exit;
        }

        // Fetch all announcements
        $announcements = $this->model->getAll();
    require __DIR__ . '/../views/system_admin/manageAnnouncements.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            die("Error: No announcement ID provided.");
        }

        $id = intval($_GET['id']);
        $announcement = $this->model->getById($id);

        if (!$announcement) {
            die("Error: Announcement not found.");
        }

        // Update announcement
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $event_date = $_POST['event_date'] ?? '';

            if($title && $description && $event_date) {
                if ($this->model->update($id, $title, $description, $event_date)) {
                    header("Location: index.php?action=manageAnnouncements&updated=true");
                    exit;
                } else {
                    echo "Error updating announcement.";
                }
            }
        }

        require __DIR__ . '/../views/system_admin/editAnnouncementView.php';
    }
}
