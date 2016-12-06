<h1 id="title">Registro de Local para Eventos</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Local para Evento</h3>
    <hr />
    <form name="frmreglocals" method="POST" action="?folder=locals/&file=cb_ins_locals&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>Nome:</td>
                            <td><input type="text" name="txtnome" placeholder="Ex.: Espaço 1" maxlength="30"></td>
                        </tr>
                        <tr>
                            <td>Área (m²):</td>
                            <td><input type="text" name="txtarea" placeholder="Ex.: 10" maxlength="8"></td>
                        </tr>
                        <tr>
                            <td>Altura (m):</td>
                            <td><input type="text" name="txtaltura" placeholder="Ex.: 3" maxlength="5"></td>
                        </tr>
                        <tr rowspan="3">
                            <td>Descrição: *</td>
                            <td><textarea name="txtdescricao" maxlength="255" style="height: 100px; max-height:100px; max-width:180px;"></textarea></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>CEP:</td>
                            <td><input type="text" name="txtcep" placeholder="Ex.: 89556226" maxlength="8"></td>
                        </tr>
                        <tr>
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

                                        echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Bairro:</td>
                            <td>
                                <select name="selbairro">
                                    <option value="">Selecione uma cidade...</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Logradouro:</td>
                            <td><input type="text" name="txtlogradouro" placeholder="Ex.: Rua Iririú" maxlength="40"></td>
                        </tr>
                        <tr>
                            <td>Número:</td>
                            <td><input type="text" name="txtnumero" placeholder="Ex.: 459" maxlength="5"></td>
                        </tr>
                        <tr>
                            <td>Valor para Aluguel:</td>
                            <td><input type="text" name="txtvalor_aluguel" placeholder="Ex.: 100" maxlength="8"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">Complemento: *<input type="text" name="txtcomplemento" placeholder="Ex.: casa" maxlength="20" style="width:525px;"></td>
            </tr>
            <tr>
                <td align="right"><button type="reset" name="btnreset">Limpar</button></td>
                <td align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da consulta-->
    <h2>Locais Registrados</h2>
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
                $pesquisa = "WHERE locals.name LIKE '%".$p_pesquisa."%' OR locals.description LIKE '%".$p_pesquisa."%' OR districts.name LIKE '%".$p_pesquisa."%' OR locals.street LIKE '%".$p_pesquisa."%' OR locals.number LIKE '%".$p_pesquisa."%' OR locals.area LIKE '%".$p_pesquisa."%' OR locals.height LIKE '%".$p_pesquisa."%'";
            }
        }
        //Este bloco é responsável por fazer a seleção dos dados id, name, email, phone e birthdate da tabela clients (clientes). E executa a pesquisa se houver.
        $sql_sel_locals = "SELECT locals.id, locals.rent_value, locals.name, locals.description, locals.street, locals.number, locals.area, locals.height, (districts.name) AS nome_bairro FROM locals INNER JOIN districts ON locals.districts_id=districts.id ".$pesquisa." ORDER BY locals.name ASC";

        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);

        $sql_sel_locals_preparado->execute();
        ?>
    </div><!--Fim do centro-->
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="10%">Nome</th>
            <th width="21%">Descrição</th>
            <th width="10%">Bairro</th>
            <th width="12%">Rua</th>
            <th width="7%">Nº</th>
            <th width="7%">Área</th>
            <th width="7%">Altura</th>
            <th width="10%">Valor para Aluguel</th>
            <th width="3%">Editar</th>
            <th width="3%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php


            if($sql_sel_locals_preparado->rowCount()>0){

                while($sql_sel_locals_dados = $sql_sel_locals_preparado->fetch()){

                    $valor_a = explode('.', $sql_sel_locals_dados['area']);

                    $cont = count($valor_a);

                    for($contadora=0; $contadora<$cont; $contadora++){

                        $valor_area = 0;

                        if($contadora==1){
                            $centimetros = $valor_a[$contadora];
                        }else{
                            $centimetros = '00';
                        }

                        $valor_area = $valor_a[0].",".$centimetros;

                    }

                    //

                    $valor_al = explode('.', $sql_sel_locals_dados['height']);

                    $cont = count($valor_al);

                    for($contadora=0; $contadora<$cont; $contadora++){

                        $valor_altura = 0;

                        if($contadora==1){
                            $centimetros = $valor_al[$contadora];
                        }else{
                            $centimetros = '00';
                        }

                        $valor_altura = $valor_al[0].",".$centimetros;

                    }

                    //

                    $valor_alg = explode('.', $sql_sel_locals_dados['rent_value']);

                    $cont = count($valor_alg);

                    for($contadora=0; $contadora<$cont; $contadora++){

                        $valor_aluguel = 0;

                        if($contadora==1){
                            $centavos = $valor_alg[$contadora];
                        }else{
                            $centavos = '00';
                        }

                        $valor_aluguel = $valor_alg[0].",".$centavos;

                    }

                    //

                    if($sql_sel_locals_dados['description']==''){
                        $descricao = 'Não há descrição!';
                    }else{
                        $descricao = $sql_sel_locals_dados['description'];
                    }

        ?>
            <tr>
                <td><?php echo $sql_sel_locals_dados['name'];?></td>
                <td><?php echo $descricao;?></td>
                <td><?php echo $sql_sel_locals_dados['nome_bairro'];?></td>
                <td><?php echo $sql_sel_locals_dados['street'];?></td>
                <td><?php echo $sql_sel_locals_dados['number'];?></td>
                <td><?php echo $valor_area;?> m²</td>
                <td><?php echo $valor_altura;?> m</td>
                <td>R$ <?php echo $valor_aluguel;?></td>
                <td align="center"><a href="?folder=locals/&file=cb_fmupd_locals&ext=php&id=<?php echo $sql_sel_locals_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                <td align="center"><?php echo safedelete($sql_sel_locals_dados['id'], "", "?folder=locals/&file=cb_del_locals&ext=php", "o local para evento", ""); ?></td>
            </tr>
        <?php

                }
            }else{

        ?>
        <tr>
            <td align="center" colspan="9">Não há registro de local!</td>
        </tr>
        <?php

            }

        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da consulta-->
