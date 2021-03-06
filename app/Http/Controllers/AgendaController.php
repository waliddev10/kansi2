<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Present;
use App\Workunit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    //
    public function index()
    {
        $agendaList = (new Agenda)
            ->with(['presents'])
            ->where('user_id', Auth::user()->id)
            ->orderBy('start', 'desc')
            ->whereHas('presents', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            // ->where('start', '<', Carbon::now())
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->start)->isoFormat('MMMM YYYY');
            });

        return view('pages.agendas.agenda_list', compact('agendaList'));
    }

    public function detail($slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();
        $present = Present::where('agenda_id', $agenda->id)->where('user_id', Auth::user()->id)->first();
        $presents = Present::with('user')->where('agenda_id', $agenda->id)->orderBy('created_at', 'asc')->get();

        // return response()->json($agenda);

        return view('pages.agendas.agenda_detail', compact('agenda', 'present', 'presents'));
    }

    public function present_index($slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();
        $presents = Present::with('user')->where('agenda_id', $agenda->id)->orderBy('created_at', 'asc')->get();

        return view('pages.agendas.present_list', compact('agenda', 'presents'));
    }

    public function present_store(Request $request)
    {
        $this->validate($request, [
            'agenda_id' => 'required',
            'description' => 'required',
            'attachment' => 'nullable'
        ]);

        $file = $request->file('file');
        if ($file) {
            $file->move(storage_path('agenda/attachment'), $file->getClientOriginalName());
        }

        $position = new Present();
        $position->agenda_id = $request->agenda_id;
        $position->description = $request->description;
        if ($file) {
            $position->attachment = $file->getClientOriginalName();
        }
        $position->user_id = Auth::user()->id;
        if ($position->save()) {
            return response()->json(['message' => 'Aktivitas telah diselesaikan.'], 200);
        }
    }

    public function get_api_detail($id)
    {
        $agenda = new Agenda();
        $workunit = new Workunit();
        $agenda_item = $agenda->findOrFail($id);
        $workunits = [];

        if ($agenda_item->workunit_id) {
            $workunit_id = explode(',', $agenda_item->workunit_id);
            $workunits = $workunit->whereIn('id', $workunit_id)->get();
        }
        return compact('agenda_item', 'workunits');
    }

    // get for calendar

    public function get(Request $request)
    {
        $queryBuild = (new Agenda)
            ->where('user_id', Auth::user()->id)
            ->orderBy('start', 'asc');

        $start = $request->start;
        $end = $request->end;

        $agendas_olah = $queryBuild
            ->with(['user', 'presents'])
            ->where('start', '>=', $start)
            ->where('end', '<=', $end)
            ->orderBy('end', 'desc')
            ->get();

        $agendas = collect([]);
        collect($agendas_olah)->each(function ($item, $key) use ($agendas) {
            $agendas->push((object)[
                'id' => $item->id,
                'description' => $item->description,
                'end' => $item->end,
                'slug' => $item->slug,
                'start' => $item->start,
                'title' => $item->title,
                'color' => ($item->presents->count()) ? 'green' : 'red',
                'url' => $item->url,
            ]);
        });

        return response()->json($agendas, 200);
    }


    //// MODERATOR ////
    public function moderator_agenda_index()
    {
        return view('pages.moderator.agenda');
    }

    public function moderator_agenda_get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_agenda = Agenda::where('id',  intval($request->id))->first();
        if ($moderator_agenda) {
            return response()->json($moderator_agenda, 200);
        }
        return response()->json();
    }

    public function moderator_agenda_store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'start' => 'required',
            'end' => 'required',
            // 'link' => 'max:255',
            'attachment' => 'max:255',
            'status_agenda_id' => 'required',
            'user_id' => 'required',
        ]);

        $agenda = new Agenda();
        $agenda->title = $request->title;
        $agenda->slug = Str::slug(time() . ' ' . $request->title, '-');
        $agenda->description = $request->description;
        $agenda->user_id = $request->user_id;
        $agenda->start = $request->start;
        $agenda->end = $request->end;
        // $agenda->link = $request->link;
        // $agenda->workunit_id = ($request->workunit_id) ? implode(',', $request->workunit_id) : null;
        $agenda->attachment = $request->attachment;
        $agenda->status_agenda_id = $request->status_agenda_id;
        $agenda->save();
        return response()->json(['message' => 'Item "' . $agenda->title . '" berhasil ditambahkan.'], 200);
    }

    public function moderator_agenda_update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'start' => 'required',
            'end' => 'required',
            'link' => 'max:255',
            'attachment' => 'max:255',
            'status_agenda_id' => 'required',
        ]);

        $agenda = Agenda::find(intval($request->id));
        $agenda->title = $request->title;
        $agenda->slug = Str::slug(time() . ' ' . $request->title, '-');
        $agenda->description = $request->description;
        $agenda->user_id = Auth::user()->id;
        $agenda->start = $request->start;
        $agenda->end = $request->end;
        $agenda->link = $request->link;
        $agenda->workunit_id = ($request->workunit_id) ? implode(',', $request->workunit_id) : null;
        $agenda->attachment = $request->attachment;
        $agenda->status_agenda_id = $request->status_agenda_id;
        if ($agenda->save()) {
            return response()->json(['message' => 'Item berhasil diubah menjadi "' . $agenda->title . '".'], 200);
        }
        return response()->json();
    }

    public function moderator_agenda_destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_agenda = Agenda::find(intval($request->id));
        if ($moderator_agenda->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $moderator_agenda->title . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function moderator_agenda_restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_agenda = Agenda::onlyTrashed()->find(intval($request->id));
        if ($moderator_agenda->restore()) {
            return response()->json(['message' => 'Item "' . $moderator_agenda->title . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function moderator_agenda_destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_agenda = Agenda::onlyTrashed()->find(intval($request->id));
        if ($moderator_agenda->forceDelete()) {
            return response()->json(['message' => 'Item "' . $moderator_agenda->title . '" secara permanen dihapus.'], 200);
        }
        return response()->json();
    }

    # -----------------------------------------------------------------
    # SCRIPT RESPONSE DATATABLE ---------------------------------------
    # Pusing Banget Ga Tuh!
    # Semangat
    # -----------------------------------------------------------------
    public function moderator_agenda_datatable(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Agenda::with('user')->with('status_agenda')->get()->count();
        $sql_data = Agenda::with('user')->with('status_agenda')->when($search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('start', 'like', '%' . $search . '%')
                ->orWhere('end', 'like', '%' . $search . '%')
                ->orWhere('attachment', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%');
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

    public function moderator_agenda_datatable_trash(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Agenda::onlyTrashed()->with('user')->with('status_agenda')->get()->count();
        $sql_data = Agenda::onlyTrashed()->with('user')->with('status_agenda')->when($search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('start', 'like', '%' . $search . '%')
                ->orWhere('end', 'like', '%' . $search . '%')
                ->orWhere('attachment', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%');
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
