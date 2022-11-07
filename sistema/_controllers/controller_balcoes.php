<?php

class balcoes extends controller {
	
	protected $_modulo_nome = "Balcões de Retirada";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(103);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$estados = new model_estados_cidades();
		$dados['estados'] = $estados->lista_estados();

		$estado_selecionado = $this->get('uf');
		$dados['estado_selecionado'] = $estado_selecionado;

		$balcoes = new model_balcoes();
		$dados['lista'] = $balcoes->lista($estado_selecionado);
		
		$this->view('balcoes', $dados);
	}

	public function novo(){
		
		$dados['_base'] = $this->base();

		$estados = new model_estados_cidades();
		$dados['estados'] = $estados->lista_estados();

		$this->view('balcoes.novo', $dados);
	}
	
	public function novo_grv(){
		
		$titulo =  $this->post('titulo');
		$descricao = $this->post('descricao');
		$valor = $this->post('valor');
		$uf = $this->post('uf');
		$cidade = $this->post('cidade');

		$this->valida($titulo);

		$valores = new model_valores();
		$valor_tratado = $valores->trata_valor_banco($valor);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir('balcoes', array(
			'codigo'=>$codigo,
			'titulo'=>$titulo,
			'descricao'=>$descricao,
			'valor'=>$valor_tratado,
			'uf'=>$uf,
			'cidade'=>$cidade
		));
		
		$this->irpara(DOMINIO.$this->_controller);
	}

	public function alterar(){
		
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
			
		$estados = new model_estados_cidades();
		$dados['estados'] = $estados->lista_estados();

		$balcoes = new model_balcoes();
		$valores = new model_valores();

		$dados['data'] = $balcoes->carrega($codigo);
		$data = $dados['data'];
		
		$dados['valor'] = $valores->trata_valor($data->valor);
		
		$this->view('balcoes.alterar', $dados);
	}
	
	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo =  $this->post('titulo');
		$descricao = $this->post('descricao');
		$valor =  $this->post('valor');
		$uf = $this->post('uf');
		$cidade = $this->post('cidade');

		$this->valida($codigo);
		$this->valida($valor);
		
		// instancia
		$balcoes = new model_balcoes();
		$valores = new model_valores();

		$valor_tratado = $valores->trata_valor_banco($valor);

		// executa
		$db = new mysql();
		$db->alterar('balcoes', array(
			'titulo'=>$titulo,
			'descricao'=>$descricao,
			'valor'=>$valor_tratado,
			'uf'=>$uf,
			'cidade'=>$cidade
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller);		
	}
	
	public function apagar_varios(){
		
		$balcoes = new model_balcoes();
		
		foreach ($balcoes->lista() as $key => $value){
			if($this->post('apagar_'.$value['id']) == 1){
				
				$db = new mysql();
				$db->apagar('balcoes', " id='".$value['id']."' "); 
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);		
	}

	public function cidades(){
		
		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		echo '<select data-plugin-selectTwo class="form-control populate" name="cidade" >';
		echo "<option value='' >Selecione</option>";
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM cidade where uf='$estado' order by nome asc ");
		while($data = $exec->fetch_object()){
			
			if($cidade == $data->nome){
				$selected = " selected='' ";
			} else {
				$selected = "";
			}
			
			echo "<option value='".$data->nome."' $selected >".$data->nome."</option>";
			
		}
		
		echo "</select>";
		
		echo "
		<script>
			$('select').select2();
		</script>
		";
		
	}

}