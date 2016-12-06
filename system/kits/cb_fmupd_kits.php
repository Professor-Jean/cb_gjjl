<?php

    $g_id = $_GET['id'];

    $valor_real_s = 0;

    /* O SELECT abaixo é responsável por selecionar os kits */

    $sql_sel_kits = "SELECT kits.id, kits.name, kits.discount, kits.description, kits_has_items.items_id, kits_has_items.item_quantity, kits_has_items.actual_value FROM kits INNER JOIN kits_has_items ON kits.id=kits_has_items.kits_id WHERE kits.id='".$g_id."'";

    $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);

    $sql_sel_kits_preparado->execute();

    $sql_sel_kits_dados = $sql_sel_kits_preparado->fetch();

    $valor_real_s = 0;
    $valor_desconto = 0;

    $sql_sel_id_items = "SELECT items_id FROM kits_has_items WHERE kits_id='" . $sql_sel_kits_dados['id'] . "'";

    $sql_sel_id_items_preparado = $conexaobd->prepare($sql_sel_id_items);

    $sql_sel_id_items_preparado->execute();

    $linhas_cont = $sql_sel_id_items_preparado->rowCount();

    for ($contadora = 0; $contadora < $linhas_cont; $contadora++) {

        $sql_sel_id_items_dados = $sql_sel_id_items_preparado->fetch();

        $items_id[$contadora] = $sql_sel_id_items_dados['items_id'];

        $sql_sel_valor_kit = "SELECT item_quantity, actual_value FROM kits_has_items WHERE items_id='" . $items_id[$contadora] . "' AND kits_id='" . $sql_sel_kits_dados['id'] . "'";

        $sql_sel_valor_kit_preparado = $conexaobd->prepare($sql_sel_valor_kit);

        $sql_sel_valor_kit_preparado->execute();

        $sql_sel_valor_kit_dados = $sql_sel_valor_kit_preparado->fetch();

        $valor_real_s = $valor_real_s + ($sql_sel_valor_kit_dados['item_quantity'] * $sql_sel_valor_kit_dados['actual_value']);

    }

    $valor_final_s = $valor_real_s - $sql_sel_kits_dados['discount'];

    //

    $valor_f = explode('.', $valor_final_s);

    $cont = count($valor_f);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_final = 0;

        if($contadora==1){
            $centavos = $valor_f[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_final = $valor_f[0].",".$centavos;

    }

    //

    $valor_r = explode('.', $valor_real_s);

    $cont = count($valor_r);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_real = 0;

        if($contadora==1){
            $centavos = $valor_r[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_real = $valor_r[0].",".$centavos;

    }

    //

    $valor_d = explode('.', $sql_sel_kits_dados['discount']);

    $cont = count($valor_d);

    for($contadora=0; $contadora<$cont; $contadora++){

        $valor_desconto = 0;

        if($contadora==1){
            $centavos = $valor_d[$contadora];
        }else{
            $centavos = '00';
        }

        $valor_desconto = $valor_d[0].",".$centavos;

    }

?>
<h1 id="title">Registro de Kit</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Kit</h3>
    <hr/>
    <form id="register_form" name="frmregkit" method="POST" action="?folder=kits/&file=cb_upd_kits&ext=php">
    <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
    <input type="hidden" name="hidid" value="<?php echo $sql_sel_kits_dados['id']; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="txtnome" value="<?php echo $sql_sel_kits_dados['name']; ?>" placeholder="Ex.:Cortina Rosa" maxlength="20"></td>
            </tr>
            <tr>
                <td>Descrição: *</td>
                <td><textarea name="txtdescricao" maxlength="255" style="max-width:180px;"><?php echo $sql_sel_kits_dados['description']; ?></textarea></td>
            </tr>
            <tr>
                <td>Itens:</td>
                <td>Quantidade:</td>
                <td>
                    <a href="#" title="Adicionar item" class="adicionarCampo"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <?php

            $sql_sel_kits_hi = "SELECT kits_has_items.item_quantity, kits_has_items.items_id, kits_has_items.kits_id, items.name, kits.id FROM kits_has_items INNER JOIN kits ON kits_has_items.kits_id=kits.id INNER JOIN items ON kits_has_items.items_id=items.id WHERE kits_id='".$g_id."'";

            $sql_sel_kits_hi_preparado = $conexaobd->prepare($sql_sel_kits_hi);

            $sql_sel_kits_hi_preparado->execute();

            while($sql_sel_kits_hi_dados = $sql_sel_kits_hi_preparado->fetch()){

            ?>
            <tr class="linhas">
                <td>
                    <select name="selitens[]" class='itens' onchange="achapreco(this.value)">
                        <?php

                        echo "<option value='".$sql_sel_kits_hi_dados['items_id']."'>".$sql_sel_kits_hi_dados['name']."</option>";

                        /* O SELECT abaixo é responsável por selecionar os itens */

                        $sql_sel_items = "SELECT id, name, quantity, value FROM items WHERE id<>'".$sql_sel_kits_hi_dados['items_id']."'";

                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

                        $sql_sel_items_preparado->execute();

                        while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                            $id_items = $sql_sel_items_dados['id'];
                            $nome_item = $sql_sel_items_dados['name'];

                            echo "<option value='".$id_items."'>".$nome_item."</option>";

                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="txtquantidade[]" class='quantidade' value="<?php echo $sql_sel_kits_hi_dados['item_quantity']; ?>" maxlength="4" placeholder="Ex.:2"></td>
                <td><a href="#" title="Remover Item" class="removerCampo"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <?php

            }

            ?>
            <tr>
                <td colspan="2"><button type="button" name="btncalcular" id="valor_real_calc" style="width: 410px;">Calcular Valor Real</button></td>
            </tr>
            <tr>
                <td>Valor Real:</td>
                <td><input type="text" name="txtvalor_real" class="valor_real" value="<?php echo $valor_real; ?>" placeholder="Ex.:1500" maxlength="10" readonly></td>
            </tr>
            <tr>
                <td>Desconto:</td>
                <td><input type="text" name="txtdesconto" class="desconto" value="<?php echo $valor_desconto; ?>" placeholder="Ex.:50" maxlength="4"></td>
            </tr>
            <tr>
                <td>Valor Final:</td>
                <td><input type="text" name="txtvalor_final" class="valor_final" value="<?php echo $valor_final; ?>" placeholder="Ex.:1450" maxlength="10" readonly ></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
