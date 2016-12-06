<h1 id="title">Registro de Orçamento de Evento</h1>
<div class="cregister"><div id="calendar"></div></div>
<div id="register" class="register"><!--Início do conteúdo do formulário-->
    <h3>Cadastrar Orçamento de Evento</h3>
    <hr />
    <form name="frmregeventos" method="POST" action="?folder=events/&file=cb_ins_events&ext=php">
        <h4 style="text-align: center; color: #700;">Campos Não Obrigatórios *</h4>
        <table>
            <tr>
                <td>Cliente:</td>
                <?php
                    //Este bloco é responsável por fazer a seleção do id e o nome da tabela clients (clientes).
                    $sql_sel_clients = "SELECT id, name FROM clients";
                    $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
                    $sql_sel_clients_preparado->execute();
                ?>
                <td colspan="3">
                    <select id="nomecliente" name="selcliente" style="width: 485px;">
                        <option value="">Escolha um Cliente...</option>
                <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela clients em options que aparecerão para o usuário.
                        while($sql_sel_clients_dados = $sql_sel_clients_preparado->fetch()){
                            $valor_cliente = $sql_sel_clients_dados['id'];
                            $nome_cliente = $sql_sel_clients_dados['name'];

                            echo "<option value='".$valor_cliente."'>".$nome_cliente."</option>";
                        }
                ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">Kits:</td>
                <td colspan="2">Quantidade: <a href="#" title="Adicionar item" class="adicionarCampo"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <tr class="linhas">
                <td colspan="2">
                    <?php
                        //Este bloco é responsável por fazer a seleção do id e o nome da tabela kits.
                        $sql_sel_kits = "SELECT id, name FROM kits";
                        $sql_sel_kits_preparado = $conexaobd->prepare($sql_sel_kits);
                        $sql_sel_kits_preparado->execute();
                    ?>
                    <select name="selkits[]" class='kits' style="width: 250px;" onchange="achaprecoek(this.value)">
                        <option value="">Escolha...</option>
                    <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela kits em options que aparecerão para o usuário.
                        while($sql_sel_kits_dados = $sql_sel_kits_preparado->fetch()){
                            $valor_kits = $sql_sel_kits_dados['id'];
                            $nome_kits = $sql_sel_kits_dados['name'];

                            echo "<option value='".$valor_kits."'>".$nome_kits."</option>";
                        }
                    ?>
                    </select>
                </td>
                <td colspan="2"><input type="text" name="txtquantidadekits[]" class='quantidadekits' maxlength="4" placeholder="Ex.:2" style="width: 250px;"><a href="#" title="Remover Item" class="removerCampo"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <tr>
                <td colspan="2">Itens:</td>
                <td colspan="2">Quantidade: <a href="#" title="Adicionar item" class="adicionarCampo1"><img width="25px" heigth="25px" src="../layout/images/plus.png" border="0"/></a>
                </td>
            </tr>
            <tr class="linhas1">
                <td colspan="2">
                    <?php
                        //Este bloco é responsável por fazer a seleção do id e o nome da tabela items (itens).
                        $sql_sel_items = "SELECT id, name FROM items";
                        $sql_sel_items_preparado = $conexaobd->prepare($sql_sel_items);
                        $sql_sel_items_preparado->execute();
                    ?>
                    <select name="selitens[]" class='itens' style="width: 250px;" onchange="achaprecoei(this.value)">
                        <option value="">Escolha...</option>
                    <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela items em options que aparecerão para o usuário.
                        while($sql_sel_items_dados = $sql_sel_items_preparado->fetch()){
                            $valor_itens = $sql_sel_items_dados['id'];
                            $nome_itens = $sql_sel_items_dados['name'];

                            echo "<option value='".$valor_itens."'>".$nome_itens."</option>";
                        }
                    ?>
                    </select>
                </td>
                <td colspan="2"><input type="text" name="txtquantidadeitens[]" class='quantidadeitens' maxlength="4" placeholder="Ex.:2" style="width: 250px;"><a href="#" title="Remover Item" class="removerCampo1"><img width="25px" heigth="25px" src="../layout/images/less.png" border="0"/></a></td>
            </tr>
            <tr>
                <td colspan="4"><button type="button" name="btncalculare" id="valor_real_calc" style="width: 650px;">Calcular Valor Real</button></td>
            </tr>
            <tr>
                <td>Local:</td>
                <td>
                    <?php
                        //Este bloco é responsável por fazer a seleção do id e o nome da tabela locals.
                        $sql_sel_locals = "SELECT id, name FROM locals";
                        $sql_sel_locals_preparado = $conexaobd->prepare($sql_sel_locals);
                        $sql_sel_locals_preparado->execute();
                    ?>
                    <select name="sellocal" id="local" class="localvazio">
                        <option value="">Escolha...</option>
                    <?php
                        //Este bloco é responsável por exibir os dados contidos na tabela locals em options que aparecerão para o usuário.
                        while($sql_sel_locals_dados = $sql_sel_locals_preparado->fetch()){
                            $valor_local = $sql_sel_locals_dados['id'];
                            $nome_local = $sql_sel_locals_dados['name'];

                            echo "<option value='".$valor_local."'>".$nome_local."</option>";
                        }
                    ?>
                        <option value="cliente">Local do Cliente</option>
                        <option value="outro">Local Externo</option>
                    </select>
                </td>
                <input type="hidden" name="hidlocal" value="">
                <td>CEP:</td>
                <td><input type="text" name="txtcep" placeholder="Ex.: 86559557" maxlength="8" class="inativo"></td>
            </tr>
            <tr>
                <td>Cidade:</td>
                <td id="cidade">
                    <?php
                        //Este bloco é responsável por fazer a seleção de todos os dados da tabela cities (cidade), ordenando por nome.
                        $sql_sel_cities = "SELECT * FROM cities ORDER BY name";
                        $sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
                        $sql_sel_cities_preparado->execute();
                    ?>
                    <select name="selcidade" onChange="mostraBairro()" class="sinativo">
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
                <td>Bairro:</td>
                <td id="bairro">
                    <select name="selbairro" class="sinativo">
                        <option value="">Selecione uma cidade...</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Logradouro:</td>
                <td><input type="text" name="txtlogradouro" placeholder="Ex.: Rua Pica-Pau" maxlength="40" class="inativo"></td>
                <td>Número:</td>
                <td><input type="text" name="txtnumero" placeholder="Ex.: 158" maxlength="5" class="inativo"></td>
            </tr>
            <tr>
                <td>Complemento: *</td>
                <td colspan="3"><input type="text" name="txtcomplemento" placeholder="Ex.: casa" maxlength="20" style="width: 485px;" class="inativo"></td>
            </tr>
            <tr>
                <td>Data do Evento:</td>
                <td colspan="3"><input id="data" type="text" name="txtdata_evento" placeholder="Ex.: DD/MM/AAAA" maxlength="10" style="width: 460px;" readonly><img id="calendario" src="../layout/images/edit.png" width="25px" style="cursor: pointer;"></td>
            </tr>
            <tr>
                <td>Horário:</td>
                <td colspan="3"><input type="text" name="txthorario" placeholder="Ex.: HH:MM" maxlength="5" style="width: 485px;"></td>
            </tr>
            <tr>
                <td>Taxa de Entrega:</td>
                <td colspan="3"><input type="text" name="txttaxa_entrega" class="taxa_entrega" placeholder="Ex.: 15" maxlength="6" style="width: 485px;"></td>
            </tr>
            <tr>
                <td>Valor Real:</td>
                <td><input type="text" name="txtvalor_real" class="valor_real" placeholder="Ex.: 1500" maxlength="10" readonly></td>
                <td>Desconto:</td>
                <td><input type="text" name="txtdesconto" class="descontoe" placeholder="Ex.: 50" maxlength="10"></td>
            </tr>
            <tr>
                <td>Valor Final:</td>
                <td colspan="3"><input type="text" name="txtvalor_final" class="valor_final" placeholder="Ex.: 1450" maxlength="10" style="width: 485px;" readonly></td>
            </tr>
            <tr>
                <td>Observação: *</td>
                <td colspan="3"><textarea name="txtobservacao" maxlength="255" style="width: 485px; max-width: 485px;"></textarea></td>
            </tr>
            <tr>
                <td colspan="1" align="left"><button type="reset" name="btnreset">Limpar</button></td>
                <td colspan="3" align="right"><button type="submit" name="btnsubmit">Enviar</button></td>
            </tr>
        </table>
    </form>
</div><!--Fim do conteúdo do formulário-->