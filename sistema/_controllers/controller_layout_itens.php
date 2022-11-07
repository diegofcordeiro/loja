<?php

class layout_itens extends controller {
	
	protected $_modulo_nome = "Layout - Itens";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(132);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$aba = $this->get('aba');
		if($aba){
			$dados['aba_selecionada'] = $aba;
		} else {
			$dados['aba_selecionada'] = 'botoes';
		}

		$dados['codigo_selecionado'] = $this->get('codigo');

		$layour = new model_layout();
		$dados['botoes'] = $layour->lista_botoes();
		$dados['lista_css'] = $layour->lista_css();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();


		$this->view('layout_itens', $dados);
	}

	public function botoes_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('layout_itens.botoes.novo', $dados);
	}

	public function botoes_novo_grv(){
		
		$titulo = $this->post('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("layout_botoes", array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'texto'=>'<p style="text-align: center; "><b>Botão</b></p>',
			'borda'=>0,
			'borda_radius'=>2,
			'cor_fundo'=>'#000000',
			'cor_borda'=>'#000000',
			'cor_texto'=>'#ffffff',
			'cor_sel_fundo'=>'#000000',
			'cor_sel_borda'=>'#000000',
			'cor_sel_texto'=>'#ffffff',
			'padding_top'=>'7px',
			'padding_left'=>'20px',
			'padding_right'=>'20px',
			'padding_bottom'=>'7px'
		));

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/botoes/codigo/'.$codigo);
	}

	public function botoes_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro!');
			$this->volta(1);
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_botoes WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$fontes = new model_fontes();
		$dados['fontes'] = $fontes->lista();
		
		$this->view('layout_itens.botoes.alterar', $dados);
	}

	public function botoes_imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		$codigo = $this->get('codigo');

		$diretorio = "../arquivos/img_botoes/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				$db = new mysql();
				$db->alterar("layout_botoes", array( 
					"imagem_fundo"=>$nome_arquivo
				), " codigo='$codigo' ");

			} else {				
				$this->msg('Erro ao gravar imagem!'); 
			}

			$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/botoes/codigo/'.$codigo);

		}

	}

	public function botoes_imagem_apagar(){
		
		$codigo = $this->get('codigo');

		if($codigo){  

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM layout_botoes WHERE codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem_fundo){
				unlink('../arquivos/img_botoes/'.$data->imagem_fundo);
			}

			$db = new mysql();
			$db->alterar("layout_botoes", array( 
				"imagem_fundo"=>""
			), " codigo='$codigo' ");			

			$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/botoes/codigo/'.$codigo);

		} else {
			$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/botoes');
		}
	}

	public function botoes_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$texto = $this->post_htm('texto');
		$borda = $this->post('borda');
		$borda_radius = $this->post('borda_radius');

		$padding_top = $this->post('padding_top');
		$padding_left = $this->post('padding_left');
		$padding_right = $this->post('padding_right');
		$padding_bottom = $this->post('padding_bottom');
		
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("layout_botoes", array(
			"titulo"=>$titulo,
			"texto"=>$texto,
			"borda"=>$borda,
			"borda_radius"=>$borda_radius,
			"padding_top"=>$padding_top,
			"padding_left"=>$padding_left,
			"padding_right"=>$padding_right,
			"padding_bottom"=>$padding_bottom
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller);	
	}

	public function botoes_cores_grv(){

		$codigo = $this->post('codigo');
		
		$cor_fundo = $this->post('cor_fundo');
		$cor_borda = $this->post('cor_borda');
		$cor_texto = $this->post('cor_texto');

		$cor_sel_fundo = $this->post('cor_sel_fundo');
		$cor_sel_borda = $this->post('cor_sel_borda');
		$cor_sel_texto = $this->post('cor_sel_texto');

		$db = new mysql();
		$db->alterar("layout_botoes", array(
			"cor_fundo"=>$cor_fundo,
			"cor_borda"=>$cor_borda,
			"cor_texto"=>$cor_texto,
			"cor_sel_fundo"=>$cor_sel_fundo,
			"cor_sel_borda"=>$cor_sel_borda,
			"cor_sel_texto"=>$cor_sel_texto
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller);	
	}

	public function botoes_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_botoes WHERE id!='1' ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == $data->codigo){
				
				if($data->imagem_fundo){
					unlink('../arquivos/img_botoes/'.$data->imagem_fundo);
				}
				
				$conexao = new mysql();
				$conexao->apagar("layout_botoes", " codigo='$data->codigo' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial');
	}


	public function fontes_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('layout_itens.fontes.novo', $dados);
	}

	public function fontes_novo_grv(){

		$titulo = $this->post('titulo');
		$family = $this->post('family');

		$this->valida($titulo);
		$this->valida($family);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("layout_fontes", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"family"=>"$family",
			"tipo"=>"css"
		));

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/fontes/codigo/'.$codigo);
	}

	public function fontes_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');	

		if(!$codigo){
			$this->msg('Erro!');
			$this->volta(1);
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_fontes WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('layout_itens.fontes.alterar', $dados);
	}

	public function fontes_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$family = $this->post('family');
		$endereco = $this->post_htm('endereco');
		$tipo = $this->post('tipo');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($family);
		$this->valida($tipo);

		if($tipo == 'arquivo'){

			$arquivo_original = $_FILES['arquivo'];
			$tmp_name = $_FILES['arquivo']['tmp_name'];

			//carrega model de gestao de imagens
			$arquivo = new model_arquivos_imagens();

			$diretorio = "../arquivos/fontes/";

			if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

				//pega a exteção
				$nome_original = $arquivo_original['name'];
				$extensao = $arquivo->extensao($nome_original);
				$nome_arquivo  = $arquivo->trata_nome($nome_original);

				if(copy($tmp_name, $diretorio.$nome_arquivo)){

					//grava banco
					$db = new mysql();
					$db->alterar("layout_fontes", array(
						"titulo"=>"$titulo",
						"family"=>"$family",
						"endereco"=>"",
						"arquivo"=>"$nome_arquivo",
						"tipo"=>"$tipo"
					), " codigo='$codigo' ");

					$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/fontes');

				} else {
					$this->msg('Erro ao gravar arquivo!');
					$this->volta(1);
				}

			}

		} else {

			$this->valida($endereco);

			$db = new mysql();
			$db->alterar("layout_fontes", array(
				"titulo"=>"$titulo",
				"family"=>"$family",
				"endereco"=>"$endereco",
				"arquivo"=>"",
				"tipo"=>"$tipo"
			), " codigo='$codigo' ");

			$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/fontes');

		}		

	}

	public function fontes_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_fontes WHERE id!='1' ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == $data->codigo){

				if($data->tipo == 'arquivo'){
					if($data->arquivo){
						unlink('../arquivos/fontes/'.$data->arquivo);
					}	
				}

				$conexao = new mysql();
				$conexao->apagar("layout_fontes", " codigo='$data->codigo' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/fontes');
	}


	public function css_novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('layout_itens.css.novo', $dados);
	}

	public function css_novo_grv(){
		
		$titulo = $this->post('titulo');
		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$nomeclasse = 'pers_'.time();

		$db = new mysql();
		$db->inserir("layout_css", array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'conteudo'=>'',
			'classe'=>$nomeclasse
		));

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/css/codigo/'.$codigo);
	}

	public function css_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro!');
			$this->volta(1);
			exit;
		}

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM layout_css WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('layout_itens.css.alterar', $dados);
	}

	public function css_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo'); 
		$conteudo = $this->post_htm('conteudo'); 

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("layout_css", array(
			"titulo"=>$titulo,
			"conteudo"=>$conteudo
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/css');

	}

	public function css_apagar(){

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM layout_css  ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == $data->codigo){

				$conexao = new mysql();
				$conexao->apagar("layout_css", " codigo='$data->codigo' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/css');
	}
}