<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once('calendario.php');

if ($mesInformado == "")
	$mesInformado = (int) date('m');
if ($anoInformado == "")
	$anoInformado = (int) date('Y');

$f = new Calendario($anoInformado);
$mes = $f->getMes($mesInformado);

include('main.phtml');