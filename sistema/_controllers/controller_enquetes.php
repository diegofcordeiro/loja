<?php

class enquetes extends controller {
	
	protected $_modulo_nome = "Enquetes";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(113);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";


		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM enquete ORDER BY id desc");
		while($data = $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['enquete'] = $data->enquete;
			
			if($data->status == 1){
				$status = "Ativo";
			} else {
				$status = "Finalizado";
			}
			
			$lista[$n]['status'] = $status;

			$n++;
		}
		$dados['lista'] = $lista;

		
		$this->view('enquetes', $dados);
	}	

	public function novo(){
		
		$dados['_base'] = $this->base();

		$this->view('enquetes.novo', $dados);
	}

	public function novo_grv(){
		
		$enquete = $this->post('enquete'); 
		$titulo = $this->post('titulo'); 

		$this->valida($enquete); 
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("enquete", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"enquete"=>"$enquete",
			"status"=>"1"	
		));

		// layout

		$titulo = strip_tags($titulo);

		$layout = new model_layout();
		$tipo = "enquete";
		$titulo_pagina = "Enquete - $titulo";
		$layout->adicionar_pagina($codigo, $titulo_pagina, $tipo);
		$layout->adiciona_cores($tipo, $codigo);


		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/respostas/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'dados';
		}

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM enquete where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();


		$trata = new model_valores();

		//relatorio
		$relatorio = array();

		$conexao = new mysql();
		$coisas_vot_total = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='$codigo' ");
		$linhas_vot_total = $coisas_vot_total->num_rows;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM enquete_resposta WHERE enquete_codigo='$codigo'");
		$n = 0;
		while($data = $coisas->fetch_object()){

			$relatorio[$n]['resposta'] = $data->resposta;
			$relatorio[$n]['codigo'] = $data->codigo;

			$conexao = new mysql();
			$coisas_vot = $conexao->Executar("SELECT id FROM enquete_voto WHERE codigo_enquete='$codigo' AND codigo_resposta='$data->codigo' ");
			$linhas_vot = $coisas_vot->num_rows;

			$relatorio[$n]['votos'] = $linhas_vot;

			if($linhas_vot != 0){
				$porcento = ($linhas_vot / $linhas_vot_total) * 100;
				$porcento = $trata->trata_valor_calculo($porcento);
			} else {
				$porcento = 0;
			}

			$relatorio[$n]['votos_porc'] = $porcento;

			$n++;
		}
		$dados['relatorio'] = $relatorio;

		$layout = new model_layout();
		$dados['cores'] = $layout->lista_cores($codigo);
		$dados['botoes'] = $layout->lista_botoes();
		$dados['lista_css'] = $layout->lista_css();

		$destinos = array();
		$n = 0;

		$db = new mysql();
		$exec_des = $db->executar("SELECT * FROM layout_paginas order by titulo asc");
		while($data_des = $exec_des->fetch_object()){

			$destinos[$n]['titulo'] = $data_des->titulo;
			$destinos[$n]['chave'] = $data_des->chave;

			$n++;
		}
		$dados['destinos'] = $destinos;


		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();

		$this->view('enquetes.alterar', $dados);
	} 
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$enquete = $this->post('enquete');
		$status = $this->post('status');
		$posicao_img = $this->post('posicao_img');
		$botao_titulo = $this->post('botao_titulo');
		$endereco_padrao = $this->post_htm('endereco_padrao');
		$endereco = $this->post_htm('endereco');
		$descricao = $this->post_htm('descricao');
		$posicao_enquete = $this->post('posicao_enquete');
		$botao_codigo_votar = $this->post('botao_codigo_votar');
		$botao_codigo_img = $this->post('botao_codigo_img');
		$botao_codigo_result = $this->post('botao_codigo_result');
		
		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($enquete);
		
		if(isset($_POST['lista_css'])){
			$lista_css = $_POST['lista_css'];
			$lista_css_tratada = implode(' ', $lista_css);
		} else {
			$lista_css_tratada = "";
		}

		if(isset($_POST['lista_css_img'])){
			$lista_css_img = $_POST['lista_css_img'];
			$lista_css_img_tratada = implode(' ', $lista_css_img);
		} else {
			$lista_css_img_tratada = "";
		}

		$db = new mysql();
		$db->alterar("enquete", array(
			"titulo"=>$titulo,
			"enquete"=>$enquete,
			"status"=>$status,
			"posicao_img"=>$posicao_img,
			"botao_titulo"=>$botao_titulo,
			"endereco_padrao"=>$endereco_padrao,
			"endereco"=>$endereco,
			"descricao"=>$descricao,
			"posicao_enquete"=>$posicao_enquete,
			"botao_codigo_votar"=>$botao_codigo_votar,
			"botao_codigo_img"=>$botao_codigo_img,
			"botao_codigo_result"=>$botao_codigo_result,
			"classes"=>$lista_css_tratada,
			'classes_img'=>$lista_css_img_tratada
		), " codigo='$codigo' ");
		
		
		// layout
		$titulo = strip_tags($titulo);
		$layout = new model_layout();
		$tipo = "enquete";
		$titulo_pagina = "Enquete - $titulo";
		$layout->altera_paginas($codigo, $titulo_pagina);
		$layout->adiciona_cores($tipo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function cores_grv(){
		
		$codigo = $this->post('codigo'); 

		$this->valida($codigo); 

		$layout = new model_layout();
		$cores = $layout->lista_cores($codigo);
		foreach ($cores as $key => $value) {
			$cor_nova = $this->post('cor_'.$value['id']);
			if($cor_nova){
				$db = new mysql();
				$db->alterar("layout_itens_cores_sel", array(
					'cor'=>$cor_nova
				), " id='".$value['id']."' ");
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/cores');		
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_enquetes/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					$largura_g = 1200;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
				}

				$db = new mysql();
				$db->alterar("enquete", array(
					"imagem"=>"$nome_arquivo"
				), " codigo='$codigo' ");

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");

			}

		}

	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM enquete WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('../arquivos/img_enquetes/'.$data->imagem);
			}

			$db = new mysql();
			$db->alterar("enquete", array(
				"imagem"=>""
			), " codigo='$codigo' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}
	public function nova_resposta(){
		
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');

		$dados['codigo'] = $codigo;

		$this->view('enquetes.resposta.nova', $dados);
	}


	public function nova_resposta_grv(){

		$codigo_enquete = $this->post('codigo');
		$resposta = $this->post('resposta');

		$codigo = $this->gera_codigo();

		$this->valida($resposta);
		$this->valida($codigo);

		// Grava informações no banco
		$conexao = new mysql();
		$conexao->inserir("enquete_resposta", array(			 
			"codigo"=>"$codigo",
			"enquete_codigo"=>"$codigo_enquete",
			"resposta"=>"$resposta"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo_enquete.'/aba/respostas');
	} 


	public function alterar_resposta(){ 
		
		$dados['_base'] = $this->base();

		$codigo_enquete = $this->get('codigo_enquete');
		$codigo = $this->get('codigo');

		$dados['codigo_enquete'] = $codigo_enquete;
		$dados['codigo'] = $codigo;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM enquete_resposta WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();		 


		$this->view('enquetes.resposta.alterar', $dados);
	}


	public function alterar_resposta_grv(){

		$codigo_enquete = $this->post('codigo_enquete');
		$codigo = $this->post('codigo');
		$resposta = $this->post('resposta');

		$this->valida($resposta);
		$this->valida($codigo);
		$this->valida($codigo_enquete);

		// Grava informações no banco
		$conexao = new mysql();
		$conexao->alterar("enquete_resposta", array(
			"resposta"=>"$resposta"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo_enquete.'/aba/respostas');
	}


	public function apagar_resposta(){

		$codigo_enquete = $this->get('codigo_enquete');
		$codigo = $this->get('codigo'); 

		$this->valida($codigo);
		$this->valida($codigo_enquete);

		$conexao = new mysql();
		$conexao->apagar("enquete_resposta", " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo_enquete.'/aba/respostas');
	}


	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM enquete ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == $data->codigo){

				$conexao = new mysql();
				$conexao->apagar("enquete_resposta", " codigo_enquete='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("enquete", " codigo='$data->codigo' ");
				
				// layout
				$layout = new model_layout(); 
				$layout->apagar_pagina($data->codigo);
				$layout->apagar_cores($data->codigo);
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
		
	}


}