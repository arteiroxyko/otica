<?php 


class util_model extends CI_Model {

    public function deletarComEvento($errorNum=null, $o_a=null, $nomeMsg=null, $redirect=null) {
        
        if ($errorNum == '0') {
            $this->session->set_flashdata('msg', $nomeMsg.' foi deletado com sucesso!');
        } else if ($errorNum == '1451') {
            $this->session->set_flashdata('msg', 'Não foi possível deletar '.$o_a.' '.$nomeMsg.' porque \njá está associado a outro evento');
        } else {
            $this->session->set_flashdata('msg', 'Não foi possível deletar '.$o_a.' '.$nomeMsg.', informe este erro ao administrador do sistema:\n\n' . $this->db->_error_message());
        }

        if ($redirect!=null) {
            redirect($redirect);
        }
    }
}

?>
