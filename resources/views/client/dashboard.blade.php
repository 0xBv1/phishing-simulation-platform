@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;">
        Welcome, {{ $company->name }}
    </h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h3 style="font-size: 1rem; margin-bottom: 0.5rem; opacity: 0.9;">Total Campaigns</h3>
            <p style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_campaigns'] }}</p>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
            <h3 style="font-size: 1rem; margin-bottom: 0.5rem; opacity: 0.9;">Active Campaigns</h3>
            <p style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['active_campaigns'] }}</p>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
            <h3 style="font-size: 1rem; margin-bottom: 0.5rem; opacity: 0.9;">Total Targets</h3>
            <p style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_targets'] }}</p>
        </div>

        <div class="card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
            <h3 style="font-size: 1rem; margin-bottom: 0.5rem; opacity: 0.9;">Total Interactions</h3>
            <p style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_interactions'] }}</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <div class="card">
            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.5rem; margin: 0;">Recent Campaigns</h2>
                <a href="{{ route('api.campaign.templates') }}" class="btn btn-primary btn-sm">
                    Create New Campaign
                </a>
            </div>
            
            @if($recentCampaigns->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 0.75rem; text-align: left;">Campaign Type</th>
                                <th style="padding: 0.75rem; text-align: left;">Status</th>
                                <th style="padding: 0.75rem; text-align: left;">Start Date</th>
                                <th style="padding: 0.75rem; text-align: left;">End Date</th>
                                <th style="padding: 0.75rem; text-align: left;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentCampaigns as $campaign)
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 0.75rem;">
                                    <span style="text-transform: capitalize;">{{ $campaign->type }}</span>
                                </td>
                                <td style="padding: 0.75rem;">
                                    @if($campaign->status === 'active')
                                        <span style="padding: 0.25rem 0.75rem; background-color: #c6f6d5; color: #22543d; border-radius: 9999px; font-size: 0.875rem;">
                                            Active
                                        </span>
                                    @elseif($campaign->status === 'draft')
                                        <span style="padding: 0.25rem 0.75rem; background-color: #e2e8f0; color: #4a5568; border-radius: 9999px; font-size: 0.875rem;">
                                            Draft
                                        </span>
                                    @elseif($campaign->status === 'completed')
                                        <span style="padding: 0.25rem 0.75rem; background-color: #bee3f8; color: #2c5282; border-radius: 9999px; font-size: 0.875rem;">
                                            Completed
                                        </span>
                                    @else
                                        <span style="padding: 0.25rem 0.75rem; background-color: #fefcbf; color: #744210; border-radius: 9999px; font-size: 0.875rem;">
                                            Paused
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem;">{{ $campaign->start_date->format('M d, Y') }}</td>
                                <td style="padding: 0.75rem;">{{ $campaign->end_date->format('M d, Y') }}</td>
                                <td style="padding: 0.75rem;">
                                    <a href="#" style="color: #2b6cb0; text-decoration: none; margin-right: 1rem;">View</a>
                                    <a href="#" style="color: #2b6cb0; text-decoration: none;">Report</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #718096; padding: 2rem;">
                    No campaigns yet. Create your first campaign to get started!
                </p>
            @endif
        </div>

        <div>
            <div class="card" style="margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Current Plan</h3>
                <p style="font-size: 1.5rem; font-weight: 600; color: #2b6cb0; margin-bottom: 0.5rem;">
                    {{ $company->plan->name }}
                </p>
                <p style="color: #718096;">
                    ${{ number_format($company->plan->price, 2) }}/month
                </p>
                <p style="color: #718096; margin-top: 1rem;">
                    Employee Limit: {{ $company->plan->employee_limit == -1 ? 'Unlimited' : $company->plan->employee_limit }}
                </p>
                <a href="#" class="btn btn-secondary btn-sm" style="margin-top: 1rem;">
                    Upgrade Plan
                </a>
            </div>

            <div class="card">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Quick Actions</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('client.campaigns.create') }}" class="btn btn-primary">
                        Create Campaign
                    </a>
                    <a href="{{ route('client.templates') }}" class="btn btn-secondary">
                        View Templates
                    </a>
                    <a href="{{ route('client.users') }}" class="btn btn-secondary">
                        Manage Users
                    </a>
                    <a href="{{ route('client.reports') }}" class="btn btn-secondary">
                        View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Campaign Performance Overview</h2>
        @php
            $openRate = $stats['total_interactions'] > 0 
                ? (\App\Models\Interaction::whereHas('campaign', function($q) use ($company) {
                    $q->where('company_id', $company->id);
                })->where('action_type', 'opened')->count() / $stats['total_interactions']) * 100 
                : 0;
            
            $clickRate = $stats['total_interactions'] > 0 
                ? (\App\Models\Interaction::whereHas('campaign', function($q) use ($company) {
                    $q->where('company_id', $company->id);
                })->where('action_type', 'clicked')->count() / $stats['total_interactions']) * 100 
                : 0;
        @endphp
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div>
                <h4 style="color: #718096; margin-bottom: 0.5rem;">Average Open Rate</h4>
                <p style="font-size: 1.5rem; font-weight: 600;">
                    {{ number_format($openRate, 1) }}%
                </p>
            </div>
            <div>
                <h4 style="color: #718096; margin-bottom: 0.5rem;">Average Click Rate</h4>
                <p style="font-size: 1.5rem; font-weight: 600;">
                    {{ number_format($clickRate, 1) }}%
                </p>
            </div>
            <div>
                <h4 style="color: #718096; margin-bottom: 0.5rem;">Emails Sent</h4>
                <p style="font-size: 1.5rem; font-weight: 600;">
                    {{ \App\Models\Interaction::whereHas('campaign', function($q) use ($company) {
                        $q->where('company_id', $company->id);
                    })->where('action_type', 'sent')->count() }}
                </p>
            </div>
            <div>
                <h4 style="color: #718096; margin-bottom: 0.5rem;">Users Trained</h4>
                <p style="font-size: 1.5rem; font-weight: 600;">
                    {{ \App\Models\CampaignTarget::whereHas('campaign', function($q) use ($company) {
                        $q->where('company_id', $company->id)->where('type', 'training');
                    })->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
