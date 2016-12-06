<h1 id="title">Cancelamento de Evento</h1>
<div id="register"><!--Início do conteúdo do formulário-->
    <h3>Cancelar Evento</h3>
    <hr />
    <?php
    $g_id = $_GET['id'];
    ?>
    <form name="frmcancevento" method="POST" action="?folder=events_control/control/&file=cb_cancelconfirmed_control&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <table>
            <tr>
                <td>Código do Evento:</td>
                <td><input type="text" name="txtid" readonly maxlength="5" value="<?php echo $g_id ?>"></td>
            </tr>
            <tr>
                <td>Motivo:</td>
                <td>
                    <select name="selmotivo">
                        <option value="">Escolha...</option>
                        <option value="FI">Financeiro</option>
                        <option value="IN">Insatisfação</option>
                        <option value="EI">Evento mais importante</option>
                        <option value="AF">Adversidade familiar</option>
                        <option value="OT">Outros</option>
                </td>
            </tr>
            <tr>
                <td>Comentário: *</td>
                <td><textarea name="txacomentario" maxlength="255" style="max-width:180px;"></textarea></td>
            </tr>
            <tr>
                <td>Ressarcimento:</td>
                <td><input type="text" name="txtressarc" maxlength="7" placeholder="Ex.: 12,00" ></td>
            </tr>
            <tr>
                <td>Multa:</td>
                <td><input type="text" name="txtmulta" maxlength="7" placeholder="Ex.: 15,00" ></td>
            </tr>
            <tr>
                <td><button type="reset" name="btnreset">Limpar</button></td>
                <td><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->