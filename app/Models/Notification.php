<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User; 

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'message',
        'read',
        'sent_date',
    ];

    protected $allowedIncludes = [
        'user',
        'event',
        'user.messagesSent',
        'user.messagesReceived',
        'user.roles',
        'user.supports',
        'user.events',
        'user.services',
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
        'message',
        'read',
        'sent_date',
    ];

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
