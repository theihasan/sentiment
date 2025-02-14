<?php

namespace App\Livewire;

use App\Jobs\SentimentCalculation;
use Livewire\Attributes\On;
use Livewire\Component;

class TextForm extends Component
{
    public $content;
    public $result;

    public function render()
    {
        return view('livewire.text-form');
    }

    public function submit(): void
    {
        $this->validate([
            'content' => 'required|string|min:3',
        ]);

        $text = $this->content;
        $this->content = '';

        SentimentCalculation::dispatch($text);
        $this->result = 'Sentiment calculation in progress. Please wait...';
    }

    #[On('echo:sentiment-analyzed,SentimentAnalyzed')]
    public function dump($sentiment): void
    {
        $this->result = 'Sentiment score: ' . $sentiment['sentiment']['sentiment_score'] .
            '  Emoji: ' . json_encode(json_decode($sentiment['sentiment']['emoji']), JSON_UNESCAPED_UNICODE);
    }


}
