<?php
session_start();

if (isset($_POST['setup'])) {
    
    $_SESSION['players'] = [
        1 => $_POST['player1_name'],
        2 => $_POST['player2_name'],
        3 => $_POST['player3_name']
    ];

    
    $_SESSION['player_positions'] = [
        1 => 1,
        2 => 1,
        3 => 1
    ];

   
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Configuración de Jugadores</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Configuración de Jugadores</h1>
        <form method="post">
            <div class="form-group">
                <label for="player1_name" class="form-label">Nombre del Jugador 1:</label>
                <input type="text" class="form-control" id="player1_name" name="player1_name" required>
            </div>
            <div class="form-group">
                <label for="player2_name" class="form-label">Nombre del Jugador 2:</label>
                <input type="text" class="form-control" id="player2_name" name="player2_name" required>
            </div>
            <div class="form-group">
                <label for="player3_name" class="form-label">Nombre del Jugador 3:</label>
                <input type="text" class="form-control" id="player3_name" name="player3_name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="setup">Comenzar Juego</button>
        </form>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
