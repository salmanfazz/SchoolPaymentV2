@extends('layouts.navbar')
@section('content')
	<title>School Payment || Data Pembayaran</title>
	@if(session('success'))
		<div class = "alert alert-success">
	{{ session('success') }}
		</div>
	@endif
	@if(session('error'))
		<div class = "alert alert-error">
	{{ session('error') }}
		</div>
	@endif
	<br>
	<h1>Data Pembayaran</h1>
		<form action = "{{ url('pembayaran', @$pembayaran->nim) }}" method = "POST">
			@csrf
			@if(!empty($pembayaran))
				@method('PATCH')
			@endif
		<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
		<div class="card-body">
			<div class="form-group">
				<label for="nim" class="col-form-label">NIM</label><br>
				<select name="nim">
					<option value="">-- Pilih NIM --</option>
					@foreach ($siswa as $row)
					<option value="{{ $row->nim }}" {{ @$pembayaran->nim == $row->nim ? 'selected' : ''}}>{{ $row->nim }} - {{ $row->nama }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="tanggal" class="col-form-label">Tanggal</label><br>
				<input type = "date" class = "form-control" name = "tanggal" value = "{{ old('tanggal', @$pembayaran->tanggal) }}"/>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-form-label">Keterangan</label><br>
				<input type = "text" class = "form-control" name = "keterangan" value = "{{ old('keterangan', @$pembayaran->keterangan) }}"/>
			</div>
			<div class="form-group">
				<label for="periode" class="col-form-label">Periode</label><br>
				<input type = "text" class = "form-control" name = "periode" value = "{{ old('periode', @$pembayaran->periode) }}"/>
			</div>
				<a href="{{ url('/pembayaran') }}" class="btn btn-info">Back</a>
				<button type="submit" class="btn btn-success" name="submit">Save</button>
		</div>
		</form>
		<div class="card-body">
			<table id="datatable" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="th-sm">No Tagihan</th>
							<th class="th-sm">Keterangan</th>
							<th class="th-sm">Nilai Tagihan</th>
							<th class="th-sm"><center>Aksi</center></th>
						</tr>
					</thead>
					@if(!empty($pembayaran))
					@foreach ($data_tagihan as $row)
					<tbody>
						<tr>
							<td> {{ $row->no_tagihan }} </td>
							<td> {{ $row->keterangan }} </td>
							<td> {{ $row->nilai }} </td>
							<td><center><button type="button" class="btn open-AddData btn-primary" data-toggle="modal" data-nilai="{{ $row->nilai }}" data-keterangan="{{ $row->keterangan }}" data-no_tagihan="{{ $row->no_tagihan }}" data-target="#TambahDataPembayaran">Bayar</button></center></td>
						</tr>
					</tbody>
					@endforeach
					@endif
					<tfoot>	
						<tr>
							<th>No Tagihan</th>
							<th>Keterangan</th>
							<th>Nilai Tagihan</th>
							<th><center>Aksi</center></th>
						</tr>			
				</tfoot>
			</table>
		</div>
		<!-- Modal Tambah Data Pmebayaran-->
		<div class="modal fade" id="TambahDataPembayaran" tabindex="-1" role="dialog" aria-labelledby="TambahDataPembayaran" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="">Tambah Data Pembayaran</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ url('/pembayaran/add') }}" method="post">
							@csrf
								<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
								<input type="hidden" class="form-control" id="no_bayar" name="no_bayar" value="{{ @$pembayaran->no_bayar }}">
							<div class="form-group">
								<label for="no_tagihan" class="col-form-label">No Tagihan</label>
								<input type="number" class="form-control" id="no_tagihan" name="no_tagihan" readonly>
							</div>
							<div class="form-group">
								<label for="keterangan" class="col-form-label">Keterangan</label>
								<input type="text" class="form-control" id="keterangan" name="keterangan" readonly>
							</div>
							<div class="form-group">
								<label for="nilai" class="col-form-label">Nilai Tagihan</label>
								<input type="number" class="form-control" id="nilai" name="nilai" readonly>
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-primary">Bayar</button>
					</div>
						</form>
				</div>
			</div>
		</div>
		<script>
			$(document).on("click", ".open-AddData", function () {
				 var nilai = $(this).data('nilai');
				 var keterangan = $(this).data('keterangan');
				 var no_tagihan = $(this).data('no_tagihan');
				 $(".modal-body #nilai").val( nilai );
				 $(".modal-body #keterangan").val( keterangan );
				 $(".modal-body #no_tagihan").val( no_tagihan );
			});
		</script>
@endsection