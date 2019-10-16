@extends('layouts.navbar')
@section('content')
	<title>School Payment || Dashboard</title>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<div class="container-fluid">
			<h1 class="mt-4">Dashboard</h1>
			<div class="row">
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-warning">
							<h5 class="card-title text-dark">Data Siswa</h5>
							<center><img src="icon/student.png" width="42%"/>
							<h1>{{ $siswa }}</h1></center>
						</div>
							<a href="{{ url('/siswa') }}" class="btn btn-primary">Detail</a>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-success">
							<h5 class="card-title">Data Tagihan</h5>
							<center><img src="icon/bill.png" width="35%"/>
							<h1 id="tagihan">{{ $tagihan }}</h1></center>
						</div>
							<a href="{{ url('/tagihan') }}" class="btn btn-primary">Detail</a>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-body bg-danger">
							<h5 class="card-title">Data Pembayaran</h5>
							<center><img src="icon/pay.png" width="42%"/>
							<h1>{{ $pembayaran }}</h1></center>
						</div>
							<a href="{{ url('/pembayaran') }}" class="btn btn-primary">Detail</a>
					</div>
				</div>
			</div>
		</div>
		<canvas id="myChart"></canvas>
		<script>
		var ctx = document.getElementById('myChart').getContext('2d');
		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'bar',

			// The data for our dataset
			data: {
				labels: ['Data Siswa','Data Tagihan','Data Pembayaran'],
				datasets: [{
					label: 'Grafik Data',
					backgroundColor: 'rgb(255, 99, 132)',
					borderColor: 'rgb(255, 99, 132)',
					data: [{{$siswa}},{{$tagihan}},{{$pembayaran}}]
				}]
			},

			// Configuration options go here
			options: {}
		});
		</script>
@endsection