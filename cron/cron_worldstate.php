<?php
if(isset($_GET['token']) && $_GET['token'] === "worldstatexbps4pc") {
    require('autoload.php');

    $var = new GetWorldState();
    $var->getUrlContent();
    $var->selectedDataToFile("ActiveMissions");
}
