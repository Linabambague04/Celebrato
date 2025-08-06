<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'sent_date',
    ];

    protected $allowedIncludes = [
        'sender',
        'receiver',
        'sender.roles',
        'sender.events',
        'sender.services',
        'sender.notifications',
        'sender.payments',
        'sender.feedbacks',
        'sender.supports',
        'sender.messagesSent',
        'sender.messagesReceived',
        'receiver.roles',
        'receiver.events',
        'receiver.services',
        'receiver.notifications',
        'receiver.payments',
        'receiver.feedbacks',
        'receiver.supports',
        'receiver.messagesSent',
        'receiver.messagesReceived',
    ];

    protected $allowedFilters = [
        'sender_id',
        'receiver_id',
        'content',
        'sent_date',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
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
