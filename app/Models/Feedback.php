<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Event; 
use App\Models\User; 

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedbacks";

    protected $fillable = [
        'user_id',
        'event_id',
        'comment',
        'rating',
        'date',
    ];

    protected $allowedIncludes = [
        'user',
        'event',
        'user.roles',
        'user.events',
        'user.services',
        'user.notifications',
        'user.payments',
        'user.feedbacks',
        'user.supports',
        'user.messagesSent',
        'user.messagesReceived',
        'event.users',
        'event.resources',
        'event.securities',
        'event.activities',
        'event.services',
        'event.payments',
        'event.feedbacks',
        ];

    protected $allowedFilters = [
        'user_id',
        'event_id',
        'comment',
        'rating',
        'date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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

