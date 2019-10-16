<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index() 
	{		
		$data['tagihan'] = \App\Tagihan::orderBy('no_tagihan')
						->get();
		return view('tagihan', $data);
	}
	
	public function create()
	{
		$data['siswa'] = \App\Siswa::orderBy('nim')
						->get();
		$data['jenis'] = \App\Jenis::orderBy('kode_jenis')
						->get();
		$data['data_tagihan'] = DB::table('dev_tagihan_d')
							->join('dev_jenis','dev_jenis.kode_jenis','=','dev_tagihan_d.kode_jenis')
							// ->where('no_tagihan', $no_tagihan);
							->get();
		return view('Tagihan.add_tagihan', $data);
	}
	
	public function store(Request $request)
	{
		$rule = [
			'nim'=>'required|string',
			'tanggal'=>'required|string',
			'keterangan'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$tagihan = new \App\Tagihan;
		$tagihan->kode_lokasi	= $input['kode_lokasi'];
		$tagihan->nim			= $input['nim'];
		$tagihan->tanggal 		= $input['tanggal'];
		$tagihan->keterangan 	= $input['keterangan'];
		$status = $tagihan->save();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data Berhasil Ditambahkan');
		} else {
			return redirect('/tagihan/create')->with('error', 'Data Gagal Ditambahkan');
		}
	}
	
	public function storeData(Request $request)
	{
		$rule = [
			'kode_jenis'=>'required|string',
			'nilai'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$tagihan = new \App\DataTagihan;
		$tagihan->no_tagihan		= $input['no_tagihan'];
		$tagihan->kode_lokasi		= $input['kode_lokasi'];
		$tagihan->kode_jenis 		= $input['kode_jenis'];
		$tagihan->nilai			 	= $input['nilai'];
		$status = $tagihan->save();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data Berhasil Ditambahkan');
		} else {
			return redirect('/tagihan')->with('error', 'Data Gagal Ditambahkan');
		}
	}
	
	public function edit(Request $request, $no_tagihan)
	{
		$data['siswa'] = \App\Siswa::orderBy('nim')
						->get();
		$data['jenis'] = \App\Jenis::orderBy('kode_jenis')
						->get();
		$data['data_tagihan'] = DB::table('dev_tagihan_d')
							->join('dev_jenis','dev_jenis.kode_jenis','=','dev_tagihan_d.kode_jenis')
							->join('dev_tagihan_m','dev_tagihan_m.no_tagihan','=','dev_tagihan_d.no_tagihan')
							->where('dev_tagihan_d.no_tagihan', $no_tagihan)
							->get();
		$data['tagihan'] = DB::table('dev_tagihan_m')->where('no_tagihan', $no_tagihan)->first();
		
		return view('Tagihan.add_tagihan', $data);
	}
	
	public function update(Request $request, $no_tagihan)
	{
		$rule = [
			'nim'=>'required|string',
			'tanggal'=>'required|string',
			'keterangan'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$tagihan = \App\Tagihan::find($no_tagihan);
		// $status = $tagihan->update($input);
		$tagihan->kode_lokasi	= $input['kode_lokasi'];
		$tagihan->nim			= $input['nim'];
		$tagihan->tanggal 		= $input['tanggal'];
		$tagihan->keterangan 	= $input['keterangan'];
		$status = $tagihan->update();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data Berhasil Diubah');
		} else {
			return redirect('/tagihan/create')->with('error', 'Data Berhasil Diubah');
		}
	}
	
	public function updateData(Request $request)
	{
		$rule = [
			'nilai'=>'required|string',
			'kode_jenis'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$tagihan = \App\DataTagihan::find($input['kode_jenis']);
		$tagihan->nilai 		= $input['nilai'];
		$tagihan->kode_jenis 	= $input['kode_jenis'];
		$status = $tagihan->update();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data Berhasil Diubah');
		} else {
			return redirect('/tagihan')->with('error', 'Data Berhasil Diubah');
		}
	}
	
	public function destroy(Request $request, $no_tagihan)
	{
		$tagihan = \App\Tagihan::find($no_tagihan);
		$status = $tagihan->delete();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data berhasil dihapus');
		} else {
			return redirect('/tagihan')->with('error', 'Data gagal dihapus');
		}
	}
	
	public function destroyData(Request $request, $nilai)
	{
		$tagihan = \App\DataTagihan::where('nilai',$nilai);
		$status = $tagihan->delete();
		
		if ($status) {
			return redirect('/tagihan')->with('success', 'Data berhasil dihapus');
		} else {
			return redirect('/tagihan')->with('error', 'Data gagal dihapus');
		}
	}
	
	function action(Request $request)
    {
		if($request->ajax()) {
			$output = '';
			$query = $request->get('query');
		
			if($query != '') {
				$data = \App\Tagihan::where('no_tagihan', 'like', '%'.$query.'%')
				->orWhere('nim', 'like', '%'.$query.'%')
				->orWhere('tanggal', 'like', '%'.$query.'%')
				->orWhere('keterangan', 'like', '%'.$query.'%')
				->orderBy('no_tagihan')
				->get();
			}
			else {
				$data = DB::table('dev_tagihan_m')
				->orderBy('no_tagihan')
				->get();
			}
			$total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
					$output .= '
						<tr>
							<td>'.$row->no_tagihan.'</td>
							<td>'.$row->nim.'</td>
							<td>'.$row->tanggal.'</td>
							<td>'.$row->keterangan.'</td>
							<td>
								<center><a class = "btn btn-primary" href = "'.url('/tagihan/' . $row->no_tagihan . '/edit') .'">Edit</a></center>
							</td>
							<td>
								<form action = "'.url('/tagihan', $row->no_tagihan).'" method = "POST">
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
