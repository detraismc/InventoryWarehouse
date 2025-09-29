<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserLog;

class LogController extends Controller
{
    public function index()
    {
        $logList = UserLog::all();
        return view('inventory.log', compact('logList'));
    }

    public function destroy(string $id)
    {
        $userLog = UserLog::findOrFail($id);
        $userLog->delete();
        return redirect()->route('inventory.log')->with('success', 'Log berhasil didelete');
    }
}
