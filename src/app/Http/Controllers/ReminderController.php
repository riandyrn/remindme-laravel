<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\ReminderResource;
use App\Services\ReminderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * @var ReminderService
     */
    private ReminderService $reminderService;

    /**
     * @param ReminderService $reminderService
     */
    public function __construct(ReminderService $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $userId = $request->user()->id;
        return Helper::apiResponse(
            ReminderResource::collection($this->reminderService->listReminder($userId, $limit))
                ->additional(['limit' => $limit])
        );
    }
}
