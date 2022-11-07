<?php

class modulos extends controller {
	
	protected $_modulo_nome = "Módulos";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso('adm');
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$setores = new model_setores();
		$dados['lista'] = $setores->lista_completa();
		
		$this->view('modulos', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$this->view('modulos.novo', $dados);
	}
	
	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$titulo_tecnico = $this->post('titulo_tecnico');
		$ico = $this->post('ico');
		$id_pai = $this->post('id_pai');
		$endereco = $this->post('endereco');
		
		$this->valida($titulo);
		$this->valida($titulo_tecnico);
		
		$setores = new model_setores();
		$id = $setores->inserir(array(
			$id_pai,
			$titulo,
			$titulo_tecnico,
			$endereco,
			$ico
		));

		$perfil = new model_perfil();
		$ordem = $perfil->ordem($this->_cod_usuario);
		$nova_ordem = $ordem.','.$id;
		$perfil->alterar_ordem_menu($nova_ordem, $this->_cod_usuario);

		$this->irpara(DOMINIO.$this->_controller);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$id = $this->get('codigo');

		$setores = new model_setores();
		$dados['data'] = $setores->selecionar($id);

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller);
		}

		$this->view('modulos.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$titulo_tecnico = $this->post('titulo_tecnico');
		$ico = $this->post('ico');
		$id_pai = $this->post('id_pai');
		$endereco = $this->post('endereco');
		
		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($titulo_tecnico);
		
		$setores = new model_setores();
		$setores->alterar(array(
			$id_pai,
			$titulo,
			$titulo_tecnico,
			$endereco,
			$ico
		), array(
			$codigo
		));

		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function apagar_varios(){
		
		$setores = new model_setores();
		$lista = $setores->lista_completa();

		foreach ($lista as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){

				$setores->apagar(array(
					$value['id']
				));

			}
		}
		
		$this->irpara(DOMINIO.$this->_controller);
	}

	public function bloqueios(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Bloqueios";

		$setores = new model_setores();
		$lista = $setores->lista_completa();

		$lista_org = new model_ordena_permissoes();
		$lista_org->monta(0, $lista);
		
		$dados['lista'] = $lista_org->_lista_certa;

		$this->view('modulos.bloqueios', $dados);
	}
	
	public function bloqueios_grv(){
		
		$setores = new model_setores();
		$lista = $setores->lista_completa();

		$nova_ordem = "";

		foreach ($lista as $key => $value) {
			
			if( $this->post('setor_'.$value['id']) ){
				if(!$value['check']){ 
					$setores->adiciona_perfil($value['id']);
				}
				if($value['id_pai'] == 0){
					$nova_ordem .= $value['id'].',';
				}
			} else {
				if($value['check']){ 
					$setores->remove_perfil($value['id']);					
				}
			}

		}

		$perfil = new model_perfil();
		$perfil->alterar_ordem_menu($nova_ordem, $this->_cod_usuario);

		$this->irpara(DOMINIO.$this->_controller.'/bloqueios');		
	}

	public function ajuda(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Ajuda";

		$ajuda = new model_ajuda();
		$dados['lista'] = $ajuda->lista_tudo();

		//<span class="ajuda" title=" $_base['ajuda']['1'] " ></span>

		$this->view('modulos.ajuda', $dados);
	}

	public function ajuda_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT id FROM ajuda order by id desc limit 1");
		$data = $exec->fetch_object();
		$dados['ultimo_id'] = $data->id;
		
		$this->view('modulos.ajuda.novo', $dados);
	}
	
	public function ajuda_novo_grv(){

		$grupo = $this->post('grupo');
		$descricao = $this->post('descricao');

		$this->valida($grupo);
		$this->valida($descricao);

		$db = new mysql();
		$db->inserir("ajuda", array(
			"grupo"=>"$grupo",
			"descricao"=>"$descricao"
		));

		$this->irpara(DOMINIO.'modulos/ajuda');
	}

	public function ajuda_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$id = $this->get('id');
		$this->valida($id);

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM ajuda where id='$id' ");
		$dados['data'] = $exec->fetch_object();

		$this->view('modulos.ajuda.alterar', $dados);
	}

	public function ajuda_alterar_grv(){

		$id = $this->post('id');
		$grupo = $this->post('grupo');
		$descricao = $this->post('descricao');

		$this->valida($id);
		$this->valida($grupo);
		$this->valida($descricao);

		$db = new mysql();
		$db->alterar("ajuda", array(
			"grupo"=>"$grupo",
			"descricao"=>"$descricao"
		), " id='$id' ");

		$this->irpara(DOMINIO.'modulos/ajuda');
	}

	public function ajuda_apagar_varios(){

		$ajuda = new model_ajuda();
		$lista = $ajuda->lista_tudo();

		foreach ($lista as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){
				$db = new mysql();
				$db->apagar("ajuda", " id='".$value['id']."' ");
			}
		}
		
		$this->irpara(DOMINIO.'modulos/ajuda');
	}

}