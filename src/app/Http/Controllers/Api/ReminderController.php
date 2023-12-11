<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Reminder\CreateRequest;
use App\DataTransferObjects\Reminder\CreateDto;
use App\DataTransferObjects\Reminder\ListsDto;
use App\DataTransferObjects\Reminder\DetailDto;
use App\DataTransferObjects\Reminder\DeleteDto;
use App\Helpers\ApiFormatter;
use Illuminate\Http\JsonResponse;
use App\Services\ReminderService;
use Exception;

class ReminderController extends Controller
{
    private $reminderService;

    public function __construct(ReminderService $reminderService)
    {
        $this->reminderService = $reminderService;
    }

    public function create(CreateRequest $request): JsonResponse
    {
        try {

            $results = $this->reminderService->create(
                CreateDto::fromApiRequest($request)
            );

            if ( $results && $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    $results['error_code'],
                    $results['message'],
                    $results['status_code'],
                );
            }

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

    public function getLists(Request $request): JsonResponse
    {
        try {
            $results = $this->reminderService->lists(
                ListsDto::fromApiRequest($request)
            );

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

    public function getDetail(Request $request): JsonResponse
    {
        try {
            $results = $this->reminderService->detail(
                DetailDto::fromApiRequest($request)
            );

            if ( $results && $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    $results['error_code'],
                    $results['message'],
                    $results['status_code'],
                );
            }

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $results = $this->reminderService->delete(
                DeleteDto::fromApiRequest($request)
            );

            if ( $results && $results['error_code'] != null ) {
                return ApiFormatter::responseError(
                    $results['error_code'],
                    $results['message'],
                    $results['status_code'],
                );
            }

            return ApiFormatter::responseSuccess(
                $results,
            );

        } catch (Exception $e) {

            return ApiFormatter::responseError(
                'ERR_INTERNAL_SERVER_500',
                $e->getMessage(),
                500
            );

        }
    }

}
