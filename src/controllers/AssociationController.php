<?php
// src/controllers/AssociationController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Event.php';

class AssociationController {
    private $pdo;
    private $userModel;
    private $eventModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
        $this->eventModel = new Event($pdo);
    }

    public function verifyAthlete($id) {
        return $this->userModel->verifyAthlete($id);
    }

    public function getAthletes($association_id) {
        return $this->userModel->getAthletesByAssociation($association_id);
    }

    public function createEvent($data) {
        return $this->eventModel->create($data);
    }

    public function getEvents($association_id) {
        return $this->eventModel->getEventsByAssociation($association_id);
    }
}
?>
