<?php

namespace App\Http\Controllers;

use App\Models\PengajuanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $param['pageTitle'] = "Analisa Kredit";
        $id_cabang = Auth::user()->id_cabang;
        if (Auth::user()->role == "Staf Analis Kredit") {
            $param['data'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.progress_pengajuan_data','pengajuan.tanggal_review_penyelia','pengajuan.tanggal_review_pincab','pengajuan.status','pengajuan.status_by_sistem','pengajuan.id_cabang','pengajuan.average_by_sistem','pengajuan.average_by_penyelia','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.sektor_kredit','calon_nasabah.jumlah_kredit','calon_nasabah.id_pengajuan')->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')->where('pengajuan.id_cabang',$id_cabang)->where('pengajuan.posisi','=','Proses Input Data')->get();
        } elseif (Auth::user()->role == "Penyelia Kredit") {
            $param['data'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.progress_pengajuan_data','pengajuan.tanggal_review_penyelia','pengajuan.tanggal_review_pincab','pengajuan.status','pengajuan.status_by_sistem','pengajuan.id_cabang','pengajuan.average_by_sistem','pengajuan.average_by_penyelia','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.sektor_kredit','calon_nasabah.jumlah_kredit','calon_nasabah.id_pengajuan')->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')->where('pengajuan.id_cabang',$id_cabang)->where('pengajuan.posisi','=','Review Penyelia')->get();
        } elseif (Auth::user()->role == "PBP") {
            $param['data'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.progress_pengajuan_data','pengajuan.tanggal_review_penyelia','pengajuan.tanggal_review_pincab','pengajuan.status','pengajuan.status_by_sistem','pengajuan.id_cabang','pengajuan.average_by_sistem','pengajuan.average_by_penyelia','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.sektor_kredit','calon_nasabah.jumlah_kredit','calon_nasabah.id_pengajuan')->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')->where('pengajuan.id_cabang',$id_cabang)->where('pengajuan.posisi','=','PBP')->get();
        } elseif (Auth::user()->role == "Pincab") {
            $param['data'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.progress_pengajuan_data','pengajuan.tanggal_review_penyelia','pengajuan.tanggal_review_pincab','pengajuan.status','pengajuan.status_by_sistem','pengajuan.id_cabang','pengajuan.average_by_sistem','pengajuan.average_by_penyelia','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.sektor_kredit','calon_nasabah.jumlah_kredit','calon_nasabah.id_pengajuan')->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')->where('pengajuan.id_cabang',$id_cabang)->where('pengajuan.posisi','=','Pincab')->get();
        } else {
            $param['data'] = PengajuanModel::select('pengajuan.id','pengajuan.tanggal','pengajuan.posisi','pengajuan.progress_pengajuan_data','pengajuan.tanggal_review_penyelia','pengajuan.tanggal_review_pincab','pengajuan.status','pengajuan.status_by_sistem','pengajuan.id_cabang','pengajuan.average_by_sistem','pengajuan.average_by_penyelia','calon_nasabah.nama','calon_nasabah.jenis_usaha','calon_nasabah.sektor_kredit','calon_nasabah.jumlah_kredit','calon_nasabah.id_pengajuan')->join('calon_nasabah','calon_nasabah.id_pengajuan','pengajuan.id')->get();
        }
        return view('dashboard',$param);
    }
}
