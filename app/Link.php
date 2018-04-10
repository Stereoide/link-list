<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'title',
        'read_at',
        'dismissed_at',
        'starred_at',
    ];

    public $dates = ['created_at', 'updated_at', 'read_at', 'dismissed_at', 'starred_at', ];

    /* Scopes */

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->WhereNotNull('read_at');
    }

    public function scopeNotDismissed($query)
    {
        return $query->whereNull('dismissed_at');
    }

    public function scopeDismissed($query)
    {
        return $query->WhereNotNull('dismissed_at');
    }

    public function scopeNotStarred($query)
    {
        return $query->whereNull('starred_at');
    }

    public function scopeStarred($query)
    {
        return $query->WhereNotNull('starred_at');
    }

    /* Methods */

    public function read($timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = Carbon::now();
        }

        $this->read_at = $timestamp;
        $this->save();
    }

    public function unread()
    {
        $this->read_at = null;
        $this->save();
    }

    public function isRead()
    {
        return !is_null($this->read_at);
    }

    public function dismiss($timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = Carbon::now();
        }

        $this->dismissed_at = $timestamp;
        $this->save();
    }

    public function removeDismissal()
    {
        $this->dismissed_at = null;
        $this->save();
    }

    public function isDismissed()
    {
        return !is_null($this->dismissed_at);
    }

    public function star($timestamp = null)
    {
        if (is_null($timestamp)) {
            $timestamp = Carbon::now();
        }

        $this->starred_at = $timestamp;
        $this->save();
    }

    public function removeStar()
    {
        $this->starred_at = null;
        $this->save();
    }

    public function isStarred()
    {
        return !is_null($this->starred_at);
    }
}
