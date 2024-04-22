<?php
session_start();

if (!isset($_SESSION['players']) || !isset($_SESSION['player_positions'])) {
    header("Location: setup.php");
    exit();
}


$escaleras = [3 => 11, 15 => 35, 22 => 42, 45 => 87];
$serpientes = [98 => 78, 95 => 75, 47 => 26, 90 => 32];

$message = '';


if (isset($_POST['move'])) {
    $diceRoll = rand(1, 12); 
    $_SESSION['last_dice_roll'] = $diceRoll;
    $currentPlayer = $_POST['current_player'];
    $newPosition = $_SESSION['player_positions'][$currentPlayer] + $diceRoll;
    $newPosition = min($newPosition, 100); 

  
    if (array_key_exists($newPosition, $escaleras)) {
        $message = "¡" . $_SESSION['players'][$currentPlayer] . " subió por una escalera de $newPosition a " . $escaleras[$newPosition] . "!";
        $newPosition = $escaleras[$newPosition];
    } elseif (array_key_exists($newPosition, $serpientes)) {
        $message = "¡" . $_SESSION['players'][$currentPlayer] . " bajó por una serpiente de $newPosition a " . $serpientes[$newPosition] . "!";
        $newPosition = $serpientes[$newPosition];
    }

    $_SESSION['player_positions'][$currentPlayer] = $newPosition;

  
    if ($_SESSION['player_positions'][$currentPlayer] == 100) {
        
        header("Location: win.php?winner=" . urlencode($_SESSION['players'][$currentPlayer]) . "&playerNumber=$currentPlayer");
        exit();
    }
}


if (isset($_POST['reset'])) {
    $_SESSION['player_positions'] = array_fill(1, 3, 1);
    unset($_SESSION['last_dice_roll']);
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tablero de Escaleras y Serpientes</title>
  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }

        .board-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(10, 60px);
          
            grid-gap: 5px;
        }

        .cell {
            height: 60px;
           
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid black;
            background-color: #f0f0f0;
            background-size: cover;
           
            background-position: center;
            
        }

        .escalera {
            background-image: url('./images/esc.jpeg');
        }

        .serpiente {
            background-image: url('./images/ser.png');
        }

        .player1 {
            background-image: url('./images/player1.png');
        }

        .player2 {
            background-image: url('./images/player2.png');
        }

        .player3 {
            background-image: url('./images/player3.png');
        }

        .player {
            background-color: blue;
            color: white;
            font-weight: bold;
            position: relative;
            z-index: 1;
            
        }

        .escalera,
        .escalera-fin {
            background-color: lightgreen;
        }

        .escalera-fin {
            background-color: darkgreen;
        }

        .serpiente,
        .serpiente-fin {
            background-color: salmon;
        }

        .serpiente-fin {
            background-color: darkred;
        }

        .game-info {
            border: 2px solid #007bff;
            padding: 20px;
            margin-top: 20px;
        }

        .last-roll {
            background-color: #007bff;
            color: white;
            padding: 10px;
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Tablero de Escaleras y Serpientes</h1>
        <div class="board-container">
            <div class="mr-5">
                <div class="game-info">
                    <?php foreach ($_SESSION['players'] as $playerNumber => $playerName) : ?>
                        <div class="mb-3">
                            <p>Jugador <?php echo $playerNumber; ?>: <?php echo htmlspecialchars($playerName); ?></p>
                            <p>Posición actual: <?php echo $_SESSION['player_positions'][$playerNumber]; ?></p>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="current_player" value="<?php echo $playerNumber; ?>">
                                <button type="submit" name="move" class="btn btn-primary">Lanzar Dado para <?php echo $playerName; ?></button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="board">
                <?php
               
                $cellNumber = 100;
                for ($row = 9; $row >= 0; $row--) {
                    if ($row % 2 == 1) {
                        
                        for ($col = 10; $col >= 1; $col--) {
                            $cellNumber--;
                            drawCell($cellNumber);
                        }
                    } else {
                       
                        for ($col = 1; $col <= 10; $col++) {
                            $cellNumber--;
                            drawCell($cellNumber);
                        }
                    }
                }

               
                function drawCell($cellNumber)
                {
                    global $escaleras, $serpientes;
                    $cellStyle = '';
                    
                    $cellNumber += 1;
                    foreach ($escaleras as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'escalera';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'escalera-fin';
                        }
                    }
                    foreach ($serpientes as $start => $end) {
                        if ($cellNumber == $start) {
                            $cellStyle = 'serpiente';
                        }
                        if ($cellNumber == $end) {
                            $cellStyle = 'serpiente-fin';
                        }
                    }
                    foreach ($_SESSION['player_positions'] as $playerNumber => $position) {
                        if ($position == $cellNumber) {
                            $cellStyle .= ' player' . $playerNumber; 
                        }
                    }
                    echo "<div class='cell $cellStyle'>$cellNumber</div>";
                }
                ?>
            </div>
        </div>
        <div class="last-roll text-center">
            Último lanzamiento: <?php echo $_SESSION['last_dice_roll'] ?? 'Aún no has lanzado'; ?>
        </div>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="text-center">
            <form method="post">
                <button type="submit" name="reset" class="btn btn-danger">Reiniciar Juego</button>
            </form>
        </div>
    </div>
 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
