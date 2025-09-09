<?php

namespace App\Repositories\Interfaces;

interface NotificationRepositoryInterface extends BaseRepository
{
    public function getUnreadCount(): int;

    public function getUnreadNotifications(int $limit = 10): \Illuminate\Support\Collection;

    public function markAllAsRead(): void;
}
