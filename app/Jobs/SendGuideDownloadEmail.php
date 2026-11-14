<?php

namespace App\Jobs;

use App\Models\LeadDownload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendGuideDownloadEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public LeadDownload $leadDownload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Dispatching '{$this->leadDownload->guide_slug}' guide download email for {$this->leadDownload->email}", [
            'lead_id' => $this->leadDownload->id,
            'name' => $this->leadDownload->name,
            'email' => $this->leadDownload->email,
            'guide_slug' => $this->leadDownload->guide_slug,
        ]);

        // Email delivery simulation / hook for Mailable
        // Mail::to($this->leadDownload->email)->send(new GuideDownloadMail($this->leadDownload));
    }
}

