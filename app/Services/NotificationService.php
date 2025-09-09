<?php

namespace App\Services;

use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Collection;

class NotificationService extends Service implements NotificationServiceInterface
{
    protected NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->notificationRepository = $repository;
    }

    public function getUnreadCount(): int
    {
        return $this->notificationRepository->getUnreadCount();
    }

    public function getUnreadNotifications(int $limit = 10): Collection
    {
        return $this->notificationRepository->getUnreadNotifications($limit);
    }

    public function markAllAsRead(): void
    {
        $this->notificationRepository->markAllAsRead();
    }
}
