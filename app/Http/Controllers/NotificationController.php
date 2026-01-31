<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display user notifications
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    /**
     * Get unread notifications count (for API)
     */
    public function unreadCount()
    {
        $user = Auth::user();
        $count = $user->unreadNotifications()->count();
        
        // Eager load latest 5 for dropdown
        $notifications = $user->notifications()->latest()->take(5)->get();
        $latest = $notifications->map(function($n) {
            $type = $n->data['type'] ?? 'info';
            $message = $n->data['message'] ?? __('System Notification');

            if ($type == 'new_appointment') {
                 $message = str_replace('Lịch hẹn mới', __('New Appointment'), $message);
            }

            return [
                'id' => $n->id,
                'message' => $message,
                'type' => $type,
                'time' => $n->created_at->diffForHumans(),
                'read_at' => $n->read_at,
                'link' => $n->data['link'] ?? '#',
            ];
        });

        return response()->json([
            'unread_count' => $count,
            'latest_notifications' => $latest
        ]);
    }
}
