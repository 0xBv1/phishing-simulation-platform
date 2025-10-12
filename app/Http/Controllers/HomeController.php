<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::guard('company')->check()) {
            $company = Auth::guard('company')->user();
            
            // Redirect based on role
            switch ($company->role ?? 'client') {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'developer':
                    return redirect()->route('api.documentation');
                case 'client':
                default:
                    return redirect()->route('client.dashboard');
            }
        }

        return view('home');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard()
    {
        $company = Auth::guard('company')->user();
        
        if ($company->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $stats = [
            'total_companies' => \App\Models\Company::count(),
            'total_campaigns' => \App\Models\Campaign::count(),
            'total_users' => \App\Models\User::count(),
            'total_revenue' => \App\Models\Payment::where('status', 'completed')->sum('amount'),
        ];

        return view('admin.dashboard', compact('company', 'stats'));
    }

    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clientDashboard()
    {
        $company = Auth::guard('company')->user();
        
        $stats = [
            'total_campaigns' => $company->campaigns()->count(),
            'active_campaigns' => $company->campaigns()->where('status', 'active')->count(),
            'total_targets' => \App\Models\CampaignTarget::whereHas('campaign', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
            'total_interactions' => \App\Models\Interaction::whereHas('campaign', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->count(),
        ];

        $recentCampaigns = $company->campaigns()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('client.dashboard', compact('company', 'stats', 'recentCampaigns'));
    }
}
