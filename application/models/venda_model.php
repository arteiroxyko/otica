<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venda_model extends CI_Model {

    public function cadastrarOrcamento($dados = null) {
        if ($dados != null &&
                $dados['itens'] != null ||
                $dados['lentes'] != null ||
                $dados['servicos'] != null) {

            $this->db->trans_start(); //Começa uma transação em diversas tabelas
            //Trata os elementos do orçamento
            $orcamento = array(
                'data' => $dados['data'],
                'id_forma_pgto' => $dados['forma_pagamento'],
                'vendedor' => $dados['vendedor'],
                'desconto' => $dados['desconto'],
                'status' => '1',
                'id_cliente' => $dados['id_cliente'],
            );
            $this->db->insert('orcamento', $orcamento); //insere no BD

            $id_orcamento = $this->db->insert_id(); //Captura o ID do orçamento
            //processo de insert na tabela itens
            if ($dados['itens'] != null) {
                foreach ($dados['itens'] as $item) {//captura cada item do array
                    $item = array(
                        'nome' => $item['nomeProduto'],
                        'id_produto' => $item['idProduto'],
                        'preco_unitario' => $this->util->virgulaParaPonto($item["precoVenda"]),
                        'quantidade' => $item['quantidadeProduto'],
                        'id_orcamento' => $id_orcamento
                    );
                    $this->db->insert('itens', $item); //Insere is itens na tabeka
                }
            }
            if ($dados['servicos'] != null) {
                foreach ($dados['servicos'] as $servico) {//captura cada item do array
                    $servico = array(
                        'nome' => $servico['nome'],
                        'preco_venda' => $this->util->virgulaParaPonto($servico['preco']),
                        'id_orcamento' => $id_orcamento,
                        'descricao' => $servico['descricao'],
                    );
                    $this->db->insert('servico', $servico); //Insere is itens na tabeka
                }
            }
            if ($dados['lentes'] != null) {
                foreach ($dados['lentes'] as $lente) {//captura cada item do array
                    $lente = array(
                        'nome' => $lente['nome_lente'],
                        'referencia' => $lente['referencia'],
                        'preco_venda' => $this->util->virgulaParaPonto($lente['preco_venda']),
                        'id_orcamento' => $id_orcamento
                    );
                    $this->db->insert('lente', $lente); //Insere is itens na tabeka
                }
            }

            $this->db->trans_complete();


            $this->session->set_flashdata('orcamentoOk', 'Orçamento salvo com sucesso!\n\nDeseja Imprimir o Orçamento?');
            $this->session->set_flashdata('id_orcamento', $id_orcamento);

            redirect('venda/limparVenda');
        } else {
            $this->session->set_flashdata('msg', 'Não foi possível salvar o orçamento, verifique todos os dados e tente novamente.');
            redirect('venda/cadastrarVenda');
        }
    }

    public function retornaOrcamento($id_orcamento = NULL) {


        if ($id_orcamento != NULL) {

            $this->db->where('id', $id_orcamento);
            $this->db->limit(1);
            $orcamento = $this->db->get('orcamento')->row();

            $this->db->where('id_orcamento', $id_orcamento);
            $itens = $this->db->get('itens')->result();

            $this->db->where('id_orcamento', $id_orcamento);
            $servicos = $this->db->get('servico')->result();


            $this->db->where('id_orcamento', $id_orcamento);
            $lentes = $this->db->get('lente')->result();

            //captura o cliente
            $this->db->where('id', $orcamento->id_cliente);
            $this->db->limit(1);
            $cliente = $this->db->get('cliente')->row();

            $this->db->where('id', $cliente->id_pessoa);
            $this->db->limit(1);
            $pessoa = $this->db->get('pessoa')->row();

            $this->db->where('id', $orcamento->id_forma_pgto);
            $this->db->limit(1);
            $formaPgo = $this->db->get('forma_pgto')->row();

            $dados = array(
                'orcamento' => $orcamento,
                'servicos' => $servicos,
                'lentes' => $lentes,
                'itens' => $itens,
                'cliente' => $cliente,
                'pessoa' => $pessoa,
                'formaPgto' => $formaPgo,
            );
            return $dados;
        }
    }

    public function cadastrarVenda($dados = null) {
        if ($dados != null &&
                $dados['itens'] != null ||
                $dados['lentes'] != null ||
                $dados['servicos'] != null) {

            $this->db->trans_start(); //Começa uma transação em diversas tabelas
            //Trata os elementos do orçamento
            $orcamento = array(
                'data' => $dados['data'],
                'id_forma_pgto' => $dados['forma_pagamento'],
                'vendedor' => $dados['vendedor'],
                'desconto' => $dados['desconto'],
                'status' => '0',
                'id_cliente' => $dados['id_cliente'],
            );
            $this->db->insert('orcamento', $orcamento); //insere no BD

            $id_orcamento = $this->db->insert_id(); //Captura o ID do orçamento
            //processo de insert na tabela itens
            if ($dados['itens'] != null) {
                foreach ($dados['itens'] as $item) {//captura cada item do array
                    $item = array(
                        'nome' => $item['nomeProduto'],
                        'id_produto' => $item['idProduto'],
                        'preco_unitario' => $this->util->virgulaParaPonto($item["precoVenda"]),
                        'quantidade' => $item['quantidadeProduto'],
                        'id_orcamento' => $id_orcamento
                    );
                    if ($this->produto_model->decrement_quantidade($item['quantidade'], $item['id_produto'])) {
                        
                    } else {
                        $this->session->set_flashdata('msg', 'A quantidade do produto ' . $item['nome'] . ' de código ' . $item['id_produto'] . ' é maior do que está cadastrado no estoque.');
                        $this->db->trans_rollback();
                        redirect('venda/cadastrarVenda');
                    }

                    $this->db->insert('itens', $item); //Insere is itens na tabeka
                }
            }
            if ($dados['servicos'] != null) {
                foreach ($dados['servicos'] as $servico) {//captura cada item do array
                    $servico = array(
                        'nome' => $servico['nome'],
                        'preco_venda' => $this->util->virgulaParaPonto($servico['preco']),
                        'id_orcamento' => $id_orcamento,
                        'descricao' => $servico['descricao'],
                    );
                    $this->db->insert('servico', $servico); //Insere is itens na tabeka
                }
            }
            if ($dados['lentes'] != null) {
                foreach ($dados['lentes'] as $lente) {//captura cada item do array
                    $lente = array(
                        'nome' => $lente['nome_lente'],
                        'referencia' => $lente['referencia'],
                        'preco_venda' => $this->util->virgulaParaPonto($lente['preco_venda']),
                        'id_orcamento' => $id_orcamento
                    );
                    $this->db->insert('lente', $lente); //Insere is itens na tabeka
                }
            }

            $venda = array(
                'data' => $dados['data'],
                'horario' => date("H:i"),
                'id_orcamento' => $id_orcamento
            );
            $this->db->insert('venda', $venda); //Insere na tabela venda 

            $id_venda = $this->db->insert_id(); //Captura o ID da venda

            if ($dados['forma_pagamento'] == 3) {
                if ($dados['cheques'] != null) {
                    foreach ($dados['cheques'] as $cheque) {//captura cada item do array
                        $cheque = array(
                            'data' => $cheque['data'],
                            'valor' => $cheque['valor'],
                            'descricao' => $cheque['descricao'],
                            'id_venda' => $id_venda
                        );
                        $this->db->insert('cheque', $cheque); //insere os cheques cadastrados pelo cliente
                    }
                }
            }

            if ($this->db->trans_complete()) {
                $this->session->set_flashdata('vendaOk', 'Venda finalizada com sucesso!\n\nDeseja Imprimir o Recibo agora?');
                $this->session->set_flashdata('id_venda', $id_venda);

                redirect('venda/limparVenda');
            } else {
                $this->session->set_flashdata('msg', 'Não foi possível realizar a venda, verifique todos os dados e tente novamente.');
                redirect('venda/cadastrarVenda');
            }
        } else {
            $this->session->set_flashdata('msg', 'Não foi possível realizar a venda, verifique todos os dados e tente novamente.');
            redirect('venda/cadastrarVenda');
        }
    }

    public function retornaVenda($id_venda = NULL) {


        if ($id_venda != NULL) {

            $this->db->where('id', $id_venda);
            $this->db->limit(1);
            $venda = $this->db->get('venda')->row();

            $this->db->where('id', $venda->id_orcamento);
            $this->db->limit(1);
            $orcamento = $this->db->get('orcamento')->row();

            if ($orcamento->id_forma_pgto == 3) {
                $this->db->where('id_venda', $id_venda);
                $cheques = $this->db->get('cheque')->result();
                $parcelas = count($cheques);
            }

            $this->db->where('id_orcamento', $venda->id_orcamento);
            $itens = $this->db->get('itens')->result();


            $this->db->where('id_orcamento', $venda->id_orcamento);
            $servicos = $this->db->get('servico')->result();


            $this->db->where('id_orcamento', $venda->id_orcamento);
            $lentes = $this->db->get('lente')->result();

            //captura o cliente
            $this->db->where('id', $orcamento->id_cliente);
            $this->db->limit(1);
            $cliente = $this->db->get('cliente')->row();

            $this->db->where('id', $cliente->id_pessoa);
            $this->db->limit(1);
            $pessoa = $this->db->get('pessoa')->row();

            $this->db->where('id', $orcamento->id_forma_pgto);
            $this->db->limit(1);
            $formaPgo = $this->db->get('forma_pgto')->row();


            $dados = array(
                'venda' => $venda,
                'orcamento' => $orcamento,
                'cheques' => $cheques,
                'servicos' => $servicos,
                'lentes' => $lentes,
                'itens' => $itens,
                'cliente' => $cliente,
                'pessoa' => $pessoa,
                'formaPgto' => $formaPgo,
                'parcelas' => $parcelas,
            );
            return $dados;
        }
    }

    public function vendasCliente($id_cliente = NULL) {
        if ($id_cliente != NULL) {
            //Captura os dados para listar a venda
            $this->db->select('venda.id as id_venda,venda.data as data_venda, venda.horario as horario_venda, 
                orcamento.id_forma_pgto as id_forma_pagamento, orcamento.vendedor,orcamento.desconto,
                forma_pgto.nome as forma_pagamento,(select sum(itens.preco_unitario*itens.quantidade) from itens where id_orcamento = orcamento.id) as preco_total_itens,(select  sum(lente.preco_venda) from lente where id_orcamento = orcamento.id) as preco_total_lentes ,(select sum(servico.preco_venda) from servico where id_orcamento = orcamento.id) as preco_total_servicos');
            $this->db->where('orcamento.id_cliente', $id_cliente);
            $this->db->where('status', 0);
            $this->db->join('venda', 'venda.id_orcamento = orcamento.id');
            $this->db->join('itens', 'itens.id_orcamento = orcamento.id', 'left');
            $this->db->join('lente', 'lente.id_orcamento = orcamento.id', 'left');
            $this->db->join('servico', 'servico.id_orcamento = orcamento.id', 'left');
            $this->db->join('forma_pgto', 'orcamento.id_forma_pgto = forma_pgto.id', 'left');

            $this->db->group_by('orcamento.id');
            $this->db->from('orcamento');
            return $this->db->get()->result();
        }
    }

    public function listaOrcamentos() {

        $this->db->select('pessoa.nome as nome_cliente,orcamento.id as id_orcamento, orcamento.data as data_orcamento, orcamento.id_forma_pgto as id_forma_pagamento, orcamento.vendedor,orcamento.desconto,
                forma_pgto.nome as forma_pagamento,(select sum(itens.preco_unitario*itens.quantidade) from itens where id_orcamento = orcamento.id) as preco_total_itens,(select  sum(lente.preco_venda) from lente where id_orcamento = orcamento.id) as preco_total_lentes ,(select sum(servico.preco_venda) from servico where id_orcamento = orcamento.id) as preco_total_servicos');
        $this->db->where('status', 1);
        $this->db->join('itens', 'itens.id_orcamento = orcamento.id', 'left');
        $this->db->join('lente', 'lente.id_orcamento = orcamento.id', 'left');
        $this->db->join('servico', 'servico.id_orcamento = orcamento.id', 'left');
        $this->db->join('forma_pgto', 'orcamento.id_forma_pgto = forma_pgto.id', 'left');
        $this->db->join('cliente', 'cliente.id = orcamento.id_cliente', 'left');
        $this->db->join('pessoa', 'pessoa.id = cliente.id_pessoa', 'left');
        $this->db->group_by('orcamento.id');
        $this->db->from('orcamento');
        return $this->db->get()->result();
    }

    public function deleteOrcamento($id = null) {

        if ($id != null) {

            $this->db->where('id', $id);
            $this->db->where('status', '1');
            $this->db->delete('orcamento');

            if ($this->db->_error_number() == '0') {
                $this->session->set_flashdata('msg', 'Orcamento deletado com sucesso');
                return true;
            } else if ($this->db->_error_number() == '1451') {
                $this->session->set_flashdata('msg', 'Não foi possível deletar o cliente porque \njá está associado a outro evento');
                return false;
            } else {
                $this->session->set_flashdata('msg', 'Não foi possível deletar o cliente, informe este erro ao administrador do sistema:\n\n' . $this->db->_error_message());
                return false;
            }
            return false;
        }
        return false;
    }

}