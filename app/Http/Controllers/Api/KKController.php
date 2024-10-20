<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\KK;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class KKController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          //get all posts
          $kk = KK::latest()->paginate(5);
          return new PostResource(true, 'List Data Posts', $kk);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            //define validation rules
            $validator = Validator::make($request->all(), [
                'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'no_kk'     => 'required',
            ]);

            //check if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/kk', $image->hashName());

            //create post
            $post = KK::create([
                'image'     => $image->hashName(),
                'no_kk'     => $request->no_kk,
            ]);

            //return response
            return new PostResource(true, 'Data KK Berhasil Ditambahkan!', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         //find post by ID
         $post = KK::find($id);

         //return single post as a resource
         return new PostResource(true, 'Detail Data KK', $post);
    }

    public function search(Request $request)
    {
        // Validate that 'no_kk' is present in the query parameters
        $request->validate([
            'no_kk' => 'required|string' // Ensure it's a string
        ]);

        // Retrieve KK data based on partial 'no_kk' match using LIKE
        $kk = KK::where('no_kk', 'LIKE', '%' . $request->no_kk . '%')->get();

        // Debugging: Check what $kk contains

        // Check if any KK records are found
        if ($kk->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data KK ditemukan!',
                'data'    => $kk
            ], 200);
        }

        // If not found, return error response
        return response()->json([
            'success' => false,
            'message' => 'Data KK tidak ditemukan!',
        ], 404);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //find post by ID
         $kk = KK::find($id);

         //delete image
         Storage::delete('public/kk/'.basename($kk->image));

         //delete post
         $kk->delete();

         //return response
         return new PostResource(true, 'Data KK Berhasil Dihapus!', null);
    }
}
