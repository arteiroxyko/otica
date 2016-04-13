<html>
    <head><title><?php echo $titulo; ?></title>
        
        <link href="favicon.ico" rel="shortcut icon" type="image/ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="http://localhost/otica/public/css/menu.css" rel="stylesheet" type="text/css">
        <link href="http://localhost/otica/public/css/estilo.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="http://localhost/otica/public/css/calendario.css">
        <link rel="stylesheet" href="http://localhost/otica/public/css/tabela.css">
        <script type="text/javascript" src="http://localhost/otica/public/js/util.js"></script> 
        <script type="text/javascript" src="http://localhost/otica/public/js/produto.js"></script> 
        
        <style type="text/css">
        </style>
        


    </head>
    <body>
        <header>
            <nav>
                <div id="logo"><img src="http://localhost/otica/public/img/logo.png" width="60" height="20"></div>
<div class="headerInfo">

                    <?php
                    echo "<p>";
                    echo 'Data: ' . date('d') . '/' . date('m') . '/' . date('Y').'&nbsp; &nbsp; (' . anchor('login/logoff', 'sair') . ')';
                    echo "</p>";
                    echo"<br>";
                    echo '<p>';
                    echo 'Usuário: <span id="name_user">' . $this->session->userdata('nome').'</span> &nbsp; '."<a href=\"javascript:abrirPopUp('" . base_url('usuario/update/'.$this->session->userdata('id')) . "','706','370');\"> <img src='".base_url('public/img/config.png')."' width='20' style='vertical-align: middle;' title='Alterar dados Pessoais' /></a>";
                    echo "</p>";
                    ?>
</div>