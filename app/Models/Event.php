<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\EventResource;
use App\Models\EventSecurity;
use App\Models\ActivityEvent;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\EventService;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'status',
    ];

    protected $allowedIncludes = [
        // Relaciones directas
        'organizer',
        'users',
        'resources',
        'securities',
        'activities',
        'payments',
        'feedbacks',
        'eventServices',
        'organizer.roles',
        'organizer.services',
        'organizer.notifications',
        'organizer.payments',
        'organizer.feedbacks',
        'organizer.supports',
        'organizer.messagesSent',
        'organizer.messagesReceived',
        'users.roles',
        'users.services',
        'users.notifications',
        'users.payments',
        'users.feedbacks',
        'users.supports',
        'users.messagesSent',
        'users.messagesReceived',
        'eventServices.service',
        'eventServices.provider',
    ];

    protected $allowedFilters = [
        'organizer_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'status',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function resources()
    {
        return $this->hasMany(EventResource::class);
    }

    public function securities()
    {
        return $this->hasMany(EventSecurity::class);
    }

    public function activities()
    {
        return $this->hasMany(ActivityEvent::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function eventServices()
    {
        return $this->hasMany(EventService::class);
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
