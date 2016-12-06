<h1 id="title">Estatísticas</h1>
<div id="tabs">
    <ul>
        <li><a href="#tabs-regions">Gráfico de Regiões</a></li>
        <li><a href="#tabs-locals">Gráfico de Locais</a></li>
        <li><a href="#tabs-kits">Gráfico de Kits</a></li>
        <li><a href="#tabs-items">Gráfico de Itens</a></li>
        <li><a href="#tabs-reasons">Gráfico de Motivos de Cancelamento</a></li>
    </ul>
    <div id="tabs-regions"><!--Início da aba de Regiões-->
        <div class="statistics_filter">
					<form name="frmfiltrodata" method="POST" action="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-regions"><!--Início do formulário de filtro de Data-->
						<?php
							//Este bloco é responsável por fazer o select de todos os dados da tabela cities (cidades).
							$sql_sel_cities = "SELECT * FROM cities";
							$sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
							$sql_sel_cities_preparado->execute();
						?>
							<table>
								<tr>
									<td><h3>Data:</h3></td>
									<td><input name="txtdatade" class="datepicker" placeholder="De" readonly></td>
									<td><input name="txtdataate" class="datepicker" placeholder="Até" readonly></td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<select name="selcidade">
											<option value="0">Cidade</option>
											<?php
											//Este bloco é responsável por exibir os dados contidos na tabela cities em options que aparecerão para o usuário.
											while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
													$valor_cidade = $sql_sel_cities_dados['id'];
													$nome_cidade = $sql_sel_cities_dados['name'];

													if(strtoupper($nome_cidade)=="JOINVILLE"){
															echo "<option value='".$valor_cidade."' selected>".$nome_cidade."</option>";
													}else{
															echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
													}
											}
											?>
										</select>
									</td>
									<td><button type="submit" name="pesquisar">Pesquisar</button></td>
								</tr>
						</table>
					</form><!--Fim do formulário de filtro de Cidade-->
				</div>

        <canvas id="chart_region" width="200px" height="50px"></canvas>
    </div><!--Fim da aba de Regiões-->
    <div id="tabs-locals"><!--Início da aba de Locais-->
			<div class="statistics_filter">
				<form name="frmfiltrodata" method="POST" action="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-locals"><!--Início do formulário de filtro de Data-->
					<?php
					//Este bloco é responsável por fazer o select de todos os dados da tabela cities (cidades).
					$sql_sel_cities = "SELECT * FROM cities";
					$sql_sel_cities_preparado = $conexaobd->prepare($sql_sel_cities);
					$sql_sel_cities_preparado->execute();
					?>
					<table>
						<tr>
							<td><h3>Data:</h3></td>
							<td><input name="txtdatade" class="datepicker" placeholder="De" readonly></td>
							<td><input name="txtdataate" class="datepicker" placeholder="Até" readonly></td>
						</tr>
						<tr>
							<td colspan="2" align="left">
								<select name="selcidade">
									<option value="0">Cidade</option>
									<?php
									//Este bloco é responsável por exibir os dados contidos na tabela cities em options que aparecerão para o usuário.
									while($sql_sel_cities_dados = $sql_sel_cities_preparado->fetch()){
										$valor_cidade = $sql_sel_cities_dados['id'];
										$nome_cidade = $sql_sel_cities_dados['name'];

										if(strtoupper($nome_cidade)=="JOINVILLE"){
											echo "<option value='".$valor_cidade."' selected>".$nome_cidade."</option>";
										}else{
											echo "<option value='".$valor_cidade."'>".$nome_cidade."</option>";
										}
									}
									?>
								</select>
							</td>
							<td><button type="submit" name="pesquisar">Pesquisar</button></td>
						</tr>
					</table>
				</form><!--Fim do formulário de filtro de Cidade-->
			</div>
        <canvas id="chart_locals" width="200px" height="50px"></canvas>
    </div><!--Fim da aba de Locais-->
    <div id="tabs-kits"><!--Início da aba de Kits-->
			<div class="statistics_filter">
				<form name="frmfiltrodata" method="POST" action="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-kits"><!--Início do formulário de filtro de Data-->
					<table>
						<tr>
							<td><h3>Data:</h3></td>
							<td><input name="txtdatade" class="datepicker" placeholder="De" readonly></td>
							<td><input name="txtdataate" class="datepicker" placeholder="Até" readonly></td>
							<td><button type="submit" name="pesquisar">Pesquisar</button></td>
						</tr>
					</table>
				</form><!--Fim do formulário de filtro de Cidade-->
			</div>
        <canvas id="chart_kits" width="200px" height="50px"></canvas>
    </div><!--Fim da aba de Kits-->
    <div id="tabs-items"><!--Início da aba de Itens-->
			<div class="statistics_filter">
				<form name="frmfiltrodata" method="POST" action="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-items"><!--Início do formulário de filtro de Data-->
					<table>
						<tr>
							<td><h3>Data:</h3></td>
							<td><input name="txtdatade" class="datepicker" placeholder="De" readonly></td>
							<td><input name="txtdataate" class="datepicker" placeholder="Até" readonly></td>
							<td><button type="submit" name="pesquisar">Pesquisar</button></td>
						</tr>
					</table>
				</form><!--Fim do formulário de filtro de Cidade-->
			</div>
        <canvas id="chart_items" width="200px" height="50px"></canvas>
    </div><!--Fim da aba de Itens-->
    <div id="tabs-reasons"><!--Início da aba de Itens-->
			<div class="statistics_filter">
				<form name="frmfiltrodata" method="POST" action="?folder=reports/&file=cb_statistics_reports&ext=php#tabs-reasons"><!--Início do formulário de filtro de Data-->
					<table>
						<tr>
							<td><h3>Data:</h3></td>
							<td><input name="txtdatade" class="datepicker" placeholder="De" readonly></td>
							<td><input name="txtdataate" class="datepicker" placeholder="Até" readonly></td>
							<td><button type="submit" name="pesquisar">Pesquisar</button></td>
						</tr>
					</table>
				</form><!--Fim do formulário de filtro de Cidade-->
			</div>
        <canvas id="chart_reasons" width="200px" height="50px"></canvas>
    </div><!--Fim da aba de Itens-->
</div>
<?php
    include "../addons/php/cb_statisticscharts_php.php";
    //Inclusão da página dos gráficos!
?>