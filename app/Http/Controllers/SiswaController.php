<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
        {
        $this->middleware('auth');
        }

    public function index()
    {
        $data =Siswa::paginate(10);
        $user =Auth::user();
        if ($user->level == 'admin') {
        return view('admin.siswa',compact('data'));
        } elseif ($user->level == 'gurubk') {
        return view('guru.siswa',compact('data'));
        }   
    }
        
    public function search(Request $request)
{
    $keyword = $request->search;
    $data =Siswa::where('nis', 'like', "%" . $keyword . "%")->paginate(5);
    $user =Auth::user();
    if ($user->level == 'admin') {
    return view('admin.siswa', compact(['data']))->with('i', (request()->input('page',
    1) - 1) * 5);
    } elseif ($user->level == 'gurubk') {
    return view('guru.siswa', compact(['data']))->with('i', (request()->input('page',
    1) - 1) * 5);
}
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'nm' => 'required',
            'kls' => 'required',
            ]);
            //check if validation fails
            if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            }
            if (Siswa::where('nis','=',$request->nis)->count() > 0)
            {
            toastr()->error('NIS Siswa sudah ada');
            return redirect('/admin/siswa');
            }else {
            //create post
            $simpan = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nm,
            'kelas' => $request->kls,
            ]);
            }
            if ($simpan) {
            toastr()->success('Data Siswa berhasil di simpan');
            return redirect('/admin/siswa');
            } else {
            toastr()->error('Data Siswa gagal di simpan');
            return redirect('/admin/siswa');
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=Siswa::find($id);
        return view('admin.siswa',compact(['data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $upd = Siswa::find($id);
        $upd ->update([
        'nis' => $request->nis,
        'nama' => $request->nm,
        'kelas' => $request->kls,
        ]);
        if ($upd) {
        toastr()->success('Data Siswa berhasil di ubah');
        return redirect('/admin/siswa');
        } else {
        toastr()->error('Data Siswa gagal di ubah');
        return redirect('/admin/siswa');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $del = Siswa::find($id);
    $del->delete(); //perintah untuk hapus
    if ($del) {
    toastr()->success('Data Siswa berhasil dihapus');
    return redirect('/admin/siswa');
    } else {
    toastr()->error('Data Siswa berhasil dihapus');
    return redirect('/admin/siswa');
    }
    }
}
