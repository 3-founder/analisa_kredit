@extends('layouts.template')
@section('content')
    @include('components.notification')

    <style>
        .sub label:not(.info) {
            font-weight: 400;
        }

        h4 {
            color: #1f1d62;
            font-weight: 600 !important;
            font-size: 20px;
            /* border-bottom: 1px solid #dc3545; */
        }

        h5 {
            color: #1f1d62;
            font-weight: 600 !important;
            font-size: 18px;
            /* border-bottom: 1px solid #dc3545; */
        }

        .form-wizard h6 {
            color: #c2c7cf;
            font-weight: 600 !important;
            font-size: 16px;
            /* border-bottom: 1px solid #dc3545; */
        }

    </style>
    <div class="">
        <form action="{{ route('pengajuan.check.pincab.status.detail.post') }}" method="POST">
            @csrf

            {{-- calon nasabah --}}
            <div class="card">
                <div class="card-header bg-info color-white font-weight-bold" data-toggle="collapse" href="#cardDataUmum">
                    Data Umum
                </div>
                <div class="card-body collapse multi-collapse show" id="cardDataUmum">
                    @php
                        $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemSP->id)
                        ->where('nama', 'Surat Permohonan')
                        ->get();
                    @endphp
                    @foreach ($dataLevelDua as $item)
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                ->where('jawaban_text.id_jawaban', $item->id)
                                ->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextDua)
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ $item->nama }}</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    @php
                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                    @endphp
                                    @if ($file_parts['extension'] == 'pdf')
                                        <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="600px"></iframe>
                                    @else
                                        <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="600px">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->nama }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        {{-- alamat rumah --}}
                        <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Rumah</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->alamat_rumah }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        {{-- alamat usaha --}}
                        <label for="staticEmail" class="col-sm-3 col-form-label">Alamat Usaha</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->alamat_usaha }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        {{-- No KTP --}}
                        <label for="staticEmail" class="col-sm-3 col-form-label">No. KTP</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->no_ktp }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        {{-- Tempat tanggal lahir --}}
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tempat, Tanggal lahir/Status</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7 ">
                            <div class="d-flex justify-content-start ">
                                <div class="m-0" style="width: 100%">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $dataNasabah->tempat_lahir . ', ' . date('d-m-Y', strtotime($dataNasabah->tanggal_lahir)) . '/' . $dataNasabah->status}}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Sektor Kredit</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->sektor_kredit }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="slik" class="col-sm-3 col-form-label">SLIK</label>
                        <label for="slik" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $itemSlik->option }}">
                        </div>
                    </div>
                    @php
                        $komentarSlikPenyelia = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                            ->where('id_pengajuan', $dataUmum->id)
                            ->where('id_item', $itemSlik->id_item)
                            ->where('id_user', $comment->id_penyelia)
                            ->first();
                        if ($dataUmum->id_cabang == 1) {
                            $komentarSlikPBP = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', '=', 'detail_komentar.id_komentar')
                                ->where('id_pengajuan', $dataUmum->id)
                                ->where('id_item', $itemSlik->id_item)
                                ->where('id_user', $comment->id_pbp)
                                ->first();
                        }
                    @endphp
                        <div class="row form-group sub pl-4">
                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">

                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <div class="d-flex">
                                    <div class="">
                                        <p><strong>Skor : </strong></p>
                                    </div>
                                    <div class="px-2">


                                        <p class="badge badge-info text-lg"><b>
                                                {{ $itemSlik->skor_penyelia != null ? $itemSlik->skor_penyelia : $itemSlik->skor }}</b></p>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="row form-group sub pl-4">
                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">

                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <div class="d-flex">
                                    <div style="width: 30%">
                                        <p class="p-0 m-0"><strong>Komentar Penyelia : </strong></p>
                                    </div>
                                    <h6 class="font-italic">{{ $komentarSlikPenyelia->komentar }}</h6>
                                    {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                </div>
                            </div>
                        </div>
                        @if ($dataUmum->id_cabang == 1)
                            <div class="row form-group sub pl-4">
                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">

                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    <div class="d-flex">
                                        <div style="width: 30%">
                                            <p class="p-0 m-0"><strong>Komentar PBP : </strong></p>
                                        </div>
                                        <h6 class="font-italic">{{ $komentarSlikPBP->komentar }}</h6>
                                        {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                    </div>
                                </div>
                            </div>
                        @endif
                    
                    @php
                        $dataLaporanSLIK = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemSP->id)
                        ->where('nama', 'Laporan SLIK')
                        ->get();
                    @endphp
                    @foreach ($dataLaporanSLIK as $item)
                        @php
                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'item.id as id_item', 'item.nama')
                                ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                ->where('jawaban_text.id_jawaban', $item->id)
                                ->get();
                        @endphp
                        @foreach ($dataDetailJawabanText as $itemTextDua)
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">{{ $item->nama }}</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    @php
                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                    @endphp
                                    @if ($file_parts['extension'] == 'pdf')
                                        <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="700px"></iframe>
                                    @else
                                        <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="700px">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Usaha</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->jenis_usaha }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jumlah Kredit yang diminta </label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="Rp.{{ number_format($dataNasabah->jumlah_kredit, 2, '.', ',') }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tenor yang diminta </label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{$dataNasabah->tenor_yang_diminta}} tahun">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Tujuan Kredit</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->tujuan_kredit }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Jaminan yang disediakan</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->jaminan_kredit }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Hubungan dengan Bank</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->hubungan_bank }}">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Hasil Verifikasi Karakter Umum</label>
                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                            <div class="d-flex justify-content-end">
                                <div style="width: 20px">
                                    :
                                </div>
                            </div>
                        </label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $dataNasabah->verifikasi_umum }}">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {{-- aspek management --}}
            @foreach ($dataAspek as $itemAspek)
                @php
                    // check level 2
                    $dataLevelDua = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 2)
                        ->where('id_parent', $itemAspek->id)
                        ->get();
                    // check level 4
                    $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent', 'status_skor', 'is_commentable')
                        ->where('level', 4)
                        ->where('id_parent', $itemAspek->id)
                        ->get();
                @endphp
                <div class="card mb-3">
                    <div class="card-header bg-info font-weight-bold color-white" data-toggle="collapse"
                        href="#cardData{{ $loop->iteration }}">
                        {{ $itemAspek->nama }}
                    </div>
                    <div class="card-body collapse multi-collapse" id="cardData{{ $loop->iteration }}">
                        @foreach ($dataLevelDua as $item)
                            @if ($item->opsi_jawaban != 'option')
                                @php
                                    $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.status_skor', 'item.is_commentable')
                                        ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                        ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                        ->where('jawaban_text.id_jawaban', $item->id)
                                        ->get();
                                @endphp
                                @foreach ($dataDetailJawabanText as $itemTextDua)
                                    @php
                                        $getKomentar = \App\Models\DetailKomentarModel::select('detail_komentar.id', 'detail_komentar.id_komentar', 'detail_komentar.id_user', 'detail_komentar.id_item', 'detail_komentar.komentar')
                                            ->where('detail_komentar.id_item', $itemTextDua->id_item)
                                            ->get();
                                    @endphp

                                    <div class="row form-group sub pl-4">
                                        <label for="staticEmail"
                                            class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            @if ($item->opsi_jawaban == 'file')
                                            <br>
                                                @php
                                                    $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text);
                                                @endphp
                                                @if ($file_parts['extension'] == 'pdf')
                                                    <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" width="100%" height="700px"></iframe>
                                                @else    
                                                    <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextDua->opsi_text }}" alt="" width="700px">
                                                @endif
                                            @else
                                                <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                                    id="staticEmail" value="{{ $itemTextDua->opsi_text }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}} {{$item->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                            @endif
                                        </div>
                                    </div>
                                    @if ($itemTextDua->status_skor == 1)
                                        <div class="p-3">
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="d-flex">
                                                        <div class="">
                                                            <p><strong>Skor : </strong></p>
                                                        </div>
                                                        <div class="px-2">


                                                            <p class="badge badge-info text-lg"><b>
                                                                    {{ $itemTextDua->skor_penyelia }}</b></p>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @if ($itemTextDua->is_commentable != null)
                                                @foreach ($getKomentar as $itemKomentar)
                                                    <div class="row form-group sub pl-4">
                                                        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                            <div class="d-flex justify-content-end">
                                                                <div style="width: 20px">

                                                                </div>
                                                            </div>
                                                        </label>
                                                        <div class="col-sm-7">
                                                            <div class="d-flex">
                                                                <div style="width: 15%">
                                                                    <p class="p-0 m-0"><strong>Komentar : </strong>
                                                                    </p>
                                                                </div>
                                                                <h6 class="font-italic">{{ $itemKomentar->komentar }}
                                                                </h6>
                                                                {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                    @if ($item->nama == 'Repayment Capacity')
                                    @else
                                        <hr>
                                    @endif
                                @endforeach
                            @endif
                            @php
                                $dataJawaban = \App\Models\OptionModel::where('option', '!=', '-')
                                    ->where('id_item', $item->id)
                                    ->get();
                                $dataOption = \App\Models\OptionModel::where('option', '=', '-')
                                    ->where('id_item', $item->id)
                                    ->get();

                                // check level 3
                                $dataLevelTiga = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent')
                                    ->where('level', 3)
                                    ->where('id_parent', $item->id)
                                    ->get();
                            @endphp
                            @if ($item->id_parent == 10 && $item->nama != 'Hubungan Dengan Supplier')
                                <div class="row form-group sub pl-4">
                                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                </div>
                                <hr>
                            @endif
                            @if (count($dataJawaban) != 0)
                                @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi' || $item->nama == 'Repayment Capacity Opsi')

                                @else
                                    <div class="row form-group sub pl-4">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $item->nama }}</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            @foreach ($dataJawaban as $key => $itemJawaban)
                                                @php
                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                        ->where('id_pengajuan', $dataUmum->id)
                                                        ->get();
                                                    $count = count($dataDetailJawaban);
                                                    for ($i = 0; $i < $count; $i++) {
                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                    }
                                                @endphp
                                                @if (in_array($itemJawaban->id, $data))
                                                    @if (isset($data))
                                                        <input type="text" readonly
                                                            class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                            value="{{ $itemJawaban->option }}">
                                                        <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi')
                                
                                @else
                                    <div class="row form-group sub pl-4">
                                        <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">

                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            @foreach ($dataJawaban as $key => $itemJawaban)
                                                @php
                                                    $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                        ->where('id_pengajuan', $dataUmum->id)
                                                        ->get();
                                                    $count = count($dataDetailJawaban);
                                                    for ($i = 0; $i < $count; $i++) {
                                                        $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                    }
                                                @endphp
                                                @if (in_array($itemJawaban->id, $data))
                                                    @if (isset($data))
                                                        @php
                                                            $dataDetailJawabanskor = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->where('id_jawaban', $itemJawaban->id)
                                                                ->get();
                                                            $getKomentarPenyelia = \App\Models\DetailKomentarModel::select('detail_komentar.*')
                                                                ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                ->where('detail_komentar.id_komentar', $comment->id)
                                                                ->where('detail_komentar.id_item', $item->id)
                                                                ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                ->get();
                                                            if ($dataUmum->id_cabang == 1) {
                                                                $getKomentarPBP = \App\Models\DetailKomentarModel::select('detail_komentar.*')
                                                                    ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                    ->where('detail_komentar.id_komentar', $comment->id)
                                                                    ->where('detail_komentar.id_item', $item->id)
                                                                    ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                    ->get();    
                                                            }
                                                        @endphp
                                                        @foreach ($dataDetailJawabanskor as $item)
                                                            @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                <div class="d-flex">
                                                                    <div class="">
                                                                        <p><strong>Skor : </strong></p>
                                                                    </div>
                                                                    <div class="px-2">
                                                                        <p class="badge badge-info text-lg"><b>
                                                                                {{ $item->skor_penyelia }}</b></p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @foreach ($getKomentarPenyelia as $itemKomentarPenyelia)
                                        <div class="row form-group sub pl-4">
                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
        
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="d-flex">
                                                    <div style="width: 30%">
                                                        <p class="p-0 m-0"><strong>Komentar Penyelia : </strong></p>
                                                    </div>
                                                    <h6 class="font-italic">{{ $itemKomentarPenyelia->komentar}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($dataUmum->id_cabang == 1)    
                                        @foreach ($getKomentarPBP as $itemKomentarPBP)
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
            
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="d-flex">
                                                        <div style="width: 30%">
                                                            <p class="p-0 m-0"><strong>Komentar PBP : </strong></p>
                                                        </div>
                                                        <h6 class="font-italic">{{ $itemKomentarPBP->komentar}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($item->nama == 'Persentase Kebutuhan Kredit Opsi')
                                        
                                    @else
                                        <hr>
                                    @endif
                                @endif
                            @endif
                            @foreach ($dataLevelTiga as $keyTiga => $itemTiga)
                                @if ($itemTiga->opsi_jawaban != 'option')
                                    @php
                                        $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.is_commentable', 'item.status_skor')
                                            ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                            ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                            ->where('jawaban_text.id_jawaban', $itemTiga->id)
                                            ->get();
                                        $getKomentar2 = \App\Models\DetailKomentarModel::select('*')
                                            ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                            ->where('detail_komentar.id_item', $itemTiga->id)
                                            ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                            ->get();
                                    @endphp
                                    @foreach ($dataDetailJawabanText as $itemTextTiga)
                                        @php
                                            $getKomentar2 = \App\Models\DetailKomentarModel::select('*')
                                                ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                ->where('detail_komentar.id_item', $itemTextTiga->id_item)
                                                ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                ->get();
                                        @endphp
                                        @if ($itemTextTiga->nama == 'NIB' || $itemTextTiga->nama == 'Surat Keterangan Usaha')
                                            <div class="row form-group sub pl-4">
                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">{{ $itemTextTiga->nama }}</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                        @else
                                            <div class="row form-group sub pl-5">
                                            <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemTextTiga->nama }}</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label">
                                        @endif
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
                                                        :
                                                    </div>
                                                </div>
                                            </label>
                                            @if ($itemTextTiga->nama == 'NIB' || $itemTextTiga->nama == 'Surat Keterangan Usaha')
                                                <div class="col-sm-7">
                                            @else
                                                <div class="col-sm-7" style="padding: 0px">
                                            @endif
                                                @if ($item->opsi_jawaban == 'file')
                                                <br>
                                                    @php
                                                        $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextTiga->opsi_text);
                                                    @endphp
                                                    @if ($file_parts['extension'] == 'pdf')
                                                        <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextTiga->opsi_text }}" width="100%" height="700px"></iframe>
                                                    @else   
                                                        <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $item->id . '/' . $itemTextTiga->opsi_text }}" alt="" width="700px">
                                                    @endif
                                                @else
                                                    <input type="text" readonly class="form-control-plaintext font-weight-bold"
                                                        id="staticEmail" value="{{ $itemTextTiga->opsi_text }} {{$itemTiga->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                    <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                @endif
                                            </div>
                                        </div>
                                        @if ($itemTextTiga->status_skor == 1)
                                            <div class="row form-group sub pl-5">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="d-flex">
                                                        <div class="">
                                                            <p><strong>Skor : </strong></p>
                                                        </div>
                                                        <div class="px-2">
                                                            <p class="badge badge-info text-lg">
                                                                <b>{{ $itemTextTiga->skor_penyelia }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @foreach ($getKomentar2 as $itemKomentar2)
                                            <div class="row form-group sub pl-5">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="d-flex">
                                                        <div style="width: 15%">
                                                            <p class="p-0 m-0"><strong>Komentar : </strong></p>
                                                        </div>
                                                        <h6 class="font-italic">{{ $itemKomentar2->komentar }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($itemTiga->nama == 'Ratio Coverage')
                                            
                                        @else
                                            <hr>
                                        @endif
                                    @endforeach
                                @endif
                                @php
                                    // check  jawaban level tiga
                                    $dataJawabanLevelTiga = \App\Models\OptionModel::where('option', '!=', '-')
                                        ->where('id_item', $itemTiga->id)
                                        ->get();
                                    $dataOptionTiga = \App\Models\OptionModel::where('option', '=', '-')
                                        ->where('id_item', $itemTiga->id)
                                        ->get();
                                    // check level empat
                                    $dataLevelEmpat = \App\Models\ItemModel::select('id', 'nama', 'opsi_jawaban', 'level', 'id_parent')
                                        ->where('level', 4)
                                        ->where('id_parent', $itemTiga->id)
                                        ->get();
                                @endphp

                                @if (count($dataJawabanLevelTiga) != 0)
                                    @if ($itemTiga->nama == 'Ratio Tenor Asuransi Opsi')
                                        
                                    @else
                                        @if ( $itemTiga->nama == 'Ratio Coverage Opsi')
                                            
                                        @else    
                                            <div class="row form-group sub pl-5">
                                                <label for="staticEmail"
                                                    class="col-sm-3 col-form-label">{{ $itemTiga->nama }}</label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7" style="padding: 0px">
                                                    @foreach ($dataJawabanLevelTiga as $key => $itemJawabanLevelTiga)
                                                        @php
                                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->get();
                                                            $count = count($dataDetailJawaban);
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                            }
                                                        @endphp
                                                        @if (in_array($itemJawabanLevelTiga->id, $data))
                                                            @if (isset($data))
                                                                <input type="text" readonly
                                                                    class="form-control-plaintext font-weight-bold"
                                                                    id="staticEmail" value="{{ $itemJawabanLevelTiga->option }}">
                                                                <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row form-group sub pl-4">
                                            <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">

                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col-sm-7">
                                                @foreach ($dataJawabanLevelTiga as $key => $itemJawabanTiga)
                                                    @php
                                                        $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                            ->where('id_pengajuan', $dataUmum->id)
                                                            ->get();
                                                        $count = count($dataDetailJawaban);
                                                        for ($i = 0; $i < $count; $i++) {
                                                            $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                        }
                                                    @endphp
                                                    @if (in_array($itemJawabanTiga->id, $data))
                                                        @if (isset($data))
                                                            @php
                                                                $dataDetailJawabanTiga = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                    ->where('id_pengajuan', $dataUmum->id)
                                                                    ->where('id_jawaban', $itemJawabanTiga->id)
                                                                    ->get();
                                                                $getKomentarPenyelia3 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                    ->where('id_item', $itemJawabanTiga->id_item)
                                                                    ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                    ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                    ->get();
                                                                if ($dataUmum->id_cabang == 1) {
                                                                    $getKomentarPBP3 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                        ->where('detail_komentar.id_item', $itemJawabanTiga->id_item)
                                                                        ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                        ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                        ->get();
                                                                }
                                                            @endphp
                                                            @foreach ($dataDetailJawabanTiga as $item)
                                                                @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                    <div class="d-flex">
                                                                        <div class="">
                                                                            <p><strong>Skor : </strong></p>
                                                                        </div>
                                                                        <div class="px-2">
                                                                            <p class="badge badge-info text-lg"><b>
                                                                                    {{ $item->skor_penyelia }}</b></p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @foreach ($getKomentarPenyelia3 as $itemKomentar3)
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    <div class="d-flex">
                                                        <div style="width: 30%">
                                                            <p class="p-0 m-0"><strong>Komentar Penyelia: </strong></p>
                                                        </div>
                                                        <h6 class="font-italic">{{ $itemKomentar3->komentar }}</h6>
                                                        {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                    </div>
                                                    {{-- <input type="text" readonly class="form-control-plaintext" id="komentar" value="{{ $itemKomentar3->komentar }}"> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                        @if ($dataUmum->id_cabang == 1)    
                                            @foreach ($getKomentarPBP3 as $itemKomentar3)    
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex">
                                                            <div style="width: 30%">
                                                                <p class="p-0 m-0"><strong>Komentar PBP: </strong></p>
                                                            </div>
                                                            <h6 class="font-italic">{{ $itemKomentar3->komentar }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <hr>
                                    @endif
                                @endif

                                @foreach ($dataLevelEmpat as $keyEmpat => $itemEmpat)
                                    @if ($itemEmpat->opsi_jawaban != 'option')
                                        @php
                                            $dataDetailJawabanText = \App\Models\JawabanTextModel::select('jawaban_text.id', 'jawaban_text.id_pengajuan', 'jawaban_text.id_jawaban', 'jawaban_text.opsi_text', 'jawaban_text.skor_penyelia', 'item.id as id_item', 'item.nama', 'item.is_commentable', 'item.status_skor')
                                                ->join('item', 'jawaban_text.id_jawaban', 'item.id')
                                                ->where('jawaban_text.id_pengajuan', $dataUmum->id)
                                                ->where('jawaban_text.id_jawaban', $itemEmpat->id)
                                                ->get();
                                        @endphp
                                        @foreach ($dataDetailJawabanText as $itemTextEmpat)
                                            @php
                                                $getKomentar4 = \App\Models\DetailKomentarModel::select('*')
                                                    ->join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                    ->where('id_item', $itemTextEmpat->id_item)
                                                    ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                    ->get();
                                            @endphp
                                            @if ($itemEmpat->id_parent == '95')    
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jaminan Utama</label>
                                                    {{-- @elseif ($itemEmpat->id_paret == '110')
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Jaminan Tambahan</label> --}}
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            @else
                                                <div class="row form-group sub pl-5">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemEmpat->nama }}</label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label">
                                            @endif
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                @if ($itemEmpat->id_parent == '95')
                                                    <div class="col-sm-7">
                                                @else
                                                    <div class="col-sm-7" style="padding: 0px">
                                                @endif
                                                    @if ($itemEmpat->opsi_jawaban == 'file')
                                                    <br>
                                                        @php
                                                            $file_parts = pathinfo(asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text);
                                                        @endphp
                                                        @if ($file_parts['extension'] == 'pdf')
                                                            <iframe src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}" width="100%" height="700px"></iframe>    
                                                        @else    
                                                            <img src="{{ asset('..') . '/upload/' . $dataUmum->id . '/' . $itemEmpat->id . '/' . $itemTextEmpat->opsi_text }}"
                                                                alt="" width="700px">
                                                        @endif
                                                    @else
                                                        @if ($itemEmpat->id == 101)    
                                                            <input type="text" readonly
                                                                class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                value="{{ $itemEmpat->nama . '       : ' . $itemTextEmpat->opsi_text }} {{$itemEmpat->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                        @else
                                                            <input type="text" readonly
                                                                class="form-control-plaintext font-weight-bold" id="staticEmail"
                                                                value="{{ $itemTextEmpat->opsi_text }} {{$itemEmpat->opsi_jawaban == 'persen' ? '%' : ''}}">
                                                            <input type="hidden" name="id[]" value="{{ $itemAspek->id }}">
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($itemTextEmpat->status_skor != null && $itemTextEmpat == false)
                                                <div class="row form-group sub" style="padding-left: 5rem !important">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">
                                                                :
                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex">
                                                            <div class="">
                                                                <p><strong>Skor : </strong></p>
                                                            </div>
                                                            <div class="px-2">
                                                                <p class="badge badge-info text-lg"><b>
                                                                        {{ $itemTextEmpat->skor_penyelia }}</b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($getKomentar4 as $itemKomentar4)
                                                <div class="row form-group sub" style="padding-left: 5rem !important">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex">
                                                            <div style="width: 15%">
                                                                <p class="p-0 m-0"><strong>Komentar : </strong></p>
                                                            </div>
                                                            <h6 class="font-italic">{{ $itemKomentar4->komentar }}
                                                            </h6>
                                                            {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                        </div>
                                                        {{-- <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $itemKomentar4->komentar }}"> --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                            <hr>
                                        @endforeach
                                    @endif
                                    @php
                                        // check level empat
                                        $dataJawabanLevelEmpat = \App\Models\OptionModel::where('option', '!=', '-')
                                            ->where('id_item', $itemEmpat->id)
                                            ->get();

                                        $dataOptionEmpat = \App\Models\OptionModel::where('option', '=', '-')
                                            ->where('id_item', $itemEmpat->id)
                                            ->get();
                                    @endphp
                                    {{-- Data jawaban Level Empat --}}
                                    @if (count($dataJawabanLevelEmpat) != 0)
                                        @php
                                            $dataDetailJawabanTest = \App\Models\JawabanPengajuanModel::select('jawaban.id', 'jawaban.id_pengajuan', 'jawaban.id_jawaban', 'item.id as id_item', 'item.nama', 'item.is_commentable', 'item.status_skor')
                                                ->join('option', 'option.id', 'jawaban.id_jawaban')
                                                ->join('item', 'option.id_item', 'item.id')
                                                ->where('jawaban.id_pengajuan', $dataUmum->id)
                                                ->where('option.id_item', $itemEmpat->id)
                                                ->get();
                                        @endphp
                                        @if (!$dataDetailJawabanTest->isEmpty())
                                            <div class="row form-group sub pl-4">
                                                @if ($itemEmpat->id_parent == '110')
                                                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jaminan Tambahan</label>
                                                @elseif ($itemEmpat->id_parent == '95')
                                                    <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Jaminan Utama</label>
                                                @else
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">{{ $itemEmpat->nama }}</label>
                                                @endif
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">
                                                            :
                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7" style="padding: 0px">
                                                    <label for="staticEmail" class="col-sm-4 col-form-label font-weight-bold">{{ $itemEmpat->nama }}</label>
                                                </div>
                                            </div>
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanLevelEmpat)
                                                        @php
                                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->get();
                                                            $count = count($dataDetailJawaban);
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                            }
                                                        @endphp
                                                        @if (in_array($itemJawabanLevelEmpat->id, $data))
                                                            @if (isset($data))
                                                                <input type="text" readonly
                                                                    class="form-control-plaintext font-weight-bold"
                                                                    id="staticEmail"
                                                                    value="{{ $itemJawabanLevelEmpat->option }}">
                                                                <input type="hidden" name="id[]"
                                                                    value="{{ $itemAspek->id }}">
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row form-group sub pl-4">
                                                <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                    <div class="d-flex justify-content-end">
                                                        <div style="width: 20px">

                                                        </div>
                                                    </div>
                                                </label>
                                                <div class="col-sm-7">
                                                    @php
                                                        $getKomentar5 = '';
                                                    @endphp
                                                    @foreach ($dataJawabanLevelEmpat as $key => $itemJawabanEmpat)
                                                        @php
                                                            $dataDetailJawaban = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                ->where('id_pengajuan', $dataUmum->id)
                                                                ->get();
                                                            $count = count($dataDetailJawaban);
                                                            for ($i = 0; $i < $count; $i++) {
                                                                $data[] = $dataDetailJawaban[$i]['id_jawaban'];
                                                            }
                                                        @endphp
                                                        @if (in_array($itemJawabanEmpat->id, $data))
                                                            @if (isset($data))
                                                                @php

                                                                    $dataDetailJawabanEmpat = \App\Models\JawabanPengajuanModel::select('id', 'id_jawaban', 'skor', 'skor_penyelia')
                                                                        ->where('id_pengajuan', $dataUmum->id)
                                                                        ->where('id_jawaban', $itemJawabanEmpat->id)
                                                                        ->get();
                                                                    $getKomentarPenyelia5 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                        ->where('detail_komentar.id_item', $itemJawabanEmpat->id_item)
                                                                        ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                        ->where('detail_komentar.id_user', $comment->id_penyelia)
                                                                        ->first();
                                                                    if ($dataUmum->id_cabang == 1) {
                                                                        $getKomentarPBP5 = \App\Models\DetailKomentarModel::join('komentar', 'komentar.id', 'detail_komentar.id_komentar')
                                                                        ->where('detail_komentar.id_item', $itemJawabanEmpat->id_item)
                                                                        ->where('komentar.id_pengajuan', $comment->id_pengajuan)
                                                                        ->where('detail_komentar.id_user', $comment->id_pbp)
                                                                        ->first();
                                                                    }
                                                                @endphp
                                                                @foreach ($dataDetailJawabanEmpat as $item)
                                                                    @if ($item->skor_penyelia != null && $item->skor_penyelia != '')
                                                                        <div class="d-flex">
                                                                            <div class="">
                                                                                <p><strong>Skor : </strong></p>
                                                                            </div>
                                                                            <div class="px-2">
                                                                                <p class="badge badge-info text-lg"><b>
                                                                                        {{ $item->skor_penyelia }}</b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @if ($getKomentarPenyelia5)
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex">
                                                            <div style="width: 30%">
                                                                <p class="p-0 m-0"><strong>Komentar Penyelia : </strong>
                                                                </p>
                                                            </div>
                                                            <h6 class="font-italic">
                                                                {{ $getKomentarPenyelia5->komentar }}</h6>
                                                            {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($dataUmum->id_cabang == 1)    
                                                <div class="row form-group sub pl-4">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"></label>
                                                    <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                        <div class="d-flex justify-content-end">
                                                            <div style="width: 20px">

                                                            </div>
                                                        </div>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex">
                                                            <div style="width: 30%">
                                                                <p class="p-0 m-0"><strong>Komentar PBP : </strong>
                                                                </p>
                                                            </div>
                                                            <h6 class="font-italic">
                                                                {{ $getKomentarPBP5->komentar }}</h6>
                                                            {{-- <input type="text" readonly class="form-control-plaintext font-italic" id="komentar" value="{{ $itemKomentar->komentar }}"> --}}

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <hr>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach

                        @php
                            $pendapatUsulanStaf = \App\Models\PendapatPerAspek::select('*')
                                ->where('id_staf', '!=', null)
                                ->where('id_aspek', $itemAspek->id)
                                ->where('id_pengajuan', $dataUmum->id)
                                ->get();
                            $pendapatUsulanPenyelia = \App\Models\PendapatPerAspek::select('*')
                                ->where('id_penyelia', '!=', null)
                                ->where('id_pengajuan', $dataUmum->id)
                                ->get();
                            if ($dataUmum->id_cabang == 1) {
                                $pendapatUsulanPBP = \App\Models\PendapatPerAspek::select('*')
                                    ->where('id_pbp', '!=', null)
                                    ->where('id_pengajuan', $dataUmum->id)
                                    ->get();
                            }
                        @endphp
                        {{-- @php
                    echo "<pre>"; print_r($pendapatUsulanStaf);echo "</pre>";
                @endphp --}}
                        @foreach ($pendapatUsulanStaf as $item)
                            @if ($item->id_aspek == $itemAspek->id)
                                <div class="alert alert-success">
                                    <div class="form-group row sub mb-0" style="">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                            & Usulan <br> (Staff)</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                value="{{ $item->pendapat_per_aspek }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach ($pendapatUsulanPenyelia as $item)
                            @if ($item->id_aspek == $itemAspek->id)
                                <div class="alert alert-success ">
                                    <div class="form-group row sub mb-0" style="">
                                        <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                            & Usulan <br> (Penyelia)</label>
                                        <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                            <div class="d-flex justify-content-end">
                                                <div style="width: 20px">
                                                    :
                                                </div>
                                            </div>
                                        </label>
                                        <div class="col-sm-7">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                value="{{ $item->pendapat_per_aspek }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if ($dataUmum->id_cabang == 1)    
                            @foreach ($pendapatUsulanPBP as $item)
                                @if ($item->id_aspek == $itemAspek->id)
                                    <div class="alert alert-success ">
                                        <div class="form-group row sub mb-0" style="">
                                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                                & Usulan <br> (PBP)</label>
                                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                                <div class="d-flex justify-content-end">
                                                    <div style="width: 20px">
                                                        :
                                                    </div>
                                                </div>
                                            </label>
                                            <div class="col-sm-7">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                                    value="{{ $item->pendapat_per_aspek }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="card mb-3">
                <div class="card-header bg-info color-white font-weight-bold" data-toggle="collapse" href=#cardPendapatUsulan>
                    Pendapat & Usulan
                </div>
                <div class="card-body collapse multi-collapse show" id="cardPendapatUsulan">
                    <div class="alert alert-success ">
                        <div class="form-group row sub mb-0" style="">
                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                & Usulan <br> (Staff)</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $pendapatDanUsulan->komentar_staff }}">
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-success ">
                        <div class="form-group row sub mb-0" style="">
                            <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                & Usulan <br> (Penyelia)</label>
                            <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $pendapatDanUsulan->komentar_penyelia }}">
                            </div>
                        </div>
                    </div>
                    @if ($dataUmum->id_cabang == 1)    
                        <div class="alert alert-success">
                            <div class="form-group row sub mb-0">
                                <label for="staticEmail" class="col-sm-3 col-form-label font-weight-bold">Pendapat
                                    & Usulan <br> (PBP)</label>
                                <label for="staticEmail" class="col-sm-1 col-form-label px-0">
                                    <div class="d-flex justify-content-end">
                                        <div style="width: 20px">
                                            :
                                        </div>
                                    </div>
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                        value="{{ $pendapatDanUsulan->komentar_pbp }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="alert alert-success ">
                        <div class="form-group row">
                            <label for="komentar_pincab" class="col-sm-3 col-form-label">Pendapat & Usulan Pimpinan Cabang</label>
                            <label for="komentar_pincab" class="col-sm-1 col-form-label px-0">
                                <div class="d-flex justify-content-end">
                                    <div style="width: 20px">
                                        :
                                    </div>
                                </div>
                            </label>
                            <div class="col-sm-7">
                                <input type="hidden" name="id_pengajuan" id="" value="{{ $dataUmum->id }}">
                                <textarea name="komentar_pincab" class="form-control" id="" cols="5" rows="3"
                                    placeholder="Masukkan Pendapat Pemimpin Cabang">{{ $pendapatDanUsulan->komentar_pincab }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
        </form>
    </div>
@endsection
