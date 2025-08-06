<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Event;

class ActivityEvent extends Model
{
    use HasFactory;
    protected $table = 'activityEvents';

    protected $fillable = [
        'event_id',
        'activity_type',
        'status',
        'timestamp',
    ];

    protected $allowedIncludes = [
        'event',
        'event.organizer',
        'event.users',
        'event.resources',
        'event.securities',
        'event.activities',
        'event.payments',
        'event.feedbacks',
        'event.eventServices',
        'event.organizer.roles',
        'event.organizer.services',
        'event.organizer.notifications',
        'event.organizer.payments',
        'event.organizer.feedbacks',
        'event.organizer.supports',
        'event.organizer.messagesSent',
        'event.organizer.messagesReceived',
    ];

    protected $allowedFilters = [
        'event_id',
        'activity_type',
        'status',
        'timestamp',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
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
