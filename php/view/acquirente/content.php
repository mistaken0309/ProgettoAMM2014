<?php
switch ($vista->getSottoPagina()) {
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    default:
        
?>

<p>Sei dentro! Yay!!</p>
<p>Sei un acquirente</p>

    <?php
        break;
}
?>

