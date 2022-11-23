<?php

Class model_cursos extends model{
	
	private $tab_cursos 			= "cursos";
	private $curso_categoria_sel 	= "curso_categoria_sel";
	private $curso_produto 			= "curso_produto";
	private $conteudo_curso_topico  = "conteudo_curso_topico";
	private $curso_conteudo			= "curso_conteudo";
	private $feedback				= "feedback";
	private $curso_feedback			= "curso_feedback";
	
	
	

	public function lista(){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_cursos." order by nome asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['nome'] = $data->nome;
			$i++;
		}
		
		return $lista;
	}	
	public function novo_curso($titulo){ 
	
		$db = new mysql();
		$db->inserir($this->tab_cursos, array(
			"nome"	=>$titulo,
			"status"	=>0
		));
		return $db->ultimo_id();
	}
	public function conteudo_curso_topico_by_id($id){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->conteudo_curso_topico." WHERE id_produto = ".$id);
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$i++;
		}
		
		return $lista;
	}
	public function curso_feedback_by_id($id){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->curso_feedback." WHERE id_curso = ".$id);
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$i++;
		}
		
		return $lista;
	}
	public function lista_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT id, capa FROM ".$this->tab_cursos." WHERE id='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		$imagens = array();
        
        // foreach($data_ordem as $key => $value){
            $imagens[0]['id'] = $data_ordem->id;
            $imagens[0]['imagem'] = $data_ordem->capa;
            $imagens[0]['imagem_p'] = PASTA_CLIENTE.'img_cursos_p/'.$codigo.'/'.$data_ordem->capa;
            $imagens[0]['imagem_g'] = PASTA_CLIENTE.'img_cursos_g/'.$codigo.'/'.$data_ordem->capa;
			// }
            // echo '<pre>';print_r("SELECT capa FROM ".$this->tab_cursos." WHERE id='$codigo' ORDER BY id desc limit 1");exit;

		return $imagens;
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
			print_r("SELECT * FROM curso_conteudo WHERE id_curso_conteudo_topico = '$data->id' order by id asc");exit;
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
    public function carrega_curso($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_cursos." WHERE id='$codigo' ");
		return $exec->fetch_object();
    }
    public function adiciona_imagem($vars){ 

		$db = new mysql();
        $db->alterar($this->tab_cursos, array(
			"capa"	=>$vars[1]
		), " id='$vars[0]' " );
		$ultid = $db->ultimo_id();
		
		return $ultid;
	}
	public function apagar_curso_categoria($id){
		$db = new mysql();
		$db->apagar($this->curso_categoria_sel, " curso_id='$id' ");
	}
	public function curso_produto($id){
		$db = new mysql();
		$db->apagar($this->curso_produto, " id_curso='$id' ");
	}
	public function apagar_curso_conteudo($id){
		$db = new mysql();
		$db->apagar($this->curso_conteudo, " id='$id' ");
	}
	public function apagar_curso_conteudo_topico($id){
		$db = new mysql();
		$db->apagar($this->conteudo_curso_topico, " id_produto='$id' ");
	}
	public function apagar_feedback($id){
		$db = new mysql();
		$db->apagar($this->feedback, " id='$id' ");
	}
	public function apagar_curso_feedback($id){
		$db = new mysql();
		$db->apagar($this->curso_feedback, " id_curso='$id' ");
	}
	public function apagar_curso($id){
		$db = new mysql();
		$db->apagar($this->tab_cursos, " id='$id' ");
	}
	
	

}