<?php

    /* O SELECT abaixo é responsável por selecionar os itens */

    $sql_sel_items = "SELECT id, name, quantity, value FROM items";

    $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

    $sql_sel_items_preparado->execute();
    $i=0;

?>
<h1 id="title">Registro de Kit</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Kit</h3>
    <hr/>
    <form id="register_form" name="frmregkit" method="POST" action="?folder=kits/&file=cb_ins_kits&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.:Cortina Rosa" maxlength="20"></td>
            </tr>
            <tr>
                <td>Descrição: *</td>
                <td><textarea name="txtdescricao" maxlength="255" style="max-width:180px;"></textarea></td>
            </tr>
            <tr>
                <td>Itens:</td>
                <td>Quantidade:</td>
                <td>
                    <a href="#" title="Adicionar item" class="adicionarCampo"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <tr class="linhas">
                <td>
                    <select name="selitens[]" class='itens' onchange="achapreco(this.value)">
                        <option value="">Escolha...</option>
                        <?php
                        $i++;
                        while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                            $id_items = $sql_sel_items_dados['id'];
                            $nome_item = $sql_sel_items_dados['name'];

                            echo "<option value='".$id_items."'>".$nome_item."</option>";

                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="txtquantidade[]" class='quantidade' maxlength="4" placeholder="Ex.:2"></td>
                <td><a href="#" title="Remover Item" class="removerCampo"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <tr>
                <td colspan="2"><button type="button" name="btncalcular" id="valor_real_calc" style="width: 410px;">Calcular Valor Real</button></td>
            </tr>
            <tr>
                <td>Valor Real:</td>
                <td><input type="text" name="txtvalor_real" class="valor_real" placeholder="Ex.:1500" maxlength="10" readonly></td>
            </tr>
            <tr>
                <td>Desconto:</td>
                <td><input type="text" name="txtdesconto" class="desconto" placeholder="Ex.:50" maxlength="4"></td>
            </tr>
            <tr>
                <td>Valor Final:</td>
                <td><input type="text" name="txtvalor_final" class="valor_final" placeholder="Ex.:1450" maxlength="10" readonly ></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da tabela-->
    <h2>Kits Registrados</h2>
    <div align="center"><!--Início do centro-->
        <div align="right" class="search"><!--Início da pesquisa-->
            <form name="frmpesquisa" method="POST" action="">
                <input type="text" name="txtpesquisa" placeholder="Pesquisar" maxlength="">
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
                $pesquisa = "WHERE kits.id LIKE '%".$p_pesquisa."%' OR kits.name LIKE '%".$p_pesquisa."%' OR kits.description LIKE '%".$p_pesquisa."%'";
            }
        }

        //Este bloco é responsável por fazer a seleção dos dados  id, name, description, da tabela kits. E executa a pesquisa se houver.

        /* O SELECT abaixo é responsável por selecionar os kits */

        $sql_sel_kits = "SELECT kits.id, kits.name, kits.description, kits.discount, kits_has_items.kits_id FROM kits INNER JOIN kits_has_items ON kits.id=kits_has_items.kits_id ".$pesquisa." GROUP BY kits.id";

        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);

        $sql_sel_kits_preparado->execute();

        ?>
    </div><!--Fim do centro-->
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="5%">Código</th>
            <th width="25%">Nome</th>
            <th width="50%">Descrição</th>
            <th width="10%">Valor</th>
            <th width="5%">Editar</th>
            <th width="5%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php

            if($sql_sel_kits_preparado->rowCount()>0){

                while($sql_sel_kits_dados = $sql_sel_kits_preparado->fetch()){

                    $valor_kit = 0;
                    $valor_desconto = 0;

                    $sql_sel_id_items = "SELECT items_id FROM kits_has_items WHERE kits_id='".$sql_sel_kits_dados['id']."'";

                    $sql_sel_id_items_preparado = $conexaobd->prepare($sql_sel_id_items);

                    $sql_sel_id_items_preparado->execute();

                    $linhas_cont = $sql_sel_id_items_preparado->rowCount();

                    for($contadora=0; $contadora<$linhas_cont; $contadora++){

                        $sql_sel_id_items_dados = $sql_sel_id_items_preparado->fetch();

                        $items_id[$contadora] = $sql_sel_id_items_dados['items_id'];

                        $sql_sel_valor_kit = "SELECT item_quantity, actual_value FROM kits_has_items WHERE items_id='".$items_id[$contadora]."' AND kits_id='".$sql_sel_kits_dados['id']."'";

                        $sql_sel_valor_kit_preparado = $conexaobd->prepare($sql_sel_valor_kit);

                        $sql_sel_valor_kit_preparado->execute();

                        $sql_sel_valor_kit_dados = $sql_sel_valor_kit_preparado->fetch();

                        $valor_kit = $valor_kit + ($sql_sel_valor_kit_dados['item_quantity'] * $sql_sel_valor_kit_dados['actual_value']);

                    }

                    $valor_desconto = $valor_kit - $sql_sel_kits_dados['discount'];

                    $valor_s = explode('.', $valor_desconto);

                    $cont = count($valor_s);

                    for($contadora=0; $contadora<$cont; $contadora++){

                        $valor = 0;

                        if($contadora==1){
                            if($valor_s[$contadora]<10){
                                $centavos = "".$valor_s[$contadora]."0";
                            }else{
                                $centavos = $valor_s[$contadora];
                            }
                        }else{
                            $centavos = '00';
                        }

                        $valor = $valor_s[0].",".$centavos;

                    }

                    if($sql_sel_kits_dados['description']==''){
                        $descricao = 'Não há descrição!';
                    }else{
                        $descricao = $sql_sel_kits_dados['description'];
                    }

        ?>
        <tr>
            <td><?php echo $sql_sel_kits_dados['id']; ?></td>
            <td><?php echo $sql_sel_kits_dados['name']; ?></td>
            <td><?php echo $descricao; ?></td>
            <td>R$ <?php echo $valor; ?></td>
            <td align="center"><a href="?folder=kits/&file=cb_fmupd_kits&ext=php&id=<?php echo $sql_sel_kits_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
            <td align="center"><?php echo safedelete($sql_sel_kits_dados['id'], $sql_sel_kits_dados['kits_id'], "?folder=kits/&file=cb_del_kits&ext=php", "o kit", "".$sql_sel_kits_dados['name'].""); ?></td>
        </tr>
        <?php
                }
            }else {
        ?>
        <tr>
            <td align="center" colspan="7"><?php echo mensagens('Vazio', 'kits');  ?></td>
        </tr>
        <?php
            }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da tabela-->
