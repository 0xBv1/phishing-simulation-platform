@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700;">Email Templates</h1>
            <a href="{{ route('client.campaigns.create') }}" class="btn btn-primary">Create Campaign</a>
        </div>

        @if($templates->count() === 0)
            <p style="color:#718096;">No templates found.</p>
        @else
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1rem;">
                @foreach($templates as $template)
                    <div class="card" style="padding:1rem;">
                        <h3 style="margin:0 0 .5rem 0;">{{ $template->name }}</h3>
                        <p style="color:#718096; margin-bottom: .5rem; text-transform: capitalize;">Type: {{ $template->type }}</p>
                        <div style="display:flex;gap:.5rem;">
                            <a href="{{ route('client.campaigns.create') }}" class="btn btn-primary">Use</a>
                            <a href="#" class="btn btn-secondary">Preview</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:1rem;">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>
@endsection



