<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once('calendario.php');


$explode = explode('/', $_SERVER['REQUEST_URI']);
$mesInformado = $anoInformado = null;
if (array_key_exists(1, $explode))
	$mesInformado = (int) $explode[1];
if (array_key_exists(2, $explode))
	$anoInformado = (int) $explode[2];
if ($mesInformado == "")
	$mesInformado = (int) date('m');
if ($anoInformado == "")
	$anoInformado = (int) date('Y');

$f = new Calendario($anoInformado);
$mes = $f->getMes($mesInformado);




include('main.phtml');