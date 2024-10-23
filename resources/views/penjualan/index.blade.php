@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Penjualan</button> 
                <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>  Export Penjualan (XLSX)</a>
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export Penjualan (PDF)</a> 
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data</button> 
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($supplier as $item)
                                    <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter</small>
                        </div>
                    </div>
                </div>
            </div> --}}
            <table class="table table-border table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Nama Customer</th>
                        <th>PIC</th>
                        <th>Tanggal Penjualan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = ''){
            $('#myModal').load(url,function(){
                $('#myModal').modal('show');
            });
        }

        var dataPenjualan;
        $(document).ready(function(){
            dataPenjualan = $('#table_penjualan').DataTable({
                //serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax:{
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d){
                        d.supplier_id = $('#supplier_id').val();
                        d.barang_id = $('#barang_id').val();
                        d.user_id = $('#user_id').val();
                    }
                },
                columns:[
                    {
                        //nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },{
                        data: "penjualan_kode",
                        className: "",
                        orderable: false,
                        searchable: true
                    },{
                        data: "pembeli",
                        className: "",
                        orderable:true,
                        searchable: true
                    },{
                        // mengambil data level dari hasil ORM berelasi
                        data: "user.nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    },{
                        data: "penjualan _tanggal",
                        className: "",
                        orderable:true,
                        searchable: true
                    },{
                        data: "aksi",
                        className: "",
                        orderable:false,
                        searchable: false
                    }
                ]
            });
            $('#supplier_id').on('change', function(){
                dataPenjualan.ajax.reload();
            });
        });
    </script>
@endpush