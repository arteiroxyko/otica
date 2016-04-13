<?php 
$this->load->view('includes/header_popup.php');
if($pagina != '') $this->load->view('telas/'.$pagina);
$this->load->view('includes/footer.php');
?>
  