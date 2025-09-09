<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\Company;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class DashboardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/company/dashboard",
     *     summary="Get company dashboard",
     *     description="Get comprehensive dashboard data including company information, statistics, and recent activity",
     *     tags={"Company"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Dashboard data retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dashboard data retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="company", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Acme Corporation"),
     *                     @OA\Property(property="email", type="string", example="admin@acme.com"),
     *                     @OA\Property(property="plan_id", type="integer", example=2),
     *                     @OA\Property(property="plan", type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Basic"),
     *                         @OA\Property(property="price", type="number", format="float", example=10.00),
     *                         @OA\Property(property="employee_limit", type="integer", example=50)
     *                     )
     *                 ),
     *                 @OA\Property(property="statistics", type="object",
     *                     @OA\Property(property="total_campaigns", type="integer", example=5),
     *                     @OA\Property(property="active_campaigns", type="integer", example=2),
     *                     @OA\Property(property="completed_campaigns", type="integer", example=3),
     *                     @OA\Property(property="total_targets", type="integer", example=150),
     *                     @OA\Property(property="total_interactions", type="integer", example=450),
     *                     @OA\Property(property="successful_simulations", type="integer", example=4),
     *                     @OA\Property(property="vulnerable_employees", type="integer", example=12)
     *                 ),
     *                 @OA\Property(property="recent_activity", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="type", type="string", example="campaign_completed"),
     *                         @OA\Property(property="message", type="string", example="Phishing Campaign #3 completed"),
     *                         @OA\Property(property="timestamp", type="string", format="date-time")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/Error")
     *     )
     * )
     */
    public function dashboard(Request $request)
    {
        $company = $request->user();
        
        // Load relationships and get counts
        $company->load(['plan', 'campaigns', 'users', 'payments']);
        
        // Get campaign statistics
        $campaignsCount = $company->campaigns()->count();
        $activeCampaignsCount = $company->campaigns()
            ->whereIn('status', ['active', 'running'])
            ->count();
        
        // Get user count
        $usersCount = $company->users()->count();
        
        // Get total interactions across all campaigns
        $interactionsCount = $company->campaigns()
            ->withCount('interactions')
            ->get()
            ->sum('interactions_count');
        
        // Get recent campaigns (last 5)
        $recentCampaigns = $company->campaigns()
            ->latest()
            ->limit(5)
            ->get();
        
        // Add computed attributes to the company model
        $company->campaigns_count = $campaignsCount;
        $company->active_campaigns_count = $activeCampaignsCount;
        $company->users_count = $usersCount;
        $company->interactions_count = $interactionsCount;
        $company->recent_campaigns = $recentCampaigns;
        
        return new DashboardResource($company);
    }
}
