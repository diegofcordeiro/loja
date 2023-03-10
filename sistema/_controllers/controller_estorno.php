<?php

class estorno extends controller
{

    protected $_modulo_nome = "Estorno";

    public function init()
    {
        $this->autenticacao();
        $this->nivel_acesso(70);
    }
    public function remove_from_lms($id_usuario, $id_trilha)
    {
        require('conexao.php');
        $sql_insert = "DELETE FROM curso_matricula WHERE id_usuario='$id_usuario' AND id_trilha='$id_trilha'";
        $mysqli->query($sql_insert);
    }
    public function vindi_estorno()
    {
        $codigo = $this->get('codigo');
        $id_usuario = $this->get('usuario_id');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.vindi.com.br/api/v1/charges/' . $codigo . '/refund',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
				"cancel_bill": "true",
				"comments": "Estorno pelo site"
			}',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'authorization: Basic N2FGMXktTW1uX2N5SE13QVhOaEhpdE5pNk1NaGFlNk9OdlFhSlg5TGJCYzp1bmRlZmluZWQ=',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);

        $conexao = new mysql();
        $coisas_carrinho = $conexao->Executar("SELECT SUM(valor_total) as valor_total_soma, pedido_loja_carrinho.* FROM pedido_loja_carrinho WHERE transacao_charger_id='$codigo' group by id_combo ");
        while ($data_carrinho = $coisas_carrinho->fetch_object()) {

            if ($data_carrinho->id_combo > 0) {
                $conexao = new mysql();
                $conexao->alterar("pedido_loja_carrinho", array(
                    "status" => 8
                ), " sessao='" . $data_carrinho->sessao . "' and id_combo='" . $data_carrinho->id_combo . "' ");

                $conexao->alterar("pedido_loja", array(
                    "status" => 8
                ), " codigo='" . $data_carrinho->sessao . "' ");


                $data_combo = $conexao->Executar("SELECT combos.id as combo_id, produto.ref FROM `combos`  inner join combo_produto on combo_produto.id_combo = combos.id inner join produto on produto.id = combo_produto.id_produto WHERE combo_produto.id_combo = '$data_carrinho->id_combo'");
                while ($res_combo = $data_combo->fetch_object()) {
                    $this->remove_from_lms($id_usuario, $res_combo->ref);
                }
            } else {
                $conexao = new mysql();
                $conexao->alterar("pedido_loja_carrinho", array(
                    "status" => 8
                ), " sessao='" . $data_carrinho->sessao . "' and produto='" . $data_carrinho->produto . "' ");

                $conexao->alterar("pedido_loja", array(
                    "status" => 8
                ), " codigo='" . $data_carrinho->sessao . "' ");

                $this->remove_from_lms($id_usuario, $data_carrinho->produto_ref);
            }
        }

        $this->irpara(DOMINIO . $this->_controller . '/minhaconta');
    }
}
