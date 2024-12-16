<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardRecordResource;
use App\Services\CardRecordService;
use Exception;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request, CardRecordService $cardRecordService)
    {
        $specializationId = $request->input('specialization_id');

        if (!$specializationId) {
            return response()->json(['message' => 'Спеціалізація не обрана.'], 400);
        }

        try {
            $cardRecords = $cardRecordService->getCardRecordsBySpecialization($specializationId, $request->user()->id);

            return CardRecordResource::collection($cardRecords)->resolve();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function getSpecializations(Request $request)
    {
        $specializations = $request->user()->patient->cards()
            ->with('specialization:id,name')
            ->get()
            ->pluck('specialization');

        return response()->json($specializations);
    }
}
