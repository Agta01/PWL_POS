@extends('layouts.template') 
@section('content') 
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $page->title }}</h3>
		<div class="card-tools"></div>
	</div>
	<div class="card-body">
		<form method="POST" action="{{ url('penjualan') }}" class="form-horizontal"> @csrf <div class="form-group row">
				<label class="col-1 control-label col-form-label">penjualan</label>
				<div class="col-11">
					<select class="form-control" id="penjualan_id" name="penjualan_id" required>
						<option value="">- Pilih penjualan -</option> @foreach($penjualan as $item) <option value="{{ $item->penjualan_id }}">{{ $item->penjualan_nama }}</option> @endforeach
					</select> @error('penjualan_id') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label">Kode</label>
				<div class="col-11">
					<input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="{{
old('penjualan_kode') }}" required> @error('penjualan_kode') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label">Nama</label>
				<div class="col-11">
					<input type="text" class="form-control" id="penjualan_nama" name="penjualan_nama" value="{{
old('penjualan_nama') }}" required> @error('penjualan_nama') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label">Harga Beli</label>
				<div class="col-11">
					<input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{
old('harga_beli') }}" required> @error('harga_beli') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label">Harga Jual</label>
				<div class="col-11">
					<input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{
old('harga_jual') }}" required> @error('harga_jual') <small class="form-text text-danger">{{ $message }}</small> @enderror
				</div>
			</div>
			<div class="form-group row">
				<label class="col-1 control-label col-form-label"></label>
				<div class="col-11">
					<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
					<a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
				</div>
			</div>
		</form>
	</div>
</div> 
@endsection 
@push('css') 
@endpush
@push('js') 
@endpush