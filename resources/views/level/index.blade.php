@extends('layouts.template') @section('content') <div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $page->title }}</h3>
		<div class="card-tools">
			<a href="{{ url('/level/export_excel') }}" class="btn btn-sm btn-primary"><i class="fa fa-file-excel"></i> Export Level</a>
			<button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-sm btn-info">Import Level</button>
			<button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
		</div>
	</div>
	<div class="card-body">
		<div class="card-body">
			@if (session('success'))
				<div class="alert alert-success">{{ session('success') }}</div>
			@endif
			@if (session('error'))
				<div class="alert alert-danger">{{ session('error') }}</div>
			@endif
		</div>
		<table class="table table-bordered table-striped table-hover table-sm" id="table_level">
			<thead>
				<tr>
					<th>ID</th>
					<th>Kode</th>
					<th>Nama</th>
					<th>Aksi</th>
				</tr>
			</thead>
		</table>
	</div>
	<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
</div> @endsection @push('css') @endpush @push('js') 
<script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
		var dataLevel;
	$(document).ready(function() {
		 dataLevel = $('#table_level').DataTable({
			// serverSide: true, jika ingin menggunakan server side processing
			serverSide: true,
			ajax: {
				"url": "{{ url('level/list') }}",
				"dataType": "json",
				"type": "POST"
			},
			columns: [{ // nomor urut dari laravel datatable addIndexColumn()
				data: "DT_RowIndex",
				className: "text-center",
				orderable: false,
				searchable: false
			}, {
				data: "level_kode",
				className: "",
				// orderable: true, jika ingin kolom ini bisa diurutkan
				orderable: true,
				// searchable: true, jika ingin kolom ini bisa dicari
				searchable: true
			}, {
				data: "level_nama",
				className: "",
				orderable: true,
				searchable: true
			}, {
				data: "aksi",
				className: "",
				orderable: false,
				searchable: false
			}]
		});
	});
</script> @endpush