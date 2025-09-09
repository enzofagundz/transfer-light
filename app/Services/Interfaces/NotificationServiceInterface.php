<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface NotificationServiceInterface extends BaseService
{
    public function getUnreadCount(): int;

    public function getUnreadNotifications(int $limit = 10): Collection;

    public function markAllAsRead(): void;
}
