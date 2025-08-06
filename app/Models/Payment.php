<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;  
use App\Models\Event; 

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'event_id',
        'amount',
        'payment_method',
        'status',
        'payment_date'
    ];

    protected $allowedIncludes = [
        'user',
        'user.roles',
        'user.notifications',
        'user.messages',
        'user.feedback',
        'user.support',
        'user.services',
        'event',
        'event.resources',
        'event.security',
        'event.activities',
        'event.services',
        'event.users',
    ];

    protected $allowedFilters = [
        'user_id',
        'event_id',
        'amount',
        'payment_method',
        'status',
        'payment_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
