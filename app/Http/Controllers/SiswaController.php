<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SiswaController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index() 
	{
		$data['siswa'] = \App\Siswa::orderBy('nim')
						->get();
		$data['jurusan'] = \App\Jurusan::orderBy('kode_jur')
						->get();
		return view('siswa', $data);
	}
	public function store(Request $request)
	{
		$rule = [
			'nim'=>'required|string',
			'nama'=>'required|string',
			'kode_jur'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$siswa = new \App\Siswa;
		$siswa->nim			= $input['nim'];
		$siswa->kode_lokasi	= $input['kode_lokasi'];
		$siswa->nama 		= $input['nama'];
		$siswa->kode_jur 	= $input['kode_jur'];
		$status = $siswa->save();
		
		if ($status) {
			return redirect('/siswa')->with('success', 'Data Berhasil Ditambahkan');
		} else {
			return redirect('/siswa')->with('error', 'Data Gagal Ditambahkan');
		}
	}
	
	public function update(Request $request)
	{
		$rule = [
			'nim'=>'required|string',
			'nama'=>'required|string',
			'kode_jur'=>'required|string',
		];
		$this->validate($request, $rule);
		
		$input = $request->all();
		
		$siswa = \App\Siswa::find($input['nim']);
		$siswa->nama 		= $input['nama'];
		$siswa->kode_jur 	= $input['kode_jur'];
		$status = $siswa->update();
		
		if ($status) {
			return redirect('/siswa')->with('success', 'Data Berhasil Diubah');
		} else {
			return redirect('/siswa')->with('error', 'Data Berhasil Diubah');
		}
	}
	
	public function destroy(Request $request, $nim)
	{
		$siswa = \App\Siswa::find($nim);
		$status = $siswa->delete();
		
		if ($status) {
			return redirect('/siswa')->with('success', 'Data berhasil dihapus');
		} else {
			return redirect('/siswa')->with('error', 'Data gagal dihapus');
		}
	}
	
	function action(Request $request)
    {
		if($request->ajax()) {
			$output = '';
			$query = $request->get('query');
		
			if($query != '') {
				$data = \App\Siswa::where('nim', 'like', '%'.$query.'%')
				->orWhere('nama', 'like', '%'.$query.'%')
				->orWhere('kode_jur', 'like', '%'.$query.'%')
				->orderBy('nim')
				->get();
			}
			else {
				$data = DB::table('dev_siswa')
				->orderBy('nim')
				->get();
			}
			$total_row = $data->count();
			if($total_row > 0) {
				foreach($data as $row) {
					$output .= '
						<tr>
							<td>'.$row->nim.'</td>
							<td>'.$row->nama.'</td>
							<td>'.$row->kode_jur.'</td>
							<td>
								<center><a data-toggle="modal" data-nim="'.$row->nim.'" data-nama="'.$row->nama.'" data-kode_jur="'.$row->kode_jur.'" title="Add this item" class="open-EditSiswa btn btn-primary" href="#addSiswaDialog">Edit</a></center>
							</td>
							<td>
								<form action = "'.url('/siswa', $row->nim) .'" method = "post">
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
