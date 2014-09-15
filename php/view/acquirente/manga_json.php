<?php

$json = array();
$json['errori'] = $errori;
$json['mangas'] = array();
foreach($mangas as $manga){
     /* @var $manga manga */
    $element = array();
    $element['id'] = $manga->getId();
    $element['titolo'] = $manga->getTitolo();
    $element['volume'] = $manga->getNumeroVolume();
    $element['autore_id'] = $manga->getAutore();
    $element['autore'] = AutoreFactory::instance()->getAutorePerId($manga->getAutore())->getAutore();
    $element['prezzo'] = $manga->getPrezzo();
    $json['mangas'][] = $element;
    
}
echo json_encode($json);
?>
