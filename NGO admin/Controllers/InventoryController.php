<?php

class InventoryController {
    // no DB required — static categories that route to other controllers
    public function index() {
        $categories = [
            ['slug' => 'testkits',      'title' => 'Testing kits',        'icon' => 'fa-vial'],
            ['slug' => 'preventivemed', 'title' => 'Preventive Medication','icon' => 'fa-pills'],
            ['slug' => 'facilitytest',  'title' => 'Facility based tests', 'icon' => 'fa-hospital'],
            ['slug' => 'othermaterial', 'title' => 'Other materials',      'icon' => 'fa-box-open'],
        ];

        include __DIR__ . '/../views/inventorymanagement.php';
    }
}
?>