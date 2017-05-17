<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once('calendario.php');
$f = new Calendario();
//$datas = $f->getDatas();
$mes = $f->getMes();


include('main.phtml');