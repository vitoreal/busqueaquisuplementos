<?php

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\JsonResponse;

class Mensagens {

    public function load($msg){

		$mensagem = array();
    	
    	switch($msg){
				
			//Mensagens de Alerta
			case '001': // NAO
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "Bem vindo ao sistema, você está logado!";
			break;

			case '002':
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Login ou Senha Inválidos!";
				break;

			case '003':
				
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "Registro Cadastrado com Sucesso!";
				
				break;

			case '004':
				
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "Registro Alterado com Sucesso!";
				break;

			case '005':
				
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "Registro Excluido com Sucesso!";

				break;

			case '006':
				
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Login ou Email já cadastrados!";

				break;

			case '007':
				
				$mensagem['mensagem']['tipoMsg'] = "ERRO";
				$mensagem['mensagem']['texto'] = "Esta ação não pôde ser concluída!";

				break;

			case '008':
				
				$mensagem['mensagem']['tipoMsg'] = "ERRO";
				$mensagem['mensagem']['texto'] = "Erro ao excluir o registro!";

				break;

			case '009':
				
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Já existe um registro com esse nome!";

				break;

			case '010':
				
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Este registro não pode ser deletado porque está em uso!";
				
				break;

			case '011':
				
				$mensagem['mensagem']['tipoMsg'] = "ERRO";
				$mensagem['mensagem']['texto'] = "Erro inesperado, tente novamente!";
				
				break;

			case '012':
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Este usuário está sem acesso. Favor, entre em contato conosco!";
				break;
				
			case '013':
				
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "Registro Cadastrado com Sucesso. Favor, tente acessar novamente! ";
				
				break;
			
			case '014':
				
				$mensagem['mensagem']['tipoMsg'] = "SUCESSO";
				$mensagem['mensagem']['texto'] = "E-mail enviado com sucesso, em breve entraremos em contato! ";
				
				break;
				
			case '015':
			
				$mensagem['mensagem']['tipoMsg'] = "ERRO";
				$mensagem['mensagem']['texto'] = "E-mail não enviado. Favor entre em contato conosco! ";
			
				break;
				
			case '016':
					
				$mensagem['mensagem']['tipoMsg'] = "ALERTA";
				$mensagem['mensagem']['texto'] = "Verifique se os seus dados estão corretos! ";
					
				break;

            case '017':

                $mensagem['mensagem']['tipoMsg'] = "SUCESSO";
                $mensagem['mensagem']['texto'] = "Registro cadastrado com sucesso, favor verifique seu email! ";

                break;
            case '018':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Este Login já está sendo utilizado!";

                break;
            case '019':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Campo descrição vazio!";

                break;
            case '020':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Já existe um login com esse nome!";

                break;
            case '021':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Esta loja foi desativada!";

                break;
            case '022':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Este produto já foi cadastrado para essa loja!";

                break;
            case '023':

            $mensagem['mensagem']['tipoMsg'] = "ALERTA";
            $mensagem['mensagem']['texto'] = "Esta loja já alcançou a quantidade de produtos permitidos!";

            break;
            case '024':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Já existe um registro com esse CPF!";

                break;
            case '025':

                $mensagem['mensagem']['tipoMsg'] = "SUCESSO";
                $mensagem['mensagem']['texto'] = "Preço alterado com sucesso! Você só poderá efetuar uma nova alteração daqui 24hs.";

                break;
            case '026':

                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "O login e a senha não podem ter menos que 8 dígitos!";

                break;

			default:
                $mensagem['mensagem']['tipoMsg'] = "ALERTA";
                $mensagem['mensagem']['texto'] = "Erro inesperado, tente novamente!";
				break;
					
		}

        $response = new JsonResponse();
        $response->setData($mensagem);
		return 	$response;
		
	}
}
