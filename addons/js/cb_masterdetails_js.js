$(function () {

    function removeCampo() {
        $(".removerCampo").unbind("click");
        $(".removerCampo").bind("click", function () {
            if($("tr.linhas").length > 1){
                $(this).parent().parent().remove();
            }else{
                alert("A última linha não pode ser removida.");
            }
        });
    }

    function removeCampo1() {
        $(".removerCampo1").unbind("click");
        $(".removerCampo1").bind("click", function () {
            if($("tr.linhas1").length > 1){
                $(this).parent().parent().remove();
            }else{
                alert("A última linha não pode ser removida.");
            }
        });
    }

    $(".adicionarCampo").click(function () {
        novoCampo = $("tr.linhas:first").clone();
        novoCampo.find("input").val("");
        novoCampo.find("select").val("");
        novoCampo.find("select").append("<option value='' selected>Escolha...</option>");
        novoCampo.insertAfter("tr.linhas:last");
        removeCampo();
    });

    $(".adicionarCampo1").click(function () {
        novoCampo = $("tr.linhas1:first").clone();
        novoCampo.find("input").val("");
        novoCampo.find("select").val("");
        novoCampo.find("select").append("<option value='' selected>Escolha...</option>");
        novoCampo.insertAfter("tr.linhas1:last");
        removeCampo1();
    });
});
