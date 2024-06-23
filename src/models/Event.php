<?php
// src/models/Event.php

class Event {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO events (title, description, date, time, location, createdBy) VALUES (:title, :description, :date, :time, :location, :createdBy)");
        return $stmt->execute($data);
    }

    public function readAll() {
        $stmt = $this->pdo->query("SELECT * FROM events");
        return $stmt->fetchAll();
    }

    public function read($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    public function getEventsByAssociation($createdBy) {
        $stmt = $this->pdo->prepare("SELECT * FROM events WHERE createdBy = :createdBy");
        $stmt->bindParam(':createdBy', $createdBy, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE events SET title = :title, description = :description, date = :date, time = :time, location = :location, createdBy = :createdBy WHERE id = :id");
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM events WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
