<?php
//http://www.inf.ufrgs.br/~cabral/Pascoa.html


class Data{
	public  $feriado = '', $diaUtil = true, $data, $dia, $mes, $diaSemana, $index;

	public function __construct($data, $feriado = ''){
		if ($feriado != ''){
			$this->feriado = $feriado;
			$this->diaUtil = FALSE;
		}
		$this->index = $data;
		$this->data = DateTime::createFromFormat('Ymd', $data);
		$this->diaSemana = $this->data->format('w');
		$this->mes = $this->data->format('m');
		$this->dia = $this->data->format('d');
		$this->timestamp = $this->data->format('U');
		if (in_array($this->diaSemana, [0,6])) //0 -> domingo 6-sábado
			$this->diaUtil = FALSE;


	}
	public function getDiaSemana(){
		return $this->diaSemana;
	}
	public function getMes(){
		return $this->mes;
	}
	public function __toString(){
		return $this->index . ' dow: ' . $this->diaSemana . ' feriado; ' . $this->feriado;
	}
	public function isDiaUtil(){
		if (in_array($this->diaSemana, ["6","0"]) || $this->feriado != '' )
			return FALSE;
		else
			return TRUE;
	}
	public  function getDiaSemanaAbr(){
		return $this->getDiaSemanaExtenso($this->diaSemana);
	}
	public static function getDiaSemanaExtenso($diaSemana){
		switch ($diaSemana) {
			case 0:
				return 'Dom';
			case 1:
				return 'Seg';
			case 2:
				return 'Ter';
			case 3:
				return 'Qua';
			case 4:
				return 'Qui';
			case 5:
				return 'Sex';
			case 6:
				return 'Sab';
			
		}
	}
	public static function getMesExtenso($mes){
		switch ($mes) {
			case 1:
				return 'Janeiro';
			case 2:
				return 'Fevereiro';
			case 3:
				return 'Março';
			case 4:
				return 'Abril';
			case 5:
				return 'Maio';
			case 6:
				return 'Junho';
			case 7:
				return 'Julho';
			case 8:
				return 'Agosto';
			case 9:
				return 'Setembro';
			case 10:
				return 'Outubro';
			case 11:
				return 'Novembro';
			case 12:
				return 'Dezembro';
		}
	}
}
class Calendario {

	private $datas;
	public function __construct($ano=null){
		if ($ano === NULL){
			$ano = date('Y');
		}
		$feriados = $this->getFeriados($ano);

		for($mes = 1; $mes <=12; $mes++){
			for($dia = 1; $dia<= cal_days_in_month(CAL_GREGORIAN, $mes, $ano); $dia++){
				$dia = str_pad($dia, 2, 0, STR_PAD_LEFT);
				$mes = str_pad($mes, 2, 0, STR_PAD_LEFT);
				if (array_key_exists($ano.$mes.$dia, $feriados))
					$this->datas[] = new Data($ano.$mes.$dia, $feriados[$ano.$mes.$dia]);
				else
					$this->datas[] = new Data($ano.$mes.$dia);
			}
		}

	}
	public function getDatas(){
		return $this->datas;
	}
	public function getMes($mes = ''){
		if ($mes === ''){
			$mes = date('m');
		}
		
		$retorno = [];
		foreach ($this->datas as $value) {
			if ($value->getMes() == $mes)
				$retorno[] = $value;
		}
		return $retorno;
	}
	public  function getFeriados($ano = null, $uf = 'DF'){
		$datasFixas = [
			'00000101' => 'Confraternização Universal',
			'00000421' => 'Tiradentes',
			'00000501' => 'Dia do Trabalhador',
			'00000907' => 'Independência do Brasil',
			'00001012' => 'Padroeira do Brasil',
			'00001102' => 'Finados',
			'00001115' => 'Proclamação da República',
			'00001225' => 'Natal'
		];
		$feriadosEstaduais = [
			'DF' => [
				'00000421' => 'Fundação de Brasília',
				'00001130' => 'Dia do Evangélico',
			]
		];
		$datasMoveis = [
			'Carnaval' => '-47',
			'Sexta-feira da Paixão' => '-2',
			'Corpus Christi' => '+60',
			'Páscoa' => '+0'
		];
		if ($ano === NULL){
			$ano = date('Y');
		}
		$dm = [];
		$pascoa = easter_date($ano);
		foreach ($datasMoveis as $key => $value) {
			$d = date('md', strtotime($value . ' days', $pascoa));
			$dm['0000'.$d] = $key;
		}

		$resultado = array_merge($dm, $datasFixas, $feriadosEstaduais[$uf]);
		ksort($resultado);

		foreach ($resultado as $key => $value) {
			$resultado[str_replace('0000', $ano, $key)] = $value;
			unset($resultado[$key]);
		}

		return $resultado;

	}

}
