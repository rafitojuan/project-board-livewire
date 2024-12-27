@extends('layouts.master')

@section('title')
    Log Aktivitas
@endsection

@section('css')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Semua Log</h5>
                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Project</th>
                                <th>Keterangan</th>
                                <th>Pengguna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->setTimezone('Asia/Jakarta') }}</td>
                                    <td>{{ $log->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->causer ? $log->causer->name : 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary">
                                        <p>- Belum ada aktivitas -</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                order: [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endsection
