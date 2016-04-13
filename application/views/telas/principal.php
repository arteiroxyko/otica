<br>
<br>
<?php
    if ($this->session->userdata('id_nivel') == '1') {
?>

<table width="80%" border="0" class="iconesPrincipal">
    <tr>
        <td align="center">
            <a href="<?php echo base_url('fluxoFinanceiro'); ?>" >
                <img src="http://localhost/otica/public/img/report.png" width="74px" heigth="74px"/>
                <br />
                Relatório de Fluxo Finaceiro
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('cheque'); ?>" >
                <img src="http://localhost/otica/public/img/cheque_2.png" width="74px" heigth="74px"/>
                <br />
                Gerenciar Cheques
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('venda/listaOrcamentos'); ?>">
                <img src="http://localhost/otica/public/img/orçamentos.png" width="74px" heigth="74px"/>
                <br />
                Gerenciar Orçamentos
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('venda'); ?>">
                <img src="http://localhost/otica/public/img/venda.png" width="74px" heigth="74px"/>
                <br />
                Venda de Produtos/Serviço
            </a>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td align="center">
            <a href="<?php echo base_url('agendamento'); ?>">
                <img src="http://localhost/otica/public/img/agendamento.png" width="72px" heigth="72px"/>
                <br />
                Agendamento
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('receita/adicionaReceita'); ?>" >
                <img src="http://localhost/otica/public/img/check_list_1.png" width="65px" heigth="65px"/>
                <br />
                Cadastrar Receita
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('cliente'); ?>" >
                <img src="http://localhost/otica/public/img/cadastro_cliente.png"/>
                <br />
                Cadastro de Clientes
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('cliente/listarClientes'); ?>">
                <img src="http://localhost/otica/public/img/pesquisa_cliente.png"/>
                <br />
                Pesquisa de Clientes  
            </a>
        </td>
        
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center">
            <a href="<?php echo base_url('fornecedor/adiciona'); ?>">
                <img src="http://localhost/otica/public/img/cadastro_fornecedor.png"/>
                <br />
                Cadastro de Fornecedores    
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('fornecedor/lista'); ?>">
                <img src="http://localhost/otica/public/img/pesquisa_fornecedor.png"/>
                <br />
                Pesquisa de Fornecedores    
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('produto'); ?>">
                <img src="http://localhost/otica/public/img/adiciona_produto_1.png" width="74px" heigth="74px"/>
                <br />
                Cadastro de Produtos
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('produto/lista'); ?>" >
                <img src="http://localhost/otica/public/img/lista_produto_1.png" width="74px" heigth="74px"/>
                <br />
                Pesquisa de Produtos
            </a>
        </td>
    </tr>
</table>

<?php
    } else if ($this->session->userdata('id_nivel') == '2') {
?>

<table width="80%" border="0" class="iconesPrincipal">
    <tr>
        <td align="center">
            <a href="<?php echo base_url('cheque'); ?>" >
                <img src="http://localhost/otica/public/img/cheque_2.png" width="74px" heigth="74px"/>
                <br />
                Gerenciar Cheques
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('agendamento'); ?>">
                <img src="http://localhost/otica/public/img/agendamento.png" width="72px" heigth="72px"/>
                <br />
                Agendamento
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('venda/listaOrcamentos'); ?>">
                <img src="http://localhost/otica/public/img/orçamentos.png" width="74px" heigth="74px"/>
                <br />
                Gerenciar Orçamentos
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('venda'); ?>">
                <img src="http://localhost/otica/public/img/venda.png" width="74px" heigth="74px"/>
                <br />
                Venda de Produtos/Serviço
            </a>
        </td>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td>&nbsp;</td>
        <td align="center">
            <a href="<?php echo base_url('cliente'); ?>" >
                <img src="http://localhost/otica/public/img/cadastro_cliente.png"/>
                <br />
                Cadastro de Clientes
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('dependente'); ?>">
                <img src="http://localhost/otica/public/img/dependente.png"/>
                <br />
                Cadastro de Dependente
            </a>
        </td>
    </tr>
</table>

<?php
    } else if ($this->session->userdata('id_nivel') == '3') {
?>

<table width="80%" border="0" class="iconesPrincipal">
    <tr>
    </tr>
    <tr><td><br></td></tr>
    <tr>
        <td align="center">
            <a href="<?php echo base_url('consulta'); ?>">
                <img src="http://localhost/otica/public/img/ConsultaMedica.png" width="65px" heigth="65px"/>
                <br />
                Consulta Oftalmológica
            </a>
        </td>
        <td align="center">
            <a href="<?php echo base_url('receita/adicionaReceita'); ?>" >
                <img src="http://localhost/otica/public/img/check_list_1.png" width="65px" heigth="65px"/>
                <br />
                Cadastrar Receita
            </a>
        </td>
        <td align="center" style="visibility: hidden;">
            <a href="<?php echo base_url(''); ?>" >
                <img src="http://localhost/otica/public/img/nada.png" width="65px" heigth="65px"/>
                <br />
                &nbsp;
            </a>
        </td>
        <td align="center" style="visibility: hidden;">
            <a href="<?php echo base_url(''); ?>" >
                <img src="http://localhost/otica/public/img/nada.png" width="65px" heigth="65px"/>
                <br />
                &nbsp;
            </a>
        </td>
        <td align="center" style="visibility: hidden;">
            <a href="<?php echo base_url(''); ?>" >
                <img src="http://localhost/otica/public/img/nada.png" width="65px" heigth="65px"/>
                <br />
                &nbsp;
            </a>
        </td>
    </tr>
</table>

<?php
    }
?>