<?php
    $p_id = $_POST['txtid'];
    $p_entrada = $_POST['txtentrada'];
    $msg_titulo = "Erro";
    $voltar = "?folder=events_control/control/&file=cb_fmconfirm_control&ext=php&id=".$p_id;
    $exp_entrada = explode(",", $p_entrada);
    if(!isset($exp_entrada[1])){
        $exp_entrada[1]="00";
    }
    $entrada = $exp_entrada['0'].".".$exp_entrada['1'];
    if($p_id==""){
        $mensagem = mensagens('Erro bd','evento', 'confirmar');
    }else if($p_entrada==""){
            $mensagem = mensagens('Validação', 'entrada');
        }else if(!valida_decimal($p_entrada, 1, 6)){
                $mensagem = mensagens('Validação Decimal', 'entrada');
            }else{
                $tabela="events";
                $dados=array(
                   'status'=>1,
                    'entry_fee'=>$entrada
                );
                $condicao = "id='".$p_id."'";
                $sql_upd_events_resultado = alterar($tabela, $dados, $condicao);
                if($sql_upd_events_resultado){
                    $msg_titulo = "Confirmação";
                    $mensagem = mensagens('Sucesso', 'Evento', 'Confirmação');
                    $voltar = "?folder=events_control/control/&file=cb_events_control&ext=php";
                }else{
                    $mensagem = mensagens('Erro bd', 'evento', 'confirmar');
                }
            }
?>
<h1>Aviso</h1>
<div class="message">
    <h3><img src="../layout/images/alert.png"><?php echo $msg_titulo; ?></h3>
    <hr />
    <p><?php echo $mensagem; ?></p>
    <a href="<?php echo $voltar; ?>"><img src="../layout/images/back.png">Voltar</a>
</div>

