<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Services\LeadSubmissionService;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function __construct(
        private readonly LeadSubmissionService $leads,
    ) {}

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $lead = $this->leads->create($request->validated(), $request);

        return response()->json([
            'ok' => true,
            'id' => $lead->id,
            'message' => 'Заявка принята. Мы свяжемся с вами в ближайшее время.',
        ]);
    }
}
