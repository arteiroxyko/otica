<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class fluxoFinanceiro_model extends CI_Model {

    public function gerarRelatorio($datainicial,$datafinal,$filtroContasAPagar,$filtroVenda) {

        
        if($filtroVenda=='' && $filtroContasAPagar=='on'){
            
            $query = $this->db->query("(SELECT '0' as tipo,contas_pagar.id,data,valor as preco1,0 as preco2,0 as preco3,0 as desconto,nome as descricao FROM contas_pagar WHERE data>='".$datainicial."' AND data<='".$datafinal."')
            order by data")->result();
            
        }else if($filtroContasAPagar=='' && $filtroVenda=='on'){
            $query = $this->db->query("(SELECT '1' as tipo,orcamento.id,data,
(select sum(itens.preco_unitario*itens.quantidade) from itens where id_orcamento = orcamento.id) as preco1,(select  sum(lente.preco_venda) from lente where id_orcamento = orcamento.id) as preco2 ,(select sum(servico.preco_venda) from servico where id_orcamento = orcamento.id) as preco3,orcamento.desconto as desconto, concat('Venda para o cliente: ',pessoa.nome) as descricao
FROM orcamento 
left join cliente on orcamento.id_cliente = cliente.id left join pessoa on pessoa.id = cliente.id_pessoa
WHERE data>='".$datainicial."' AND data<='".$datafinal."' AND orcamento.status='0' and orcamento.id_forma_pgto <> '3')
union
(SELECT '2',cheque.id,data,valor,0,0,0,concat('Cheque: ',descricao) as descricao FROM cheque WHERE data>='".$datainicial."' AND data<='".$datafinal."')
order by data")->result();
        }else if($filtroVenda=='on' && $filtroContasAPagar=='on'){
          $query = $this->db->query("(SELECT '1' as tipo,orcamento.id,data,
(select sum(itens.preco_unitario*itens.quantidade) from itens where id_orcamento = orcamento.id) as preco1,(select  sum(lente.preco_venda) from lente where id_orcamento = orcamento.id) as preco2 ,(select sum(servico.preco_venda) from servico where id_orcamento = orcamento.id) as preco3,orcamento.desconto as desconto, concat('Venda para o cliente: ',pessoa.nome) as descricao
FROM orcamento 
left join cliente on orcamento.id_cliente = cliente.id left join pessoa on pessoa.id = cliente.id_pessoa
WHERE data>='".$datainicial."' AND data<='".$datafinal."' AND orcamento.status='0' and orcamento.id_forma_pgto <> '3')
union
(SELECT '2',cheque.id,data,valor,0,0,0,concat('Cheque: ',descricao) as descricao FROM cheque WHERE data>='".$datainicial."' AND data<='".$datafinal."')
 union
(SELECT '0' as tipo,contas_pagar.id,data,valor as preco1,0 as preco2,0 as preco3,0 as desconto,nome as descricao FROM contas_pagar WHERE data>='".$datainicial."' AND data<='".$datafinal."')
order by data")->result();
            
        }
  return $query;
    }

  

}