<?php

class combos extends controller {
	
	protected $_modulo_nome                         = "combos";
    private   $tab_conteudo_curso_topico			= "conteudo_curso_topico";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(73);
	}
	
	public function inicial(){
        
        $dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";		
        
		// Instancia
		$combos = new model_combos();
		
		$dados['lista'] = $combos->lista();
		// echo'<pre>';print_r($dados['lista']);exit;

		$this->view('combos', $dados);
	}
    public function novo(){
        		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('combo.novo', $dados);
    }
    public function novo_combo(){
		$db = new mysql();
		$titulo = $this->post('titulo');
		
		// instancia
		$combo = new model_combos();
		$id = $combo->novo_combo($titulo);
		$this->irpara(DOMINIO.$this->_controller.'/alterar_combo/codigo/'.$id.'/aba/dados');
	}
    public function alterar_combo(){
		
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
		$combos = new model_combos();	
        $produtos = new model_produtos();

		$dados['data'] = $combos->carrega_combo($codigo);
		print_r($dados['data']);exit;
		$pr = $combos->get_plano_price($dados['data']->plano_id);
		$dados['price'] = $pr->price;

        $trilha_curso = array();
		$n = 0;
        $produto_lista = $produtos->lista();
		// echo'<pre>';print_r($produto_lista);exit;
		foreach ($produto_lista as $key => $value) {
			
			$trilha_curso[$n]['id'] = $value['id'];
			$trilha_curso[$n]['titulo'] = $value['titulo'];
        
			$db = new mysql();
			$coisas = $db->executar("SELECT * FROM combo_produto WHERE id_combo = '$codigo' and id_produto = '".$value['id']."'  ");

			if($coisas->num_rows != 0){
				$trilha_curso[$n]['checked'] = true;
			} else {
				$trilha_curso[$n]['checked'] = false;
			}

			$n++;
		}

        $dados['trilha_curso'] = $trilha_curso;
		$dados['link'] = DOMINIO.$this->_controller.'/alterar_combo/codigo/'.$codigo.'/aba/conteudo_curso';
		$dados['link_feedback'] = DOMINIO.$this->_controller.'/alterar_combo/codigo/'.$codigo.'/aba/feedback';
		$this->view('combos.alterar', $dados);
	}
    public function alterar_combo_dados(){

		$titulo = $this->post('titulo');
		$desconto = $_POST['desconto'];
		$status = $_POST['status'];
		$codigo = $_POST['codigo'];
		$produtos = $_POST['produtos'];
		$assinatura = $_POST['assinatura'];
		$price = $_POST['price'];
		


        $db = new mysql();
		$db->executar("DELETE FROM combo_produto WHERE id_combo = '$codigo' ");

		foreach($produtos as $prod){
			$db->inserir("combo_produto", array(
						'id_produto'=>$prod,
						'id_combo'=>$codigo
					));
		}

		$db = new mysql();
		$db->alterar("combos", array(
			"titulo"=>$titulo,
			"plano_id"=> $assinatura,
			"desconto"=> $desconto,
			"status"=>$status
		), " id='$codigo' ");

		// echo'<pre>';print_r($db);exit;

		$this->irpara(DOMINIO.$this->_controller.'/alterar_combo/codigo/'.$codigo.'/aba/dados');
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

		$combos = new model_combos();
		
		foreach ($combos->lista() as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){		

				$combos->apagar_produto_combo($value['id']);
				$combos->apagar_combo($value['id']);

				unlink('../arquivos/img_combos_g/'.$value['id'].'/'.$value['banner']);
				unlink('../arquivos/img_combos_p/'.$value['id'].'/'.$value['banner']);						 
			
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
		$pasta = "combos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();
		$combos = new model_combos();

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
				$ultid = $combos->adiciona_imagem(array(
					$codigo,
					$nome_foto
				));
				
			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar_combo/codigo/".$codigo."/aba/imagem");
		}

	}
    public function imagem_redimencionada(){
        $tmp_name = $_FILES['arquivo']['tmp_name'];
		$codigo = $this->post('codigo');

		$pasta = "combos";
		$diretorio_g = "../arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "../arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
        // print_r('aqio');

		$img = new model_arquivos_imagens();
		$combos = new model_combos();

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
			$ultid = $combos->adiciona_imagem(array(
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

                $db->inserir('curso_conteudo', array(
                    "nome"=>"$value",
                    "icon"=>"$icon",
                    "visualizar"=>"$visualizaca",
                    "duracao"=>"$duracao",
                    "perguntas"=>"$perguntas",
                    "id_curso_conteudo_topico"=>"$ultid",
                    "status"=>1
                ));
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
		$db->alterar('combos', array("qtd_feedback"=>"$qtd_feedback"), "id='$id_curso' ");
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