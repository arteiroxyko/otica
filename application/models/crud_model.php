<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model{
    
    public function do_insert($dados=null){
        if($dados != null){
            
            $this->db->insert('curso_ci',$dados);
            $this->session->set_flashdata('cadastrook','Cadastro efetuado com sucesso');
            redirect('crud/create');
            
        }
         
        }
        
        public function get_all(){
            
            return $this->db->get('curso_ci');
            
        }
             public function get_byid($id=NULL){
            
                 if($id!=null){
                     
                     $this->db->where('id',$id);
                     $this->db->limit(1);
                     return $this->db->get('curso_ci');
                     
                 }
                 
                 return false;
            
            
        }
        
        
        
        public function do_update($dados=null,$condicao=null){
            
                 if($dados!=null && $condicao != null){
                     
                     $this->db->update('curso_ci',$dados,$condicao);
                     $this->session->set_flashdata('edicaook','Dados alterados com sucesso');
                     redirect(current_url());
                     
                 }
                 
                 return false;
            
        }
                public function do_delete($id=null){
            
                 if($id !=null){
                     
                     $this->db->where('id',$id);
                     $this->db->delete('curso_ci');
                     $this->session->set_flashdata('deleteok','Dados deletados com sucesso');
                      redirect('crud/delete');
                     
                 }
                 
                 return false;
            
        }
        
        
        
        
        
}