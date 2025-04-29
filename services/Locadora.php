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

            // decodifica o arquivo JSON
            $dados = json_decode(file_get_contents(ARQUIVO_JSON),true);

            foreach ($dados as $dado){
                
                if ($dado['tipo']=== 'Carro'){
                    $veiculo = new Carro($dado['modelo'], $dado['placa']);
                } else {
                    $veiculo = new Moto($dado['modelo'], $dado['placa']);
                }
                $veiculo->setDisponivel($dado['disponivel']);

                $this->veiculos[] = $veiculo; //adicionar ao vetor
            }
        }
    }
    // salvar veículos
    private function salvarVeiculos(): void{
        $dados = [];

        foreach($this->veiculos as $veiculo){
            $dados[] = [
                'tipo' => ($veiculo instanceof Carro) ? 'Carro' :'Moto',
                'modelo' => $veiculo -> getModelo(),
                'placa' => $veiculo -> getPlaca(),
                'disponivel' => $veiculo -> isDisponivel()
            ];

            // salvar JSON no diretorio
            $dir =dirname(ARQUIVO_JSON);

            if (!is_dir($dir)){
                mkdir($dir, 0777, true);
            }

            file_put_contents(ARQUIVO_JSON, json_encode($dados, JSON_PRETTY_PRINT));
        }

        // adicionar novo veículo
        public function adicionarVeiculo(Veiculo $veiculo): void{
            $this->veiculos[] = $veiculo;
            $this->salvarVeiculos();
        }

        // remover veículo

        // alugar veículo por 'n' dias

        // devolver veíulo

        // retornar a lista de veículos

        // calcular previsão do valor
    }
}