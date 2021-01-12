<?php

namespace App\Http\Controllers\Users;

use App\Models\Doador;
use App\Models\Telefone;
use App\Models\LogTokenJwt;
use App\Models\RelacaoTelefone;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doador\RegisterDoadorRequest;
use App\Http\Requests\Doador\LoginDoadorRequest;
use App\Http\Requests\Doador\ImageDoadorRequest;
use App\Utils\Tools\Validators;
use App\Mail\RegisterDoadorMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail;

class DoadorController extends Controller
{
    private $doador;

    public function __construct()
    {
        $this->doador = new Doador();
    }

    public function register(RegisterDoadorRequest $request)
    {
        $tbl_doadores = $this->doador;
        $validators = new Validators();

        $responsePassword = $validators->validatorPassword($request->password);

        if ($responsePassword) {
            return response()->json($responsePassword, 400);
        }

        $tbl_doadores->id_doadores = md5(uniqid(rand(), 'true'));
        $tbl_doadores->nome = $request->nome;
        $tbl_doadores->sobrenome = $request->sobrenome;
        $tbl_doadores->email = $request->email;
        $tbl_doadores->password = bcrypt($request->password);
        $tbl_doadores->cpf = $request->cpf;
        $tbl_doadores->id_generos = $request->genero;
        $tbl_doadores->img_perfil = 'pothoPerfilDoador/fotoDoadorPadrao.png';
        $createDoador = $tbl_doadores->save();

        $tbl_telefones = new Telefone();
        $tbl_telefones->numero_telefone = $request->telefone;
        $tbl_telefones->save();

        $tbl_relacao_telefone = new RelacaoTelefone();
        $tbl_relacao_telefone->id_doadores = $tbl_doadores->id_doadores;
        $tbl_relacao_telefone->id_ongs = null;
        $tbl_relacao_telefone->id_telefones = $tbl_telefones->id_telefones;
        $tbl_relacao_telefone->save();

        if ($createDoador) {
            //Mail::send(new RegisterDoadorMail($request->email, $request->nome, $request->sobrenome, $tbl_doadores->id_doadores)); // ATIVAR PARA TESTES
            return response()->json([
                "message" => 'Sua conta foi criado com sucesso por favor verifique seu e-mail',
                "errors" => [],
            ]);
        }
    }

    public function activate($id)
    {
        $user = $this->doador->select('*')->where('id_doadores', '=', $id)->first();

        $user->status = 'true';
        $user->save();

        if ($user) {
            return response()->json([
                "message" => "Sua conta foi ativada com sucesso",
                'errors' => []
            ]);
        } else {
            return response()->json([
                "message" => 'Não foi possível concluir o cadastro',
                "errors" => [
                    "Estamos com algum problema em nosso sistema"
                ],
            ]);
        }
    }

    public function changeImage(ImageDoadorRequest $request)
    {
        $user = Auth::guard('doador')->user();

        Storage::delete([$user->img_perfil]);
        $user->img_perfil = $request->file('photo')->store('pothoPerfilDoador');
        $response = $user->save();

        return  $response ? response()->json(['exists' => $response], 200) : response()->json(['exists' => $response], 500);
    }



    public function login(LoginDoadorRequest $request)
    {
        $credential['cpf'] = $request->userkey;
        $credential['password'] = $request->password;
        $credential['status'] = 'true';

        if (!$token = Auth::guard('doador')->attempt($credential)) {
            return response()->json([
                'message' => 'Não foi possível permitir a sua entrada',
                'errors' => [
                    'password' => 'Seus dados não foram encontrados em nosso sistema'
                ]
            ], 401);
        }

        $log = new LogTokenJwt();

        $log->create([
            'token' => $token,
            'email' => $credential['cpf'],
            'tipo_usuario' => 'doador'
        ]);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Você foi desconectado com sucesso']);
    }

    public function me()
    {
        $user = auth('doador')->user();

        $query = $user->select(
            'nome',
            'sobrenome',
            'email',
            'cpf',
            'img_perfil'
        )->first();

        return response()->json($query);
    }



    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('ong')->factory()->getTTL() * 200
        ]);
    }
}
