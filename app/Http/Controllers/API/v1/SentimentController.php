<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SentimentAnalysisRequest;
use App\Service\API\v1\SentimentAnalysisService;
use Illuminate\Http\Request;

class SentimentController extends Controller
{
    public function analyze(SentimentAnalysisRequest $request, SentimentAnalysisService $sentimentAnalysisService)
    {
        $data = $request->validated();
        return $sentimentAnalysisService->analyze($data['content']);
    }



}
