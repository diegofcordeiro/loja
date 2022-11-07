<?php

Class model_marcas extends model{
	
	public function lista_menu($categorias){ 

		$consulta = "";
		foreach ($categorias as $key => $value) {
			$consulta .= " c.categoria_codigo='".$value['categoria']."' OR";
		}

		$size = strlen($consulta);
		if($size>0){
			$consulta = substr($consulta,0, $size-2);
		}

		//echo "<div style='color:#000;' >$consulta</div>";
		
		$retorno = array();
		$i = 0;

		$query = "SELECT 
		a.id AS marca_id, 
		a.codigo AS marca_codigo, 
		a.titulo AS marca_titulo,
		c.categoria_codigo AS categoria 
		FROM marcas AS a 
		INNER JOIN produto AS b 
		ON a.codigo = b.marca 
		INNER JOIN produto_categoria_sel AS c 
		ON b.codigo = c.produto_codigo
		WHERE $consulta 
		ORDER by a.titulo ASC";
		
		//echo "<div style='color:#000;' >$query</div>";
		
		$db = new mysql();
		$exec = $db->executar($query);
		while($data = $exec->fetch_object()){
			
			$retorno[$data->marca_id]['codigo'] = $data->marca_codigo;
			$retorno[$data->marca_id]['titulo'] = $data->marca_titulo;
			$i++;
		}
		
		return $retorno;
	}

}