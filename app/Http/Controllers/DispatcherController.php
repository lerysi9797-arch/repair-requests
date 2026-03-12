<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\User;

class DispatcherController extends Controller
{
    public function index()
    {
        $status = request('status');

        $query = Request::with('master')->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $requests = $query->get();
        $masters = User::where('role', 'master')->get();
        $currentStatus = $status ?? 'all';

        return view('dispatcher.dashboard', compact('requests', 'masters', 'currentStatus'));
    }

    public function assign(\Illuminate\Http\Request $request, $id)
    {
        $repairRequest = Request::findOrFail($id);
        $masterId = $request->input('master_id');

        if (!$masterId) {
            return back()->with('error', 'Выберите мастера');
        }

        $repairRequest->update([
            'assigned_to' => $masterId,
            'status' => 'assigned'
        ]);

        return back()->with('success', 'Заявка назначена мастеру');
    }

    public function cancel(Request $request, $id)
    {
        $repairRequest = Request::findOrFail($id);
        $repairRequest->update(['status' => 'canceled']);

        return back()->with('success', 'Заявка отменена');
    }
}
