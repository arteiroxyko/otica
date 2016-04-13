<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {
    # VALIDA USUÁRIO

    function login($dados = null) {

        $login = $dados['usuario'];
        $senha = $dados['senha'];

        $this->db->where('login', $login);
        $this->db->where('senha like binary', $senha);
        $query = $this->db->get('usuario')->result();
        
        if ($query != NULL) {
            
            $logadoSistema = array(
                'logado' => TRUE,
                'login' => $login,
                'id' => $query[0]->id,
                'nome' => $query[0]->nome,
                'email' => $query[0]->email,
                'id_nivel' => $query[0]->id_nivel,
               );
            $this->session->set_userdata($logadoSistema);//Atribui na sessão que o usuario está logado
            return TRUE;//Se achar um o login com usuario e senha retorna true
            
        } else {
            return FALSE;//Se não achar login com usuário e senha retorna false
            
        }
    }
    
    # VERIFICA SE O USUÁRIO ESTÁ LOGADO

    function logado() {
        $logado = $this->session->userdata('logado');

        if (!isset($logado) || $logado != true) {
             $this->session->set_flashdata('erroLogin','É necessário logar no sistema');//Adiciona na sessão temporaria o status do cadastro
            redirect('login');
        }
    }
    
    function esqueceuSenha($login) {
        $this->db->select('lembrete_senha');
        $this->db->where('login', $login);
        $this->db->limit(1);
        $lembrete = $this->db->get('usuario')->row();
  
        if($lembrete->lembrete_senha != null) {
            $this->session->set_flashdata('lembrete', $lembrete->lembrete_senha);
        } else {
            $this->session->set_flashdata('lembreteErro', 'Usuário não existe');
        }
        
        redirect('login/esqueciSenha');
    }

}
