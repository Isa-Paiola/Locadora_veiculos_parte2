<?php
require_once __DIR__ .'/../services/Auth.php';

use Services\Auth;

$usuario = Auth::getUsuario();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM - Locadora de veículos</title>
    <!-- link do css -->
    <link rel="stylesheet" href="style.css">
    <!-- Link do bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Link dos ícones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  
</head>
    <style>
.action-wrapper{
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: flex-start;
}

.btn-group-actions{
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.delete-btn{
    order: 1;
}

.rent-group{
    display: flex;
    align-items: center;
    gap: 0.5rem;
    order: 2;
}

days-input{
    width: 60px !important;
    padding: 0.25rem 0.5rem;
    text-align: center;
}


@media (max-width: 768px){
    .action-wrapper{
        flex-direction: column;
        align-items: stretch;
    }
    .btn-group-actions{
        flex-direction: column;
    }
    .rent-group{
        order: 2;
        width: 100%;
    }
    .delete-btn{
        order: 2;
        width: 100%;
    }
    .days-input{
        width: 100% !important;
    }
}
    </style>
</head>
<body class="container py-4">
    <div class="container py-4">
    <!-- barra de informações de usuário -->
     <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center inicio">
                <h1>Sistema de Locadora de Veículos</h1>
                <div class="d-flex align-items-center gap-3 user-info mx-3">
                    <span class="user-icon">
                        <i class="bi bi-person-circle" style="font-size:24px;"></i>
                    </span>

                    <!-- texto Bem vindo, [usuário] -->
                     <span class="welcome-text">
                        Bem-vindo, <strong><?=htmlspecialchars($usuario['username'])?></strong>
                     </span>

                     <!-- botão de logout -->
                      <a href="?logout=1" class="btn btn-outline-danger d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair
                    </a>
                </div>
            </div>
        </div>
     </div>

     <?php if ($mensagem):?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?htmlspecialchars($mensagem) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" 
            arial-label="Close"></button>
        </div>
        <?php endif; ?>
</body>