<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Document;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('pages.documents.home', [
            'akuntansi_list' => Document::where('category', 'AKUNTANSI')->get()->unique('year'),
            'verifikasi_list' => Document::where('category', 'VERIFIKASI')->get()->unique('year'),
        ]);
    }

    public function detailAkuntansi($year)
    {
        return view('pages.documents.akuntansi', [
            'documents' => Document::where('category', 'AKUNTANSI')->where('year', $year)->get(),
        ]);
    }
    public function detailVerifikasi($year)
    {
        return view('pages.documents.verifikasi', [
            'documents' => Document::where('category', 'VERIFIKASI')->where('year', $year)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'year' => 'required',
            'category' => 'required',
            'title' => 'required',
            'attachment' => 'file'
        ]);

        $file = $request->file('file');
        if ($file) {
            $file->move(storage_path('documents'), $file->getClientOriginalName());
        }

        $position = new Document();
        $position->year = $request->year;
        $position->category = $request->category;
        $position->title = $request->title;
        $position->attachment = $file->getClientOriginalName();
        if ($position->save()) {
            return response()->json(['message' => 'Berkas telah diupload.'], 200);
        }
    }
}
