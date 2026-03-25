<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        abort_unless($user, 403);

        $notifications = $user
            ->notifications()
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return redirect()->route('my.notifications')
            ->with('success', 'Notification marked as read.');
    }
}
