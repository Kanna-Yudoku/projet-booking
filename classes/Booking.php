<?php
class Booking {
    private int $id;
    private int $clientId;
    private int $chambreId;
    private string $dateDebut;
    private string $dateFin;
    private string $dateCreation;

    public function __construct(int $clientId, int $chambreId, string $dateDebut, string $dateFin) {
        $this->clientId = $clientId;
        $this->chambreId = $chambreId;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->dateCreation = date('Y-m-d');
    }

    public function getClientId(): int {
        return $this->clientId;
    }
    public function getChambreId(): int {
        return $this->chambreId;
    }
    public function getDateDebut(): string {
        return $this->dateDebut;
    }
    public function getDateFin(): string {
        return $this->dateFin;
    }
    public function getDateCreation(): string {
        return $this->dateCreation;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
}
