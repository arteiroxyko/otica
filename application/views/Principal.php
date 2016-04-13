<?php 

    
$this->load->view('includes/header.php');
$this->load->view('includes/menu.php');
if($pagina != '') $this->load->view('telas/'.$pagina);
$this->load->view('includes/footer.php');
?>
  