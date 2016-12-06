<h1 id="title">Registro de Cliente</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Cliente</h3>
    <hr />
    <form name="frmregclientes" method="POST" action="?folder=clients/&file=cb_ins_clients&ext=php">
        <table>
            <tr>
                <td>Nome Completo:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: João da Silva" maxlength="45"></td>
                <td>CEP:</td>
                <td><input type="text" name="txtcep" placeholder="Ex.: 89556226" maxlength="8"></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="txtemail" placeholder="Ex.: joao.silva@gmail.com" maxlength="70"></td>
                <td>Cidade:</td>
                <td>
                    <?php
                        //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidades).
                        $sql_sel_cities = "SELECT * FROM cities ORDER BY name";
                        $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
                        $sql_sel_cities_preparado->execute();
                    ?>
                    <select name="selcidade" onChange="mostraBairro()">
                        <option value="">Escolha...</option>
                    <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela cities em options que aparecerão para o usuário.
                        while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
                            $valor_cidade = $sql_sel_cities_dados['id'];
                            $nome_cidade = $sql_sel_cities_dados['name'];

                            echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Telefone:</td>
                <td><input type="text" name="txttelefone" placeholder="Ex.: 4799999999" maxlength="15"></td>
                <td>Bairro:</td>
                <td>
                    <select name="selbairro">
                        <option value="">Selecione uma cidade...</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Data de Nasc.:</td>
                <td><input type="text" class="datepicker" name="txtdata_nasc" placeholder="Ex.: DD/MM/AAAA" maxlength="10" readonly></td>
                <td>Logradouro:</td>
                <td><input type="text" name="txtlogradouro" placeholder="Ex.: Rua Iririú" maxlength="40"></td>
            </tr>
            <tr>
                <td>RG:</td>
                <td><input type="text" name="txtrg" placeholder="Ex.: 8456679" maxlength="10"></td>
                <td>Número:</td>
                <td><input type="text" name="txtnumero" placeholder="Ex.: 459" maxlength="5"></td>
            </tr>
            <tr>
                <td>CPF:</td>
                <td><input type="text" name="txtcpf" placeholder="Ex.: 52446889548" maxlength="11"></td>
                <td>Complemento:</td>
                <td><input type="text" name="txtcomplemento" placeholder="Ex.: casa" maxlength="20"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><button type="reset" name="btnreset">Limpar</button></td>
                <td colspan="2" align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
    <h2>Clientes Registrados</h2>
    <div align="center"><!--Início do centro-->
        <div align="right" class="search"><!--Início da pesquisa-->
            <form name="frmpesquisa" method="POST" action="">
                <input type="text" name="txtpesquisa" placeholder="Pesquisar" maxlength="70">
                <button type="submit" name="btnpesquisar"><img src="../layout/images/search.png"></button>
            </form>
        </div><!--Fim da pesquisa-->
        <?php
            $pesquisa = "";
            //Esta linha representa a atribuição de vazio para a variável pesquisa.
            //Este bloco é responsável por verificar se a variável post do campo txtpesquisa existe. Se ela existir verifica se ela é diferente de vazio. Se ela for diferente de vazio atribui ela a variável $p_pesquisa. Atribui a variável pesquisa a sintaxe de pesquisa do banco.
            if(isset($_POST['txtpesquisa'])){
                if($_POST['txtpesquisa']!=""){
                    $p_pesquisa = $_POST['txtpesquisa'];
                    $pesquisa = "WHERE name LIKE '%".$p_pesquisa."%' OR email LIKE '%".$p_pesquisa."%' OR phone LIKE '%".$p_pesquisa."%' OR birthdate LIKE '%".$p_pesquisa."%'";
                }
            }
            //Este bloco é responsável por fazer a seleção dos dados id, name, email, phone e birthdate da tabela clients (clientes). E executa a pesquisa se houver.
            $sql_sel_clients = "SELECT id, name, email, phone, birthdate FROM clients ".$pesquisa."";
            $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
            $sql_sel_clients_preparado->execute();
        ?>
    </div><!--Fim do centro-->
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="20%">Nome</th>
            <th width="40%">E-mail</th>
            <th width="20%">Telefone</th>
            <th width="10%">Data de Nasc.</th>
            <th width="5%">Editar</th>
            <th width="5%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
    <?php
            //Este bloco é responsável por exibir os dados contidos na tabela clients.
            if($sql_sel_clients_preparado->rowCount()>0){
                while($sql_sel_clients_dados = $sql_sel_clients_preparado->fetch()) {
                    $data = explode('-', $sql_sel_clients_dados['birthdate']);
                    $datab = $data[2].'/'.$data[1].'/'.$data[0];
    ?>
                    <tr>
                        <td><a name="modal" class="#modalwindow" href="<?php echo $sql_sel_clients_dados['id']; ?>"><?php echo $sql_sel_clients_dados['name']; ?></a></td>
                        <td><a name="modal" class="#modalwindow" href="<?php echo $sql_sel_clients_dados['id']; ?>"><?php echo $sql_sel_clients_dados['email']; ?></a></td>
                        <td><a name="modal" class="#modalwindow" href="<?php echo $sql_sel_clients_dados['id']; ?>"><?php echo $sql_sel_clients_dados['phone']; ?></a></td>
                        <td><a name="modal" class="#modalwindow" href="<?php echo $sql_sel_clients_dados['id']; ?>"><?php echo $datab; ?></a></td>
                        <td align="center"><a href="?folder=clients/&file=cb_fmupd_clients&ext=php&id=<?php echo $sql_sel_clients_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                        <td align="center"><?php echo safedelete($sql_sel_clients_dados['id'], "", '?folder=clients/&file=cb_del_clients&ext=php', 'o cliente', $sql_sel_clients_dados['name']) ?></td>
                    </tr>
    <?php
                }
            }else {
    ?>
                <tr>
                    <td align="center" colspan="6"><?php echo mensagens('Vazio', 'clientes'); ?></td>
                </tr>
    <?php
            }
    ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->
<div id="modal"><!--Começo Janela Modal-->
    <div id="modalwindow" class="window">
        <div id="headermodal">
            <h1>Consulta Detalhada de Cliente</h1>
            <a href="#" class="close"><img src="../layout/images/close.png"></a>
        </div>
        <div id="contentmodal">
            <table class="consult_table"><!--Início da tabela de consulta-->
                <tbody><!--Início do corpo da tabela-->
                    <tr>
                        <td>Nome Completo</td>
                        <td class="line" id="nome"></td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td class="line" id="email"></td>
                    </tr>
                    <tr>
                        <td>Telefone</td>
                        <td class="line" id="telefone"></td>
                    </tr>
                    <tr>
                        <td>Data de Nascimento</td>
                        <td class="line" id="data_nasc"></td>
                    </tr>
                    <tr>
                        <td>RG</td>
                        <td class="line" id="rg"></td>
                    </tr>
                    <tr>
                        <td>CPF</td>
                        <td class="line" id="cpf"></td>
                    </tr>
                    <tr>
                        <td>CEP</td>
                        <td class="line" id="cep"></td>
                    </tr>
                    <tr>
                        <td>Cidade</td>
                        <td class="line" id="cidade"></td>
                    </tr>
                    <tr>
                        <td>Bairro</td>
                        <td class="line" id="bairro"></td>
                    </tr>
                    <tr>
                        <td>Logradouro</td>
                        <td class="line" id="logradouro"></td>
                    </tr>
                    <tr>
                        <td>Número</td>
                        <td class="line" id="numero"></td>
                    </tr>
                    <tr>
                        <td>Complemento</td>
                        <td class="line" id="complemento"></td>
                    </tr>
                </tbody><!--Fim do corpo da tabela-->
            </table><!--Fim da tabela de consulta-->
        </div>
    </div>
    <div id="mask"></div>
</div><!--Fim Janela Modal-->