<?php

$json = array();
$json['errori'] = $errori;
$json['mangas'] = array();
foreach($mangas as $manga){
     /* @var $manga manga */
    $element = array();
    $element['titolo'] = $manga->getTitolo();
    $element['volume'] = $manga->getNumeroVolume();
    $element['autore'] = $manga->getAutore();
    $element['prezzo'] = $manga->getPrezzo();
    $json['mangas'][] = $element;
    
}
echo json_encode($json);
?>
