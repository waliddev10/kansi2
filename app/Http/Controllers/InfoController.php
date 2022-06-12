<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    ////////////////////  I N F O  ////////////////////
    public function index()
    {
        return view('pages.admin.application_info');
    }


    public function user_contact_index()
    {
        $contacts = Contact::orderBy('name', 'asc')->get();
        return view('pages.contact', compact('contacts'));
    }


    /////////////////  MASTER C O N T A C T  /////////////////

    public function contact_index()
    {
        return view('pages.admin.master_contact');
    }

    public function contact_get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $contact = Contact::where('id',  intval($request->id))->first();
        if ($contact) {
            return response()->json($contact, 200);
        }
        return response()->json();
    }

    public function contact_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'position' => 'required|min:3|max:255',
            'handphone' => 'required|min:9|max:16',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->position = $request->position;
        $contact->handphone = $request->handphone;
        if ($contact->save()) {
            return response()->json(['message' => 'Item "' . $contact->name . '" berhasil ditambahkan.'], 200);
        }
        return response()->json();
    }

    public function contact_update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|min:3|max:255',
            'position' => 'required|min:3|max:255',
            'handphone' => 'required|min:9|max:16',
        ]);

        $contact = Contact::find(intval($request->id));
        $contact->name = $request->name;
        $contact->position = $request->position;
        $contact->handphone = $request->handphone;
        if ($contact->save()) {
            return response()->json(['message' => 'Item berhasil diubah menjadi "' . $contact->name . '".'], 200);
        }
        return response()->json();
    }

    public function contact_destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $contact = Contact::find(intval($request->id));
        if ($contact->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $contact->name . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function contact_restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $contact = Contact::onlyTrashed()->find(intval($request->id));
        if ($contact->restore()) {
            return response()->json(['message' => 'Item "' . $contact->name . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function contact_destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $contact = Contact::onlyTrashed()->find(intval($request->id));
        if ($contact->forceDelete()) {
            return response()->json(['message' => 'Item "' . $contact->name . '" secara permanen dihapus.'], 200);
        }
        return response()->json();
    }

    # -----------------------------------------------------------------
    # SCRIPT RESPONSE DATATABLE ---------------------------------------
    # Pusing Banget Ga Tuh!
    # Semangat
    # -----------------------------------------------------------------
    public function contact_datatable(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Contact::get()->count();
        $sql_data = Contact::when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%')->orWhere('handphone', 'like', '%' . $search . '%');
        })->skip($start)->take($limit)->orderBy($order_field, $order_ascdesc)->get();

        ($search) ? $sql_filter = count($sql_data) : $sql_filter = $sql_total;

        $callback = [
            'draw' => $request->draw,
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        ];

        return response()->json($callback, 200)->header('Content-Type', 'application/json');
    }

    public function contact_datatable_trash(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Contact::onlyTrashed()->get()->count();
        $sql_data = Contact::onlyTrashed()->when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%')->orWhere('handphone', 'like', '%' . $search . '%');
        })->skip($start)->take($limit)->orderBy($order_field, $order_ascdesc)->get();

        ($search) ? $sql_filter = count($sql_data) : $sql_filter = $sql_total;

        $callback = [
            'draw' => $request->draw,
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        ];

        return response()->json($callback, 200)->header('Content-Type', 'application/json');
    }
}
