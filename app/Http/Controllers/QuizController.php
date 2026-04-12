<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizCalculateRequest;
use App\Models\QuizOption;
use App\Models\QuizResult;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function calculate(QuizCalculateRequest $request): JsonResponse
    {
        $answers = array_values($request->validated('answers'));

        $options = QuizOption::query()
            ->whereIn('id', $answers)
            ->get();

        $score = (int) $options->sum('weight');

        $result = QuizResult::query()
            ->where('is_published', true)
            ->where('min_score', '<=', $score)
            ->where('max_score', '>=', $score)
            ->orderBy('sort_order')
            ->with('recommendedService')
            ->first();

        if (! $result) {
            $result = QuizResult::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->with('recommendedService')
                ->first();
        }

        if (! $result) {
            return response()->json([
                'ok' => false,
                'message' => 'Результат не найден.',
            ], 404);
        }

        return response()->json([
            'ok' => true,
            'score' => $score,
            'result' => [
                'title' => $result->title,
                'description' => $result->description,
                'service' => $result->recommendedService?->only(['id', 'name', 'slug']),
            ],
        ]);
    }
}
