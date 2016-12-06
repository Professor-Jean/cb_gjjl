<h1 id="title">Registro de Item</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Item</h3>
    <hr/>
    <form id="register_form" name="frmregitem" method="POST" action="?folder=items/&file=cb_ins_items&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="txtnome" placeholder="Ex.:Cortina Rosa" maxlength="40"></td>
            </tr>
            <tr>
                <td>Quantidade:</td>
                <td><input type="text" name="txtquantidade" placeholder="Ex.:1234" maxlength="3"></td>
            </tr>
            <tr>
                <td>Valor Unitário:</td>
                <td><input type="text" name="txtvalorunitario" placeholder="Ex.:1234" maxlength="7"></td>
            </tr>
            <tr>
                <td valign="middle">Descrição: *</td>
                <td><textarea name="txtdescricao" maxlength="255" style="max-width:180px;"></textarea></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
<div id="consult"><!--Início da tabela-->
    <h2>Itens Registrados</h2>
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
                $pesquisa = "WHERE id LIKE '%".$p_pesquisa."%' OR name LIKE '%".$p_pesquisa."%' OR quantity LIKE '%".$p_pesquisa."%' OR value LIKE '%".$p_pesquisa."%' OR description LIKE '%".$p_pesquisa."%'";
            }
        }
        //Este bloco é responsável por fazer a seleção dos dados  id, name, quantity, value, description da tabela items. E executa a pesquisa se houver.
        $sql_sel_items = "SELECT * FROM items ".$pesquisa."";
        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
        $sql_sel_items_preparado->execute();
        ?>
    </div><!--Fim do centro-->
    <table class="consult_table"><!--Início da tabela de consulta-->
        <thead><!--Início do cabeçalho da tabela-->
        <tr>
            <th width="5%">Código</th>
            <th width="25%">Nome</th>
            <th width="45%">Descrição</th>
            <th width="10%">Quantidade</th>
            <th width="10%">Valor Unitário</th>
            <th width="5%">Editar</th>
            <th width="5%">Excluir</th>
        </tr>
        </thead><!--Fim do cabeçalho da tabela-->
        <tbody><!--Início do corpo da tabela-->
        <?php
        
            if($sql_sel_items_preparado->rowCount()>0){

                while ($sql_sel_items_dados = $sql_sel_items_preparado->fetch()) {

                    $valor = explode('.' ,$sql_sel_items_dados['value']);

                    if($sql_sel_items_dados['description']==''){
                        $descricao = 'Não há descrição!';
                    }else{
                        $descricao = $sql_sel_items_dados['description'];
                    }

        ?>
            <tr>
                <td><?php echo $sql_sel_items_dados['id']; ?></td>
                <td><?php echo $sql_sel_items_dados['name']; ?></td>
                <td><?php echo $descricao; ?></td>
                <td><?php echo $sql_sel_items_dados['quantity']; ?></td>
                <td>R$ <?php echo $valor[0].",".$valor[1]; ?></td>
                <td align="center"><a href="?folder=items/&file=cb_fmupd_items&ext=php&id=<?php echo $sql_sel_items_dados['id']; ?>"><img src="../layout/images/edit.png" width="25px"></a></td>
                <td align="center"><?php echo safedelete($sql_sel_items_dados['id'], "", "?folder=items/&file=cb_del_items&ext=php", "Item", "".$sql_sel_items_dados['name'].""); ?></td>
            </tr>
        <?php
                }
            }else{
        ?>
            <tr>
                <td align="center" colspan="7" ><?php echo mensagens('Vazio', 'itens');  ?></td>
            </tr>
        <?php
            }
        ?>
        </tbody><!--Fim do corpo da tabela-->
    </table><!--Fim da tabela de consulta-->
</div><!--Fim da tabela-->