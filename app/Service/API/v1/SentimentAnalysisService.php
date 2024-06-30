<?php

namespace App\Service\API\v1;

use App\Models\Sentiment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HTTPRESPONSE;

class SentimentAnalysisService
{
    protected array $emojis = [];
    public function analyze(string $content): string
    {
        $this->emojis = $this->getEmojis($content);
        try {
            $totalSentimentScore = 0;

            foreach ($this->emojis as $emoji) {
                $sentimentScore = $this->calculateSentimentScore($emoji);
                $totalSentimentScore += $sentimentScore;
            }

            $this->saveSentimentAnalysis($content, $totalSentimentScore, json_encode($this->emojis));
            return response()->json([
                'message' => 'Sentiment analysis completed successfully',
                'sentiment_score' => $totalSentimentScore,
                'emojis' => $this->emojis,
            ], HTTPRESPONSE::HTTP_OK);

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

        return $matches[0];
    }

    protected function saveSentimentAnalysis(string $content, int $sentimentScore, string $emojis): void
    {
        Sentiment::create([
            'content' => $content,
            'sentiment_score' => $sentimentScore,
            'emoji' => $emojis,
        ]);
    }
}
