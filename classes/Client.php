<?php
class Client {
    private int $id;
    private string $nom;
    private string $email;

    public function __construct(string $nom, string $email) {
        $this->nom = $nom;
        $this->email = $email;
    }

    public function getNom(): string {
        return $this->nom;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
}
