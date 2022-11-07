<?php

Class model_layout extends model{	

	public function lista_itens($codigo){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM layout_itens_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);
			
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM layout_itens WHERE codigo='$value' AND pagina='$codigo' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					if($data->ativo == 1){
						$lista[$data->codigo]['codigo'] = $data->codigo;
						$lista[$data->codigo]['titulo'] = $data->titulo;
						$lista[$data->codigo]['tipo'] = $data->tipo;
					}
				}
			}
		}

		return $lista;
	}

	public function lista_cores($pagina){
		
		$cores = array();
		
		$conexao = new mysql();
		$coisas_cores = $conexao->Executar("SELECT * FROM layout_itens_cores_sel WHERE item_codigo='$pagina' ");
		while($data_cores = $coisas_cores->fetch_object()){
			$cores[$data_cores->cor_id] = $data_cores->cor;
		}

		$retorno['lista'] = $cores;
		$retorno['detalhes'] = $this->lista_cores_nome($pagina);
		
		return $retorno;
	}

	public function lista_cores_nome($pagina){
		
		$cores = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas_cores = $conexao->Executar("SELECT * FROM layout_itens_cores_sel WHERE item_codigo='$pagina' ");
		while($data_cores = $coisas_cores->fetch_object()){
			$cores[$n]['tipo'] = $data_cores->tipo;
			$cores[$n]['id'] = $data_cores->cor_id;
			$cores[$n]['titulo'] = $data_cores->titulo;
			$cores[$n]['cor'] = $data_cores->cor;
			$n++;
		}
		
		return $cores;
	}
	
	public function carrega_botao($codigo, $destino, $onclick){
		
		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM layout_botoes WHERE codigo='$codigo' ");
		$data = $coisas->fetch_object();
		
		if(isset($data->codigo)){
			
			$botao = "
			<style>
			a.botao_".$codigo.", .botao_".$codigo."{
				border:".$data->borda."px solid ".$data->cor_borda." !important; 
				border-radius:".$data->borda_radius."px !important; 
				color:".$data->cor_texto." !important;
				cursor:pointer !important;
				padding-top:".$data->padding_top."px !important;
				padding-left:".$data->padding_left."px !important;
				padding-right:".$data->padding_right."px !important;
				padding-bottom:".$data->padding_bottom."px !important;
				";

				if($data->imagem_fundo){

					$botao .= "
					background-image:url(".DOMINIO."arquivos/img_botoes/".$data->imagem_fundo.") !important;
					background-repeat:no-repeat !important; 
					background-size:cover !important; 
					background-position:center !important;
					";

				}

				$botao .= "
			}
			a.botao_".$codigo.":hover, .botao_".$codigo.":hover {
				border:".$data->borda."px solid ".$data->cor_sel_borda." !important; 
				border-radius:".$data->borda_radius."px !important;
				color:".$data->cor_sel_texto." !important;
			}

			</style>
			";

			if(!$onclick){
				$href = "href='".$destino."' ";
			} else {
				$href = $destino;
			}

			$botao .= "<a class='botao_padrao botao_".$codigo."' ".$href." >".$data->texto."</a>";

		} else {
			
			$href = $destino;
			$botao = "<a class='botao_padrao botao_".$codigo."' ".$href." >OK</a>";

		}
		
		return $botao;
	}

	public function lista_css(){

		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT classe, conteudo FROM layout_css ORDER BY id asc");
		while($data = $coisas->fetch_object()){ 
			
			$lista[$n]['classe'] = $data->classe;
			$lista[$n]['conteudo'] = $data->conteudo;
			$n++;
		}
		
		return $lista;
	}
}