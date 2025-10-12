@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Create Campaign</h1>
        <p style="color: #718096; margin-bottom: 1.5rem;">Start a new phishing simulation or awareness campaign.</p>

        <form method="POST" action="{{ url('/api/campaign/create') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="phishing">Phishing</option>
                    <option value="awareness">Awareness</option>
                    <option value="training">Training</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Campaign</button>
            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary" style="margin-left: .5rem;">Cancel</a>
        </form>
    </div>
</div>
@endsection



