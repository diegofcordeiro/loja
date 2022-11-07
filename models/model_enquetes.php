<?php

Class model_enquetes extends model{
	
	public function carregar($codigo){

		$retorno = array();		 

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM enquete WHERE codigo='$codigo' ");
		$data = $exec->fetch_object();
		
		$retorno['data'] = $data;

		// cores
		$layout = new model_layout();
		$retorno['cores'] = $layout->lista_cores($codigo);

		$retorno['botao_votar'] = $layout->carrega_botao($data->botao_codigo_votar, " aquivaiolink ", true);
		$retorno['botao_result'] = $layout->carrega_botao($data->botao_codigo_result, " aquivaiolink ", true);
		
		if($data->botao_codigo_img){
			$retorno['botao_img'] = $layout->carrega_botao($data->botao_codigo_img, " aquivaiolink ", true);
		} else {
			$retorno['botao_img'] = "";
		}

		//calcula total de votos
		$trata = new model_valores();	

		$conexao = new mysql();
		$coisas_vot_total = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='".$codigo."' ");
		$linhas_vot_total = $coisas_vot_total->num_rows;

		//lisa respostas
		$respostas = array();
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM enquete_resposta WHERE enquete_codigo='".$codigo."' ");
		$n = 0;
		while($data = $coisas->fetch_object()){
			
			$respostas[$n]['texto'] = $data->resposta;
			$respostas[$n]['codigo'] = $data->codigo;

				//calula numero de votos
			$conexao = new mysql();
			$coisas_vot = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='".$codigo."' AND codigo_resposta='$data->codigo' ");
			$linhas_vot = $coisas_vot->num_rows;

			$respostas[$n]['votos'] = $linhas_vot;

				//calula porcentagem de votos
			if($linhas_vot != 0){
				$porcento = ($linhas_vot / $linhas_vot_total) * 100;
				$porcento = $trata->trata_valor_calculo($porcento);
			} else {
				$porcento = 0;
			}
			$respostas[$n]['votos_porc'] = $porcento;

			$n++;
		}
		$retorno['enquete_respostas'] = $respostas;
		

		
		return $retorno;
	}
	
}