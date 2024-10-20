<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\KTP;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KTPController extends Controller
{
    public function index()
    {
          //get all posts
          $kk = KTP::latest()->paginate(5);
          return new PostResource(true, 'List Data KTP', $kk);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'no_ktp' => 'required|unique:k_t_p_s',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'kk_id' => 'required|exists:k_k_s,id',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        //upload image
        $image = $request->file('image');
        $image->storeAs('public/ktp', $image->hashName());

        $ktp = KTP::create([
            'image'     => $image->hashName(),
            'no_ktp'     => $request->no_ktp,
            'nama'     => $request->nama,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'alamat'     => $request->alamat,
            'kk_id'     => $request->kk_id,
        ]);
         //return response
        return new PostResource(true, 'Data KK Berhasil Ditambahkan!', $ktp);
    }
}
