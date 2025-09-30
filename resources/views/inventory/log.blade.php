@extends('layouts.inventory')

@section('title', 'Logs')

@section('content')

    <div class="card p-3">
        <div class="table-responsive">
            <table id="logTable" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>By</th>
                        <th>Log</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logList as $log)
                        <tr>
                            <td>{{ $log->date }}</td>
                            <td>{{ $log->sender }}</td>
                            <td>{{ $log->log }}</td>
                            <td class="text-center">
                                <form action="{{ route('inventory.log.delete', ['id' => $log->id]) }}" id="deleteForm"
                                    method="POST" class="d-inline">
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
