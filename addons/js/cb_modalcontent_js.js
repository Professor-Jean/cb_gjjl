/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
					 João Santucci;
					 João Spieker;
					 Lucas Janning;
 *Data de Criação: 23/10/2016
 *Data de Modificação: 23/10/2016
 *Descrição: Esta página é responsável por fazer com que os dados do cliente selecionado na lista de clientes seja mostrado na janela modal.

 ***********************************************************************************************************************************************/

$(document).ready(function(){
	$('a[name=modal]').click(function(e){
		e.preventDefault();
        //var id = $('a[name=modal]').serialize();
		var id = $(this).attr('href');
		$.ajax({
			type: "POST",
			url: "clients/cb_detailedconsults_clients.php",
			data: {id: id}
		})
		.done(function(dados) {
			var cliente = JSON.parse(dados);
			$('#nome').html(cliente.name);
			$('#email').html(cliente.email);
			$('#telefone').html(cliente.phone);
			$('#data_nasc').html(cliente.birthdate);
			$('#rg').html(cliente.rg);
			$('#cpf').html(cliente.cpf);
			$('#cep').html(cliente.cep);
			$('#cidade').html(cliente.citiesname);
			$('#bairro').html(cliente.districtsname);
			$('#logradouro').html(cliente.street);
			$('#numero').html(cliente.number);
			$('#complemento').html(cliente.complement);
		});
	});
});

//Janela modal da consulta detalhada de eventos
$(document).ready(function(){
	$('a[name=modal_eventos]').click(function(e){
		e.preventDefault();
		//var id = $('a[name=modal]').serialize();
		var id = $(this).attr('href');
		$.ajax({
			type: "POST",
			url: "events/cb_detailedconsults_events.php",
			data: {id: id}
		})
			.done(function(dados) {
				var resultado = JSON.parse(dados);
				$(".modal_tbody").html(
						"<tr>" +
						"<td>Cliente:</td>" +
						"<td class='line'>" + resultado.nome + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>E-mail:</td>" +
						"<td class='line'>" + resultado.email + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Telefone:</td>" +
						"<td class='line'>" + resultado.fone + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Local:</td>" +
						"<td class='line'>" + resultado.local + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>CEP:</td>" +
						"<td class='line'>" + resultado.cep + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Cidade:</td>" +
						"<td class='line'>" + resultado.cidade + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Bairro:</td>" +
						"<td class='line'>" + resultado.bairro + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Logradouro:</td>" +
						"<td class='line'>" + resultado.logradouro + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Número:</td>" +
						"<td class='line'>" + resultado.num + "</td>" +
						"</tr>"
						+ "<tr style='border-bottom: 2px solid #000;'>" +
						"<td>Complemento:</td>" +
						"<td class='line'>" + resultado.complemento + "</td>" +
						"</tr>"
						+ "<tr style='border-bottom: 2px solid #000;'>" +
                            "<td>Kits(qtde):</td>" +
                                "<td class='line'>" +
                                    "<table style='border-bottom: 0px; box-shadow: none;'>" +
                                        resultado.kit +
                                    "</table>" +
                                "</td>" +
						"</tr>"
						+ "<tr style='border-bottom: 2px solid #000;'>" +
						"<td>Itens(qtde):</td>" +
                            "<td class='line'>" +
                                "<table style='border-bottom: 0px; box-shadow: none;'>" +
                                    resultado.item +
                                "</table>" +
                            "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Data do Evento:</td>" +
						"<td class='line'>" + resultado.data + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Horário do Evento</td>" +
						"<td class='line'>" + resultado.horario + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Taxa de Entrega(Já incluso):</td>" +
						"<td class='line'>" + resultado.taxa_entrada + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Valor Real:</td>" +
						"<td class='line'>" + resultado.valor_real + "</td>" +
						"</tr>"
						+ "<tr>" +
						"<td>Valor Final:</td>" +
						"<td class='line'>" + resultado.valor_final + "</td>" +
						"</tr>"
                        +"<tr>" +
                        "<td>Observação:</td>" +
                        "<td class='line'><textarea style='margin:0px; padding:0px; width:245px; max-width:245px; height:100%; max-height:235px;' readonly>" + resultado.observacao + "</textarea></td>" +
                        "</tr>"
				);

			});
	});
});

//Janela modal da consulta detalhada de eventos orçados
$(document).ready(function(){
    $('a[name=modal_orcados]').click(function(e){
        e.preventDefault();
        //var id = $('a[name=modal]').serialize();
        var id = $(this).attr('href');
        $.ajax({
            type: "POST",
            url: "events/cb_detailedconsults_budget_events.php",
            data: {id: id}
        })
            .done(function(dados) {
                var resultado = JSON.parse(dados);
                $(".modal_tbody").html(
                    "<tr>" +
                    "<td>Cliente:</td>" +
                    "<td class='line'>" + resultado.nome + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>E-mail:</td>" +
                    "<td class='line'>" + resultado.email + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Telefone:</td>" +
                    "<td class='line'>" + resultado.fone + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Local:</td>" +
                    "<td class='line'>" + resultado.local + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>CEP:</td>" +
                    "<td class='line'>" + resultado.cep + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Cidade:</td>" +
                    "<td class='line'>" + resultado.cidade + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Bairro:</td>" +
                    "<td class='line'>" + resultado.bairro + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Logradouro:</td>" +
                    "<td class='line'>" + resultado.logradouro + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Número:</td>" +
                    "<td class='line'>" + resultado.num + "</td>" +
                    "</tr>"
                    + "<tr style='border-bottom: 2px solid #000;'>" +
                    "<td>Complemento:</td>" +
                    "<td class='line'>" + resultado.complemento + "</td>" +
                    "</tr>"
                    + "<tr style='border-bottom: 2px solid #000;'>" +
                    "<td>Kits(qtde):</td>" +
                    "<td class='line'>" +
                    "<table style='border-bottom: 0px; box-shadow: none;'>" +
                    resultado.kit +
                    "</table>" +
                    "</td>" +
                    "</tr>"
                    + "<tr style='border-bottom: 2px solid #000;'>" +
                    "<td>Itens(qtde):</td>" +
                    "<td class='line'>" +
                    "<table style='border-bottom: 0px; box-shadow: none;'>" +
                    resultado.item +
                    "</table>" +
                    "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Data do Evento:</td>" +
                    "<td class='line'>" + resultado.data + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Horário do Evento:</td>" +
                    "<td class='line'>" + resultado.horario + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Valor Real:</td>" +
                    "<td class='line'>" + resultado.valor_real + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Valor Final:</td>" +
                    "<td class='line'>" + resultado.valor_final + "</td>" +
                    "</tr>"
                    +"<tr>" +
                    "<td>Observação:</td>" +
                    "<td class='line'><textarea style='margin:0px; padding:0px; width:245px; max-width:245px; height:100%; max-height:235px;' readonly>" + resultado.observacao + "</textarea></td>" +
                    "</tr>"
                );

            });
    });
});

//Janela modal da consulta detalhada de eventos cancelados
$(document).ready(function(){
	$('a[name=modal_cancelados]').click(function(e){
		e.preventDefault();
		//var id = $('a[name=modal]').serialize();
		var id = $(this).attr('href');
		$.ajax({
			type: "POST",
			url: "events/cb_detailedconsults_canceled_events.php",
			data: {id: id}
		})
			.done(function(dados) {
				var resultado = JSON.parse(dados);
				$(".modal_tbody").html(
                    "<tr>" +
                    "<td>Cliente:</td>" +
                    "<td class='line'>" + resultado.nome + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>E-mail:</td>" +
                    "<td class='line'>" + resultado.email + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Telefone:</td>" +
                    "<td class='line'>" + resultado.fone + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Local:</td>" +
                    "<td class='line'>" + resultado.local + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Data do Evento:</td>" +
                    "<td class='line'>" + resultado.data + "</td>" +
                    "</tr>"
                    +"<tr>" +
                    "<td>Ressarcimento:</td>" +
                    "<td class='line'>" + resultado.ressarcimento + "</td>" +
                    "</tr>"
                    + "<tr>" +
                    "<td>Multa:</td>" +
                    "<td class='line'>" + resultado.multa + "</td>" +
                    "</tr>"
                    +"<tr>" +
                    "<td>Motivo:</td>" +
                    "<td class='line'>" + resultado.razao + "</td>" +
                    "</tr>"
                    +"<tr>" +
                    "<td>Comentário:</td>" +
                    "<td class='line'><textarea style='margin:0px; padding:0px; width:245px; max-width:245px; height:100%; max-height:235px;' readonly>" + resultado.comentario + "</textarea></td>" +
                    "</tr>"
				);
			});
	});
});
