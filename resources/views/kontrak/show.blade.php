@extends('layouts.template')

@section('content')
  <div class="row">
    <!-- Data Mitra -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="card-title">Data Mitra</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <th style="width:200px;">Nama Lengkap</th>
                <td>{{ $kontrak->mitra->nama_lengkap }}</td>
              </tr>
              <tr>
                <th>NMS</th>
                <td>{{ $kontrak->mitra->nms }}</td>
              </tr>
              <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $kontrak->mitra->jenis_kelamin ?? '-' }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ $kontrak->mitra->alamat ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Data Kontrak -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="card-title">Data Kontrak</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <th style="width:200px;">Tanggal Kontrak</th>
                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal_kontrak)->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th>Tanggal Surat</th>
                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal_surat)->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th>Tanggal BAST</th>
                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal_bast)->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th>Keterangan</th>
                <td>{{ $kontrak->keterangan ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          <a href="{{ route('kontrak.index') }}" class="btn btn-secondary">Kembali</a>
          <a href="{{ route('kontrak.edit', $kontrak->id) }}" class="btn btn-primary">Edit</a>
        </div>
      </div>
    </div>
  </div>
@endsection
