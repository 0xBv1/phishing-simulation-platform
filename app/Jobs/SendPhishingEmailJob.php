<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignTarget;
use App\Models\EmailTemplate;
use App\Models\Interaction;
use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPhishingEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $timeout = 60;
    public $tries = 3;

    protected $targetEmail;
    protected $targetName;
    protected $campaign;
    protected $template;
    protected $uniqueToken;
    protected $interactionId;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $targetEmail,
        string $targetName,
        Campaign $campaign,
        EmailTemplate $template,
        string $uniqueToken,
        int $interactionId
    ) {
        $this->targetEmail = $targetEmail;
        $this->targetName = $targetName;
        $this->campaign = $campaign;
        $this->template = $template;
        $this->uniqueToken = $uniqueToken;
        $this->interactionId = $interactionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Prepare email content
            $emailContent = $this->prepareEmailContent();
            
            // Send the email
            $this->sendEmail($emailContent);
            
            // Log successful send
            Log::info('Phishing email sent successfully', [
                'target_email' => $this->targetEmail,
                'campaign_id' => $this->campaign->id,
                'token' => $this->uniqueToken
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send phishing email', [
                'target_email' => $this->targetEmail,
                'campaign_id' => $this->campaign->id,
                'error' => $e->getMessage()
            ]);
            
            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Prepare email content with personalized data
     */
    protected function prepareEmailContent(): array
    {
        $fakeLink = $this->generateFakeLink();
        $trackingPixel = $this->generateTrackingPixel();
        
        // Replace placeholders in template
        $htmlContent = $this->template->html_content;
        $htmlContent = str_replace('{{name}}', $this->targetName, $htmlContent);
        $htmlContent = str_replace('{{email}}', $this->targetEmail, $htmlContent);
        $htmlContent = str_replace('{{fake_link}}', $fakeLink, $htmlContent);
        $htmlContent = str_replace('{{reset_link}}', $fakeLink, $htmlContent);
        $htmlContent = str_replace('{{login_link}}', $fakeLink, $htmlContent);
        $htmlContent = str_replace('{{verify_link}}', $fakeLink, $htmlContent);
        $htmlContent = str_replace('{{tracking_pixel}}', $trackingPixel, $htmlContent);
        $htmlContent = str_replace('{{campaign_name}}', $this->campaign->type, $htmlContent);

        return [
            'subject' => $this->generateEmailSubject(),
            'html_content' => $htmlContent,
            'fake_link' => $fakeLink,
            'tracking_pixel' => $trackingPixel,
        ];
    }

    /**
     * Generate fake link for phishing simulation
     */
    protected function generateFakeLink(): string
    {
        $baseUrl = config('app.url');
        return "{$baseUrl}/campaign/{$this->uniqueToken}";
    }

    /**
     * Generate tracking pixel for email opens
     */
    protected function generateTrackingPixel(): string
    {
        $baseUrl = config('app.url');
        return "{$baseUrl}/track/{$this->uniqueToken}/opened";
    }

    /**
     * Generate email subject based on campaign type
     */
    protected function generateEmailSubject(): string
    {
        $subjects = [
            'phishing' => [
                'Urgent: Verify Your Account Security',
                'Action Required: Suspicious Activity Detected',
                'Important: Update Your Password Immediately',
                'Security Alert: Unauthorized Login Attempt',
                'Account Verification Required'
            ],
            'awareness' => [
                'Security Training: Phishing Awareness',
                'Monthly Security Update',
                'Cybersecurity Best Practices',
                'Security Awareness Training',
                'Protect Your Digital Identity'
            ],
            'training' => [
                'Security Training Module Available',
                'Complete Your Security Training',
                'New Security Training Content',
                'Security Education Update',
                'Training Reminder: Cybersecurity'
            ]
        ];

        $campaignType = $this->campaign->type;
        $availableSubjects = $subjects[$campaignType] ?? $subjects['phishing'];
        
        return $availableSubjects[array_rand($availableSubjects)];
    }

    /**
     * Send the email using Laravel Mail
     */
    protected function sendEmail(array $emailContent): void
    {
        // For simulation purposes, we'll use a simple mail implementation
        // In production, you would use proper mail drivers
        
        Mail::raw($emailContent['html_content'], function ($message) use ($emailContent) {
            $message->to($this->targetEmail, $this->targetName)
                   ->subject($emailContent['subject'])
                   ->from(config('mail.from.address'), config('mail.from.name'));
        });

        // Alternative: Use a custom Mailable class for better HTML support
        // Mail::to($this->targetEmail)->send(new PhishingEmailMailable($emailContent));
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendPhishingEmailJob failed permanently', [
            'target_email' => $this->targetEmail,
            'campaign_id' => $this->campaign->id,
            'token' => $this->uniqueToken,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);

        // Update interaction record to reflect failure
        if ($this->interactionId) {
            $interaction = Interaction::find($this->interactionId);
            if ($interaction) {
                $interaction->update([
                    'action_type' => 'failed',
                    'timestamp' => now(),
                ]);
            }
        }
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'campaign:' . $this->campaign->id,
            'email:' . $this->targetEmail,
            'type:phishing'
        ];
    }
}
