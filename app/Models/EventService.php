<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Event;   
use App\Models\Service; 
use App\Models\User;

class EventService extends Model
{
    use HasFactory;

    protected $table = "eventServices";

    protected $fillable = [
        'service_id',
        'event_id',
        'provider_id',
        'status',
    ];

    protected $allowedIncludes = [
        'event',
        'service',
        'provider',
        'provider.roles',
        'provider.messagesSent',
        'provider.messagesReceived',
        'provider.payments',
        'provider.feedbacks',
        'provider.notifications',
        'provider.supports',
        'provider.events',
        'provider.services',
        'event.users',
        'event.resources',
        'event.securities',
        'event.activities',
        'event.services',
        'event.payments',
        'event.feedbacks',
        'service.users',
        'service.events'
    ];

    protected $allowedFilters = [
        'service_id',
        'event_id',
        'provider_id',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
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
