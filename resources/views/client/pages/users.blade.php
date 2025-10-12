@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700;">Manage Users</h1>
            <a href="#" class="btn btn-primary">Invite User</a>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:2px solid #e2e8f0;">
                        <th style="padding:.75rem;text-align:left;">Name</th>
                        <th style="padding:.75rem;text-align:left;">Email</th>
                        <th style="padding:.75rem;text-align:left;">Role</th>
                        <th style="padding:.75rem;text-align:left;">Joined</th>
                        <th style="padding:.75rem;text-align:left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom:1px solid #e2e8f0;">
                            <td style="padding:.75rem;">{{ $user->name }}</td>
                            <td style="padding:.75rem;">{{ $user->email }}</td>
                            <td style="padding:.75rem; text-transform: capitalize;">{{ $user->role }}</td>
                            <td style="padding:.75rem;">{{ $user->created_at->format('M d, Y') }}</td>
                            <td style="padding:.75rem;">
                                <a href="#" class="btn btn-secondary btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm" style="margin-left:.5rem;">Remove</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:1rem; text-align:center; color:#718096;">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:1rem;">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection



