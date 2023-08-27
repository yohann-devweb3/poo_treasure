<!DOCTYPE html>
<html>

<head>
    <title>Treasure Realms</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <?php
    session_start();
    ?>
</head>

<body>
    <h1>Treasure Realms</h1>
    <div class="movement-log">
        <h3>Règlement</h3>
        <li>
            D&eacute;placez vous à l'aide des flèches du clavier
        </li>
        <li>
            Vous devez trouver le trésor mais prenez garde aux monstres !
        </li>
        <li>
            Vous avez ci-dessous le journal de vos 4 derniers déplacements
        </li>
        <div class="logCard">
            <h3>Journal de mouvements</h3>
            <div class="log-items"></div>
        </div>

        <div class="controls" id="buttons">
            <button type="button" name="direction" value="up">&#8593;</button>
            <button type="button" name="direction" value="down">&#8595;</button>
            <button type="button" name="direction" value="left">&#8592;</button>
            <button type="button" name="direction" value="right">&#8594;</button>
        </div>
        <div class="game-map">
            <?php
            include '../poo_treasure/monster.php';
            include '../poo_treasure/treasure.php';
            include '../poo_treasure/player.php';
            include '../poo_treasure/map.php';

            $gameMap = new GameMap(10, 10);
            $player = $gameMap->getPlayer();
            $playerX = $player->getX();
            $playerY = $player->getY();
            $treasure = $gameMap->getTreasure();
            $monsters = $gameMap->getMonsters();

            for ($y = 1; $y <= 10; $y++) {
                for ($x = 1; $x <= 10; $x++) {
                    $isPlayer = ($x == $playerX && $y == $playerY);
                    $isTreasure = ($x == $treasure->gettreasureX() && $y == $treasure->gettreasureY());
                    $isMonster = false;

                    foreach ($monsters as $monster) {
                        if ($x == $monster->getmonsterX() && $y == $monster->getmonsterY()) {
                            $isMonster = true;
                            if ($isMonster == $isPlayer) {
                            }
                            break;
                        }
                    }

                    echo '<div class="map-cell';

                    if ($isPlayer) {
                        echo ' player';
                    } else {
                        if ($isTreasure) {
                            echo ' treasure';
                        }
                        if ($isMonster) {
                            echo ' monster';
                        }
                    }

                    echo '"></div>';
                }
            }
            ?>


            <script>
                let playerX = <?php echo $playerX; ?>;
                let playerY = <?php echo $playerY; ?>;

                const step = 1;
                const movementLog = document.querySelector('.log-items');
                const maxLogItems = 4; // Limite d'éléments dans le journal

                document.addEventListener('DOMContentLoaded', function() {
                    const controls = document.querySelector('.controls');
                    const actionLog = document.querySelector('.action-log');

                    controls.addEventListener('click', function(event) {
                        if (event.target.name === 'direction') {
                            const direction = event.target.value;
                            const action = (direction === 'reset') ? 'btn' : 'move';
                            sendAction(action, direction);
                        }
                    });


                });


                document.addEventListener('keydown', (event) => {
                    switch (event.key) {
                        case 'ArrowUp':
                            if (playerY > 1) playerY -= step;
                            logMovement('Le joueur se dirige vers le haut');
                            break;
                        case 'ArrowDown':
                            if (playerY < 10) playerY += step;
                            logMovement('Le joueur se dirige vers le bas');
                            break;
                        case 'ArrowLeft':
                            if (playerX > 1) playerX -= step;
                            logMovement('Le joueur se dirige vers la gauche');
                            break;
                        case 'ArrowRight':
                            if (playerX < 10) playerX += step;
                            logMovement('Le joueur se dirige vers la droite');
                            break;


                    }
                    // AJAX call to update player position on server
                    $.post("index.php", {
                        newPlayerX: playerX,
                        newPlayerY: playerY
                    }, function(data) {

                    });
                    updatePlayerPosition();
                    console.log('joueur : ' + playerX + "-" + playerY);

                });

                function updatePlayerPosition() {
                    const playerCell = document.querySelector('.player');
                    playerCell.style.gridRow = playerY;
                    playerCell.style.gridColumn = playerX;
                }

                function logMovement(direction) {
                    const movement = document.createElement('p');
                    movement.textContent = ` ${direction}`;

                    // Limiter le nombre d'éléments dans le journal
                    if (movementLog.childElementCount >= maxLogItems) {
                        movementLog.removeChild(movementLog.firstChild);
                    }

                    movementLog.appendChild(movement);
                }

                // Déplace les monstres et le trésor en dehors de la boucle
                updateOtherElements();

                function updateOtherElements() {
                    const treasureCell = document.querySelector('.treasure');
                    treasureCell.style.gridRow = <?php echo $treasure->gettreasureY(); ?>;
                    treasureCell.style.gridColumn = <?php echo $treasure->gettreasureX(); ?>;

                    const monsterCells = document.querySelectorAll('.monster');
                    <?php foreach ($monsters as $index => $monster) { ?>
                        monsterCells[<?php echo $index; ?>].style.gridRow = <?php echo $monster->getmonsterY(); ?>;
                        monsterCells[<?php echo $index; ?>].style.gridColumn = <?php echo $monster->getmonsterX(); ?>;
                    <?php } ?>
                }


                document.addEventListener('keydown', (event) => {
                    // ...

                    // Check for combat
                    const monsterCells = document.querySelectorAll('.monster');
                    for (let i = 0; i < monsterCells.length; i++) {
                        if (playerX === parseInt(monsterCells[i].style.gridColumn) && playerY === parseInt(monsterCells[i].style.gridRow)) {
                            logCombat(); // Call combat function if player and monster have same position
                        }
                    }

                    // ...
                });

                function logCombat() {
                    const combatMessage = document.createElement('p');
                    combatMessage.textContent = 'Combat commencé !';

                    // Limiter le nombre d'éléments dans le journal
                    if (movementLog.childElementCount >= maxLogItems) {
                        movementLog.removeChild(movementLog.firstChild);
                    }

                    movementLog.appendChild(combatMessage);
                }
            </script>
        </div>
</body>

</html>