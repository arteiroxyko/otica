<?php 

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Usuario_model extends CI_Model {

	public function do_insert($dados = null, $crm = null) {
            
            if ($dados != null) {
                $this -> db -> trans_start();
                $this -> db -> insert('usuario', $dados);
                $id = $this->db->insert_id();
                
                if (element('id_nivel', $dados) == "4") {
                    $medico = array('nome' => element('nome', $dados, null),
                                    'crm' => $crm,
                                    'id_usuario' => $id);
                    $this -> db -> insert('medico', $medico);
                }
                
                $this -> db -> trans_complete();
                
                $this -> session -> set_flashdata('cadastrook', 'Cadastro efetuado com sucesso');
                
                redirect('usuario');
            }
	}

	public function getAll() {

		$this -> db -> select('usuario.id as id_usuario, usuario.nome as nome_usuario, usuario.login, usuario.senha, usuario.lembrete_senha, usuario.email, usuario.id_nivel, nivel.id, nivel.nome as nome_nivel, nivel.descricao');
		$this -> db -> from('usuario');
                $this -> db -> join('nivel', 'nivel.id = usuario.id_nivel');
		return $this -> db -> get();
	}

	public function get_byid($id = NULL) {
		if ($id != NULL) {
			$this -> db -> where('id', $id);
			$this -> db -> limit(1);
			$user = $this -> db -> get('usuario') -> row();
                        
                        $this -> db -> where('id', $user->id_nivel);
			$this -> db -> limit(1);
                        $nivel = $this -> db -> get('nivel') -> row();
                        
                        if ($user->id_nivel == "4") {
                            $this -> db -> where('id_usuario', $id);
                            $this -> db -> limit(1);
                            $medico = $this -> db -> get('medico') -> row();
                        }
                        
                        $dados = array('usuario' => $user, 'nivel' => $nivel, 'medico' => $medico);
                        
			return $dados;
		}
	}

	public function do_update($dados = NULL, $crm = NULL, $condicao = NULL) {
            
		if ($dados != null || $condicao != null) {
                    
                    $this->db->trans_start();
                    $this->db->update('usuario', $dados, 'id = '.$condicao);
                    if (element('id_nivel', $dados) == 4) {
                        $medico = array('nome' => element('nome', $dados, null),
                                        'crm' => $crm);
                        $this->db->update('medico', $medico, 'id_usuario = '.$condicao);
                    }
		}
                
                if ($this->db->_error_number() == 0) {
                    $this -> session -> set_flashdata('msgOk', 'Usuário alterado com sucesso');
                } else {
                    $this -> session -> set_flashdata('msg', 'Ocorreu um erro ao alterar o usuário!');
                }
                
                $this->db->trans_complete();
                
                $this->session->set_userdata('nome', element('nome', $dados, null));
//                $this -> session -> set_flashdata('name_user', element('nome', $dados, null));
                
                
                redirect(current_url());
	}

        public function select($campo = null, $dado = null) {
            $this -> db -> where($campo, $dado);
            $this -> db -> limit(1);
            return $this -> db -> get('usuario') -> row();
        }


        public function do_delete($id = null) {
            if ($id != null) {               
                $this->db->where('id_usuario', $id);
                $this->db->delete('medico');
                $medico = array('id_usuario' => null);
                $this->db->update('medico', $medico, 'id_usuario = ' . $id);
                
                $this->db->where('id', $id);
                $this->db->delete('usuario');
                
                return $this->db->_error_number();
            }
            return false;
    }
}