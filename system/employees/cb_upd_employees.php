<?php
    $p_id = $_POST['hidid'];
    $p_usersid = $_POST['hidusersid'];
    $p_nome = $_POST["txtnome"];
    $p_email = $_POST["txtemail"];
    $p_telefone = $_POST["txttelefone"];
    $p_nascimento = $_POST["txtnascimento"];
    $p_usuario = $_POST["txtusuario"];
    $p_senha = $_POST["pwdsenha"];
    $hash_senha = md5($salt.$p_senha);
    $explode_nascimento = explode("/", $p_nascimento);
    $msg_titulo = "Erro";
    $voltar = "?folder=employees/&file=cb_fmupd_employees&ext=php&id=".$p_id;


    if($p_nome==""){
        $mensagem = mensagens('Validação', 'nome');
    }else if(!valida_nome($p_nome, 45)){
            $mensagem = mensagens('Validação Nome', 'nome');
        }else if($p_email==""){
                 $mensagem = mensagens('Validação', 'e-mail');
            }else if(!valida_email($p_email)){
                    $mensagem = mensagens('Validação Email', 'e-mail');
                }else if($p_telefone==""){
                        $mensagem = mensagens('Validação', 'telefone');
                    }else if(!valida_numerico($p_telefone, 1, 15)) {
                            $mensagem = mensagens('Validação Numerico', 'telefone');
                        }else if($p_nascimento==""){
                                $mensagem = mensagens('Validação', 'data de nascimento');
                            }else if(((!isset($explode_nascimento[2]))||(isset($explode_nascimento[3])))||(!valida_data($explode_nascimento[2], $explode_nascimento[1], $explode_nascimento[0]))){
                                    $mensagem = mensagens('Validação Data');
                                }else if($p_usuario == ""){
                                        //Se a variável p_usuario for vazia, chama a função mensagens.
                                        $mensagem = mensagens('Validação', 'usuário');
                                    }else if(!valida_alfanumerico($p_usuario, 1, 20)){
                                            //Se a variável p_usuario possuir caracteres especiais, chama a função mensagens.
                                            $mensagem = mensagens('Validação Alfanumericos', 'Usuário');
                                        }else if($p_senha == "") {
                                                //Se a variável p_senha for vazia, chama a função mensagens.
                                                $mensagem = mensagens('Validação', 'senha');
                                            }else{
                                                $sql_sel_employees = "SELECT * FROM employees WHERE email='".$p_email."' AND id <>'".$p_id."'";
                                                $sql_sel_employees_preparado = $conexaobd->prepare($sql_sel_employees);
                                                $sql_sel_employees_preparado->execute();

                                                if($sql_sel_employees_preparado->rowCount()==0){
                                                    $sql_sel_users = "SELECT * FROM users WHERE username='".$p_usuario."' AND id <>'".$p_usersid."'";
                                                    $sql_sel_users_preparado = $conexaobd->prepare($sql_sel_users);
                                                    $sql_sel_users_preparado->execute();

                                                    if($sql_sel_users_preparado->rowCount()==0){
                                                        $tabela="users";
                                                        $dados=array(
                                                            'username'=>$p_usuario,
                                                            'password'=>$hash_senha,
                                                            'permission'=>'1'
                                                        );
                                                        $condicao = "id='".$p_usersid."'";
                                                        $sql_upd_users_resultado = alterar($tabela, $dados, $condicao);
                                                        if($sql_upd_users_resultado){
                                                            $usuario_id = $p_usersid;
                                                            $tabela="employees";
                                                            $dados=array(
                                                                'users_id'=>$usuario_id,
                                                                'name'=>$p_nome,
                                                                'birthdate'=>$explode_nascimento[2]."-".$explode_nascimento[1]."-".$explode_nascimento[0],
                                                                'email'=>$p_email,
                                                                'phone'=>$p_telefone
                                                            );
                                                            $condicao = "id='".$p_id."'";
                                                            $sql_upd_employees_resultado = alterar($tabela, $dados, $condicao);
                                                            if($sql_upd_employees_resultado){
                                                                $msg_titulo = "Confirmação";
                                                                $mensagem = mensagens('Sucesso', 'Colaborador', 'Alteração');
                                                                $voltar = "?folder=employees/&file=cb_fmins_employees&ext=php";
                                                            }else{
                                                                $mensagem = mensagens('Erro bd', 'Colaborador', 'alterar');
                                                            }
                                                        }else{
                                                            $mensagem = mensagens('Erro bd', 'Colaborador', 'alterar');
                                                        }
                                                    }else{
                                                        $mensagem = mensagens('Repetição', 'usuário');
                                                    }
                                                }else{
                                                    $mensagem = mensagens('Repetição', 'e-mail');
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
