<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function index()
    {
        $requests = Request::with('master')
            ->where('assigned_to', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('master.dashboard', compact('requests'));
    }

    public function take(HttpRequest $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $repairRequest = Request::where('id', $id)
                ->where('assigned_to', Auth::id())
                ->where('status', 'assigned')
                ->lockForUpdate()
                ->first();

            if (!$repairRequest) {
                return response()->json(['error' => 'Заявка уже взята или недоступна'], 409);
            }

            $repairRequest->update(['status' => 'in_progress']);

            return back()->with('success', 'Заявка взята в работу');
        });
    }

    public function complete(HttpRequest $request, $id)
    {
        $repairRequest = Request::where('id', $id)
            ->where('assigned_to', Auth::id())
            ->where('status', 'in_progress')
            ->firstOrFail();

        $repairRequest->update(['status' => 'done']);

        return back()->with('success', 'Заявка выполнена');
    }
}
