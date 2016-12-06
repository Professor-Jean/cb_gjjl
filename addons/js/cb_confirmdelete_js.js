/***********************************************************************************************************************************************
 *Autores: Gabriel Dezan;
           João Santucci;
           João Spieker;
           Lucas Janning;
 *Data de Criação: 02/10/2016
 *Data de Modificação: 02/10/2016
 *Descrição: Esta página contém o código responsável por realizar a confirmação de exclusão, mostrando um Pop-up na tela pedindo a confirmação da exclusão.
 ***********************************************************************************************************************************************/

function confirmacao(tipo, nome){

	//Esta linha é responsável por exibir a mensagem de confirmação e armazenar o resultado
	var resultado = confirm("Você realmete deseja excluir " + tipo + " " + nome+ "?");

	//Esta linha é responsável por Verificar o resultado da confirmação: Ok=true e Cancelar=false
	if(resultado == false){
		return false;
	}
}
