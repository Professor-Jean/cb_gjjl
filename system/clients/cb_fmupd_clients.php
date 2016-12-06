<h1 id="title">Registro de Cliente</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Cliente</h3>
    <hr />
    <?php
        $g_id = $_GET['id'];
        //Esta linha é responsável por receber o id da fmins via GET.
        //Este bloco é responsável por fazer a seleção dos clientes que tenham o id igual ao recebido juntando com as tabelas districts e cities para pegar o id que está vinculado com o registro.
        $sql_sel_clients = "SELECT clients.*, districts.id AS districtsid, cities.id AS citiesid FROM clients INNER JOIN districts ON clients.districts_id=districts.id INNER JOIN cities ON districts.cities_id=cities.id WHERE clients.id='".$g_id."'";
        $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
        $sql_sel_clients_preparado->execute();
        $sql_sel_clients_dados = $sql_sel_clients_preparado->fetch();
        $data = explode('-', $sql_sel_clients_dados['birthdate']);
        $datab = $data[2].'/'.$data[1].'/'.$data[0];
    ?>
    <form name="frmregcidades" method="POST" action="?folder=clients/&file=cb_upd_clients&ext=php">
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_clients_dados['id']; ?>">
        <table>
            <tr>
                <td>Nome Completo:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.: João da Silva" maxlength="45" value="<?php echo $sql_sel_clients_dados['name']; ?>"></td>
                <td>CEP:</td>
                <td><input type="text" name="txtcep" placeholder="Ex.: 89556226" maxlength="8" value="<?php echo $sql_sel_clients_dados['cep']; ?>"></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="txtemail" placeholder="Ex.: joao.silva@gmail.com" maxlength="70" value="<?php echo $sql_sel_clients_dados['email']; ?>"></td>
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
                            //Este bloco é responsável por exibir os dados contidos na tabela cities em options que apareceram para o usuário.
                            while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
                                $valor_cidade = $sql_sel_cities_dados['id'];
                                $nome_cidade = $sql_sel_cities_dados['name'];

                                if($valor_cidade == $sql_sel_clients_dados['citiesid']){
                                    //Se à variável valor_dates for igual a dates_id da tabela availabletickets, mostre a mesagem
                                    echo "<option value='".$valor_cidade."' selected>".$nome_cidade."</option>";
                                }else{
                                    //Se não, mostre a mensagem
                                    echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
                                }
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Telefone:</td>
                <td><input type="text" name="txttelefone" placeholder="Ex.: 4799999999" maxlength="15" value="<?php echo $sql_sel_clients_dados['phone']; ?>"></td>
                <td>Bairro:</td>
                <td>
                    <?php
                        //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidades).
                        $sql_sel_districts = "SELECT * FROM districts ORDER BY name";
                        $sql_sel_districts_preparado = $conexaobd->prepare($sql_sel_districts);
                        $sql_sel_districts_preparado->execute();
                    ?>
                    <select name="selbairro">
                        <option value="">Escolha...</option>
                    <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela districts em options que apareceram para o usuário.
                        while($sql_sel_districts_dados = $sql_sel_districts_preparado->fetch()){
                            $valor_bairro = $sql_sel_districts_dados['id'];
                            $nome_bairro = $sql_sel_districts_dados['name'];

                            if($valor_bairro == $sql_sel_clients_dados['districtsid']){
                                //Se à variável valor_dates for igual a dates_id da tabela availabletickets, mostre a mesagem
                                echo "<option value='".$valor_bairro."' selected>".$nome_bairro."</option>";
                            }
                        }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Data de Nasc.:</td>
                <td><input type="text" name="txtdata_nasc" placeholder="Ex.: DD/MM/AAAA" maxlength="10" value="<?php echo $datab; ?>"></td>
                <td>Logradouro:</td>
                <td><input type="text" name="txtlogradouro" placeholder="Ex.: Rua Iririú" maxlength="40" value="<?php echo $sql_sel_clients_dados['street']; ?>"></td>
            </tr>
            <tr>
                <td>RG:</td>
                <td><input type="text" name="txtrg" placeholder="Ex.: 8456679" maxlength="10" value="<?php echo $sql_sel_clients_dados['rg']; ?>"></td>
                <td>Número:</td>
                <td><input type="text" name="txtnumero" placeholder="Ex.: 459" maxlength="5" value="<?php echo $sql_sel_clients_dados['number']; ?>"></td>
            </tr>
            <tr>
                <td>CPF:</td>
                <td><input type="text" name="txtcpf" placeholder="Ex.: 52446889548" maxlength="11" value="<?php echo $sql_sel_clients_dados['cpf']; ?>"></td>
                <td>Complemento:</td>
                <td><input type="text" name="txtcomplemento" placeholder="Ex.: casa" maxlength="20" value="<?php echo $sql_sel_clients_dados['complement']; ?>"></td>
            </tr>
            <tr>
                <td colspan="2"><button type="reset" name="btnreset">Limpar</button></td>
                <td colspan="2"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->