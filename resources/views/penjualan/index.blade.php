@extends('layouts.template') 

@section('content') 
<div class="card"> 
    <div class="card-header"> 
        <h3 class="card-title">Daftar penjualan</h3> 
        <div class="card-tools"> 
            <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import penjualan</button> 
            <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export penjualan</a>
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button> 
            <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export penjualan PDF</a>
        </div> 
    </div> 

    <div class="card-body"> 
        <!-- untuk Filter data --> 
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2"> 
            <div class="row"> 
                <div class="col-md-12"> 
                    <div class="form-group form-group-sm row text-sm mb-0"> 
                        <label for="filter_date" class="col-md-1 col-form-label">Filter</label> 
                        <div class="col-md-3"> 
                            <select name="filter_penjualan" class="form-control form-control-sm filter_penjualan"> 
                                <option value="">- Semua -</option> 
                                @foreach($penjualan as $l) 
                                    <option value="{{ $l->penjualan_id }}">{{ $l->pembeli }}</option> 
                                @endforeach 
                            </select> 
                            <small class="form-text text-muted">Filter penjualan</small> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 

        @if(session('success')) 
            <div class="alert alert-success">{{ session('success') }}</div> 
        @endif 
        
        @if(session('error')) 
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif 

        <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan"> 
            <thead> 
                <tr>
                    <th>No</th>
                    <th>Kode penjualan</th>
                    <th>Pembeli</th>
                    <th>Nama Pembeli</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr> 
            </thead> 
            <tbody></tbody> 
        </table> 
    </div> 
</div> 

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div> 

@endsection 

@push('js') 
<script> 
    function modalAction(url = ''){ 
        $('#myModal').load(url,function(){ 
            $('#myModal').modal('show'); 
        }); 
    } 

    var tablePenjualan; 
    $(document).ready(function(){ 
        tablePenjualan = $('#table-penjualan').DataTable({ 
            processing: true, 
            serverSide: true, 
            ajax: { 
                "url": "{{ url('penjualan/list') }}", 
                "dataType": "json", 
                "type": "POST", 
                "data": function (d) { 
                    d.pembeli = $('.filter_penjualan').val(); 
                } 
            }, 
            columns: [
                { data: "DT_RowIndex", className: "text-center", width: "5%", orderable: false, searchable: false },
                { data: "penjualan_kode", className: "", width: "10%", orderable: true, searchable: true },
                { data: "pembeli", className: "", width: "20%", orderable: true, searchable: true },
                { data: "m_user.nama", className: "", width: "15%", orderable: true, searchable: true },
                { data: "harga", className: "", width: "10%", orderable: true, searchable: false },
                { data: "jumlah", className: "", width: "10%", orderable: true, searchable: false },
                { data: "aksi", className: "text-center", width: "14%", orderable: false, searchable: false }
            ] 
        }); 

        $('#table-penjualan_filter input').unbind().bind().on('keyup', function(e){ 
            if(e.keyCode == 13){ // enter key 
                tablePenjualan.search(this.value).draw(); 
            } 
        }); 

        $('.filter_penjualan').change(function(){ 
            tablePenjualan.draw(); 
        }); 
    }); 
</script> 
@endpush
