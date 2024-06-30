<?php

namespace App\Jobs;

use App\Events\SentimentAnalyzed;
use App\Models\Sentiment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SentimentStore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $tries = 3;
    public int $timeout = 120;
    public array $backoff = [15, 30, 60];
    public int $maxExceptions = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $text, protected int $totalSentimentScore, protected array $emojis)
    {
        //
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $sentiment = Sentiment::create([
                'content' => $this->text,
                'sentiment_score' => $this->totalSentimentScore,
                'emoji' => json_encode($this->emojis),
            ]);
            event(new SentimentAnalyzed($sentiment->toArray()));
        } catch (\Exception $e) {
            Log::error('Error in SentimentStore Job: ' . $e->getMessage(), [
                'text' => $this->text,
                'totalSentimentScore' => $this->totalSentimentScore,
                'emojis' => $this->emojis,
            ]);
        }
    }
}
