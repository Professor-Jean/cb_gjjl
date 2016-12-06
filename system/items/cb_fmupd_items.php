<?php

    $g_id = $_GET['id'];

    $sql_sel_items = "SELECT * FROM items WHERE id='".$g_id."'";

    $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);

    $sql_sel_items_preparado->execute();

    $sql_sel_items_dados = $sql_sel_items_preparado->fetch();

    $valor = explode('.' ,$sql_sel_items_dados['value']);

?>
<h1 id="title">Registro de Item</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Alterar Item</h3>
    <hr/>
    <form id="alteration_form" name="frmraltitem" method="POST" action="?folder=items/&file=cb_upd_items&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <input type="hidden" name="hidid" value="<?php echo $sql_sel_items_dados['id']; ?>">
        <table>
            <tr>
                <td>Nome:</td>
                <td><input type="text" value="<?php echo $sql_sel_items_dados['name']; ?>" name="txtnome" placeholder="Ex.:Porta bolo do ben 10" maxlength="40"></td>
            </tr>
            <tr>
                <td>Quantidade:</td>
                <td><input type="text" value="<?php echo $sql_sel_items_dados['quantity']; ?>" name="txtquantidade" placeholder="Ex.:1234" maxlength="3"></td>
            </tr>
            <tr>
                <td>Valor Unitário:</td>
                <td><input type="text" value="<?php echo $valor[0].",".$valor[1]; ?>" name="txtvalorunitario" placeholder="Ex.:1234" maxlength="7"></td>
            </tr>
            <tr>
                <td valign="middle">Descrição: *</td>
                <td><textarea name="txtdescricao"  maxlength="255" style="max-width:180px;"><?php echo $sql_sel_items_dados['description']; ?></textarea></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->
