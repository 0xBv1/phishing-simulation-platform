<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientPageController extends Controller
{
    public function createCampaign()
    {
        $company = Auth::guard('company')->user();
        return view('client.pages.create-campaign', compact('company'));
    }

    public function viewTemplates()
    {
        $company = Auth::guard('company')->user();
        $templates = \App\Models\EmailTemplate::latest()->paginate(12);
        return view('client.pages.templates', compact('company', 'templates'));
    }

    public function manageUsers()
    {
        $company = Auth::guard('company')->user();
        $users = $company->users()->latest()->paginate(15);
        return view('client.pages.users', compact('company', 'users'));
    }

    public function viewReports()
    {
        $company = Auth::guard('company')->user();
        $campaigns = $company->campaigns()->latest()->paginate(10);
        return view('client.pages.reports', compact('company', 'campaigns'));
    }
}



