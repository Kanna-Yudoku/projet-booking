<?php
class Hotel {
    private int $id;
    private string $nom;
    private string $adresse;

    public function __construct(string $nom, string $adresse) {
        $this->nom = $nom;
        $this->adresse = $adresse;
    }

    public function getNom(): string {
        return $this->nom;
    }
    public function getAdresse(): string {
        return $this->adresse;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
}
