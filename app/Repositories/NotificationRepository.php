<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Support\Collection;

class NotificationRepository extends Repository implements NotificationRepositoryInterface
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function getUnreadCount(): int
    {
        return $this->model->whereNull('read_at')->count();
    }

    public function getUnreadNotifications(int $limit = 10): Collection
    {
        return $this->model->whereNull('read_at')->latest()->take($limit)->get();
    }

    public function markAllAsRead(): void
    {
        $this->model->whereNull('read_at')->update(['read_at' => now()]);
    }
}
