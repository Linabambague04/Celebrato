<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\EventService;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $allowedIncludes = [
        'users',
        'eventServices',
        'eventServices.event',
        'eventServices.event.users',
        'eventServices.event.eventResources',
        'eventServices.event.eventSecurities',
        'eventServices.event.activityEvents',
        'eventServices.event.eventUsers',
    ];

    protected $allowedFilters = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
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
