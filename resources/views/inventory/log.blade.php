@extends('layouts.inventory')

@section('title', 'Logs')

@section('content')

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.log.transaction') ? 'active' : '' }}"
                href="{{ route('inventory.log.transaction') }}">
                Transaction Log
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.log.account') ? 'active' : '' }}"
                href="{{ route('inventory.log.account') }}">
                Account Log
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('inventory.log.setup') ? 'active' : '' }}"
                href="{{ route('inventory.log.setup') }}">
                Setup Log
            </a>
        </li>
    </ul>

    <div class="card p-3">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th style="width: 150px;">Timestamp</th>
                        <th>By</th>
                        <th>Log</th>
                        <th class="text-center" style="width: 60px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logList as $log)
                        <tr>
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->sender }}</td>
                            <td>{{ $log->log }}</td>
                            <td class="text-center">
                                <form action="{{ route('inventory.log.delete', ['id' => $log->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-custom btn-delete">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
