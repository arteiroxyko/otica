<!--Julia-->
<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class contas_a_pagar_model extends CI_Model {
	public function do_insert($dados = null) {
            if ($dados != null) {
		$this -> db -> trans_start();
		$conta = array(
                    'nome' => element('nome', $dados, null),
                    'valor' => $this->util->virgulaParaPonto(element('preco', $dados, null)),
                    'data' => element('data', $dados, null),
                    'descricao' => element('descricao', $dados, null)
                    );
		$this -> db -> insert('contas_pagar', $conta);
		$this -> db -> trans_complete();

		$this -> session -> set_flashdata('msgOk', 'Cadastro efetuado com sucesso');

		redirect('contasAPagar');
            }
	}

	public function getAll() {
		$this->db->select('*');
		$this->db->from('contas_pagar');
                return $this->db->get();
	}

	public function get_byid($id_conta = NULL) {
	
		if ($id_conta != NULL) {
		
			$this -> db -> where('id', $id_conta);
			$this -> db -> limit(1);
			return $this -> db -> get('contas_pagar') -> row();
		}
	}

	public function do_update($dados = NULL, $condicao = NULL) {

		if ($dados != null || $condicao != null) {
			$this -> db -> trans_start();

			$conta = array(
                            'nome' => element('nome', $dados, null),
                            'valor' => $this->util->virgulaParaPonto(element('preco', $dados, null)),
                            'data' => element('data', $dados, null),
                            'descricao' => element('descricao', $dados, null)
                        );
			$this -> db -> update('contas_pagar', $conta, 'id = ' . $condicao);

			if ($this -> db -> trans_complete()) {
				$this -> session -> set_flashdata('statusUpdate', 'Alterado com sucesso');
			} else {
				$this -> session -> set_flashdata('statusUpdate', 'Não foi possível alterar o fornecedor');
			}

			redirect('contasAPagar/update/'.$condicao);
		}
		redirect('contasAPagar/update/'.$condicao);
	}

	public function do_delete($id = null) {
            if ($id != null) {
                $this->db->where('id', $id);
                $this->db->delete('contas_pagar');
                return $this->db->_error_number();
            }
	}

}