<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TanggapanController extends Controller
{
public function __construct()
    {
    $this->middleware('auth');
    }
public function index()
        {
        $data = Tanggapan::paginate(10);
        $dapel =Pelanggaran::all();
        $user =Auth::user();
        if ($user->level == 'admin') {
        return view('admin.tanggapan',compact('data'));
        } elseif ($user->level == 'gurubk') {
        return view('guru.tanggapan',compact('data','dapel'));
        }
        }
  public function search(Request $request)
        {
            $keyword = $request->search;
            $dapel =Pelanggaran::all();
            $data =Tanggapan::where('id_pelanggaran', 'like', "%" . $keyword . "%")->paginate(5);
             { return view('guru.tanggapan', compact(['data','dapel']))->with('i', (request()->input('page',1) - 1) * 5);
            }
        }
  public function store(Request $request)
        {
        $validator = Validator::make($request->all(), [
        'idpel' => 'required',Rule::unique('pelanggaran'),
        'idtang' => 'required',Rule::unique('tanggapan'),
        'tgl' => 'required',
        'isi' => 'required',
        ]);
        //check if validation fails
        if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
        }
        if (Tanggapan::where('id_pelanggaran','=',$request->idpel)->count()>0)
        {
        toastr()->error('Id Pelanggaran sudah pernah ditanggapi');
        return redirect('/guru/tanggapan');
        }else if (Tanggapan::where('id_tanggapan','=',$request->idtang)->count()>0)
        {
        toastr()->error('Id Tanggapan sudah ada');
        return redirect('/guru/tanggapan');
        }else{
        //create post
        $simpan = Tanggapan::create([
        'id_pelanggaran' => $request->idpel,
        'id_tanggapan' => $request->idtang,
        'tgl_tanggapan' => $request->tgl,
        'id_petugas' => Auth::user()->id_petugas,
        'isi_tanggapan' => $request->isi,
        ]);
        }
        if ($simpan) {
        toastr()->success('Tanggapan berhasil di simpan');
        return redirect('/guru/tanggapan');
        } else {
        toastr()->error('Tanggapan gagal di simpan');
        return redirect('/guru/tanggapan');
        }
        }
 public function destroy(string $id)
    {
        $del = Tanggapan::find($id);
    $del->delete(); //perintah untuk hapus
    if ($del) {
    toastr()->success('tanggapan sukses di hapus');
    return redirect('/guru/tanggapan');
    } else {
    toastr()->error('tanggapan gagal di hapus');
    return redirect('/guru/tanggapan');
    }
    }

 public function edit(string $id)
    {
        $data=Tanggapan::find($id);
//ubah adalah pengambilan data dari variabel $ubah, namanya harus sama
        return view('guru.tanggapan',compact(['data']));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'idpel' => 'required',
            'idtang' => 'required',
            'tgl' => 'required',
            'isi' => 'required',
            ]);
            $upd = Tanggapan::find($id);
            $upd ->update([
            'id_pelanggaran' => $request->idpel,
            'id_tanggapan' => $request->idtang,
            'tgl_tanggapan' => $request->tgl,
            'id_petugas' => Auth::user()->id_petugas,
            'isi_tanggapan' => $request->isi,
            ]);
            if ($upd) {
            toastr()->success('Tanggapan berhasil di ubah');
            return redirect('/guru/tanggapan');
            } else {
            toastr()->error('Tanggapan gagal di ubah');
            return redirect('/guru/tanggapan');
            }
    }
}
