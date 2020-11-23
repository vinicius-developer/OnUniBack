<?php

namespace App\Http\Controllers\Actions;

use App\Models\Report;
use App\Models\RelacaoReport;
use App\Http\Controllers\Controller;
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
            $acusador = Auth::guard('doador')->user();
            $reportExists = $this->reportExists('tbl_relacao_reports.id_doadores', 'tbl_reports.id_reportado', $acusador->id_doadores, $request->id_reportado);
            $reportadoExists = $this->reportadoExists('tbl_ongs', 'id_ongs', $request->id_reportado);
        } else {
            $acusador = Auth::guard('ong')->user();
            $reportExists = $this->reportExists('tbl_relacao_reports.id_ongs', 'tbl_reports.id_reportado', $acusador->id_ongs, $request->id_reportado);
            $reportadoExists = $this->reportadoExists('tbl_doadores', 'id_doadores', $request->id_reportado);
        }

        if($reportExists) {
            return response()->json([
                "message" => "Você já reportou esse usuário"
            ], 404);
        }

        if(!$reportadoExists) {
            return response()->json([
                "message" => "O id reportado não existe em nossa base de dados"
            ], 404);
        }

        $tbl_reports->id_reportado = $request->id_reportado;
        $tbl_reports->explicacao = $request->explicacao;
        $tbl_reports->tipo_usuario_reportado = $request->tipo_usuario_reportado;
        $createReport = $tbl_reports->save();

        if($request->tipo_usuario_reportado === 'ong') {
            $tbl_relacao_reports->id_doadores = $acusador->id_doadores;
        } else {
            $tbl_relacao_reports->id_ongs = $acusador->id_ongs;
        }

        $tbl_relacao_reports->id_reports = $tbl_reports->id_reports;
        $createRelacaoReport = $tbl_relacao_reports->save();

        if($createReport && $createRelacaoReport) {
            return response()->json([
                "message" => "Sua reclamação foi salva com sucesso, nós iremos analisá-la"
            ], 200);
        }
    }

    protected function reportadoExists($tabela, $colunm, $id) 
    {
        return DB::table($tabela)
                   ->where($colunm, '=', $id)
                   ->exists();    
    }

    protected function reportExists($colunmAcusador, $colunmReportado, $idAcusador, $idReportado)
    {
        return DB::table('tbl_relacao_reports')
                   ->join('tbl_reports', 'tbl_relacao_reports.id_reports', '=', 'tbl_reports.id_reports')
                   ->where($colunmAcusador, '=', $idAcusador)
                   ->where($colunmReportado, '=', $idReportado)
                   ->exists();

    }
}
