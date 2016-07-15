<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'body'
    ];

    /**
     * one to many user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * one to many group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feed()
    {
        return $this->belongsTo('App\Models\Feed', 'feed_id');
    }

    /**
     * one to many 2nd comment to itself
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentComment()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    /**
     * one to many 2nd comments to itself
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childComments()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    /**
     * morph to like
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    /**
     * morph to unlikes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unlikes()
    {
        return $this->morphMany('App\Models\Unlike', 'unlikeable');
    }



}
