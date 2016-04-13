<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class grife_model extends CI_Model {
	public function do_insert($dados = null) {
            if ($dados != null) {
                
		$this -> db -> trans_start();
		$grife = array('nome' => element('nome', $dados));
		$this -> db -> insert('grife', $grife);

		$this -> db -> trans_complete();

		$this -> session -> set_flashdata('cadastrook', 'Cadastro efetuado com sucesso');

		redirect('grife');
            }
	}

	public function getAll() {

		$this -> db -> select('id, nome');
		$this -> db -> from('grife');
                $this -> db ->order_by('nome');
		return $this -> db -> get();
	}

	public function do_select($pesquisa = null) {

		$this -> db -> select('id, nome');
		$this -> db -> from('grife');
		$this -> db -> like('nome', $pesquisa);
                $this -> db ->order_by('nome');

		return $this -> db -> get();
	}

	public function get_byid($id_grife = NULL) {
	
		if ($id_grife != NULL) {
		
			$this -> db -> where('id', $id_grife);
			$this -> db -> limit(1);
			$grife = $this -> db -> get('grife') -> row();
			
			$dados = array('grife' => $grife);
			return $dados;
		}
	}

	public function do_update($dados = NULL, $condicao = NULL) {

		if ($dados != null || $condicao != null) {

			$this -> db -> trans_start();

			$grife = array('nome' => element('nome', $dados));
                        $condicao_grife = array('id' => $condicao['id_grife']);
			$this -> db -> update('grife', $grife, $condicao_grife);

			if ($this -> db -> trans_complete()) {
				$this -> session -> set_flashdata('statusUpdate', 'Alterado com sucesso');
			} else {
				$this -> session -> set_flashdata('statusUpdate', 'Não foi possível alterar a grife');
			}
                        redirect(current_url());
		}
	}

	public function do_delete($id = null) {
            if ($id != null) {
                $this->db->where('id', $id);
                $this->db->delete('grife');
                return $this->db->_error_number();
            }
	}

}