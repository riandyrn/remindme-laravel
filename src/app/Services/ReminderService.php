<?php

namespace App\Services;

use App\DataTransferObjects\Reminder\CreateDto;
use App\DataTransferObjects\Reminder\ListsDto;
use App\Http\Transformers\Api\Reminder\CreateTransformer;
use App\Http\Transformers\Api\Reminder\ListsTransformer;
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


}
