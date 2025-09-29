<?php
class Chambre {
    private int $id;
    private int $numero;
    private int $hotelId;

    public function __construct(int $numero, int $hotelId) {
        $this->numero = $numero;
        $this->hotelId = $hotelId;
    }

    public function getNumero(): int {
        return $this->numero;
    }
    public function getHotelId(): int {
        return $this->hotelId;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
}
