<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ReminderRequest;
use App\Http\Resources\ReminderCollection;
use App\Http\Resources\ReminderResource;
use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $userId = $request->user()->id;
        return Helper::apiResponse(
            new ReminderCollection($this->reminderService->listReminder($userId, $limit), $limit)
        );
    }

    /**
     * @param ReminderRequest $request
     * @return JsonResponse
     */
    public function store(ReminderRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        return Helper::apiResponse(
            new ReminderResource($this->reminderService->createReminder($userId, $request->validated()))
        );
    }

    public function show(Request $request, Reminder $reminder): JsonResponse
    {
        throw_if($reminder->user_id != $request->user()->id, throw new AccessDeniedHttpException());
        return Helper::apiResponse(
            new ReminderResource($reminder)
        );
    }
}
