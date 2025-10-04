<?php

namespace App\Http\Controllers;

use App\Models\UserLog;

class LogController extends Controller
{
    /**
     * Display all transaction-related logs.
     *
     * @return \Illuminate\View\View
     */
    public function transaction()
    {
        $logList = UserLog::where('log_type', 'transaction')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    /**
     * Display all account-related logs.
     *
     * @return \Illuminate\View\View
     */
    public function account()
    {
        $logList = UserLog::where('log_type', 'account')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    /**
     * Display all setup-related logs.
     *
     * @return \Illuminate\View\View
     */
    public function setup()
    {
        $logList = UserLog::where('log_type', 'setup')->latest()->get();
        return view('inventory.log', compact('logList'));
    }

    /**
     * Delete a specific log entry.
     *
     * @param string $id ID of the log entry to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $userLog = UserLog::findOrFail($id);
        $userLog->delete();

        return redirect()->route('inventory.log.transaction')->with('success', 'Log berhasil didelete');
    }
}
