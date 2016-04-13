<head>
<link href="http://localhost/otica/public/favicon.ico" rel="shortcut icon" type="image/ico" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>SisGO - Login</title>
<link href="http://localhost/otica/public/css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<section class="container">
  <div class="login">
    <h1>SisGO</h1>
    <form method="post" action="<?php 
 echo base_url('login');?>"/>
    
    <p>
      <input type="text" name="usuario" value="" autocomplete="off" placeholder="Usuário" autofocus required title="O campo usuário é obrigatório">
    </p>
    <p>
      <input type="password" name="senha" value="" autocomplete="off" placeholder="Senha" required title="O campo senha é obrigatório">
    </p>
    <p class="remember_me"><img src="http://localhost/otica/public/img/Oculos.png" width="128" height="128" >
    <p class="submit">
      <input type="submit" name="commit" value="Login">
    </p>
    </form>
    <?php
      echo "<div class='erroLogin'>";
      echo "validation_errors('<p>','</p>')";
      if($this->session->flashdata('erroLogin')){
      echo '<p>'.$this->session->flashdata('erroLogin').'</p>';
      }
    echo "</div>";
            ?>
  </div>
  <div class="login-help">
    <?
$atts = array(
              'width'      => '500',
              'height'     => '300',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );

echo "<p>Esqueceu a sua senha? ".anchor_popup('login/esqueciSenha', 'Clique aqui.', $atts)."</p>";
?>
  </div>
</section>
</body>
</html>