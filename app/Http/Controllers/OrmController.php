<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Event;
use App\Models\Service;
use App\Models\Message;
use App\Models\Feedback;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Support;
use App\Models\Notification;
use App\Models\EventService;
use Illuminate\Http\Request;

class OrmController extends Controller
{
    public function queries()
    {
        // $users = User::with([
        //     'roles',
        //     'events',
        //     'services',
        //     'notifications',
        //     'payments.event',
        //     'feedbacks.event',
        //     'supports',
        //     'sentMessages.receiver',
        //     'receivedMessages.sender',
        //     'eventServices.event',
        //     'eventServices.service'
        // ])->get();

        // $events = Event::with([
        //     'users',
        //     'organizer',
        //     'eventResources',
        //     'eventSecurity',
        //     'eventActivities',
        //     'payments.user',
        //     'feedbacks.user',
        //     'eventServices.service',
        //     'eventServices.provider'
        // ])->get();

        // $services = Service::with([
        //     'users',
        //     'eventServices.event',
        //     'eventServices.provider'
        // ])->get();

        // $roles = Role::with('users')->get();

        // $eventServices = EventService::with([
        //     'event.organizer',
        //     'service.users',
        //     'provider.sentMessages',
        //     'provider.receivedMessages'
        // ])->get();

        // $payments = Payment::with(['user', 'event'])->get();

        $feedbacks = Feedback::with(['user', 'event'])->get();

    //     $messages = Message::with(['sender', 'receiver'])->get();

    //     $notifications = Notification::with('user')->get();

    //     $supports = Support::with('user')->get();

    //     return response()->json([
    //         'users' => $users,
    //         'events' => $events,
    //         'services' => $services,
    //         'roles' => $roles,
    //         'event_services' => $eventServices,
    //         'payments' => $payments,
    //         'feedbacks' => $feedbacks,
    //         'messages' => $messages,
    //         'notifications' => $notifications,
    //         'supports' => $supports
    //     ]);
    }
}
