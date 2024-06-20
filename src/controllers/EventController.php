<?php

require_once __DIR__ . '/../models/Event.php';

class EventController {
    private $eventModel;

    public function __construct($pdo) {
        $this->eventModel = new Event($pdo);
    }

    public function create($data) {
        return $this->eventModel->create($data);
    }

    public function readAll() {
        return $this->eventModel->readAll();
    }

    public function read($id) {
        return $this->eventModel->read($id);
    }

    public function update($data) {
        return $this->eventModel->update($data);
    }

    public function delete($id) {
        return $this->eventModel->delete($id);
    }
}
?>
