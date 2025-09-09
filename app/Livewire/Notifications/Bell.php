<?php

namespace App\Livewire\Notifications;

use App\Services\Interfaces\NotificationServiceInterface;
use Illuminate\View\View;
use Livewire\Component;

class Bell extends Component
{
    public int $unreadNotificationsCount = 0;

    public function mount(NotificationServiceInterface $notificationService): void
    {
        $this->refreshNotifications($notificationService);
    }

    public function refreshNotifications(NotificationServiceInterface $notificationService): void
    {
        $this->unreadNotificationsCount = $notificationService->getUnreadCount();
    }

    public function getNotificationsProperty(NotificationServiceInterface $notificationService)
    {
        return $notificationService->getUnreadNotifications();
    }

    public function markAllAsRead(NotificationServiceInterface $notificationService): void
    {
        $notificationService->markAllAsRead();
        $this->refreshNotifications($notificationService);
    }

    public function render(): View
    {
        return view('livewire.notifications.bell');
    }
}
