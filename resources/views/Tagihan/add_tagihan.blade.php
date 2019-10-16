@extends('layouts.navbar')
@section('content')
<title>School Payment || Data Tagihan</title>
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
	<h1>Data Tagihan</h1>
		<form action = "{{ url('tagihan', @$tagihan->no_tagihan) }}" method = "POST">
			@csrf
			@if(!empty($tagihan))
				@method('PATCH')
			@endif
		<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
		<div class="card-body">
			<div class="form-group">
				<label for="nim" class="col-form-label">NIM</label><br>
				<select name="nim">
					<option value="">-- Pilih NIM --</option>
					@foreach ($siswa as $row)
					<option value="{{ $row->nim }}" {{ @$tagihan->nim == $row->nim ? 'selected' : ''}}>{{ $row->nim }} - {{ $row->nama }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="tanggal" class="col-form-label">Tanggal</label><br>
				<input type = "date" class = "form-control" name = "tanggal" value = "{{ old('tanggal', @$tagihan->tanggal) }}"/>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-form-label">Keterangan</label><br>
				<input type = "text" class = "form-control" name = "keterangan" value = "{{ old('keterangan', @$tagihan->keterangan) }}"/>
			</div>
				<a href="{{ url('/tagihan') }}" class="btn btn-info">Back</a>
				<button type="submit" class="btn btn-success" name="submit">Save</button>
				@if(!empty($tagihan))<button type="button" class="btn open-AddData btn-primary" data-toggle="modal" data-target="#TambahDataTagihan">Tambah Tagihan</button>@endif
		</div>
		</form>
		<div class="card-body">
			<table id="datatable" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="th-sm">No</th>
							<th class="th-sm">Kode Jenis Tagihan</th>
							<th class="th-sm">Jenis Tagihan</th>
							<th class="th-sm">Nilai</th>
							<th class="th-sm" colspan="2"><center>Aksi</center></th>
						</tr>
					</thead>
					@if(!empty($tagihan))
					@foreach ($data_tagihan as $row)
					<tbody>
						<tr>
							<td> {{ isset($i) ? ++$i : $i = 1 }} </td>
							<td> {{ $row->kode_jenis }} </td>
							<td> {{ $row->nama }} </td>
							<td> {{ $row->nilai }} </td>
							<td>
							<center><a data-toggle="modal" data-no_tagihan="{{ $row->no_tagihan }}"data-kode_jenis="{{ $row->kode_jenis }}" data-nilai="{{ $row->nilai }}"title="Add this item" class="open-EditData btn btn-primary" href="#editDataDialog">Edit</a></center>
							<td>
							<form action = "{{ url('/data-tagihan', $row->nilai) }}" method = "post">
							@csrf
							@method('DELETE')
							<center><button class = "btn btn-danger" type = "submit">Delete</button></center>
							</form>
						</td>
						</td>
						</tr>
					</tbody>
					@endforeach
					@endif
					<tfoot>	
						<tr>
							<th>No</th>
							<th>Kode Jenis Tagihan</th>
							<th>Jenis Tagihan</th>
							<th>Nilai</th>
							<th colspan="2"><center>Aksi</center></th>
						</tr>			
				</tfoot>
			</table>
		</div>
		<!-- Modal Tambah Data Tagihan-->
		<div class="modal fade" id="TambahDataTagihan" tabindex="-1" role="dialog" aria-labelledby="TambahDataTagihan" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="">Tambah Data Tagihan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ url('/tagihan/add') }}" method="post">
								<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
								<input type="hidden" class="form-control" id="no_tagihan" name="no_tagihan" value="<?= @$tagihan->no_tagihan ?>">
							@csrf
							<div class="form-group">
								<label for="kode_jenis" class="col-form-label">Kode Jenis Tagihan</label><br>
								<select name="kode_jenis" id="kode_jenis">
									<option value="">-- Pilih Kode Jenis Tagihan --</option>
									@foreach($jenis as $row)
									<option value="{{ $row->kode_jenis}}">{{ $row->kode_jenis}} - {{ $row->nama}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="nilai" class="col-form-label">Nilai</label>
								<input type="number" class="form-control" id="nilai" name="nilai">
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-primary">Save</button>
					</div>
						</form>
				</div>
			</div>
		</div>
		<!-- Modal Edit Data Tagihan -->
		<div class="modal fade" id="editDataDialog" tabindex="-1" role="dialog" aria-labelledby="EditSiswa" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="">Edit Data Tagihan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action = "{{ url('/data-tagihan/update') }}" method = "post">
								<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
								<input type="text" class="form-control" id="no_tagihan" name="no_tagihan" value="&nbsp">
							@csrf
							@method('PATCH')
							<div class="form-group">
								<label for="kode_jenis" class="col-form-label">Kode Jenis Tagihan</label><br>
								<select name="kode_jenis" id="kode_jenis">
									<option value="">-- Pilih Kode Jenis Tagihan --</option>
									@foreach($jenis as $row)
									<option value="{{ $row->kode_jenis}}">{{ $row->kode_jenis}} - {{ $row->nama}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="nilai" class="col-form-label">Nilai</label>
								<input type="text" class="form-control" id="nilai" name="nilai">
							</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="submit" class="btn btn-primary">Save</button>
					</div>
						</form>
				</div>
			</div>
		</div>
		<script>
			$(document).on("click", ".open-EditData", function () {
				 var no_tagihan = $(this).data('no_tagihan');
				 var nilai = $(this).data('nilai');
				 var kode_jenis = $(this).data('kode_jenis');
				 $(".modal-body #no_tagihan").val( no_tagihan );
				 $(".modal-body #nilai").val( nilai );
				 $(".modal-body #kode_jenis").val( kode_jenis );
			});
		</script>
@endsection