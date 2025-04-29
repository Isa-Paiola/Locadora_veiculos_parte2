<?php
namespace Services;

use Models\{Veiculo, Carro, Moto};

// class para gerenciar a locação
class Locadora {
    private array $veiculos = [];

    public function __construct(){
        $this->carregarVeiculos();
    }

    private function carregarVeiculos(): void {
        if (file_exists(ARQUIVO_JSON)){

        }
    }
}