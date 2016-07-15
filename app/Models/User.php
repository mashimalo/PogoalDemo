<?php namespace App\Models;

use App\Models\Comment;
use App\Models\Feed;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use SoftDeletes;
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * One to One relation
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    /**
     * Check admin role
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->slug == 'admin';
    }

    /**
     * Check not user role
     *
     * @return bool
     */
    public function isNotUser()
    {
        return $this->role->slug != 'user';
    }

    public function isCurrent()
	    {
        if (Auth::guest()) return false;

	        return Auth::user()->id == $this->id;
	    }

    /**
     * one to many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }

    /**
     * one to many
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photo_albums()
    {
        return $this->hasMany('App\Models\PhotoAlbum');
    }

    /**
     * many to many
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groups()
    {
        return $this->belongsToMany('App\Models\Group')->withPivot('id','group_id','group_user_role_id', 'accepted')->withTimestamps();
    }

    /**
     *
     * one to many feeds,
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany('App\Models\Feed');
    }

    /**
     * one to many comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * user to like one to many
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany('App\Models\Like', 'user_id');
    }
    /**
     * check if the user have like the feed already
     *
     * @param Feed $feed
     * @return bool
     */
    public function hasLikedFeed(Feed $feed)
    {
        return (bool) $feed->likes->where('user_id', $this->id)->count();
    }

    /**
     * check if the user have like the comment already
     * @param \App\Models\Comment $comment
     * @return bool
     */
    public function hasLikedComment(Comment $comment)
    {
        return (bool) $comment->likes->where('user_id', $this->id)->count();
    }

    /**
     * user to unlike one to many
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unlikes()
    {
        return $this->hasMany('App\Models\Unlike', 'user_id');
    }

    /**
     * check if the user have unlike the feed already
     *
     * @param \App\Models\Feed $feed
     * @return bool
     */
    public function hasUnlikedFeed(Feed $feed)
    {
        return (bool) $feed->unlikes->where('user_id', $this->id)->count();
    }

    /**
     * check if the user have unlike the comment already
     * @param \App\Models\Comment $comment
     * @return bool
     */
    public function hasUnlikedComment(Comment $comment)
    {
        return (bool) $comment->unlikes->where('user_id', $this->id)->count();
    }

    /**
     * one to many notification
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }
}
