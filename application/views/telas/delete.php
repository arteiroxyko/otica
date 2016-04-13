<?php

if($this->session->flashdata('deleteok')){
    
    echo '<p>'.$this->session->flashdata('deleteok').'</p>';
}

