@extends('layouts.navbar')
@section('content')
	<title>School Payment || Data Siswa</title>
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
	<h1 class="mt-4">Data Siswa</h1>
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#TambahSiswa">Tambah</button>
	<div class="nav justify-content-end">
		<label>Search:
			<form action="" method="post">
				<input type="text" name="search" id="search" class="form-control" placeholder="" /><h3>Total Data : <span id="total_records"></span></h3>
			</form>
		</label>
	</div>
		<div id="container">
			<table id="datatable" class="table table-striped table-bordered autoWidth" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm">NIM</th>
						<th class="th-sm">Nama</th>
						<th class="th-sm">Kode Jurusan</th>
						<th class="th-sm" colspan="2"><center>Aksi</center></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>	
					<tr>
						<th>NIM</th>
						<th>Nama</th>
						<th>Kode Jurusan</th>
						<th colspan="2"><center>Aksi</center></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- Modal Tambah -->
		<div class="modal fade" id="TambahSiswa" tabindex="-1" role="dialog" aria-labelledby="TambahSiswa" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="">Tambah Siswa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ url('/siswa/add') }}" method="post">
								<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
							@csrf
							<div class="form-group">
								<label for="nim" class="col-form-label">NIM</label>
								<input type="text" class="form-control" id="nim" name="nim">
							</div>
							<div class="form-group">
								<label for="nama" class="col-form-label">Nama</label>
								<input type="text" class="form-control" id="nama" name="nama">
							</div>
							<div class="form-group">
								<label for="kode_jur" class="col-form-label">Kode Jurusan</label><br>
								<select name="kode_jur">
									<option value="">-- Pilih Kode Jurusan --</option>
									@foreach ($jurusan as $row)
									<option value="{{ $row->kode_jur}}">{{ $row->kode_jur}} - {{ $row->nama}}</option>
									@endforeach
								</select>
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
		
		<!-- Modal Edit -->
		<div class="modal fade" id="addSiswaDialog" tabindex="-1" role="dialog" aria-labelledby="EditSiswa" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="">Edit Siswa</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{ url('/siswa/update') }}" method="post">
								<input type="hidden" class="form-control" id="kode_lokasi" name="kode_lokasi" value="&nbsp">
							@csrf
							@method('PATCH')
								<label for="nim" class="col-form-label">NIM</label>
								<input type="text" class="form-control" id="nim" name="nim" readonly>
							<div class="form-group">
								<label for="nama" class="col-form-label">Nama</label>
								<input type="text" class="form-control" id="nama" name="nama">
							</div>
							<div class="form-group">
								<label for="kode_jur" class="col-form-label">Kode Jurusan</label><br>
								<select id="kode_jur" name="kode_jur">
									<option value="">-- Pilih Kode Jurusan --</option>
									@foreach ($jurusan as $row)
									<option value="{{ $row->kode_jur}}">{{ $row->kode_jur}} - {{ $row->nama}}</option>
									@endforeach
								</select>
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
			$(document).on("click", ".open-EditSiswa", function () {
				 var nim = $(this).data('nim');
				 var nama = $(this).data('nama');
				 var kode_jur = $(this).data('kode_jur');
				 $(".modal-body #nim").val( nim );
				 $(".modal-body #nama").val( nama );
				 $(".modal-body #kode_jur").val( kode_jur );
			});
		</script>
		<script>
			$(document).ready(function(){
				fetch_data();

				function fetch_data(query = '') {
					$.ajax({
					url:"{{ route('siswa.action') }}",
					method:'GET',
					data:{query:query},
					dataType:'json',
						success:function(data) {
						$('tbody').html(data.table_data);
						$('#total_records').text(data.total_data);
						}
					})
				}

				$(document).on('keyup', '#search', function(){
					var query = $(this).val();
					fetch_data(query);
				});
			});
		</script>

@endsection