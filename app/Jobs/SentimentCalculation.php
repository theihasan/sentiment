<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SentimentCalculation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $tries = 3;
    public int $timeout = 120;
    public array $backoff = [15, 30, 60];
    public int $maxExceptions = 3;

    public $emojis;
    /**
     * Create a new job instance.
     */
    public function __construct(public string $text)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $totalSentimentScore = 0;
            $this->emojis = $this->getEmojis($this->text);
            foreach ($this->emojis as $emoji) {
                $sentimentScore = $this->calculateSentimentScore($emoji);
                $totalSentimentScore += $sentimentScore;
            }

            SentimentStore::dispatch($this->text, $totalSentimentScore, $this->emojis);

        } catch (\Exception $e) {
            Log::error('Error in SentimentCalculation Job: ' . $e->getMessage(), [
                'emojis' => $this->emojis,
                'text' => $this->text,
            ]);
        }
    }

    protected function calculateSentimentScore(string $emoji): int
    {
        $emojisConfig = config('emojis');

        $sentimentScore = 0;

        foreach ($emojisConfig as $emotion => $emojiList) {
            if (array_key_exists($emoji, $emojiList)) {
                $sentimentScore += $emojiList[$emoji];
            }
        }

        return $sentimentScore;
    }

    protected function getEmojis(string $text): array
    {
        $emojiRegex = '/[\x{1F600}-\x{1F64F}' .
            '|\x{1F300}-\x{1F5FF}' .
            '|\x{1F680}-\x{1F6FF}' .
            '|\x{2600}-\x{26FF}' .
            '|\x{2700}-\x{27BF}' .
            '|\x{FE00}-\x{FE0F}' .
            '|\x{1F900}-\x{1F9FF}' .
            '|\x{1F018}-\x{1F270}' .
            '|\x{1F22F}' .
            '|\x{1F250}-\x{1F251}' .
            '|\x{1F004}' .
            '|\x{1F0CF}' .
            '|\x{1F170}-\x{1F171}' .
            '|\x{1F17E}-\x{1F17F}' .
            '|\x{1F18E}' .
            '|\x{3030}' .
            '|\x{2B50}' .
            '|\x{2B55}' .
            '|\x{2934}-\x{2935}' .
            '|\x{2B06}-\x{2B07}' .
            '|\x{2B05}' .
            '|\x{27A1}' .
            '|\x{27B0}' .
            '|\x{27BF}' .
            '|\x{24C2}' .
            '|\x{1F191}-\x{1F19A}]/xu';

        preg_match_all($emojiRegex, $text, $matches);

        return  $matches[0];

    }
}
