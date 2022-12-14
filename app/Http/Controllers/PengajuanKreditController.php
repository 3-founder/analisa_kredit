<?php

namespace App\Http\Controllers;

use App\Models\CalonNasabah;
use App\Models\Desa;
use App\Models\DetailKomentarModel;
use App\Models\ItemModel;
use App\Models\JawabanPengajuanModel;
use App\Models\JawabanTextModel;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\KomentarModel;
use App\Models\OptionModel;
use App\Models\PengajuanModel;
use App\Models\JawabanSubColumnModel;
use App\Models\PendapatPerAspek;
use App\Models\DetailPendapatPerAspek;
use DateTime;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Image;

class PengajuanKreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $param['pageTitle'] = "Dashboard";
        $id_cabang = Auth::user()->id_cabang;
        if (auth()->user()->role == 'Staf Analis Kredit') {
            $param['pageTitle'] = 'Tambah Pengajuan Kredit';
            $param['btnText'] = 'Tambah Pengajuan';
            $param['btnLink'] = route('pengajuan-kredit.create');
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pbp',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->paginate(5);
            // return view('pengajuan-kredit.add-pengajuan-kredit',$param);
            return view('pengajuan-kredit.list-edit-pengajuan-kredit', $param);
        } elseif (auth()->user()->role == 'Penyelia Kredit') {
            // $param['dataAspek'] = ItemModel::select('*')->where('level',1)->get();

            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pbp',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->paginate(5);
            return view('pengajuan-kredit.list-pengajuan-kredit', $param);
        } elseif (auth()->user()->role == 'PBP') {
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pbp',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->paginate(5);
            return view('pengajuan-kredit.list-pbp', $param);
        } 
        elseif (auth()->user()->role == 'Pincab') {
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pbp',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', Auth::user()->id_cabang)
                ->whereIn('pengajuan.posisi', ['Pincab', 'Selesai', 'Ditolak'])
                ->paginate(5);
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        } else {
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.progress_pengajuan_data',
                'pengajuan.tanggal_review_penyelia',
                'pengajuan.tanggal_review_pbp',
                'pengajuan.tanggal_review_pincab',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->paginate(5);
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $param['pageTitle'] = "Dashboard";

        $param['dataDesa'] = Desa::all();
        $param['dataKecamatan'] = Kecamatan::all();
        $param['dataKabupaten'] = Kabupaten::all();
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama','!=','Data Umum')->get();
        $param['itemSlik'] = ItemModel::with('option')->where('nama', 'SLIK')->first();
        $param['itemSP'] = ItemModel::where('nama','Surat Permohonan')->first();
        $param['itemP'] = ItemModel::where('nama','Laporan SLIK')->first();

        $data['dataPertanyaanSatu'] = ItemModel::select('id', 'nama', 'level', 'id_parent')->where('level', 2)->where('id_parent', 3)->get();

        // dump($param['dataAspek']);
        // dump($param['itemSlik']);
        // dump($param['itemSP']);
        // dump($param['dataPertanyaanSatu']);
        // dd($param['itemP']);
        return view('pengajuan-kredit.add-pengajuan-kredit', $param);
    }

    public function checkSubColumn(Request $request)
    {
        $idItem = $this->getDataLevel($request->get('idOption'));
        $subColumn = OptionModel::select('sub_column')->where('id', $idItem[1])->first();
        return $subColumn;
    }

    public function getItemJaminanByKategoriJaminanUtama(Request $request)
    {
        $kategori = $request->get('kategori');


        if ($kategori == 'Tanah' || $kategori=='Tanah dan Bangunan') {
            $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 95)->first();

            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('jawaban_text.id_pengajuan', $request->id)
                                        ->whereIn('id_jawaban', [103, 104, 107, 108, 147])
                                        ->orderBy('id', 'ASC')->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])
                                        ->get();

            $belumDiisi = array();
            foreach($dataDetailJawabanText as $key => $val){
                array_push($belumDiisi, $val->id_jawaban);
            }

            $belum = ItemModel::whereNotIn('id', $belumDiisi)
                    ->orderBy('id', 'ASC')
                    ->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])
                    ->where('id_parent', 96);

            $detailJawabanOption = \App\Models\JawabanPengajuanModel::where('id_pengajuan', $request->id)
                                        ->whereIn('id_jawaban', [136, 137, 141, 142])
                                        ->select('id_jawaban')
                                        ->orderBy('id', 'DESC');

            $itemBuktiPemilikan = ItemModel::with('option');

            $itemBuktiPemilikan->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])->where('id_parent', 96);

            $data = [
                'item' => $item,
                'belum' => $belum->get(),
                'itemBuktiPemilikan' => $itemBuktiPemilikan->get(),
                'detailJawabanOption' => $detailJawabanOption->first(),
                'dataDetailJawabanText' => $dataDetailJawabanText
            ];
        }
        else if($kategori == 'Kendaraan Bermotor'){
            $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 95)->first();
            
            $dataDetailJawabanText = DB::table('jawaban_text')
                                        ->where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->orderBy('id', 'ASC')
                                        ->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto'])
                                        ->where('id_parent', 96)
                                        ->get();

            $detailJawabanOption = \App\Models\JawabanPengajuanModel::where('id_pengajuan', $request->id)
                                        ->whereIn('id_jawaban', [138, 139, 140])
                                        ->select('id_jawaban')
                                        ->orderBy('id', 'DESC');

            $itemBuktiPemilikan = ItemModel::with('option');

            $itemBuktiPemilikan->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto'])->where('id_parent', 96);

            $data = [
                'item' => $item,
                'itemBuktiPemilikan' => $itemBuktiPemilikan->get(),
                'detailJawabanOption' => $detailJawabanOption->first(),
                'dataDetailJawabanText' => $dataDetailJawabanText
            ];
        }
        else{
            $item = ItemModel::where('nama', $kategori)->where('id_parent', 95)->first();
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->distinct('nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->orderBy('id', 'ASC')
                                        ->where('nama', $kategori)
                                        ->get();

            $itemBuktiPemilikan = ItemModel::where('nama', $kategori);

            $data = [
                'item' => $item,
                'itemBuktiPemilikan' => $itemBuktiPemilikan->get(),
                // 'detailJawabanOption' => $detailJawabanOption->first(),
                'dataDetailJawabanText' => $dataDetailJawabanText
            ];
        }

        return json_encode($data);
    }

    public function getItemJaminanByKategoriJaminanTambahan(Request $request)
    {
        $kategori = $request->get('kategori');

        $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 110)->first();

        $itemBuktiPemilikan = ItemModel::with('option');
        if ($kategori == 'Tanah' || $kategori=='Tanah dan Bangunan') {
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])
                                        ->where('id_parent', 114)
                                        ->get();

            $detailJawabanOption = \App\Models\JawabanPengajuanModel::where('id_pengajuan', $request->id)
                                        ->whereIn('id_jawaban', [145, 146, 150, 151])
                                        ->select('id_jawaban')
                                        ->orderBy('id', 'DESC');

            $blm = array();
            foreach($dataDetailJawabanText as $key => $val){
                array_push($blm, $val->id_item);
            }

            $belum = ItemModel::whereNotIn('id', $blm)
                    ->orderBy('id', 'ASC')
                    ->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])
                    ->where('id_parent', 114)
                    ->get();

            $itemBuktiPemilikan->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto']);
        }
        else{
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->distinct()
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('id_parent', 114)
                                        ->get();

            $detailJawabanOption = \App\Models\JawabanPengajuanModel::where('id_pengajuan', $request->id)
                                        ->whereIn('id_jawaban', [147, 148, 149])
                                        ->select('id_jawaban')
                                        ->orderBy('id', 'DESC');

            $itemBuktiPemilikan->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto']);
            $blm = array();
            foreach($dataDetailJawabanText as $key => $val){
                array_push($blm, $val->id_item);
            }

            $belum = ItemModel::whereNotIn('id', $blm)
                    ->orderBy('id', 'ASC')
                    ->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto'])
                    ->where('id_parent', 114)
                    ->get();
        }
        $data = [
            'detailJawabanOption' => $detailJawabanOption->first(),
            'dataDetailJawabanText' => $dataDetailJawabanText,
            'item' => $item,
            'belum' => $belum,
            'itemBuktiPemilikan' => $itemBuktiPemilikan->where('id_parent', 114)->get()
        ];

        return json_encode($data);
    }

    public function getEditJaminanKategori(Request $request)
    {
        $kategori = $request->get('kategori');

        if ($kategori == 'Tanah' || $kategori=='Tanah dan Bangunan') {
            $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 95)->first();

            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('jawaban_text.id_pengajuan', $request->id)
                                        ->orderBy('id', 'ASC')
                                        ->get();

            $itemBuktiPemilikan = ItemModel::with('option');

            $itemBuktiPemilikan->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto'])->where('id_parent', 96);
        }
        else if($kategori == 'Kendaraan Bermotor'){
            $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 95)->first();
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->groupBy('nama')
                                        ->orderBy('id', 'ASC')
                                        ->first();

            $itemBuktiPemilikan = ItemModel::with('option');

            $itemBuktiPemilikan->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto'])->where('id_parent', 96);
        }
        else{
            $item = ItemModel::where('nama', $kategori)->where('id_parent', 95)->first();
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->groupBy('nama')
                                        ->orderBy('id', 'ASC')
                                        ->get();

            $itemBuktiPemilikan = ItemModel::where('nama', $kategori);
        }

        $data = [
            'item' => $item,
            'itemBuktiPemilikan' => $itemBuktiPemilikan->get(),
            'dataDetailJawabanText' => $dataDetailJawabanText
        ];

        return json_encode($data);
    }

    public function getEditJaminanKategoriTambahan(Request $request)
    {
        $kategori = $request->get('kategori');

        $item = ItemModel::with('option')->where('nama', $kategori)->where('id_parent', 110)->first();

        $itemBuktiPemilikan = ItemModel::with('option');
        if ($kategori == 'Tanah' || $kategori=='Tanah dan Bangunan') {
            $itemBuktiPemilikan->whereIn('nama', ['SHM No', 'Atas Nama', 'SHGB No', 'Berakhir Hak (SHGB)', 'Petok / Letter C', 'Foto']);
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->groupBy('nama')
                                        ->orderBy('id', 'DESC');
        }
        else{
            $itemBuktiPemilikan->whereIn('nama', ['BPKB No', 'Atas Nama', 'Foto']);
            
            $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $request->id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->orderBy('id', 'DESC');
                                        
        }
        $data = [
            'dataDetailJawabanText' => $dataDetailJawabanText->where('id_parent', 114)->get(),
            'item' => $item,
            'itemBuktiPemilikan' => $itemBuktiPemilikan->where('id_parent', 114)->get(),
        ];

        return json_encode($data);
    }

    public function getIjinUsaha(Request $request)
    {
        $id = $request->get('id_pengajuan');

        $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', $id)
                                        ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->whereIn('item.nama', ['nib', 'surat keterangan usaha']);

        return response()->json($dataDetailJawabanText);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $_POST;
        // return 'jumlah id level = ' . count($request->get('id_level')) . '; jumlah input = ' . count($request->get('informasi'));
        // $checkLevelDua = $request->dataLevelDua != null ? 'required' : '';
        // $checkLevelTiga = $request->dataLevelTiga != null ? 'required' : '';
        // $checkLevelEmpat = $request->dataLevelEmpat != null ? 'required' : '';
        $find = array('Rp ', '.');
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required',
            'kabupaten' => 'required',
            'kec' => 'required',
            'desa' => 'required',
            'kabupaten' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'sektor_kredit' => 'required',
            'jenis_usaha' => 'required',
            'jumlah_kredit' => 'required',
            'tenor_yang_diminta' => 'required',
            'tujuan_kredit' => 'required',
            'jaminan' => 'required',
            'hubungan_bank' => 'required',
            'hasil_verifikasi' => 'required',
            'komentar_staff' => 'required'
            // 'dataLevelDua.*' => $checkLevelDua,
            // 'dataLevelTiga.*' => $checkLevelTiga,
            // 'dataLevelEmpat.*' => $checkLevelEmpat,
        ], [
            'required' => 'data harus terisi.'
        ]);

        DB::beginTransaction();
        try {
            $addPengajuan = new PengajuanModel;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->id_cabang = auth()->user()->id_cabang;
            $addPengajuan->progress_pengajuan_data = $request->progress;
            $addPengajuan->save();
            $id_pengajuan = $addPengajuan->id;

            $addData = new CalonNasabah;
            $addData->nama = $request->name;
            $addData->alamat_rumah = $request->alamat_rumah;
            $addData->alamat_usaha = $request->alamat_usaha;
            $addData->no_ktp = $request->no_ktp;
            $addData->tempat_lahir = $request->tempat_lahir;
            $addData->tanggal_lahir = $request->tanggal_lahir;
            $addData->status = $request->status;
            $addData->sektor_kredit = $request->sektor_kredit;
            $addData->jenis_usaha = $request->jenis_usaha;
            $addData->jumlah_kredit = str_replace($find,"",$request->jumlah_kredit);
            $addData->tenor_yang_diminta = $request->tenor_yang_diminta;
            $addData->tujuan_kredit = $request->tujuan_kredit;
            $addData->jaminan_kredit = $request->jaminan;
            $addData->hubungan_bank = $request->hubungan_bank;
            $addData->verifikasi_umum = $request->hasil_verifikasi;
            $addData->id_user = auth()->user()->id;
            $addData->id_pengajuan = $id_pengajuan;
            $addData->id_desa = $request->desa;
            $addData->id_kecamatan = $request->kec;
            $addData->id_kabupaten = $request->kabupaten;
            $addData->save();
            $id_calon_nasabah = $addData->id;

            //untuk jawaban yg teks, number, persen, long text
            foreach ($request->id_level as $key => $value) {
                $dataJawabanText = new JawabanTextModel;
                $dataJawabanText->id_pengajuan = $id_pengajuan;
                $dataJawabanText->id_jawaban = $request->get('id_level')[$key];
                if ($request->get('id_level')[$key] == '143') {
                    $dataJawabanText->opsi_text = $request->get('informasi')[$key];
                } else {
                    $dataJawabanText->opsi_text = str_replace($find,'',$request->get('informasi')[$key]);
                }
                // $dataJawabanText->opsi_text = $request->get('informasi')[$key] == null ? '-' : $request->get('informasi')[$key];
                $dataJawabanText->save();
            }
            //untuk upload file
            foreach ($request->id_item_file as $key => $value) {
                $image = $request->file('upload_file')[$key];
                $imageName = $key.time().'.'.$image->getClientOriginalExtension();

                $filePath = public_path() . '/upload/' . $id_pengajuan . '/'. $value;
                
                if (!\File::isDirectory($filePath)) {
                    \File::makeDirectory($filePath, 493, true);
                }
                
                $image->move($filePath, $imageName);

                $dataJawabanText = new JawabanTextModel;
                $dataJawabanText->id_pengajuan = $id_pengajuan;
                $dataJawabanText->id_jawaban =  $value;
                $dataJawabanText->opsi_text = $imageName;
                $dataJawabanText->save();
            }

            $finalArray = array();
            $rata_rata = array();
            // data Level dua
            if ($request->dataLevelDua != null) {
                $data = $request->dataLevelDua;
                $result_dua = array_values(array_filter($data));
                foreach ($result_dua as $key => $value) {
                    $data_level_dua = $this->getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    //jika skor nya tidak kosong
                    if ($skor[$key] != 'kosong') {
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = NULL;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            } else {

            }

            // data level tiga
            if ($request->dataLevelTiga != null) {
                $data = $request->dataLevelTiga;
                $result_tiga = array_values(array_filter($data));
                foreach ($result_tiga as $key => $value) {
                    $data_level_tiga = $this->getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    //jika skor nya tidak kosong
                    if ($skor[$key] != 'kosong') {
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = NULL;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            } else {

            }

            // data level empat
            if ($request->dataLevelEmpat != null) {
                $data = $request->dataLevelEmpat;
                $result_empat = array_values(array_filter($data));
                foreach ($result_empat as $key => $value) {
                    $data_level_empat = $this->getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    //jika skor nya tidak kosong
                    if ($skor[$key] != 'kosong') {
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = NULL;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'created_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            } else {

            }
            $average = array_sum($rata_rata) / count($rata_rata);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                // $updateData->status = "kuning";
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }
            for ($i = 0; $i < count($finalArray); $i++) {
                JawabanPengajuanModel::insert($finalArray[$i]);
            }

            $updateData->posisi = 'Proses Input Data';
            $updateData->status_by_sistem = $status;
            $updateData->average_by_sistem = $result;
            $updateData->update();

            //save pendapat per aspek
            foreach ($request->get('id_aspek') as $key => $value) {
                if ($request->get('pendapat_per_aspek')[$key] == '') {
                    # code...
                } else {
                    $addPendapat = new PendapatPerAspek;
                    $addPendapat->id_pengajuan = $id_pengajuan;
                    $addPendapat->id_staf = Auth::user()->id;
                    $addPendapat->id_aspek = $value;
                    $addPendapat->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                    $addPendapat->save();
                }
            }

            if ($request->get('komentar_staff') == '') {
                # code...
            } else {
                $addKomentar = new KomentarModel;
                $addKomentar->id_pengajuan = $id_pengajuan;
                $addKomentar->komentar_staff = $request->get('komentar_staff');
                $addKomentar->id_staff = Auth::user()->id;
                $addKomentar->save();
            }
            

            DB::commit();
            return redirect()->route('pengajuan-kredit.index')->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return redirect()->route('pengajuan-kredit.index')->withError('Terjadi kesalahan.'.$e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            // return $e->getMessage();
            return redirect()->route('pengajuan-kredit.index')->withError('Terjadi kesalahan'.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $param['pageTitle'] = "Dashboard";

        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama','!=','Data Umum')->get();

        $data['dataPertanyaanSatu'] = ItemModel::select('id', 'nama', 'level', 'id_parent')->where('level', 2)->where('id_parent', 3)->get();

        $param['itemSlik'] = ItemModel::with('option')->where('nama', 'SLIK')->first();
        
        $param['itemSP'] = ItemModel::where('nama','Surat Permohonan')->first();

        $param['dataUmum'] = PengajuanModel::select(
            'pengajuan.id',
            'pengajuan.tanggal',
            'pengajuan.posisi',
            'pengajuan.tanggal_review_penyelia',
            'calon_nasabah.id as id_calon_nasabah',
            'calon_nasabah.nama',
            'calon_nasabah.alamat_rumah',
            'calon_nasabah.alamat_usaha',
            'calon_nasabah.no_ktp',
            'calon_nasabah.tempat_lahir',
            'calon_nasabah.tanggal_lahir',
            'calon_nasabah.status',
            'calon_nasabah.sektor_kredit',
            'calon_nasabah.jenis_usaha',
            'calon_nasabah.jumlah_kredit',
            'calon_nasabah.tujuan_kredit',
            'calon_nasabah.jaminan_kredit',
            'calon_nasabah.hubungan_bank',
            'calon_nasabah.hubungan_bank',
            'calon_nasabah.verifikasi_umum',
            'calon_nasabah.id_kabupaten',
            'calon_nasabah.id_kecamatan',
            'calon_nasabah.id_desa',
            'calon_nasabah.tenor_yang_diminta'
        )
            ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
            ->find($id);
        $param['allKab'] = Kabupaten::get();
        $param['allKec'] = Kecamatan::where('id_kabupaten', $param['dataUmum']->id_kabupaten)->get();
        $param['allDesa'] = Desa::where('id_kecamatan', $param['dataUmum']->id_kecamatan)->get();
        $param['pendapatDanUsulanStaf'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff')->first();
            
        // return JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.opsi_jawaban')
        //                                 ->join('item', 'jawaban_text.id_jawaban', 'item.id')
        //                                 ->where('id_pengajuan', $id)
        //                                 ->get();

        // $dataSlik = JawabanPengajuanModel::where('id_pengajuan', 14)
        //                                 ->join('option', 'option.id', 'jawaban.id_jawaban')
        //                                 ->whereIn('option.id', [71, 72, 73, 74])
        //                                 ->first();
        
        // 'jawaban.id as id_jawaban','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','jawaban.skor_penyelia'

        // return $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();

        // dd($dataSlik);
        // dump($param['itemSlik']);
        // // dd($dataDetailJawabanText->get());
        // $dataDetailJawabanText = \App\Models\JawabanTextModel::where('id_pengajuan', 1)
        //                                 ->select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama')
        //                                 ->join('item', 'jawaban_text.id_jawaban', 'item.id')
        //                                 ->where('id_parent', 114)
        //                                 ->orderBy('id', 'DESC');

        //                                 return $dataDetailJawabanText->get();

        return view('pengajuan-kredit.edit-pengajuan-kredit', $param);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        // return $request;
        $find = array('Rp.', '.');
        $request->validate([
            'name' => 'required',
            'alamat_rumah' => 'required',
            'alamat_usaha' => 'required',
            'no_ktp' => 'required|max:16',
            'kabupaten' => 'required',
            'kec' => 'required',
            'desa' => 'required',
            'kabupaten' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'sektor_kredit' => 'required',
            'jenis_usaha' => 'required',
            'jumlah_kredit' => 'required',
            'tujuan_kredit' => 'required',
            'jaminan' => 'required',
            'hubungan_bank' => 'required',
            'hasil_verifikasi' => 'required',
            // 'dataLevelDua.*' => $checkLevelDua,
            // 'dataLevelTiga.*' => $checkLevelTiga,
            // 'dataLevelEmpat.*' => $checkLevelEmpat,
        ], [
            'required' => 'data harus terisi.'
        ]);
        DB::beginTransaction();
        try {
            $updatePengajuan = PengajuanModel::find($id);
            $updatePengajuan->id_cabang = auth()->user()->id_cabang;
            $updatePengajuan->progress_pengajuan_data = $request->progress;
            $updatePengajuan->save();
            $id_pengajuan = $updatePengajuan->id;

            $updateData = CalonNasabah::find($request->id_nasabah);
            $updateData->nama = $request->name;
            $updateData->alamat_rumah = $request->alamat_rumah;
            $updateData->alamat_usaha = $request->alamat_usaha;
            $updateData->no_ktp = $request->no_ktp;
            $updateData->tempat_lahir = $request->tempat_lahir;
            $updateData->tanggal_lahir = $request->tanggal_lahir;
            $updateData->status = $request->status;
            $updateData->sektor_kredit = $request->sektor_kredit;
            $updateData->jenis_usaha = $request->jenis_usaha;
            $updateData->jumlah_kredit = str_replace($find, "", $request->jumlah_kredit);
            $updateData->tujuan_kredit = $request->tujuan_kredit;
            $updateData->jaminan_kredit = $request->jaminan;
            $updateData->hubungan_bank = $request->hubungan_bank;
            $updateData->verifikasi_umum = $request->hasil_verifikasi;
            $updateData->id_user = auth()->user()->id;
            $updateData->id_pengajuan = $id_pengajuan;
            $updateData->id_desa = $request->desa;
            $updateData->id_kecamatan = $request->kec;
            $updateData->id_kabupaten = $request->kabupaten;
            $updateData->save();
            $id_calon_nasabah = $updateData->id;


            // $addJawabanLevel = new JawabanPengajuanModel;
            // $addJawabanLevel->id_pengajuan = $id_pengajuan;
            $finalArray = array();
            $finalArray_text = array();
            $rata_rata = array();

            if(count($request->file()) > 0){
                foreach($request->file('update_file') as $key => $value){
                    if($request->id_update_file[$key] != null){
                        $image = $value;
                        $imageName = $request->id_file_text[$key].time().'.'.$image->getClientOriginalExtension();
    
                        $imageLama = JawabanTextModel::where('id_jawaban', $request->get('id_file_text')[$key])
                                        ->select('opsi_text', 'id_jawaban')
                                        ->where('opsi_text', '!=', null)
                                        ->get();
                        // return $imageLama;
                        foreach($imageLama as $imageKey => $imageValue){
                            $pathLama = public_path() . '/upload/' . $id_pengajuan . '/' . $imageValue->id_jawaban .'/' . $imageValue->opsi_text;
                            \File::delete($pathLama);
                        }
        
                        $filePath = public_path() . '/upload/' . $id_pengajuan . '/'. $request->id_file_text[$key];
                        // $filePath = public_path() . '/upload';
                        if (!\File::isDirectory($filePath)) {
                            \File::makeDirectory($filePath, 493, true);
                        }
    
                        $image->move($filePath, $imageName);
    
                        $imgUpdate = DB::table('jawaban_text');
                        $imgUpdate->where('id', $request->get('id_update_file')[$key])->update(['opsi_text' => $imageName]);
                    }else {
                        $image = $request->file('update_file')[$key];
                        $imageName = $request->id_file_text[$key].time().'.'.$image->getClientOriginalExtension();

                        $filePath = public_path() . '/upload/' . $id_pengajuan . '/'. $request->id_file_text[$key];
                        
                        if (!\File::isDirectory($filePath)) {
                            \File::makeDirectory($filePath, 493, true);
                        }
                        
                        $image->move($filePath, $imageName);

                        $dataJawabanText = new JawabanTextModel;
                        $dataJawabanText->id_pengajuan = $id_pengajuan;
                        $dataJawabanText->id_jawaban =  $request->id_file_text[$key];
                        $dataJawabanText->opsi_text = $imageName;
                        $dataJawabanText->save();
                    }
                }
            }

            foreach ($request->id_jawaban_text as $key => $value) {
                if($request->id_jawaban_text[$key] == null && $request->info_text[$key] != null){
                    $data_baru = new JawabanTextModel();
                    $data_baru->id_pengajuan = $id_pengajuan;
                    $data_baru->id_jawaban = $request->id_text[$key];
                    $data_baru->opsi_text = str_replace($find, "",$request->info_text[$key]);
                    $data_baru->skor_penyelia = null;
                    $data_baru->skor = null;
                    $data_baru->save();
                }
                else{
                    $skor = array();
                    if($request->skor_penyelia_text[$key] == 'null'){
                        $skor[$key] = null;
                    }
                    else{
                        $skor[$key] = $request->skor_penyelia_text[$key];
                    }
                   array_push($finalArray_text,array(
                        'id_pengajuan' => $id_pengajuan,
                        'id_jawaban' => $request->id_text[$key],
                        'opsi_text' => str_replace($find, "",$request->info_text[$key]),
                        'skor_penyelia' => $skor[$key],
                        'updated_at' => date("Y-m-d H:i:s"),
                   ));
                }
            };

            // data Level dua
            if ($request->dataLevelDua != null) {
                $data = $request->dataLevelDua;
                $result_dua = array_values(array_filter($data));
                foreach ($result_dua as $key => $value) {
                    $data_level_dua = $this->getDataLevel($value);
                    $skor[$key] = $data_level_dua[0];
                    $id_jawaban[$key] = $data_level_dua[1];
                    if($skor[$key] != 'kosong'){
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = null;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level tiga
            if ($request->dataLevelTiga != null) {
                $data = $request->dataLevelTiga;
                $result_tiga = array_values(array_filter($data));
                foreach ($result_tiga as $key => $value) {
                    $data_level_tiga = $this->getDataLevel($value);
                    $skor[$key] = $data_level_tiga[0];
                    $id_jawaban[$key] = $data_level_tiga[1];
                    if($skor[$key] != 'kosong'){
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = null;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }

            // data level empat
            if ($request->dataLevelEmpat != null) {
                $data = $request->dataLevelEmpat;
                $result_empat = array_values(array_filter($data));
                foreach ($result_empat as $key => $value) {
                    $data_level_empat = $this->getDataLevel($value);
                    $skor[$key] = $data_level_empat[0];
                    $id_jawaban[$key] = $data_level_empat[1];
                    if($skor[$key] != 'kosong'){
                        array_push($rata_rata, $skor[$key]);
                    }
                    else{
                        $skor[$key] = null;
                    }
                    array_push(
                        $finalArray,
                        array(
                            'id_pengajuan' => $id_pengajuan,
                            'id_jawaban' => $id_jawaban[$key],
                            'skor' => $skor[$key],
                            'updated_at' => date("Y-m-d H:i:s"),
                        )
                    );
                }
            }
            $average = array_sum($rata_rata) / count($rata_rata);
            $result = round($average, 2);
            $status = "";
            $updateData = PengajuanModel::find($id_pengajuan);
            if ($result > 0 && $result <= 1) {
                $status = "merah";
            } elseif ($result >= 2 && $result <= 3) {
                // $updateData->status = "kuning";
                $status = "kuning";
            } elseif ($result > 3) {
                $status = "hijau";
            } else {
                $status = "merah";
            }

            for ($i = 0; $i < count($finalArray); $i++) {
                /*
                1. variabel a = query select k table jawaban where(id, id_jawaban)
                2. jika variabel a itu ada maka proses update
                3. jika variabel a itu null maka insert / data baru
                */
                $data = DB::table('jawaban');

                if (!empty($request->id[$i])) {
                    $data->where('id', $request->id[$i])->update($finalArray[$i]);
                } else {
                    $data->insert($finalArray[$i]);
                }
            }

            // dd($finalArray_text);
            // return $finalArray_text;
            for ($i = 0; $i < count($request->id_text); $i++) {
                /*
                1. variabel a = query select k table jawaban where(id, id_jawaban)
                2. jika variabel a itu ada maka proses update
                3. jika variabel a itu null maka insert / data baru
                */
                $data = DB::table('jawaban_text');
                if($request->id_jawaban_text[$i] != null){
                    $data->where('id', $request->get('id_jawaban_text')[$i])->update(['opsi_text' => str_replace($find, "",$request->info_text[$i])] );
                }
                // if (!empty($request->id_jawaban_text[$i])) {
                // } else {
                //     $data->insert($finalArray_text[$i]);
                // }
            }

            for($i = 0; $i < count($request->pendapat_per_aspek); $i++){
                $data = DB::table('pendapat_dan_usulan_per_aspek');
                if($request->id_jawaban_text[$i] != null){
                    $data->where('id', $request->get('id_jawaban_aspek')[$i])->update(['pendapat_per_aspek' => $request->get('pendapat_per_aspek')[$i]]);
                }
                else{
                    $data->insert([
                        'id_pengajuan' => $id_pengajuan,
                        'id_staf' => auth()->user()->id,
                        'id_penyelia' => null,
                        'id_pincab' => null,
                        'id_aspek' => $request->get('id_aspek')[$i],
                        'pendapat_per_aspek' => $request->get('pendapat_per_aspek')[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            $id = $request->get('id_komentar_staff_text');
            $updateKomentar = KomentarModel::find($id);
            $updateKomentar->komentar_staff;
            $updateKomentar->update();

            $updateData->posisi = 'Proses Input Data';
            $updateData->status_by_sistem = $status;
            $updateData->average_by_sistem = $result;
            $updateData->update();
            // Session::put('id',$addData->id);
            DB::commit();
            return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil mengupdate data.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.'.$e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan'.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getkecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where("id_kabupaten", $request->kabID)->pluck('id', 'kecamatan');
        return response()->json($kecamatan);
    }
    public function getdesa(Request $request)
    {
        $desa = Desa::where("id_kecamatan", $request->kecID)->pluck('id', 'desa');
        return response()->json($desa);
    }
    public function getDataLevel($data)
    {
        $data_level = explode('-', $data);
        return $data_level;
    }

    // get detail jawaban dan skor pengajuan
    public function getDetailJawaban($id)
    {
        if (auth()->user()->role == 'Penyelia Kredit') {
            $param['pageTitle'] = "Dashboard";
            $param['dataAspek'] = ItemModel::where('level', 1)->where('nama', '!=','Data Umum')->get();
            $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                                ->where('p.id', $id)
                                ->where('nama', 'SLIK')
                                ->first();
            $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=','Data Umum')->first();

            $param['dataUmumNasabah'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.tanggal_review_penyelia',
                'calon_nasabah.id as id_calon_nasabah',
                'calon_nasabah.nama',
                'calon_nasabah.alamat_rumah',
                'calon_nasabah.alamat_usaha',
                'calon_nasabah.no_ktp',
                'calon_nasabah.tempat_lahir',
                'calon_nasabah.tanggal_lahir',
                'calon_nasabah.status',
                'calon_nasabah.sektor_kredit',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.jumlah_kredit',
                'calon_nasabah.tujuan_kredit',
                'calon_nasabah.jaminan_kredit',
                'calon_nasabah.hubungan_bank',
                'calon_nasabah.hubungan_bank',
                'calon_nasabah.verifikasi_umum',
                'calon_nasabah.id_kabupaten',
                'calon_nasabah.id_kecamatan',
                'calon_nasabah.id_desa',
                'calon_nasabah.tenor_yang_diminta',
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->find($id);
            $param['allKab'] = Kabupaten::get();
            $param['allKec'] = Kecamatan::where('id_kabupaten', $param['dataUmumNasabah']->id_kabupaten)->get();
            $param['allDesa'] = Desa::where('id_kecamatan', $param['dataUmumNasabah']->id_kecamatan)->get();
            $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia')
                ->find($id);
            $param['pendapatDanUsulanStaf'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff')->first();
            $param['pendapatDanUsulanPenyelia'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_penyelia')->first();

            return view('pengajuan-kredit.detail-pengajuan-jawaban', $param);
        } elseif (auth()->user()->role == 'PBP') {
            $param['pageTitle'] = "Dashboard";
            $param['dataAspek'] = ItemModel::where('level', 1)->where('nama', '!=','Data Umum')->get();
            $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                                ->where('p.id', $id)
                                ->where('nama', 'SLIK')
                                ->first();
            $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=','Data Umum')->first();

            $param['dataUmumNasabah'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.tanggal_review_pbp',
                'calon_nasabah.id as id_calon_nasabah',
                'calon_nasabah.nama',
                'calon_nasabah.alamat_rumah',
                'calon_nasabah.alamat_usaha',
                'calon_nasabah.no_ktp',
                'calon_nasabah.tempat_lahir',
                'calon_nasabah.tanggal_lahir',
                'calon_nasabah.status',
                'calon_nasabah.sektor_kredit',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.jumlah_kredit',
                'calon_nasabah.tujuan_kredit',
                'calon_nasabah.jaminan_kredit',
                'calon_nasabah.hubungan_bank',
                'calon_nasabah.hubungan_bank',
                'calon_nasabah.verifikasi_umum',
                'calon_nasabah.id_kabupaten',
                'calon_nasabah.id_kecamatan',
                'calon_nasabah.id_desa',
                'calon_nasabah.tenor_yang_diminta',
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->find($id);
            $param['allKab'] = Kabupaten::get();
            $param['allKec'] = Kecamatan::where('id_kabupaten', $param['dataUmumNasabah']->id_kabupaten)->get();
            $param['allDesa'] = Desa::where('id_kecamatan', $param['dataUmumNasabah']->id_kecamatan)->get();
            $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia')
                ->find($id);
            $param['pendapatDanUsulanStaf'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff')->first();
            $param['pendapatDanUsulanPenyelia'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_penyelia')->first();
            $param['pendapatDanUsulanPBP'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_pbp')->first();

            return view('pengajuan-kredit.detail-pengajuan-jawaban-pbp', $param);
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // insert komentar
    public function getInsertKomentar(Request $request)
    {
        if (Auth::user()->role == 'PBP') {
            try {
                $finalArray = array();
                $finalArray_text = array();
    
                foreach ($request->skor_pbp as $key => $value) {
                    if ($value != '' || $value != null) {
                        array_push($finalArray, [
                            'skor_pbp' => $value
                        ]);
                    }
                };
                // return $finalArray;
                $sum_select = array_sum($request->skor_pbp);
                // $sum_text = array_sum($request->skor_penyelia_text);
                $average = ($sum_select) / count($request->skor_pbp);
                // return $average;
                $result = round($average, 2);
                $status = "";
                $updateData = PengajuanModel::find($request->id_pengajuan);
                if ($result > 0 && $result <= 1) {
                    $status = "merah";
                } elseif ($result >= 2 && $result <= 3) {
                    $status = "kuning";
                } elseif ($result > 3) {
                    $status = "hijau";
                } else {
                    $status = "merah";
                }
    
                foreach ($request->get('id_option') as $key => $value) {
                    JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $request->get('id_pengajuan'))
                    ->update([
                        'skor_pbp' => $request->get('skor_pbp')[$key]
                    ]);
                }
                $updateData->status = $status;
                $updateData->average_by_pbp = $result;
                $updateData->update();
    
                $idKomentar = KomentarModel::where('id_pengajuan', $request->id_pengajuan)->first();
                KomentarModel::where('id', $idKomentar->id)->update(
                    [
                        'komentar_pbp' => $request->komentar_pbp_keseluruhan,
                        'id_pbp' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
    
                $countDK = DetailKomentarModel::where('id_komentar', $idKomentar->id)->where('id_user', Auth::user()->id)->count();
                if ($countDK > 0) {
                    foreach ($request->id_item as $key => $value) {
                        $dk = DetailKomentarModel::where('id_komentar', $idKomentar->id)->where('id_user', Auth::user()->id)->where('id_item', $value)->first();
                        $dk->komentar = $_POST['komentar_pbp'][$key];
                        $dk->save();
                    }
                } else {
                    foreach ($request->id_item as $key => $value) {
                        $dk = new DetailKomentarModel;
                        $dk->id_komentar = $idKomentar->id;
                        $dk->id_user = Auth::user()->id;
                        $dk->id_item = $value;
                        $dk->komentar = $_POST['komentar_pbp'][$key];
                        $dk->save();
                    }
                }
    
                // pendapat penyelia
                $countpendapat = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_pbp', Auth::user()->id)->count();
                if($countpendapat > 0){
                    foreach ($request->get('id_aspek') as $key => $value) {
                        $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_aspek', $value)->where('id_pbp', Auth::user()->id)->first();
                        $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_per_aspek'][$key];
                        $pendapatperaspekpenyelia->save();
                    }
                } else {
                    foreach ($request->get('id_aspek') as $key => $value) {
                        $pendapatperaspekpenyelia = new PendapatPerAspek;
                        $pendapatperaspekpenyelia->id_pengajuan = $request->get('id_pengajuan');
                        $pendapatperaspekpenyelia->id_pbp = Auth::user()->id;
                        $pendapatperaspekpenyelia->id_aspek = $value;
                        $pendapatperaspekpenyelia->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                        $pendapatperaspekpenyelia->save();
                    }
                }
                return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil Mereview');
            } catch (Exception $e) {
                // return $e;
                return redirect()->back()->withError('Terjadi kesalahan.'. $e->getMessage());
            } catch (QueryException $e) {
                // return $e;
                return redirect()->back()->withError('Terjadi kesalahan.'. $e->getMessage());
            }
        } else {
            try {
                $finalArray = array();
                $finalArray_text = array();
    
                foreach ($request->skor_penyelia as $key => $value) {
                    if ($value != '' || $value != null) {
                        array_push($finalArray, [
                            'skor_penyelia' => $value
                        ]);
                    }
                };
                // return $finalArray;
                $sum_select = array_sum($request->skor_penyelia);
                // $sum_text = array_sum($request->skor_penyelia_text);
                $average = ($sum_select) / count($request->skor_penyelia);
                // return $average;
                $result = round($average, 2);
                $status = "";
                $updateData = PengajuanModel::find($request->id_pengajuan);
                if ($result > 0 && $result <= 1) {
                    $status = "merah";
                } elseif ($result >= 2 && $result <= 3) {
                    $status = "kuning";
                } elseif ($result > 3) {
                    $status = "hijau";
                } else {
                    $status = "merah";
                }
    
                foreach ($request->get('id_option') as $key => $value) {
                    JawabanPengajuanModel::where('id_jawaban', $value)->where('id_pengajuan', $request->get('id_pengajuan'))
                    ->update([
                        'skor_penyelia' => $request->get('skor_penyelia')[$key]
                    ]);
                }
                $updateData->status = $status;
                $updateData->average_by_penyelia = $result;
                $updateData->update();
    
                $idKomentar = KomentarModel::where('id_pengajuan', $request->id_pengajuan)->first();
                KomentarModel::where('id', $idKomentar->id)->update(
                    [
                        'komentar_penyelia' => $request->komentar_penyelia_keseluruhan,
                        'id_penyelia' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                );
    
                $countDK = DetailKomentarModel::where('id_komentar', $idKomentar->id)->count();
                if ($countDK > 0) {
                    foreach ($request->id_item as $key => $value) {
                        $dk = DetailKomentarModel::where('id_komentar', $idKomentar->id)->where('id_user', Auth::user()->id)->where('id_item', $value)->first();
                        $dk->komentar = $_POST['komentar_penyelia'][$key];
                        $dk->save();
                    }
                } else {
                    foreach ($request->id_item as $key => $value) {
                        $dk = new DetailKomentarModel;
                        $dk->id_komentar = $idKomentar->id;
                        $dk->id_user = Auth::user()->id;
                        $dk->id_item = $value;
                        $dk->komentar = $_POST['komentar_penyelia'][$key];
                        $dk->save();
                    }
                }
    
                // pendapat penyelia
                $countpendapat = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_penyelia', Auth::user()->id)->count();
                if($countpendapat > 0){
                    foreach ($request->get('id_aspek') as $key => $value) {
                        $pendapatperaspekpenyelia = PendapatPerAspek::where('id_pengajuan', $request->get('id_pengajuan'))->where('id_aspek', $value)->where('id_penyelia', Auth::user()->id)->first();
                        $pendapatperaspekpenyelia->pendapat_per_aspek = $_POST['pendapat_per_aspek'][$key];
                        $pendapatperaspekpenyelia->save();
                    }
                } else {
                    foreach ($request->get('id_aspek') as $key => $value) {
                        $pendapatperaspekpenyelia = new PendapatPerAspek;
                        $pendapatperaspekpenyelia->id_pengajuan = $request->get('id_pengajuan');
                        $pendapatperaspekpenyelia->id_penyelia = Auth::user()->id;
                        $pendapatperaspekpenyelia->id_aspek = $value;
                        $pendapatperaspekpenyelia->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                        $pendapatperaspekpenyelia->save();
                    }
                }
                return redirect()->route('pengajuan-kredit.index')->withStatus('Berhasil Mereview');
            } catch (Exception $e) {
                // return $e;
                return redirect()->back()->withError('Terjadi kesalahan.'. $e->getMessage());
            } catch (QueryException $e) {
                // return $e;
                return redirect()->back()->withError('Terjadi kesalahan.'. $e->getMessage());
            }
        }
        
        // return $request->skor_penyelia;
    }

    // check status penyelia data pengajuan
    public function checkPenyeliaKredit($id)
    {
        try {
            $statusPenyelia = PengajuanModel::find($id);
            $statusPenyelia->posisi = "Review Penyelia";
            if($statusPenyelia->tanggal_review_penyelia == null){
                $statusPenyelia->tanggal_review_penyelia = date(now());
            }
            $statusPenyelia->update();
            return redirect()->back()->withStatus('Berhasil mengganti posisi.');
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }

    // check status pincab
    public function checkPincab($id)
    {
        if (auth()->user()->role == 'Penyelia Kredit') {
            if (auth()->user()->id_cabang == '1') {
                $dataPenyelia = PengajuanModel::find($id);
                $status = $dataPenyelia->status;
                if ($status != null) {
                    $dataPenyelia->tanggal_review_pbp = date(now());
                    $dataPenyelia->posisi = "PBP";
                    $dataPenyelia->update();
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    return redirect()->back()->withError('Belum di review Penyelia.');
                }
            } else {
                $dataPenyelia = PengajuanModel::find($id);
                $status = $dataPenyelia->status;
                if ($status != null) {
                    $dataPenyelia->tanggal_review_pincab = date(now());
                    $dataPenyelia->posisi = "Pincab";
                    $dataPenyelia->update();
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    return redirect()->back()->withError('Belum di review Penyelia.');
                }
            }
        } elseif (auth()->user()->role == 'PBP') {
            $dataPenyelia = PengajuanModel::find($id);
            $status = $dataPenyelia->average_by_pbp;
                if ($status != null) {
                    $dataPenyelia->tanggal_review_pincab = date(now());
                    $dataPenyelia->posisi = "Pincab";
                    $dataPenyelia->update();
                    return redirect()->back()->withStatus('Berhasil mengganti posisi.');
                } else {
                    return redirect()->back()->withError('Belum di review PBP.');
                }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // check status pincab
    public function checkPincabStatus()
    {
        if (auth()->user()->role == "Pincab") {
            $param['pageTitle'] = "Dashboard";
            $id_cabang = Auth::user()->id_cabang;
            $param['data_pengajuan'] = PengajuanModel::select(
                'pengajuan.id',
                'pengajuan.tanggal',
                'pengajuan.posisi',
                'pengajuan.status',
                'pengajuan.status_by_sistem',
                'pengajuan.id_cabang',
                'pengajuan.average_by_sistem',
                'pengajuan.average_by_penyelia',
                'calon_nasabah.nama',
                'calon_nasabah.jenis_usaha',
                'calon_nasabah.id_pengajuan'
            )
                ->join('calon_nasabah', 'calon_nasabah.id_pengajuan', 'pengajuan.id')
                ->where('pengajuan.id_cabang', $id_cabang)
                ->get();
            return view('pengajuan-kredit.komentar-pincab-pengajuan', $param);
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    public function checkPincabStatusDetail($id)
    {

        $param['pageTitle'] = "Dashboard";
        // $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->get();
        $param['dataAspek'] = ItemModel::select('*')->where('level', 1)->where('nama','!=','Data Umum')->get();
        $param['itemSlik'] = ItemModel::join('option as o', 'o.id_item', 'item.id')
                                ->join('jawaban as j', 'j.id_jawaban', 'o.id')
                                ->join('pengajuan as p', 'p.id', 'j.id_pengajuan')
                                ->where('p.id', $id)
                                ->where('nama', 'SLIK')
                                ->first();
        $param['itemSP'] = ItemModel::where('level', 1)->where('nama', '=','Data Umum')->first();
        // $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();
        $param['dataNasabah'] = CalonNasabah::select('calon_nasabah.*', 'kabupaten.id as kabupaten_id', 'kabupaten.kabupaten', 'kecamatan.id as kecamatan_id', 'kecamatan.id_kabupaten', 'kecamatan.kecamatan', 'desa.id as desa_id', 'desa.id_kabupaten', 'desa.id_kecamatan', 'desa.desa')
            ->join('kabupaten', 'kabupaten.id', 'calon_nasabah.id_kabupaten')
            ->join('kecamatan', 'kecamatan.id', 'calon_nasabah.id_kecamatan')
            ->join('desa', 'desa.id', 'calon_nasabah.id_desa')
            ->where('calon_nasabah.id_pengajuan', $id)
            ->first();
        $param['dataUmum'] = PengajuanModel::select('pengajuan.id', 'pengajuan.tanggal', 'pengajuan.posisi', 'pengajuan.tanggal_review_penyelia', 'pengajuan.id_cabang')
            ->find($id);
        $param['comment'] = KomentarModel::where('id_pengajuan', $id)->first();
        // $param['jawabanpengajuan'] = JawabanPengajuanModel::select('jawaban.id','jawaban.id_pengajuan','jawaban.id_jawaban','jawaban.skor','option.id as id_option','option.option as name_option','option.id_item','item.id as id_item','item.nama','item.level','item.id_parent')
        //                             ->join('option','option.id','jawaban.id_jawaban')
        //                             ->join('item','item.id','option.id_item')
        //                             ->where('jawaban.id_pengajuan',$id)
        //                             ->get();
        $param['pendapatDanUsulan'] = KomentarModel::where('id_pengajuan', $id)->select('komentar_staff', 'komentar_penyelia','komentar_pincab','komentar_pbp')->first();

        return view('pengajuan-kredit.detail-komentar-pengajuan', $param);
    }
    public function checkPincabStatusDetailPost(Request $request)
    {
        try {
            $idKomentar = KomentarModel::where('id_pengajuan', $request->id_pengajuan)->first();
            KomentarModel::where('id', $idKomentar->id)->update(
                [
                    'komentar_pincab' => $request->komentar_pincab,
                    'id_pincab' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );

            return redirect('/pengajuan-kredit')->withStatus('Berhasil menambahkan komentar');
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }
    public function checkPincabStatusChange($id)
    {
        $statusPincab = PengajuanModel::find($id);
        $komentarPincab = KomentarModel::where('id_pengajuan',$id)->first();
        if (auth()->user()->role == 'Pincab') {
            if ($komentarPincab->komentar_pincab != null) {
                $statusPincab->posisi = "Selesai";
                $statusPincab->tanggal_review_pincab = date(now());
                $statusPincab->update();
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Pincab.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    public function checkPincabStatusChangeTolak($id)
    {
        $statusPincab = PengajuanModel::find($id);
        $komentarPincab = KomentarModel::where('id_pengajuan',$id)->first();
        if (auth()->user()->role == 'Pincab') {
            if ($komentarPincab->komentar_pincab != null) {
                $statusPincab->posisi = "Ditolak";
                $statusPincab->tanggal_review_pincab = date(now());
                $statusPincab->update();
                return redirect()->back()->withStatus('Berhasil mengganti posisi.');
            } else {
                return redirect()->back()->withError('Belum di review Pincab.');
            }
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }
    // check status staf analisa
    public function checkStafAnalisa($id)
    {
        if (auth()->user()->role == 'Staf Analis Kredit ') {
            $statusPenyelia = PengajuanModel::find($id);
            $statusPenyelia->posisi = "Review Penyelia";
            $statusPenyelia->update();
            return redirect()->back()->withStatus('Berhasil mengganti posisi.');
        } else {
            return redirect()->back()->withError('Tidak memiliki hak akses.');
        }
    }

    public function storeAspekPenyelia(Request $request)
    {

        DB::beginTransaction();
        try {

            // pendapat penyelia
            foreach ($request->get('id_aspek') as $key => $value) {
                $addPendapat = new PendapatPerAspek;
                $addPendapat->id_pengajuan = $request->get('id_pengajuan');
                $addPendapat->id_penyelia = Auth::user()->id;
                $addPendapat->id_aspek = $value;
                $addPendapat->pendapat_per_aspek = $request->get('pendapat_per_aspek')[$key];
                $addPendapat->save();
            }

            // komentar penyelia
            $idKomentar = KomentarModel::where('id_pengajuan', $request->get('id_pengajuan'))->first();
            foreach ($request->id_item as $key => $value){
                $addDetailKomentar = new DetailKomentarModel;
                $addDetailKomentar->id_komentar = $idKomentar->id;
                $addDetailKomentar->id_user = Auth::user()->id;
                $addDetailKomentar->id_item = $value;
                $addDetailKomentar->komentar = $_POST['komentar_penyelia'][$key];
                $addDetailKomentar->save();
            }
            KomentarModel::where('id', $idKomentar->id)->update(
                [
                    'komentar_penyelia' => $request->get('komentar_penyelia_keseluruhan'),
                    'id_penyelia' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );

            // skor penyelia
            // foreach ($request->id_jawaban as $key => $value){
            //     $detail = [
            //         'id_pengajuan' => $request->id_pengajuan,
            //         'id_jawaban' => $value,
            //         // 'skor' => $request->get('product_code')[$key],
            //         'skor_penyelia' => $request->get('skor_penyelia')[$key],
            //         'created_at' => date("Y-m-d H:i:s"),
            //     ];
            //     DB::table('jawaban')->insert($detail);
            // }
        // return redirect()->route('pengajuan-kredit.index')->withStatus('Data berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.'.$e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan'.$e->getMessage());
        }
    }

    public function partial(Request $request) {
        $find = array('.');
        DB::beginTransaction();
        try {
            $addPengajuan = new PengajuanModel;
            $addPengajuan->tanggal = date(now());
            $addPengajuan->progress_pengajuan_data = $request->progress;
            $addPengajuan->save();
            $id_pengajuan = $addPengajuan->id;

            $addData = new CalonNasabah;
            $addData->nama = $request->name;
            $addData->alamat_rumah = $request->alamat_rumah;
            $addData->alamat_usaha = $request->alamat_usaha;
            $addData->no_ktp = $request->no_ktp;
            $addData->tempat_lahir = $request->tempat_lahir;
            $addData->tanggal_lahir = $request->tanggal_lahir;
            $addData->status = $request->status;
            $addData->sektor_kredit = $request->sektor_kredit;
            $addData->jenis_usaha = $request->jenis_usaha;
            $addData->jumlah_kredit = str_replace($find,"",$request->jumlah_kredit);
            $addData->tenor_yang_diminta = $request->tenor_yang_diminta;
            $addData->tujuan_kredit = $request->tujuan_kredit;
            $addData->jaminan_kredit = $request->jaminan;
            $addData->hubungan_bank = $request->hubungan_bank;
            $addData->verifikasi_umum = $request->hasil_verifikasi;
            $addData->id_user = auth()->user()->id;
            $addData->id_pengajuan = $id_pengajuan;
            $addData->id_desa = $request->desa;
            $addData->id_kecamatan = $request->kec;
            $addData->id_kabupaten = $request->kabupaten;
            $addData->save();
            $id_calon_nasabah = $addData->id;

            //untuk jawaban yg teks, number, persen, long text
            foreach ($request->id_level as $key => $value) {
                $dataJawabanText = new JawabanTextModel;
                $dataJawabanText->id_pengajuan = $id_pengajuan;
                $dataJawabanText->id_jawaban = $request->get('id_level')[$key];
                $dataJawabanText->opsi_text = str_replace($find,'',$request->get('informasi')[$key]);
                // $dataJawabanText->opsi_text = $request->get('informasi')[$key] == null ? '-' : $request->get('informasi')[$key];
                $dataJawabanText->save();
            }
        } catch (Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return redirect()->route('pengajuan-kredit.index')->withError('Terjadi kesalahan.'.$e->getMessage());
        } catch (QueryException $e) {
            DB::rollBack();
            // return $e->getMessage();
            return redirect()->route('pengajuan-kredit.index')->withError('Terjadi kesalahan'.$e->getMessage());
        }
    }
    
    public function backToInputProses($id)
    {
        try {
            $statusPenyelia = PengajuanModel::find($id);
            $statusPenyelia->posisi = "Proses Input Data";
            $statusPenyelia->update();
            return redirect()->back()->withStatus('Berhasil mengganti posisi.');
        } catch (Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan');
        }
    }
}
