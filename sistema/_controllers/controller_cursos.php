<?php

class cursos extends controller {
	
	protected $_modulo_nome = "cursos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(73);
	}
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";		
		// echo'<pre>';print_r('a');exit;

		// Instancia
		$cursos = new model_cursos();
		
		$dados['lista'] = $cursos->lista();

		// echo'<pre>';print_r($dados);exit;
		$this->view('cursos', $dados);
	}
	public function novo(){
				
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('cursos.novo', $dados);
	}
    public function novo_curso(){
		$titulo = $this->post('titulo');
		
		$cursos = new model_cursos();
		$last_id = $cursos->novo_curso($titulo);

		$this->irpara(DOMINIO.$this->_controller.'/alterar_curso/codigo/'.$last_id.'/aba/dados');
    }
    public function alterar_curso(){
		
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
        
        // instancia
		$cursos = new model_cursos();	
        $produtos = new model_produtos();
        $dados['imagens'] = $cursos->lista_imagens($codigo);
		$dados['data'] = $cursos->carrega_curso($codigo);
		$dados['curso_conteudo'] = $cursos->curso_conteudo($codigo);
		$dados['categorias'] = $produtos->lista_categorias_cursos($codigo);


		$db = new mysql();
		$exec = $db->executar("SELECT feedback.* 
								FROM `feedback` 
								inner join curso_feedback on feedback.id = curso_feedback.id_feedback 
								where curso_feedback.id_curso = '$codigo' order by id desc");
		$lista = array();
		$i = 0;

		while($data = $exec->fetch_object()) {
			$lista[$i]['id'] = $data->id;
			$lista[$i]['nome'] = $data->nome;
			$lista[$i]['estrela'] = $data->estrela;
			$lista[$i]['texto'] = $data->texto;
			$i++;
		}

		$dados['lista_feedback'] = $lista;
		$dados['link'] = DOMINIO.$this->_controller.'/alterar_curso/codigo/'.$codigo.'/aba/conteudo_curso';
		$dados['link_feedback'] = DOMINIO.$this->_controller.'/alterar_curso/codigo/'.$codigo.'/aba/feedback';
		$this->view('cursos.alterar', $dados);
	}
    public function alterar_curso_dados(){

		$titulo = $this->post('titulo');
		$previa = $_POST['previa'];
		$descricao = $_POST['descricao'];
		$descricao_card = $_POST['descricao_card'];
		$summary = $_POST['summary'];
		$avaliacao = $_POST['avaliacao'];
		$esconder = $_POST['esconder'];
		$codigo = $_POST['codigo'];
		$data_vencimento = strtotime($_POST['data_vencimento']);

		
		$db = new mysql();
		$db->alterar("cursos", array(
			"nome"=>$titulo,
			"esconder"=> $esconder,
			"previa"=>$previa,
			"descricao"=>$descricao,
			"descricao_card"=>$descricao_card,
			"summary"=>$summary
		), " id='$codigo' ");
		// echo'<pre>';print_r($db);exit;
		$this->irpara(DOMINIO.$this->_controller.'/alterar_curso/codigo/'.$codigo.'/aba/dados');
	}
	public function alterar_curso_categorias(){

		$codigo = $this->post('codigo');
		// instancia
		$produtos = new model_produtos();
		
		foreach ($produtos->lista_categorias_todas() as $key => $value) {
			
			$produtos->confere_curso_categoria($value['codigo'], $codigo);

			if( $this->post('categoria_'.$value['id']) ){				 

				if(!$produtos->confere_curso_categoria($value['codigo'], $codigo)){					
					$produtos->adiciona_curso_categoria($value['codigo'], $codigo);					
				}

			} else {

				if($produtos->confere_curso_categoria($value['codigo'], $codigo)){					
					$produtos->apaga_curso_categoria($value['codigo'], $codigo);					
				}

			}

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar_curso/codigo/'.$codigo.'/aba/categorias');
	}
	public function apagar_varios(){

		$cursos = new model_cursos();
		foreach ($cursos->lista() as $key => $value) {			
			
			if($this->post('apagar_'.$value['id']) == 1){		

				$cursos->apagar_curso_categoria($value['id']);
				$cursos->curso_produto($value['id']);

				$cursos_topicos = $cursos->conteudo_curso_topico_by_id($value['id']);
				foreach ($cursos_topicos as $top){
					$cursos->apagar_curso_conteudo($top['id']);
				}
				
				$curso_feedback = $cursos->curso_feedback_by_id($value['id']);
				foreach ($curso_feedback as $feed){
					$cursos->apagar_feedback($feed['id']);
				}
				
				$cursos->apagar_curso_conteudo_topico($value['id']);
				$cursos->apagar_curso_feedback($value['id']);

				$cursos->apagar_curso($value['id']);

				unlink('../arquivos/img_cursos_g/'.$value['id'].'/'.$value['capa']);
				unlink('../arquivos/img_cursos_p/'.$value['id'].'/'.$value['capa']);						 
			
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}
	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$produtos = new model_produtos();
		$dados['categorias'] = $produtos->lista_categorias();

		$this->view('produtos.categorias', $dados);
	}
    public function upload(){

		//carrega normal
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('enviar_imagens', $dados);
	}
    public function imagem_manual(){

		$tmp_name = $_FILES['arquivo']['tmp_name'];
		$codigo = $this->get('codigo');		
		$nome_original = $_FILES['arquivo']['name'];
		//definições de pasta
		$pasta = "cursos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();
		$cursos = new model_cursos();

		if($tmp_name) {
			$nome_foto  = $img->trata_nome($nome_original);

			$extensao = $img->extensao($nome_original);
			if(copy($tmp_name, $diretorio_g.$nome_foto)){
				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1920;
					$altura_g = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

					//redimenciona miniatura 
					if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
						copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					}

				} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

				}

				//grava banco e retorna id
				$ultid = $cursos->adiciona_imagem(array(
					$codigo,
					$nome_foto
				));
				
			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar_curso/codigo/".$codigo."/aba/imagem");
		}

	}
    public function imagem_redimencionada(){
        $tmp_name = $_FILES['arquivo']['tmp_name'];
		$codigo = $this->post('codigo');

		$pasta = "cursos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();
		$cursos = new model_cursos();

		$imagem = $_POST['imagem'];
		$nome_original = $this->post('nomeimagem');

		$nome_foto  = $img->trata_nome($nome_original);
		$nome_foto  = 'ak'.$nome_foto;
		$extensao = $img->extensao($nome_original);

		list($tipo, $dados) = explode(';', $imagem);
		list(, $tipo) = explode(':', $tipo);
		list(, $dados) = explode(',', $dados);
		$dados = base64_decode($dados);
		$nome = md5(uniqid(time()));

		if(file_put_contents($diretorio_g.$nome_foto, $dados)) {			
			if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
				$largura_g = 1920;
				$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
				$largura_p = 300;
				$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
				$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
				if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
				}
			} else {
				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
			}
			$ultid = $cursos->adiciona_imagem(array(
				$codigo,
				$nome_foto
			));
		}

	}
    public function alterar_produto_conteudo_curso(){
		
        $id_produto = $_POST['codigo'];
        $nome = $_POST['nome_topico'];
        $id_topico = $_POST['id_topico'];

        if(isset($_POST['id_topico'])){
			$db = new mysql();
		    $db->apagar('curso_conteudo', " id_curso_conteudo_topico ='$id_topico' ");
            $db->alterar('conteudo_curso_topico', array("nome"=>"$nome"), "id='$id_topico' ");
			
            foreach($_POST['nome_conteudo'] as $key => $value){
				
                $icon = $_POST['icon'][$key];
                $visualizaca = $_POST['visualizaca'][$key];
                $duracao = $_POST['duracao'][$key];
                $perguntas = $_POST['perguntas'][$key];

                $db->inserir('curso_conteudo', array(
                    "nome"=>"$value",
                    "icon"=>"$icon",
                    "visualizar"=>"$visualizaca",
                    "duracao"=>"$duracao",
                    "perguntas"=>"$perguntas",
                    "id_curso_conteudo_topico"=>"$id_topico",
                    "status"=>1
                ));
				echo '1';
				print_r($db);exit;
				
            }
            $this->irpara(DOMINIO.$this->_controller."/alterar_curso/codigo/".$id_produto."/aba/conteudo_curso");

        }else{
            $db = new mysql();
            $db->inserir('conteudo_curso_topico', array(
                "id_produto"=>"$id_produto",
                "nome"=>"$nome",
                "status"=>1
            ));
            $ultid = $db->ultimo_id();

            foreach($_POST['nome_conteudo'] as $key => $value){
                $icon = $_POST['icon'][$key];
                $visualizaca = $_POST['visualizaca'][$key];
                $duracao = $_POST['duracao'][$key];
                $perguntas = $_POST['perguntas'][$key];

				print_r($_POST);echo'<br>';
				print_r($perguntas);exit;
                $db->inserir('curso_conteudo', array(
                    "nome"=>"$value",
                    "icon"=>"$icon",
                    "visualizar"=>"$visualizaca",
                    "duracao"=>"$duracao",
                    "perguntas"=>"$perguntas",
                    "id_curso_conteudo_topico"=>"$ultid",
                    "status"=>1
                ));
				echo '2';
				print_r($db);exit;
            }
            echo 'Items adicionados!';
        }
    }
    public function deletar_topico(){
        $id_topico = $_POST['id_topico'];
        if(isset($_POST['id_topico'])){
            $db = new mysql();
		    $db->apagar('curso_conteudo', " id_curso_conteudo_topico ='$id_topico' ");
            $db->apagar('conteudo_curso_topico', " id ='$id_topico' ");
        }
        echo 'Deletado com sucesso!';
    }
	public function deletar_feedback(){
        $id_feedback = $_POST['id_feedback'];
        if(isset($_POST['id_feedback'])){
            $db = new mysql();
		    $db->apagar('feedback', " id ='$id_feedback' ");
            $db->apagar('curso_feedback', " id_feedback ='$id_feedback' ");
        }
        echo 'Deletado com sucesso!';
    }
	public function add_curso_qtd_feedback(){
		$id_curso = $_POST['codigo'];
		$qtd_feedback = $_POST['qtd_feedback'];

		// echo'<pre>';print_r($_POST);exit;

		$db = new mysql();
		$db->alterar('cursos', array("qtd_feedback"=>"$qtd_feedback"), "id='$id_curso' ");
		// echo'<pre>';print_r($db);exit;
		
		$this->irpara(DOMINIO.$this->_controller."/alterar_curso/codigo/".$id_curso."/aba/feedback");
	}
	public function add_curso_feedback(){
		$id_curso = $_POST['codigo'];
        $nome = $_POST['nome'];
        $estrela = $_POST['estrelas'];
        $texto = $_POST['feedback'];
		// echo'<pre>';print_r($_POST);exit;
		$db = new mysql();
		$db->inserir('feedback', array(
			"nome"=>"$nome",
			"estrela"=>"$estrela",
			"texto"=>"$texto"
		));
		$ultid = $db->ultimo_id();
		$db->inserir('curso_feedback', array(
			"id_curso"=>"$id_curso",
			"id_feedback"=>"$ultid"
		));
			
		$this->irpara(DOMINIO.$this->_controller."/alterar_curso/codigo/".$id_curso."/aba/feedback");
	}
	public function alterar_curso_feedback(){
		$id_curso = $_POST['codigo'];
		$id_feedback = $_POST['id_feedback'];
        $nome = $_POST['nome'];
        $estrela = $_POST['estrelas'];
        $texto = $_POST['feedback'];
		// echo'<pre>';print_r($_POST);exit;

		$db = new mysql();
		$db->alterar('feedback', array("nome"=>"$nome","estrela"=>"$estrela","texto"=>"$texto"), "id='$id_feedback' ");
		// echo'<pre>';print_r($db);exit;
		
		$this->irpara(DOMINIO.$this->_controller."/alterar_curso/codigo/".$id_curso."/aba/feedback");
	}
}