<?php

namespace App\Http\Controllers\Auth;

use App\Models\Ong;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\RelacaoTelefone;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterOngRequest;
use App\Utils\Api\ReceitaWs;
use App\Email\registerOngEmail;
use Mail;

class OngController extends Controller
{
	private $receitaWs;
	private $ong;
	
	public function __construct() 
	{
		$this->receitaWs = new ReceitaWS();
		$this->ong = new Ong();
 	}

	public function register(RegisterOngRequest $request)
	{
		$tbl_ongs = $this->ong;
		$tbl_enderecos = new Endereco();
		$tbl_telefones = new Telefone();
		$tbl_relacao_tefones = new RelacaoTelefone();

		$cnpjOnlyNumbers = preg_replace('/[^0-9]/', '', (string) $request->cnpj);

		// $response = $this->receitaWs->requestGetWs($cnpjOnlyNumbers);
		// if($response["situacao"] !== "ATIVA") {
		// 	return response()->json([
		// 		"message" => "The given data was invalid",
		//		"errors" => [
		//			"cnpj": [					
		//              "Esse Cnpj não está ativo"	
		//          ]
		//	    ]
		// 	]);
		// }

		$tbl_ongs->id_causas_sociais = $request->causa_social;
		$tbl_ongs->cnpj = $request->cnpj;
		$tbl_ongs->nome_fantasia = $request->nome_fantasia;
        $tbl_ongs->razao_social = $request->razao_social;
		$tbl_ongs->email = $request->email;
		$tbl_ongs->senha = bcrypt($request->senha);
		$tbl_ongs->descricao_ong = $request->descricao;
		$tbl_ongs->img_perfil = 'pothoPerfilOng/fotoOngPadrao.png';
		$createOng = $tbl_ongs->save();

		$tbl_enderecos->id_ongs = $tbl_ongs->id_ongs;
		$tbl_enderecos->rua = $request->rua;
		$tbl_enderecos->cep = $request->cep;			
		$tbl_enderecos->numero = $request->numero;			
		$tbl_enderecos->complemento = $request->complemento;
		$tbl_enderecos->cidade = $request->cidade;
		$tbl_enderecos->bairro = $request->bairro;
		$tbl_enderecos->uf = $request->uf;
		$createEndereco = $tbl_enderecos->save();

		foreach($request->telefones as $telefone) {
			$tbl_telefones->numero_telefone = $telefone;
			$tbl_telefones->save();

			$tbl_relacao_telefones->id_doadores = '';
			$tbl_relacao_telefones->id_ongs = $tbl_ongs->id_ongs;
			$tbl_relacao_telefones->id_telefones = $tbl_telefones->id_telefones;
			$tbl_relacao_telefones->save();
		}

		

		if($createOng) {
			//Mail::send(new \App\Mail\resgiterOngsMail($request->email, $request->nome_fantasia));
			return response()->json([
				"message" => 'Sua conta foi criado com secesso por favor verifique se email',
				"errors" => [],
			]);
		} else {
			return response()->json([
				"message" => 'Não foi possível concluir o cadastro',
				"errors" => [],
			]);
		}

	}
}
