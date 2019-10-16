<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index() 
	{
		$data['pembayaran'] = \App\Pembayaran::orderBy('no_bayar')
						->get();
		return view('pembayaran', $data);
	}
	
	public function create()
	{
		$data['siswa'] = \App\Siswa::orderBy('nim')
						->get();
		$data['data_tagihan'] = DB::table('dev_tagihan_d')
							->join('dev_tagihan_m','dev_tagihan_m.no_tagihan','=','dev_tagihan_d.no_tagihan')
							// ->where('nim', $nim)
							->get();
		$data['data_pembayaran'] = \App\DataPembayaran::orderBy('no_bayar')
									->get();
		return view('Pembayaran.add_pembayaran', $data);
	}
	
	public function store(Request $request)
	{
		$rule = [
			'nim'=>'required|string',
			'tanggal'=>'required|string',
			'keterangan'=>'required|string',
			'periode'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$pembayaran = new \App\Pembayaran;
		$pembayaran->kode_lokasi	= $input['kode_lokasi'];
		$pembayaran->nim			= $input['nim'];
		$pembayaran->tanggal 		= $input['tanggal'];
		$pembayaran->keterangan 	= $input['keterangan'];
		$pembayaran->periode 		= $input['periode'];
		$status = $pembayaran->save();
		
		if ($status) {
			return redirect('/pembayaran')->with('success', 'Data Berhasil Ditambahkan');
		} else {
			return redirect('/pembayaran/create')->with('error', 'Data Gagal Ditambahkan');
		}
	}
	
	public function storeData(Request $request)
	{
		$rule = [
			'no_tagihan'=>'required|string',
			'keterangan'=>'required|string',
			'nilai'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$pembayaran = new \App\DataPembayaran;
		$pembayaran->no_tagihan			= $input['no_tagihan'];
		$pembayaran->no_bayar			= $input['no_bayar'];
		$pembayaran->kode_lokasi		= $input['kode_lokasi'];
		$pembayaran->nilai			 	= $input['nilai'];
		$status = $pembayaran->save();
		
		if ($status) {
			return redirect('/pembayaran')->with('success', 'Data Berhasil Dibayar');
		} else {
			return redirect('/pembayaran')->with('error', 'Data Gagal Dibayar');
		}
	}
	
	public function edit(Request $request, $nim)
	{
		$data['siswa'] = \App\Siswa::orderBy('nim')
						->get();
		$data['data_tagihan'] = DB::table('dev_tagihan_d')
							->join('dev_tagihan_m','dev_tagihan_m.no_tagihan','=','dev_tagihan_d.no_tagihan')
							->where('nim', $nim)
							->get();
		$data['data_pembayaran'] = \App\DataPembayaran::orderBy('no_bayar')
									->get();
		$data['pembayaran'] = DB::table('dev_bayar_m')
							->where('nim', $nim)->first();
		return view('Pembayaran.add_pembayaran', $data);
	}
	
	public function update(Request $request, $nim)
	{
		$rule = [
			'nim'=>'required|string',
			'tanggal'=>'required|string',
			'keterangan'=>'required|string',
			'periode'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$pembayaran = \App\Pembayaran::find($nim);
		// $status = $pembayaran->update($input);
		$pembayaran->kode_lokasi	= $input['kode_lokasi'];
		$pembayaran->nim			= $input['nim'];
		$pembayaran->tanggal 		= $input['tanggal'];
		$pembayaran->keterangan 	= $input['keterangan'];
		$pembayaran->periode 		= $input['periode'];
		$status = $pembayaran->update();
		
		if ($status) {
			return redirect('/pembayaran')->with('success', 'Data Berhasil Diubah');
		} else {
			return redirect('/pembayaran/create')->with('error', 'Data Berhasil Diubah');
		}
	}
	
	public function destroy(Request $request, $nim)
	{
		$pembayaran = \App\Pembayaran::find($nim);
		$status = $pembayaran->delete();
		
		if ($status) {
			return redirect('/pembayaran')->with('success', 'Data berhasil dihapus');
		} else {
			return redirect('/pembayaran')->with('error', 'Data gagal dihapus');
		}
	}
	
	function action(Request $request)
    {
		if($request->ajax()) {
			$output = '';
			$query = $request->get('query');
		
			if($query != '') {
				$data = \App\Pembayaran::where('no_bayar', 'like', '%'.$query.'%')
				->orWhere('nim', 'like', '%'.$query.'%')
				->orWhere('tanggal', 'like', '%'.$query.'%')
				->orWhere('keterangan', 'like', '%'.$query.'%')
				->orderBy('no_bayar')
				->get();
			}
			else {
				$data = DB::table('dev_bayar_m')
				->orderBy('no_bayar')
				->get();
			}
			$total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
					$output .= '
						<tr>
							<td>'.$row->no_bayar.'</td>
							<td>'.$row->nim.'</td>
							<td>'.$row->tanggal.'</td>
							<td>'.$row->keterangan.'</td>
							<td>
								<center><a class = "btn btn-primary" href = "'.url('/pembayaran/' . $row->nim . '/edit') .'">Edit</a></center>
							</td>
							<td>
								<form action = "'.url('/pembayaran', $row->nim).'" method = "POST">
								'.csrf_field().'
								'.method_field('DELETE').'
								<center><button class = "btn btn-danger" type = "submit">Delete</button></center>
								</form>
							</td>
						</tr>
					';
				}
			}
			else {
				$output = '
					<tr>
						<td align="center" colspan="5">No Data Found</td>
					</tr>
				';
			}
		$data = array(
			'table_data'  => $output,
			'total_data'  => $total_row
		);
			echo json_encode($data);
		}
    }
}
