<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>¡Felicidades, has ganado!</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .winner-image {
            width: 100px; 
            height: 100px; 
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">¡Felicidades, has ganado!</h1>
            <?php
           
            if (isset($_GET['winner']) && isset($_GET['playerNumber'])) {
                $winner = htmlspecialchars($_GET['winner']);
                $playerNumber = $_GET['playerNumber'];
                echo "<p class='lead'>¡El jugador $winner ha ganado!</p>";
               
                echo "<img class='winner-image' src='./images/player$playerNumber.png' alt='Imagen del jugador ganador'>";
            } else {
                echo "<p class='lead'>¡Algo salió mal!</p>";
            }
            ?>
        </div>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
