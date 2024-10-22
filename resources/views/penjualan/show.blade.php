@extends('layouts.template') @section('content') <div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $page->title }}</h3>
		<div class="card-tools"></div>
	</div>
	<div class="card-body"> @empty($penjualan) <div class="alert alert-danger alert-dismissible">
			<h5>
				<i class="icon fas fa-ban"></i> Kesalahan!
			</h5> Data yang Anda cari tidak ditemukan.
		</div> @else <table class="table table-bordered table-striped table-hover table-sm">
			<tr>
				<th>ID</th>
				<td>{{ $penjualan->penjualan_id }}</td>
			</tr>
			<tr>
				<th>penjualan</th>
				<td>{{ $penjualan->penjualan->penjualan_nama }}</td>
			</tr>
			<tr>
				<th>Kode</th>
				<td>{{ $penjualan->penjualan_kode }}</td>
			</tr>
			<tr>
				<th>Nama</th>
				<td>{{ $penjualan->penjualan_nama }}</td>
			</tr>
			<tr>
				<th>Harga Beli</th>
				<td>{{ $penjualan->harga_beli }}</td>
			</tr>
			<tr>
				<th>Harga Jual</th>
				<td>{{ $penjualan->harga_jual }}</td>
			</tr>
			
		</table> @endempty <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
	</div>
</div> @endsection @push('css') @endpush @push('js') @endpush