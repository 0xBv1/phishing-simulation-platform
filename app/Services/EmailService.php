<?php

namespace App\Services;

use App\Jobs\SendPhishingEmailJob;
use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\EmailTemplate;
use App\Models\Interaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Generate unique token links for each target and queue email jobs
     */
    public function sendCampaignEmails(Campaign $campaign): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        try {
            // Get campaign targets
            $targets = $campaign->targets;
            
            if ($targets->isEmpty()) {
                throw new \Exception('No targets found for this campaign');
            }

            // Get email template
            $template = $this->getEmailTemplate($campaign->type);
            
            if (!$template) {
                throw new \Exception('Email template not found for campaign type: ' . $campaign->type);
            }

            // Process each target
            foreach ($targets as $target) {
                try {
                    $this->processTarget($campaign, $target, $template);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = [
                        'target_email' => $target->email,
                        'error' => $e->getMessage()
                    ];
                    Log::error('Failed to process target: ' . $target->email, [
                        'campaign_id' => $campaign->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Update campaign status
            $campaign->update(['status' => 'sent']);

        } catch (\Exception $e) {
            Log::error('Failed to send campaign emails', [
                'campaign_id' => $campaign->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        return $results;
    }

    /**
     * Process individual target and queue email job
     */
    protected function processTarget(Campaign $campaign, CampaignTarget $target, EmailTemplate $template): void
    {
        // Generate unique token for this target
        $uniqueToken = $this->generateUniqueToken($campaign->id, $target->id);
        
        // Create interaction record
        $interaction = Interaction::create([
            'campaign_id' => $campaign->id,
            'email' => $target->email,
            'action_type' => 'sent',
            'timestamp' => now(),
        ]);

        // Queue the email job
        SendPhishingEmailJob::dispatch(
            $target->email,
            $target->name,
            $campaign,
            $template,
            $uniqueToken,
            $interaction->id
        );

        Log::info('Email queued for target', [
            'campaign_id' => $campaign->id,
            'target_email' => $target->email,
            'token' => $uniqueToken
        ]);
    }

    /**
     * Generate unique token for tracking
     */
    protected function generateUniqueToken(int $campaignId, int $targetId): string
    {
        $timestamp = now()->timestamp;
        $randomString = Str::random(16);
        
        return "{$campaignId}_{$targetId}_{$timestamp}_{$randomString}";
    }

    /**
     * Get email template based on campaign type
     */
    protected function getEmailTemplate(string $campaignType): ?EmailTemplate
    {
        return EmailTemplate::where('type', $campaignType)->first();
    }

    /**
     * Track email interaction (opened, clicked, submitted)
     */
    public function trackInteraction(string $token, string $actionType): array
    {
        try {
            // Parse token to get campaign and target info
            $tokenData = $this->parseToken($token);
            
            if (!$tokenData) {
                throw new \Exception('Invalid token');
            }

            // Find or create interaction record
            $interaction = Interaction::where('campaign_id', $tokenData['campaign_id'])
                ->where('email', $tokenData['email'])
                ->first();

            if (!$interaction) {
                // Create new interaction record if it doesn't exist
                $interaction = Interaction::create([
                    'campaign_id' => $tokenData['campaign_id'],
                    'email' => $tokenData['email'],
                    'action_type' => $actionType,
                    'timestamp' => now(),
                ]);
            } else {
                // Update existing interaction with new action
                $interaction->update([
                    'action_type' => $actionType,
                    'timestamp' => now(),
                ]);
            }

            // Log the interaction
            Log::info('Email interaction tracked', [
                'token' => $token,
                'action_type' => $actionType,
                'campaign_id' => $tokenData['campaign_id'],
                'email' => $tokenData['email']
            ]);

            return [
                'success' => true,
                'message' => 'Interaction tracked successfully',
                'interaction' => $interaction
            ];

        } catch (\Exception $e) {
            Log::error('Failed to track interaction', [
                'token' => $token,
                'action_type' => $actionType,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Parse token to extract campaign and target information
     */
    protected function parseToken(string $token): ?array
    {
        try {
            $parts = explode('_', $token);
            
            if (count($parts) < 4) {
                return null;
            }

            $campaignId = (int) $parts[0];
            $targetId = (int) $parts[1];
            
            // Get target email from database
            $target = CampaignTarget::find($targetId);
            
            if (!$target || $target->campaign_id !== $campaignId) {
                return null;
            }

            return [
                'campaign_id' => $campaignId,
                'target_id' => $targetId,
                'email' => $target->email,
                'timestamp' => $parts[2],
                'random' => $parts[3]
            ];

        } catch (\Exception $e) {
            Log::error('Failed to parse token', [
                'token' => $token,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get campaign statistics
     */
    public function getCampaignStats(Campaign $campaign): array
    {
        $interactions = $campaign->interactions;
        
        $stats = [
            'total_sent' => $interactions->where('action_type', 'sent')->count(),
            'total_opened' => $interactions->where('action_type', 'opened')->count(),
            'total_clicked' => $interactions->where('action_type', 'clicked')->count(),
            'total_submitted' => $interactions->where('action_type', 'submitted')->count(),
            'open_rate' => 0,
            'click_rate' => 0,
            'submit_rate' => 0,
        ];

        if ($stats['total_sent'] > 0) {
            $stats['open_rate'] = round(($stats['total_opened'] / $stats['total_sent']) * 100, 2);
            $stats['click_rate'] = round(($stats['total_clicked'] / $stats['total_sent']) * 100, 2);
            $stats['submit_rate'] = round(($stats['total_submitted'] / $stats['total_sent']) * 100, 2);
        }

        return $stats;
    }

    /**
     * Resend email to specific target
     */
    public function resendEmail(Campaign $campaign, CampaignTarget $target): array
    {
        try {
            $template = $this->getEmailTemplate($campaign->type);
            
            if (!$template) {
                throw new \Exception('Email template not found');
            }

            $this->processTarget($campaign, $target, $template);

            return [
                'success' => true,
                'message' => 'Email queued for resending'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Cancel pending emails for a campaign
     */
    public function cancelCampaignEmails(Campaign $campaign): array
    {
        try {
            // In a real implementation, you would cancel queued jobs
            // For now, we'll just update the campaign status
            $campaign->update(['status' => 'cancelled']);

            Log::info('Campaign emails cancelled', [
                'campaign_id' => $campaign->id
            ]);

            return [
                'success' => true,
                'message' => 'Campaign emails cancelled successfully'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}