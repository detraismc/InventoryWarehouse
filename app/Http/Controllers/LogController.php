<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;

class LogController extends Controller
{
    public function transaction()
    {
        $logList = UserLog::where('log_type', 'transaction')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    public function account()
    {
        $logList = UserLog::where('log_type', 'account')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    public function setup()
    {
        $logList = UserLog::where('log_type', 'setup')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    public function destroy(string $id)
    {
        $userLog = UserLog::findOrFail($id);
        $userLog->delete();
        return redirect()->route('inventory.log.transaction')->with('success', 'Log berhasil didelete');
    }
}
