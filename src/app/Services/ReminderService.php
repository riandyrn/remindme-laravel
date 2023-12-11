<?php

namespace App\Services;

use App\DataTransferObjects\Reminder\CreateDto;
use App\DataTransferObjects\Reminder\ListsDto;
use App\DataTransferObjects\Reminder\DetailDto;
use App\DataTransferObjects\Reminder\DeleteDto;
use App\Http\Transformers\Api\Reminder\CreateTransformer;
use App\Http\Transformers\Api\Reminder\ListsTransformer;
use App\Http\Transformers\Api\Reminder\DetailTransformer;
use App\Http\Transformers\Api\Reminder\DeleteTransformer;
use App\Repositories\ReminderRepository;
use App\Repositories\PersonalAccessTokenRepository;

class ReminderService
{
    private $reminderRepository;

    public function __construct(
        ReminderRepository $reminderRepository,
        PersonalAccessTokenRepository $personalAccessTokenRepository
    )
    {
        $this->reminderRepository = $reminderRepository;
        $this->personalAccessTokenRepository = $personalAccessTokenRepository;
    }

    public function create(CreateDto $dto)
    {
        $token = $this->personalAccessTokenRepository->findByToken($dto->token);
        $userId = $token->tokenable_id;

        $create = $this->reminderRepository->save($dto, $userId);

        return  CreateTransformer::make($create);
    }

    public function lists(ListsDto $dto)
    {
        $lists = $this->reminderRepository->getLimit($dto->limit);

        return  ListsTransformer::make($lists);
    }

    public function detail(DetailDto $dto)
    {
        $detail = $this->reminderRepository->getDetail($dto->id);

        if ( $detail == null ) {
            return [
                'error_code' => 'ERR_NO_RECORD_404',
                'message' => 'No data record.',
                'status_code' => 404,
            ];
        }

        return  DetailTransformer::make($detail);
    }

    public function delete(DeleteDto $dto)
    {
        $detail = $this->reminderRepository->getDetail($dto->id);

        if ( $detail == null ) {
            return [
                'error_code' => 'ERR_NO_RECORD_404',
                'message' => 'No data record.',
                'status_code' => 404,
            ];
        }

        $delete = $this->reminderRepository->delete($dto->id);

        return  $delete;
    }

}
