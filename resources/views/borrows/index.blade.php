@extends('layouts.app')
@section('title', 'Borrow Records — Library Management System')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
    <div>
        <h1 class="page-title">Borrow / Return Records</h1>
        <p class="page-subtitle">
            @if(auth()->user()->isAdmin())
                All borrowing transactions in the system.
            @else
                Your borrowing history.
            @endif
        </p>
    </div>
    <a href="{{ route('borrows.create') }}" class="btn btn-primary">+ New Borrow</a>
</div>

<div class="card" style="padding:0; overflow:hidden;">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Borrower</th>
                    <th>ID No.</th>
                    <th>Book Title</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $borrow)
                <tr>
                    <td style="color:#94a3b8;">{{ $borrow->id }}</td>
                    <td style="font-weight:500;">{{ $borrow->borrower_name }}</td>
                    <td>{{ $borrow->borrower_id_no ?? '—' }}</td>
                    <td>{{ $borrow->book->title ?? '—' }}</td>
                    <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                    <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                    <td>{{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $borrow->status }}">
                            {{ ucfirst($borrow->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            {{-- Return button: only for active borrows --}}
                            @if(in_array($borrow->status, ['borrowed', 'overdue']))
                                <a href="{{ route('borrows.edit', $borrow) }}" class="btn btn-sm btn-success">Return</a>
                            @endif

                            {{-- Admin-only: delete --}}
                            @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('borrows.destroy', $borrow) }}"
                                      onsubmit="return confirm('Delete this borrow record?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; color:#94a3b8; padding:2rem;">
                        No borrow records found.
                        <a href="{{ route('borrows.create') }}">Create one?</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-wrap">
    {{ $borrows->links() }}
</div>
@endsection
