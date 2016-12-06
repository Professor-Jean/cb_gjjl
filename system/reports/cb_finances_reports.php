
<h1 id="title">Relatório Financeiro</h1>
<div id="consult">
    <form class="filter_form" name="filtano" method="POST" action="?folder=reports/&file=cb_finances_reports&ext=php">
        <?php
            $sql_sel_ano = "SELECT YEAR(event_date) FROM events WHERE status>0 GROUP BY YEAR(event_date)";
            $sql_sel_ano_preparado = $conexaobd->prepare($sql_sel_ano);
            $sql_sel_ano_preparado->execute();

        ?>
        <table>
            <tr>
                <td>Ano:</td>
                <td>
                    <select name="selano" id="selano" onchange="filtrarFinanceiro()">
                        <?php
                        while ($sql_sel_ano_dados=$sql_sel_ano_preparado->fetch()) {
                            if ($sql_sel_ano_dados['YEAR(event_date)'] == date("Y")) {
                                ?>
                                }
                                <option selected><?php echo $sql_sel_ano_dados['YEAR(event_date)'] ?></option>
                                <?php
                            } else {
                                ?>
                                <option><?php echo $sql_sel_ano_dados['YEAR(event_date)'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
    </form>
    <h2>Gráfico de Finanças</h2>
    <div style="width: 94.3%; margin:auto; margin-top: 25px ;" id="area_chart_finances">
    </div>
    <div class="legend">
        <table>
            <tr>
                <td align="right"><div class="label_legend ganhos"></div></td>
                <td align="left">Ganhos</td>
                <td align="right"><div class="label_legend despesas"></div></td>
                <td align="left">Despesas</td>
                <td align="right"><div class="label_legend balanco"></div></td>
                <td align="left">Balanço</td>
            </tr>
        </table>
    </div>
    <h2>Consulta de Finanças<img src="../layout/images/search.png" class="filter_icon"></h2>
    <div class="filter"><!--Início do filtro-->
    <h3>Filtrar Eventos</h3>
    <hr />
        <table>
            <tr>
                <td>Data: De</td>
                <td><input type="text" readonly class="datepicker" id="txtdatai" name="txtdatai" placeholder="DD/MM/AAAA" maxlength="10"></td>
                <td>Até</td>
                <td><input type="text" readonly class="datepicker" id="txtdataf" name="txtdataf" placeholder="DD/MM/AAAA" maxlength="10"></td>
            </tr>
            <tr>
                <td>Tipo de Despesa:</td>
                <td colspan="3">
                    <?php
                    $sql_sel_types = "SELECT id, name FROM expenses_types ORDER BY name";
                    $sql_sel_types_preparado = $conexaobd->prepare($sql_sel_types);
                    $sql_sel_types_preparado ->execute();
                    ?>
                    <select name="seltipo" style="width:100%;" id="seltipo">
                        <option value="">Escolha</option>
                        <?php

                        while($sql_sel_types_dados = $sql_sel_types_preparado->fetch()){
                            $valor_local = $sql_sel_types_dados['id'];
                            $nome_local = $sql_sel_types_dados['name'];

                            echo "<option value='".$valor_local."'>".$nome_local."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cliente:</td>
                <td colspan="3"><input type="text" id="txtcliente" name="txtcliente" placeholder="José Silveira" maxlength="45" style="width:95%;"> </td>
            </tr>
            <td colspan="4" style="align: right;"   ><button type="submit" name="btnpesquisar" onClick="filtrarFinanceiro()">Pesquisar</button></td>
        </table>
    </div><!--Fim do filtro-->
    <form name="frmimprimir" method="POST" onsubmit="catchContent()" action="../addons/php/cb_buildpdf_php.php" id="gerarpdf">
        <input type="hidden" name="dadospdf" id="dadospdf" value="">
        <button type="submit" name="btnimprimir"><img src="../layout/images/print.png" width="25px" title="Imprimir">
        </button>
    </form>
    <span class="imprimir">
    <div style="width: 49%; float: left; margin-top: 64px;" id="ganho-lista">
        <h3>Ganhos</h3>
        <table class="consult_table consulta_ganhos"><!--Início da tabela de consulta-->
            <thead><!--Início do cabeçalho da tabela-->
            <tr>
                <th width="10%">Data</th>
                <th width="20%">Cliente</th>
                <th width="20%">Ganho Atual</th>
            </tr>
            </thead><!--Fim do cabeçalho da tabela-->
            <tbody class="list"><!--Início do corpo da tabela-->

            </tbody><!--Fim do corpo da tabela-->
        </table><!--Fim da tabela de consulta-->
        <ul class="pagination"></ul>
    </div>
    <div id="despesa-lista" style="width: 49%; float: left; margin-top:25px;">
        <h3>Despesas</h3>
        <table class="consult_table consulta_despesas" ><!--Início da tabela de consulta-->
            <thead><!--Início do cabeçalho da tabela-->
            <tr>
                <th width="10%">Data</th>
                <th width="20%">Tipo</th>
                <th width="20%">Valor</th>
            </tr>
            </thead><!--Fim do cabeçalho da tabela-->
            <tbody class="list"><!--Início do corpo da tabela-->
            </tbody><!--Fim do corpo da tabela-->
        </table><!--Fim da tabela de consulta-->
        <ul class="pagination"></ul>
    </div>
    <div style="clear: both;">
        <h3 style="padding-top: 30px;">Balanço</h3>
        <table class="consult_table balanco" width="70%" style="float:left; margin-right: 30px; margin-bottom: 30px;">
            <thead>
                <th width="33.3%">Ganho Total</th>
                <th width="33.3%">Despesa Total</th>
                <th width="33.4%">Balanço</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <table class="consult_table ganho_aberto" width="18%" style="float:left;">
            <thead>
                <th>Ganho em Aberto</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    </span>
</div>

<script id="grafico"></script><script>
<script id="grafico"></script>
<script>

    $(document).ready(function(){
        filtrarFinanceiro();
    })
</script>

<script id="grafico"></script>
