<?php

namespace App\Http\Controllers;

use App\Notification;
use App\ReadNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $notifications = Notification::leftJoin('read_notifications', function ($join) {
            $join->on('notifications.id', '=', 'read_notifications.notification_id')
                ->where('read_notifications.user_id', '=', Auth::user()->id)
                ->whereNull('read_notifications.deleted_at');
        })->select('*', 'notifications.created_at AS date')->orderBy('notifications.created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->isoFormat('MMMM YYYY');
        });

        return view('pages.notification', compact('notifications'));
    }

    public function detail($slug)
    {
        $notification = Notification::where('slug', $slug)->firstOrFail();
        $read_status = ReadNotification::withTrashed()->where('notification_id', $notification->id)->where('user_id', Auth::user()->id)->first();

        if ($read_status) {
            $read_status->restore();
        } else {
            $read = new ReadNotification();
            $read->notification_id = $notification->id;
            $read->user_id = Auth::user()->id;
            $read->save();
        }

        return view('pages.notification_detail', compact('notification'));
    }

    public function unread($id)
    {
        $read_status = ReadNotification::where('notification_id', intval($id))->where('user_id', Auth::user()->id)->firstOrFail();
        $read_status->delete();

        return redirect()->route('notification');
    }



    //// MODERATOR ////
    public function moderator_notification_index()
    {
        return view('pages.moderator.notification_list');
    }

    public function moderator_notification_get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_notification = Notification::where('id',  intval($request->id))->first();
        if ($moderator_notification) {
            return response()->json($moderator_notification, 200);
        }
        return response()->json();
    }

    public function moderator_notification_store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255'
        ]);

        $notification = new Notification();
        $notification->title = $request->title;
        $notification->slug = Str::slug(time() . ' ' . $request->title, '-');
        $notification->description = $request->description;
        $notification->user_id = Auth::user()->id;
        if ($notification->save()) {
            return response()->json(['message' => 'Item "' . $notification->title . '" berhasil ditambahkan.'], 200);
        }
        return response()->json();
    }

    public function moderator_notification_update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255'
        ]);

        $notification = Notification::find(intval($request->id));
        $notification->title = $request->title;
        $notification->slug = Str::slug(time() . ' ' . $request->title, '-');
        $notification->description = $request->description;
        $notification->user_id = Auth::user()->id;
        if ($notification->save()) {
            return response()->json(['message' => 'Item berhasil diubah menjadi "' . $notification->title . '".'], 200);
        }
        return response()->json();
    }

    public function moderator_notification_destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_notification = Notification::find(intval($request->id));
        if ($moderator_notification->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $moderator_notification->title . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function moderator_notification_restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_notification = Notification::onlyTrashed()->find(intval($request->id));
        if ($moderator_notification->restore()) {
            return response()->json(['message' => 'Item "' . $moderator_notification->title . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function moderator_notification_destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $moderator_notification = Notification::onlyTrashed()->find(intval($request->id));
        if ($moderator_notification->forceDelete()) {
            return response()->json(['message' => 'Item "' . $moderator_notification->title . '" secara permanen dihapus.'], 200);
        }
        return response()->json();
    }

    # -----------------------------------------------------------------
    # SCRIPT RESPONSE DATATABLE ---------------------------------------
    # Pusing Banget Ga Tuh!
    # Semangat
    # -----------------------------------------------------------------
    public function moderator_notification_datatable(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Notification::with('user')->get()->count();
        $sql_data = Notification::with('user')->when($search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
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

    public function moderator_notification_datatable_trash(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = Notification::onlyTrashed()->with('user')->get()->count();
        $sql_data = Notification::onlyTrashed()->with('user')->when($search, function ($q, $search) {
            return $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
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
