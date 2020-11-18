<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\RelacaoReport;
use App\Http\Requests\Report\RegisterReportRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $tbl_reports;
    protected $tbl_relacao_reports;

    public function __construct()
    {
        $this->tbl_reports = new Report;
        $this->tbl_relacao_reports = new RelacaoReport;
    }

    public function register(RegisterReportRequest $request) 
    {
        $tbl_reports = $this->tbl_reports;
        $tbl_relacao_reports = $this->tbl_relacao_reports;


        if($request->tipo_usuario_reportado === 'ong') {
            $reportadoExists = DB::table('tbl_ongs')->where('id_ongs', '=', $request->id_reportado)->exists();
            if(!$reportadoExists) {
                return response()->json([
                    "message" => "O id reportado não existe em nossa base de dados"
                ], 404);
            }
            $acusador = Auth::guard('doador')->user();

            $tbl_reports->explicacao = $request->explicacao;
            $tbl_reports->tipo_usuario_reportado = $request->tipo_usuario_reportado;
            $tbl_reports->save();

            $tbl_relacao_reports->id_doadores = $acusador->id_doadores;
            $tbl_relacao_reports->id_ongs = $request->id_reportado;
            $tbl_relacao_reports->id_reports = $tbl_reports->id_reports;
            $tbl_relacao_reports->save();
        } else {
            $reportadoExists = DB::table('tbl_doadores')->where('id_doadores', '=', $request->id_reportado)->exists();

            if(!$reportadoExists) {
                return response()->json([
                    "message" => "O id reportado não existe em nossa base de dados"
                ], 404);
            }
            $acusador = Auth::guard('ong')->user();

            $tbl_reports->explicacao = $request->explicacao;
            $tbl_reports->tipo_usuario_reportado = $request->tipo_usuario_reportado;
            $tbl_reports->save();

            $tbl_relacao_reports->id_doadores = $request->id_reportado;
            $tbl_relacao_reports->id_ongs = $acusador->id_ongs;
            $tbl_relacao_reports->id_reports = $tbl_reports->id_reports;
            $tbl_relacao_reports->save();
        }
    }
}
