<?php		
	function getFeriados($ano, $mes){
		$feriados = [];
		$schoolDays = \App\SchoolDay::where(DB::raw('YEAR(date)'), $ano)->where(DB::raw('MONTH(date)'), $mes)->get();
		foreach ($schoolDays as $key => $f) {				
			$feriados[date('d', strtotime($f->date))]['name'] = $f->description;			
			$feriados[date('d', strtotime($f->date))]['type'] = $f->type;			
		}

		return $feriados;
	}

	function getFaltas($ano, $mes, $id){
		$faltas = [];
		$absences = \App\Absence::where(DB::raw('YEAR(date)'), $ano)->where(DB::raw('MONTH(date)'), $mes)->where('student_id', $id)->get();
		foreach ($absences as $key => $f) {							
			$faltas[date('d', strtotime($f->date))] = $f->type;			
		}

		return $faltas;
	}

	function MostreSemanas()
	{
		$semanas = "DSTQQSS";
	 
		for( $i = 0; $i < 7; $i++ )
		 echo "<td><div class='dia semana'>".$semanas{$i}."</div></td>";
	 
	}
	 
	function GetNumeroDias( $mes )
	{
		$numero_dias = array( 
				'01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
				'07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
		);
	 
		if (((date('Y') % 4) == 0 and (date('Y') % 100)!=0) or (date('Y') % 400)==0)
		{
		    $numero_dias['02'] = 29;
		}
	 
		return $numero_dias[$mes];
	}
	 
	function GetNomeMes( $mes )
	{
	     $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
	                     '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
	                     '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
	                     '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro"
	                     );
	 
	      if( $mes >= 01 && $mes <= 12)
	        return $meses[$mes];
	 
	        return "Mês deconhecido";
	 
	}
	 
	 
	 
	function MostreCalendario( $mes, $student_id = NULL)
	{
	 
		$numero_dias = GetNumeroDias( $mes );	// retorna o número de dias que tem o mês desejado
		$nome_mes = GetNomeMes( $mes );
		$diacorrente = 0;	
	 	$feriados = getFeriados(date('Y'), $mes);
	 	if($student_id != NULL){
	 		$faltas = getFaltas(date('Y'), $mes, $student_id);
	 	}
		$diasemana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $mes,"01",date('Y')) , 0 );	// função que descobre o dia da semana
	 
		echo "<table class='calendario' border = 0 cellspacing = '0' align = 'center'>";

		 echo '<caption class="mes">'. $nome_mes . '</caption>';
		 echo "<tr>";
		   MostreSemanas();	// função que mostra as semanas aqui
		 echo "</tr>";
		for( $linha = 0; $linha < 6; $linha++ )
		{
	 
	 
		   echo "<tr>";
	 
		   for( $coluna = 0; $coluna < 7; $coluna++ ){
				echo "<td width = 30 height = 30 ";
				
				$class = "dia-letivo";

				$diaSemanaCorrente = jddayofweek( cal_to_jd(CAL_GREGORIAN, $mes, $diacorrente+1 ,date('Y')) , 0 );
				$diaPad = str_pad($diacorrente+1, 2, '0', STR_PAD_LEFT);
				if(
					($coluna >= $diasemana || $linha != 0) && 
					$numero_dias >= $diacorrente+1 && 
					($diaSemanaCorrente == 0 || $diaSemanaCorrente == 6) 
				)				
					$class = "fds-feriado";
				elseif(($coluna >= $diasemana || $linha != 0) && 
					$numero_dias >= $diacorrente+1)
					$class = "dia-letivo";

				if(isset($feriados[$diaPad])){
					if($feriados[$diaPad]['type'] == 'FERIADO')				
						$class = "fds-feriado";
					elseif($feriados[$diaPad]['type'] == 'DIA_ESCOLAR')				
						$class = "dia-escolar";
					elseif($feriados[$diaPad]['type'] == 'LIMITE_SEMESTRE_LETIVO')				
						$class = "ini-fim-semestre";
					elseif($feriados[$diaPad]['type'] == 'SABADO_LETIVO')				
						$class = "sabado-letivo";
					else
						$class = "dia-letivo";
				}
				
				if(isset($faltas[$diaPad])){
					switch ($faltas[$diaPad]) {
						case 'F':
							$class .= ' falta-nao-justificada';
							break;
						case 'J':
							$class .= ' faltas-justificada';
							break;
						case 'A':
							$class .= ' atestado-medico';
							break;
						case 'P':
							$class .= ' paralisacao';
							break;
						case 'G':
							$class .= ' greve';
							break;
						case 'I':
							$class .= ' intemperie';
							break;
						
						default:
							# code...
							break;
					}
				}
				// echo " class='fds-feriado'";
				echo " class='{$class}'";

				echo ' align = "center" valign = "center">';

				$currentDate = date('Y') . '-' . $mes . '-' . $diaPad;

				if( $diacorrente + 1 <= $numero_dias ){
					if( $coluna < $diasemana && $linha == 0){
						echo " ";
					}else{					
				   		echo "<div class='dia change-event change-event-students' data-day='{$currentDate}'>".++$diacorrente . "</div>";
					}
				}else{

				}

				/* FIM DO TRECHO MUITO IMPORTANTE */
	 
	 
	 
			echo "</td>";
		   }
		   echo "</tr>";
		}
			echo "<tfoot>";
				echo "<tr>";
					echo "<td colspan='7'>";						
						foreach ($feriados as $key => $feriado) {		
							if($feriado['type'] == "FERIADO")					
								echo "<small>{$key} - {$feriado['name']} </small><br>";
						}
					echo "</td>";
				echo "</tr>";
			echo "</tfoot>";
	 
		echo "</table>";
	}
	 
	function MostreCalendarioCompleto()
	{
		    echo '<table align = "center">';
		    $cont = 1;
		    for( $j = 0; $j < 4; $j++ )
		    {
			  echo "<tr>";
			for( $i = 0; $i < 3; $i++ )
			{
			 
			  echo "<td>";
				MostreCalendario( ($cont < 10 ) ? "0".$cont : $cont );  
	 
			        $cont++;
			  echo "</td>";
	 
		 	}
			echo "</tr>";
		   }
		   echo "</table>";
	}	 
	
	
?>