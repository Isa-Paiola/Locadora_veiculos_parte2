<?php
namespace Services;

use Models\{Veiculo, Carro, Moto};

// Classe para gerenciar a locação
class Locadora {
    private array $veiculos = [];

    public function __construct(){
        $this->carregarVeiculos();
    }

    private function carregarVeiculos(): void {
        if (file_exists(ARQUIVO_JSON)){

            // Decodifica o arquivo JSON
            $dados = json_decode(file_get_contents(ARQUIVO_JSON), true);

            foreach ($dados as $dado){

                if($dado['tipo'] === 'Carro'){
                    $veiculo = new Carro($dado['modelo'], $dado['placa']);
                } else{
                    $veiculo = new Moto($dado ['modelo'], $dado['placa']);
                }
                $veiculo-> setDisponivel($dado['disponivel']);

                $this->veiculos [] =$veiculo;
            }
        }
    }

    // Salvar veículos
    private function salvarVeiculos(): void{
        $dados = [];

        foreach($this->veiculos as $veiculo){
            $dados[] = [
                'tipo' => ($veiculo instanceof Carro) ? 'Carro' : 'Moto', 
                'modelo' => $veiculo -> getModelo(), 
                'placa' => $veiculo -> getPlaca(), 'disponivel' =>
                $veiculo -> isDisponivel()
            ];

            $dir = dirname (ARQUIVO_JSON);

            if (!is_dir($dir)){
                mkdir($dir, 0777, true);
            }
        }

        file_put_contents(ARQUIVO_JSON, json_encode($dados, JSON_PRETTY_PRINT));
    }

    // Adicionar novo veículo
    public function adicionarVeiculo(Veiculo $veiculo): void{
        $this->veiculos[] = $veiculo;
        $this->salvarveiculos();
    }

    // Remover veículo
    public function deletarVeiculo(string $modelo, string $placa): string{

        foreach($this ->veiculos as $key => $veiculo){

            // verifica se modelo e placa correspondem
            if($veiculo->getModelo() === $modelo && $veiculo->getPlaca() === $placa){
                // remove o veiculo do array
                unset($this->veiculos[$key]);

                // reorganizar os indices
                $this->veiculos = array_values($this->veiculos);

                // Salvar o novo estado
                $this->salvarVeiculos();
                return "Veículo '{$modelo}' removido com sucesso!";
            }
        }
        return "Veículo não encontrado!";
    }
    

    // Alugar Veículo por n dias
    public function alugarVeiculo(string $modelo, int $dias = 1): string{

        // percorre a lista de veículos
        foreach($this->veiculos as $veiculo){

            if($veiculo->getModelo() === $modelo && $veiculo->isDisponivel()){

                // calcular valor do aluguel
                $valorAluguel = $veiculo->calcularAluguel($dias);

                // marcar como alugado
                $mensagem = $veiculo->alugar();

                $this->salvarVeiculos();

                return $mensagem . "Valor do aluguel: R$" . number_format($valorAluguel, 2, ',', '.');
            }
        }
        return "Veículo não disponível.";
    }


    // Devolver Veículo
    public function devolverVeiculo(string $modelo): string{

        // Percorrer a lista
        foreach($this->veiculos as $veiculo){

            if($veiculo->getModelo() === $modelo && !$veiculo->isDisponivel()){

                // disponibilizar o veiculo
                $mensagem = $veiculo->devolver();

                $this->salvarVeiculos();
                return $mensagem;
            }
        }
        return "Veículo já disponível ou não encontrado.";
    }

    // Retorna a lista de veículos
    public function listarVeiculos(): array{
        return $this->veiculos;
    }

    // Calcular previsão do valor
    public function calcularPrevisaoAluguel(string $tipo, int $dias): float{

        if($tipo ==='Carro'){
            return(new Carro('','')) -> calcularAluguel($dias);
        }
        return (new Moto('','')) -> calcularAluguel($dias);
    }
}