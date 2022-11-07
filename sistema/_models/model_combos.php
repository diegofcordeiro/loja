<?php

Class model_combos extends model{
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// tabelas

	private $tab_combo 			= "combos";
	private $produto_combo 		= "combo_produto";

	public function lista(){
        
        $lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_combo." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['banner'] = $data->banner;
			$lista[$i]['assinatura'] = $data->assinatura;
			$lista[$i]['valor'] = $data->valor;
			$lista[$i]['desconto'] = $data->desconto;
			$i++;
		}
		
		return $lista;
	}	
	public function lista_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT id, capa FROM ".$this->tab_combo." WHERE id='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		$imagens = array();
        
        // foreach($data_ordem as $key => $value){
            $imagens[0]['id'] = $data_ordem->id;
            $imagens[0]['imagem'] = $data_ordem->capa;
            $imagens[0]['imagem_p'] = PASTA_CLIENTE.'img_cursos_p/'.$codigo.'/'.$data_ordem->capa;
            $imagens[0]['imagem_g'] = PASTA_CLIENTE.'img_cursos_g/'.$codigo.'/'.$data_ordem->capa;
			// }
            // echo '<pre>';print_r("SELECT capa FROM ".$this->tab_combo." WHERE id='$codigo' ORDER BY id desc limit 1");exit;

		return $imagens;
	}
	public function novo_combo($titulo){ 
		
		$db = new mysql();
		$db->inserir($this->tab_combo, array(
			"titulo"	=>$titulo
		));
        return $db->ultimo_id();
		
	}
    public function curso_conteudo($codigo){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM conteudo_curso_topico WHERE id_produto = '$codigo' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['id_produto'] = $data->id_produto;
			$lista[$i]['nome'] = $data->nome;
			$lista[$i]['status'] = $data->status;
            $exec2 = $db->executar("SELECT * FROM curso_conteudo WHERE id_curso_conteudo_topico = '$data->id' order by id asc");
            $ii = 0;
            while($data2 = $exec2->fetch_object()) {
                $lista[$i]['conteudo'][$ii]['id'] = $data2->id;
                $lista[$i]['conteudo'][$ii]['nome'] = $data2->nome;
                $lista[$i]['conteudo'][$ii]['icon'] = $data2->icon;
                $lista[$i]['conteudo'][$ii]['visualizar'] = $data2->visualizar;
                $lista[$i]['conteudo'][$ii]['duracao'] = $data2->duracao;
                $lista[$i]['conteudo'][$ii]['perguntas'] = $data2->perguntas;
                $lista[$i]['conteudo'][$ii]['id_curso_conteudo_topico'] = $data2->id_curso_conteudo_topico;
                $lista[$i]['conteudo'][$ii]['status'] = $data2->status;
                $ii++;
            }
			$i++;
		}
		
		return $lista;
	}
    public function carrega_combo($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_combo." WHERE id='$codigo' ");
		return $exec->fetch_object();
    }
    public function adiciona_imagem($vars){ 

		$db = new mysql();
        $db->alterar($this->tab_combo, array(
			"banner"=>$vars[1]
		), " id='$vars[0]' " );
		$ultid = $db->ultimo_id();
		
		return $ultid;
	}
	public function apagar_produto_combo($id){
		$db = new mysql();
		$db->apagar($this->produto_combo, " id_combo='$id' ");
	}
	public function apagar_combo($id){
		$db = new mysql();
		$db->apagar($this->tab_combo, " id='$id' ");
	}
	
}