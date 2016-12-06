//datepicker no padrão pt-BR
$.datepicker.regional['pt-BR'] = {
    closeText         : 'Fechar',
    prevText          : '&#x3c; Anterior',
    nextText          : 'Pr&oacute;ximo &#x3e',
    currentText       : 'Hoje',
    monthNames        : ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthNamesShort   : ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    dayNames          : ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
    dayNamesShort     : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    dayNamesMin       : ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    weekHeader        : 'Sn',
    dateFormat        : 'dd/mm/yy',
    firstDay          : 0,
    isRTL             : false,
    showMonthAfterYear: false,
    yearSuffix        : ''
};
$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
