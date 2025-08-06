<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;
use App\Models\Event;
use App\Models\Service;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Support;
use App\Models\Message;
use App\Models\EventService;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_date',
        'status',
    ];

    protected $allowedIncludes = [
        'roles',
        'events',
        'events.eventSecurities',
        'events.activityEvents',
        'events.eventResources',
        'events.eventServices',
        'events.eventServices.service',
        'events.eventServices.provider',
        'feedbacks',
        'payments',
        'notifications',
        'supports',
        'messagesSent',
        'messagesReceived',
        'eventServicesProvided',
        'organizedEvents'
];

    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'registration_date',
        'status',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function eventServicesProvided()
    {
        return $this->hasMany(EventService::class, 'provider_id');
    }

    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }


    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowedIncludes) || empty(request('included'))) {
            return $query;
        }

        $relations = explode(',', request('included'));
        $allowed = collect($this->allowedIncludes);

        $validRelations = array_filter($relations, fn($rel) => $allowed->contains($rel));

        return $query->with($validRelations);
    }

    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowedFilters) || empty(request('filter'))) {
            return $query;
        }

        $filters = request('filter');
        $allowed = collect($this->allowedFilters);

        foreach ($filters as $field => $value) {
            if ($allowed->contains($field)) {
                $query->where($field, 'LIKE', "%$value%");
            }
        }

        return $query;
    }
}
