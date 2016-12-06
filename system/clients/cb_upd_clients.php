<?php
    $p_id = $_POST['hidid'];
    $p_nome = $_POST['txtnome'];
    $p_email = $_POST['txtemail'];
    $p_telefone = $_POST['txttelefone'];
    $p_data_nasc = $_POST['txtdata_nasc'];
    $p_rg = $_POST['txtrg'];
    $p_cpf = $_POST['txtcpf'];
    $p_cep = $_POST['txtcep'];
    $p_cidade = $_POST['selcidade'];
    $p_bairro = $_POST['selbairro'];
    $p_logradouro = $_POST['txtlogradouro'];
    $p_numero = $_POST['txtnumero'];
    $p_complemento = $_POST['txtcomplemento'];
    //Estas linhas são responsáveis por receber o nome, email, telefone, data de nascimento, rg, cpf, cep, cidade, bairro, logradouro, numero, complemento da fmupd via POST.

    $msg_titulo = "Erro";
    //Esta linha é responsável por definir a variável msg_titulo, com o valor ERRO.

    $data = explode('/', $p_data_nasc);
    //Esta linha é responsável por explodir a variável p_data_nasc nas barras, que vem da fmupd.

    $voltar = "?folder=clients/&file=cb_fmupd_clients&ext=php&id=".$p_id;
    //Esta linha é responsável por definir a variável voltar, com o valor de voltar para a página fmupd.

    if($p_nome==""){
        //Se a variável p_nome for vazia, chama a função mensagens.
        $mensagem = mensagens('Validação', 'nome');
    }else if(!valida_nome($p_nome, 45)){
            //Se a variável p_nome, possuir números, chama a função mensagens.
            $mensagem = mensagens('Validação Nome', 'nome');
        }else if($p_email==""){
                //Se a variável p_email for vazia, chama a função mensagens.
                $mensagem = mensagens('Validação', 'e-mail');
            }else if(!valida_email($p_email)){
                    //Se a variável p_email, não for válida, chama a função mensagens.
                    $mensagem = mensagens('Validação Email');
                }else if($p_telefone==""){
                        //Se a variável p_telefone for vazia, chama a função mensagens.
                        $mensagem = mensagens('Validação', 'telefone');
                    }else if(!valida_telefone($p_telefone)){
                            //Se a variável p_telefone, possuir letras, ou não caracteres especiais que não sejam () e -, chama a função mensagens.
                            $mensagem = mensagens('Validação Fone');
                        }else if(((!isset($data[2])) || (isset($data[3]))) || (!valida_data($data[2], $data[1], $data[0]))){
        //Se a variável data[2] não existir ou a variável data[3] existir ou se as variáveis data[2], data[1] e data[0] não cumprirem o padrão, chama a função mensagens.
                                $mensagem = mensagens('Validação Data');
                            }else if($p_data_nasc==""){
                                    //Se a variável p_data_nasc for vazia, chama a função mensagens.
                                    $mensagem = mensagens('Validação', 'data de nasc.');
                                }else if($p_rg==""){
                                        //Se a variável p_rg for vazia, chama a função mensagens.
                                        $mensagem = mensagens('Validação', 'rg');
                                    }else if(!valida_alfanumerico($p_rg, 1, 10)){
                                            //Se a variável $p_rg possuir caracteres especiais ou passar de 10 caracteres, chama a função mensagens.
                                            $mensagem = mensagens('Validação Alfanumericos', 'rg');
                                        }else if($p_cpf==""){
                                                //Se a variável p_cpf for vazia, chama a função mensagens.
                                                $mensagem = mensagens('Validação', 'cpf');
                                            }else if(!valida_numerico($p_cpf, 1, 11)){
                                                    //Se a variável $p_cpf possuir letras, caracteres especiais ou passar de 11 caracteres, chama a função mensagens.
                                                    $mensagem = mensagens('Validação Numerico', 'cpf');
                                                }else if($p_cep==""){
                                                        //Se a variável p_cep for vazia, chama a função mensagens.
                                                        $mensagem = mensagens('Validação', 'cep');
                                                    }else if(!valida_numerico($p_cep, 1, 8)){
                                                            //Se a variável p_cep possuir letras, caracteres especiais ou passar de 8 caracteres, chama a função mensagens.
                                                            $mensagem = mensagens('Validação Numerico', 'cep');
                                                        }else if($p_cidade==""){
                                                                //Se a variável p_cidade for vazia, chama a função mensagens.
                                                                $mensagem = mensagens('Validação', 'cidade');
                                                            }else if($p_bairro==""){
                                                                    //Se a variável p_bairro for vazia, chama a função mensagens.
                                                                    $mensagem = mensagens('Validação', 'bairro');
                                                                }else if($p_logradouro==""){
                                                                        //Se a variável p_logradouro for vazia, chama a função mensagens.
                                                                        $mensagem = mensagens('Validação', 'logradouro');
                                                                    }else if(!valida_alfanumerico($p_logradouro, 1, 40)){
                                                                            //Se a variável p_logradouro possuir caracteres especiais ou passar de 40 caracteres, chama a função mensagens.
                                                                            $mensagem = mensagens('Validaçãp Alfanumericos', 'logradouro');
                                                                        }else if($p_numero==""){
                                                                                //Se a variável p_numero for vazia, chama a função mensagens.
                                                                                $mensagem = mensagens('Validação', 'numero');
                                                                            }else if(!valida_numerico($p_numero, 1, 5)){
                                                                                    //Se a variável p_numero possuir letras, caracteres especiais ou passar de 5 caracteres, chama a função mensagens.
                                                                                    $mensagem = mensagens('Validação Numerico', 'número');
                                                                                }else{
                                                                                    $datac = $data[2]."-".$data[1]."-".$data[0];
                                                                                    //datac = Data Completa. Esta linha representa a montagem da data no formato aceito pelo banco.
                                                                                    //Este bloco é responsável por fazer a seleção dos clientes que tenham o email igual a variável p_email, o rg igual a variável p_rg ou o cpf igual a variável p_cpf e que for diferente da variável p_id.
                                                                                    $sql_sel_clients = "SELECT * FROM clients WHERE (email='".$p_email."' OR rg='".$p_rg."' OR cpf='".$p_cpf."') AND id<>'".$p_id."'";
                                                                                    $sql_sel_clients_preparado = $conexaobd->prepare($sql_sel_clients);
                                                                                    $sql_sel_clients_preparado->execute();

                                                                                    //Este bloco é responsável por verificar se a contagem de registros com a condição acima é zero, então faz a alteração, se não, diz que o cliente já existe.
                                                                                    if($sql_sel_clients_preparado->rowCount()==0){
                                                                                        $tabela = "clients";
                                                                                        //Define o valor da variável tabela como clients.

                                                                                        //Este bloco é responsável por colocar os dados recebidos do formulário em um array.
                                                                                        $dados = array(
                                                                                            'districts_id' => $p_bairro,
                                                                                            'name' => $p_nome,
                                                                                            'email' => $p_email,
                                                                                            'phone' => $p_telefone,
                                                                                            'birthdate' => $datac,
                                                                                            'rg' => $p_rg,
                                                                                            'cpf' => $p_cpf,
                                                                                            'cep' => $p_cep,
                                                                                            'street' => $p_logradouro,
                                                                                            'number' => $p_numero,
                                                                                            'complement' => $p_complemento
                                                                                        );

                                                                                        $condicao = "id='".$p_id."'";
                                                                                        //Condição de o id ser igual a variável p_id.

                                                                                        $sql_upd_clients_resultado = alterar($tabela, $dados, $condicao);
                                                                                        //Chama a funçao alterar e atribui o valor a variável sql_upd_clients_resultado.

                                                                                        //Este bloco é responsável por exibir se a alteração funcionou ou não.
                                                                                        if($sql_upd_clients_resultado){
                                                                                            $msg_titulo = "Confirmação";
                                                                                            $mensagem = mensagens('Sucesso', 'Cliente', 'Alteração');
                                                                                            $voltar = "?folder=clients/&file=cb_fmins_clients&ext=php";
                                                                                        }else{
                                                                                            $mensagem = mensagens('Erro bd', 'cliente', 'alterar');
                                                                                        }
                                                                                    }else{
                                                                                        $mensagem = mensagens('Repetição', 'cliente');
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