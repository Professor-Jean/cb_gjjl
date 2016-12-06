/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 21/09/2016
 *Data de Modificação: 02/10/2016
 *Descrição: Esta página contém algumas funções basicas do software em javaScript.
 
 * Lista de funções.
    #Filtro.
 		#Abas.
 		#Datepicker
 		#Accordion
 		#Sortable
 		#Slider dso nomes dos usuário na página de rota de entrega
    #Filtro básico de pesquisa.
 *
 ***********************************************************************************************************************************************/

$(document).ready(function() {

	//Esta estrutura é responsável por fazer o hide/show do filtro.
	$(".filter_icon").click(function () {
		$(".filter").slideToggle();
	});

	$(".filter_icon2").click(function () {
		$(".filter2").slideToggle();
	});

	//Esta estrutura é responsável pelas abas na página de estatísticas.
	$('#tabs').tabs();

	//Esta estrutura é responsável por fazer o datepicker, que é um plugin que ajuda na seleção da data, nos campos de data.
	$(".datepicker").datepicker({
		changeMonth: true,
		changeYear: true
	});

	//Função das tabelas da consulta de eventos
	$(function () {
		$("#accordion").accordion();
	});

	$("#sortable").sortable().disableSelection();

	//Estrutura responsável por realizar o slider dos usuários na página de rota de entrega.(Com o Plugin Slicks)
	$('.center').slick({
		centerMode: true,
		centerPadding: '60px',
		responsive: [
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 3
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 1
				}
			}
		]
	});

	//Esta estrutura é responsável por receber o tamanho da div de consulta, e calcular onde deve ficar o filtro básico de pesquisa.
	var tamanhotabelaw = $(".consult_table").width();
	$('.search').css({'width': tamanhotabelaw});

	$('button[name=btnpesquisar_events_reports]').click(function () {
		var datai = document.getElementById('datai').value;
		var dataf = document.getElementById('dataf').value;
		$.ajax({
			type: "POST",
			url: "events/cb_datevalidation_events.php",
			data: {datai: datai, dataf: dataf}
		})
			.done(function (dados) {
				var resultado = JSON.parse(dados);
				if (resultado.resultado > 2) {
					alert('Você pode Filtrar de apenas de 2 em 2 anos');
				}
			});
	});

	$('button[name=btncalcular]').click(function () {
		var itens = [];
		var quantidade = [];
		var i = 0;
		$('.itens').each(function () {
			var valor = $(this).val();

			itens[i] = valor;
			i++;
		});
		var i = 0;
		$('.quantidade').each(function () {
			var valor = $(this).val();

			quantidade[i] = valor;
			i++;
		});
		$.ajax({
			type: "POST",
			url: "kits/cb_realvaluecalc_kits.php",
			data: {item_s: itens, quantidade_s: quantidade}
		})
			.done(function (dados) {
				var valorreal = JSON.parse(dados);
				$('.valor_real').val(valorreal.resultado);
			});
	});

	var flag_calc_vr = false;
	var valorRealAtual = 0;
	$('button[name=btncalculare]').click(function () {
		var kits = [];
		var itens = [];
		var quantidadekits = [];
		var quantidadeitens = [];
		var i = 0;
		$('.kits').each(function () {
			var valor = $(this).val();

			kits[i] = valor;
			i++;
		});
		var i = 0;
		$('.quantidadekits').each(function () {
			var valor = $(this).val();

			quantidadekits[i] = valor;
			i++;
		});
		var i = 0;
		$('.itens').each(function () {
			var valor = $(this).val();

			itens[i] = valor;
			i++;
		});
		var i = 0;
		$('.quantidadeitens').each(function () {
			var valorq = $(this).val();

			quantidadeitens[i] = valorq;
			i++;
		});
		$.ajax({
			type: "POST",
			url: "events/cb_realvaluecalc_events.php",
			data: {kit_s: kits, quantidadekit_s: quantidadekits, item_s: itens, quantidadeitem_s: quantidadeitens}
		})
			.done(function (dados) {
				var valorreal = JSON.parse(dados);
				var valor_real = 0;
				var valor_final = 0;
				var taxa_entrega = $('.taxa_entrega').val().replace(',', '.');
				var desconto = $('.descontoe').val().replace(',', '.');
				if(desconto==""){
					desconto = 0;
				}
				if(taxa_entrega==""){
					taxa_entrega = 0;
				}
				var valor_local = $('input[name=hidlocal]').val();
				if(valor_local==""){
					valor_local = 0;
				}

				valor_real = parseFloat(valorreal.resultado.replace('.', '').replace(',', '.')) + parseFloat(taxa_entrega) + parseFloat(valor_local);

				valor_final = valor_real - parseFloat(desconto);
				$('.valor_real').val(valor_real.toFixed(2).replace('.',','));
				$('.valor_final').val(valor_final.toFixed(2).replace('.',','));
			});
	});

	var flag_calc_te = false;
	var taxaEntregaAtual = 0;
	var taxaentrega = $('.taxa_entrega').val();
	$('.taxa_entrega').blur(function () {
		var valor_reall = parseFloat($('.valor_real').val().replace('.', '').replace(',', '.'));
		if($('.valor_real').val()==""){
			valor_reall = 0;
		}
		var taxa_entrega = parseFloat($(this).val().replace('.', '').replace(',', '.'));
		if($(this).val()==""){
			$('.taxa_entrega').focus();
		}else {
			if(taxaentrega!=""){
				taxaEntregaAtual = parseFloat(taxaentrega);
			}
			if (taxa_entrega == parseFloat(taxaEntregaAtual)) {
				flag_calc_te = true;
			} else {
				if (taxa_entrega < 0) {
					alert('O valor da taxa de entrega não pode ser menor que zero!');
					$('.taxa_entrega').val('');
				} else {
					var valor_real = (valor_reall + taxa_entrega) - taxaEntregaAtual;
					$('.valor_real').val(valor_real.toFixed(2).replace('.', ','));
					taxaEntregaAtual = taxa_entrega;
					taxaentrega = taxa_entrega;
				}
			}
		}
		var taxa_entrega = $('.taxa_entrega').val();
		var taxaEntregaSplit =  taxa_entrega.split(',');
		if(taxaEntregaSplit.length==1){
			$('.taxa_entrega').val(taxa_entrega+','+'00');
		}else{
			if(taxaEntregaSplit[1].length==1){
				$('.taxa_entrega').val(taxa_entrega+'0');
			}
		}
	});

	$('.descontoe').blur(function () {
		var valor_reall = $('.valor_real').val().replace(',', '.');
		var desconto = $(this).val().replace('.', '').replace(',', '.');
		if($(this).val()==""){
			$('.descontoe').focus();
		}else {
			if (desconto < 0) {
				alert('O valor do desconto não pode ser menor que zero!');
				$('.descontoe').val('');
			} else if (desconto <= valor_reall) {
				var valor_real = valor_reall - desconto;
				$('.valor_final').val(valor_real.toFixed(2).replace('.', ','));
			} else {
				alert('O valor do desconto não pode ser maior que o valor real!');
				$('.descontoe').val('');
			}
		}
		var desconto = $('.descontoe').val();
		if(desconto==""){
			desconto = '0';
		}
		var descontoSplit = desconto.split(',');
		if (descontoSplit.length == 1) {
			$('.descontoe').val(desconto + ',' + '00');
		} else {
			if (descontoSplit[1].length == 1) {
				$('.descontoe').val(desconto + '0');
			}
		}
	});

	//Esta estrutura é responsável por calcular instantaneamente o valor do campo "Valor Final" no formulário de kits ao campo "Valor Real" receber um desconto.
	$('.desconto').blur(function () {
		var valor_real = $('.valor_real').val();
		var desconto = $('.desconto').val();
		$.ajax({
			type: "POST",
			url: "kits/cb_finalvaluecalc_kits.php",
			dataType: 'json',
			data: {valor_real_s: valor_real, desconto_s: desconto}
		})
			.done(function (dados) {
				$('.valor_final').val(dados.resultado);
			});
	});

	$('select[name=selcliente]').change(function () {
		if ($('select[name=sellocal]').val() == "cliente") {
			$('select[name=sellocal]').val("");
			$('input[name=txtcep]').val("");
			$('select[name=selcidade]').val("");
			$('select[name=selbairro]').val("");
			$('input[name=txtlogradouro]').val("");
			$('input[name=txtnumero]').val("");
			$('input[name=txtcomplemento]').val("");
		}
	});

	//$('.inativo').attr('readonly', true);
	$('.localvazio').val("");
	$('.inativo').val("");
	$('.inativo').attr('readonly', true);
	$('.inativou').attr('readonly', true);
	$('.sinativo').attr('disabled', true);
	$('#local').change(function () {
		var local = $(this).val();
		var cliente = $('select[name=selcliente]').val();
		var evento = $('input[name=hidid]').val();
		if ((local != "cliente") && (local != "outro")) {
			$('.inativo').attr('readonly', true);
			$('.sinativo').attr('disabled', false);
			$('select[name=sellocal] option[value=""]').remove();
			$.ajax({
				type: "POST",
				url: "events/cb_findlocal_events.php",
				data: {local: local, evento: evento}
			})
				.done(function (dados) {
					var local = JSON.parse(dados);
					$('input[name=txtcep]').val(local.cep);
					$('input[name=txtcep]').attr('readonly', true);
					$('select[name=selcidade]').val(local.citiesid);
					$('select[name=selbairro] option').remove();
					$('select[name=selbairro]').append('<option value="' + local.districtsid + '" selected>' + local.districtsname + '</option>');
					$('input[name=txtlogradouro]').val(local.street);
					$('input[name=txtlogradouro]').attr('readonly', true);
					$('input[name=txtnumero]').val(local.number);
					$('input[name=txtnumero]').attr('readonly', true);
					$('input[name=txtcomplemento]').val(local.complement);
					$('input[name=txtcomplemento]').attr('readonly', true);
					var valor_reall = $('.valor_real').val();
					if(valor_reall==""){
						valor_reall = 0;
					}
					
					$('.valor_real').val((parseFloat(local.rent_value) + parseFloat(valor_reall)).toFixed(2).replace('.',','));
					$('input[name=hidlocal]').val(local.rent_value);
				});
		} else if (local == "cliente") {
			$('.inativo').attr('readonly', true);
			$('.sinativo').attr('disabled', false);
			if($('.valor_real').val()!=""){
				alert('Gere o Valor Real novamente!');
				$('.valor_real').val(0);
			}
			if (cliente != "") {
				$.ajax({
					type: "POST",
					url: "events/cb_findlocal_events.php",
					data: {idcliente: cliente, local: local}
				})
					.done(function (dados) {
						var lcliente = JSON.parse(dados);
						$('input[name=txtcep]').val(lcliente.cep);
						$('input[name=txtcep]').attr('readonly', true);
						$('select[name=selcidade]').val(lcliente.citiesid);
						$('select[name=selbairro] option').remove();
						$('select[name=selbairro]').append('<option value="' + lcliente.districtsid + '" selected>' + lcliente.districtsname + '</option>');
						$('input[name=txtlogradouro]').val(lcliente.street);
						$('input[name=txtlogradouro]').attr('readonly', true);
						$('input[name=txtnumero]').val(lcliente.number);
						$('input[name=txtnumero]').attr('readonly', true);
						$('input[name=txtcomplemento]').val(lcliente.complement);
						$('input[name=txtcomplemento]').attr('readonly', true);
					});
			} else {
				$('select[name=selbairro] option').remove();
				$('select[name=selbairro]').append('<option value="" selected>Selecione um cliente...</option>');
			}
			$('input[name=hidlocal]').val(0);
		} else {
			$('.sinativo').attr('disabled', false);
			$('.inativo').attr('readonly', false);
			$('select[name=selbairro] option').remove();
			$('select[name=selbairro]').append('<option value="">Selecione uma cidade...</option>');
			$('input[name=txtcep]').val("");
			$('select[name=selcidade]').val("");
			$('select[name=selbairro]').val("");
			$('input[name=txtlogradouro]').val("");
			$('input[name=txtnumero]').val("");
			$('input[name=txtcomplemento]').val("");
			if($('.valor_real').val()!=""){
				alert('Gere o Valor Real novamente!');
				$('.valor_real').val(0);
			}
			$('input[name=hidlocal]').val(0);
		}
	});

	$("#nomecliente").select2({
		placeholder: "Escolha um Cliente",
		allowClear: true,
		maximumInputLength: 45
	});

	if($('input[name=txtdata_evento]').val()==""){
		$('.register').hide();
		$('.cupdate').hide();
		$('#cregister').show();
	}else{
		$('.register').show();
		$('.cupdate').hide(function(){$('#calendar').show()});
		$('.cregister').hide(function(){$('#calendar').show()});
	}
	$('#calendar').fullCalendar({
		header: {
			left: 'prev, today',
			center: 'title',
			right: 'today, next'
		},

		events: "../addons/php/cb_feedcalendar_php.php",

		dayClick: function (date) {
			var dataAtual = new Date();
			var data = date.format();
			var dataSplit = data.split("-");
			var dataSel = new Date(dataSplit);
			if (dataSel >= dataAtual) {
				var datab = dataSplit[2] + "/" + dataSplit[1] + "/" + dataSplit[0];
				$('#data').val(datab);
				$('#calendar').hide();
				$('.register').show();
				$('.update').show();
				$.ajax({
					type: "POST",
					url: "events/cb_kitquantity_events.php",
					data: {data: datab}
				})
					.done(function (dados) {
						var dadosSplit = dados.split(",");
						var dadosParse = JSON.parse(dados);
						var i;
						for (i = 0; i < dadosSplit.length; i++) {
							$('.kits option[value="' + dadosParse[i] + '"]').attr('disabled', true);
						}
					});
				$.ajax({
					type: "POST",
					url: "events/cb_itemquantity_events.php",
					data: {data: datab}
				})
					.done(function (dados) {
						var dadosSplit = dados.split(",");
						var dadosParse = JSON.parse(dados);
						var i;
						for (i = 1; i <= dadosSplit.length; i++) {
							$('.itens option[value="' + dadosParse[i] + '"]').attr('disabled', true);
						}
					});
			} else {
				alert("A data que você selecionou já passou");
			}
		}
	});

	$('#calendario').click(function(){
		$('.cupdate').show();
		$('.cregister').show();
		$('.register').hide();
		$('.update').hide();
		$('#calendar').show();
		$('.kits option').attr('disabled', false);
		$('.itens option').attr('disabled', false);
	});
});

function voltar() {
	window.history.back();
}

function achaprecoek(valor) {
	var kit = valor;
	var data = $('#data').val();
	var datas = data.split("/");
	var datab = datas[2] + "-" + datas[1] + "-" + datas[0];
	$.ajax({
		type: "POST",
		url: "events/cb_kitavaiable_events.php",
		dataType: 'json',
		data: {kit: kit, datab: datab}
	})
	.done(function (dados) {
		alert('O Kit ' + dados.nome + ' tem ' + dados.quantidade + ' unidades disponíveis.');
	});
}

function achapreco(valor) {
	var item = valor;
	$.ajax({
		type: "POST",
		url: "kits/cb_itemquantity_kits.php",
		dataType: 'json',
		data: {item: item}
	})
		.done(function (dados) {
			alert('O Item ' + dados.nome + ' tem ' + dados.quantidade + ' unidades disponíveis.');
		});
}

function achaprecoei(valor) {
	var item = valor;
	if(item!="") {
		var data = $('#data').val();
		var datas = data.split("/");
		var datab = datas[2] + "-" + datas[1] + "-" + datas[0];
		$.ajax({
			type: "POST",
			url: "events/cb_itemavaiable_events.php",
			dataType: 'json',
			data: {item: item, datab: datab}
		})
			.done(function (dados) {
				alert('O Item ' + dados.nome + ' tem ' + dados.quantidade + ' unidades disponíveis.');
			});
	}
}
