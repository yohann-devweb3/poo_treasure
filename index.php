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
            <div class="log-items" id="log-items"></div>
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
                const movementLog = document.querySelector('log-items');
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

                function appendChildLiX($elementTargetdiv, $elementWantTxt) {
                    // Supposons que vous ayez une balise <div> avec une classe 'my-div' dans votre HTML
                    const myDiv = document.getElementById($elementTargetdiv);

                    // Création d'un élément <li>
                    const newListItem = document.createElement('li');
                    newListItem.textContent = $elementWantTxt;

                    // Ajout de l'élément <li> à l'intérieur de la balise <div>
                    myDiv.appendChild(newListItem);

                }

                function sendAction(action, direction) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState === 4 && xhttp.status === 200) {

                            // console.log(xhttp.responseText);

                            if (action === 'move') {
                                switch (direction) {

                                    case 'up':
                                        if (playerY > 1) {
                                            playerY -= step;
                                            appendChildLiX('log-items', 'le joueur se dirige vers le haut ['+playerX+':'+playerY+']');
                                        } else {
                                            appendChildLiX('log-items', 'le joueur rencontre un mur')
                                        };
                                        break;
                                    case 'down':
                                        if (playerY < 10) {
                                            playerY += step;
                                            appendChildLiX('log-items', 'le joueur se dirige vers le bas ['+playerX+':'+playerY+']');
                                        } else {
                                            appendChildLiX('log-items', 'le joueur rencontre un mur')
                                        };
                                        console.log('le joueur se dirige vers le bas');
                                        break;
                                    case 'right':
                                        console.log('le joueur se dirige vers la droite');
                                        if (playerX < 10) {
                                            playerX += step;
                                            appendChildLiX('log-items', 'le joueur se dirige vers la droite ['+playerX+':'+playerY+']');
                                        }else{
                                            appendChildLiX('log-items', 'le joueur rencontre un mur');
                                        };
                                        break;
                                    case 'left':
                                        console.log('le joueur se dirige vers la gauche');
                                        if (playerX > 1){
                                            playerX -= step;
                                            appendChildLiX('log-items', 'le joueur rencontre un mur');
                                        }else{
                                            appendChildLiX('log-items', 'le joueur rencontre un mur');
                                        };
                                        break;

                                    default:
                                        break;
                                }
                                updatePlayerPosition();
                            }
                        }
                        console.log('joueur : ' + playerX + "-" + playerY);
                    };

                    xhttp.open("POST", "index.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    const params = "action=" + encodeURIComponent(action) + "&direction=" + encodeURIComponent(direction);
                    xhttp.send(params);
                }


                // AJAX call to update player position on server
                $.post("index.php", {
                    newPlayerX: playerX,
                    newPlayerY: playerY
                }, function(data) {

                });


                function updatePlayerPosition() {
                    const playerCell = document.querySelector('.player');
                    playerCell.style.gridRow = playerX;
                    playerCell.style.gridColumn = playerY;
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