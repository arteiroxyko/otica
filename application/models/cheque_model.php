<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cheque_model extends CI_Model {

    public function listaChequesPendentes() {
        $this->db->select('*');
        $this->db->where('status', '0');
        $this->db->from('cheque');
        return $this->db->get()->result();
    }
    
    public function baixaCheque($id = null,$status = null) {
        if ($id != null && $status!=null) {
            $this->db->update('cheque', array('status'=>$status), array('id'=>$id));
            return true;
        }
        return false;
    }
    
    public function atualizaCheque($id = null, $data = null) {
        if ($id != null && $data != null) {
            $this->db->trans_start();
            $this->db->update('cheque', array('data'=>$data), array('id'=>$id));
            
            if ($this->db->trans_complete()) {
                $this->session->set_flashdata('msgOk', 'Data do cheque alterado com sucesso!');
                redirect(current_url());
            } else {
                $this->session->set_flashdata('msg', 'Erro ao alterar a data do cheque');
                redirect(current_url());
            }
        }
    }
    
    public function get_byid($id = null) {
        if ($id != null) {
            $this->db->where('id', $id);
            $this->db->limit(1);
            return $this->db->get('cheque')->row();
        }
    }
}
?>
