<?php

namespace App\Http\Traits;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Like;

trait Likeable
{

    public function scopeWithLikes(Builder $query)
    {
        $likes = DB::table('likes')
                   ->select('likeable_id', 'likeable_type', DB::raw('sum(liked) likes'), DB::raw('sum(not liked) dislikes'))
                   ->where('likeable_type', get_class())
                   ->groupBy('likeable_id', 'likeable_type');
        $query->leftJoinSub(
            $likes,
            'likes',
            function ($join) {
                $join->on('likes.likeable_id', '=', get_class()::getTable().'.id');
            }
        );

        
    }

    public function scopeLikeableWithLikes(Builder $query, $id)
    {
        $likes = DB::table('likes')
                   ->select('likeable_id', 'likeable_type', DB::raw('sum(liked) likes'), DB::raw('sum(not liked) dislikes'))
                   ->where('likeable_type', get_class())
                   ->groupBy('likeable_id', 'likeable_type');
        $query->leftJoinSub(
            $likes,
            'likes',
            function ($join) use($id) {
                $join->on('likes.likeable_id', '=', get_class()::getTable().'.id');
            }
        )->where(get_class()::getTable().'.id', $id);

        
    }

    
    public function like($user = null, $liked = true)
    {
        $this->likes()->updateOrCreate(
            [
                'user_id' => $user ? $user->id : auth()->id(),
            ],
            [
                'liked' => $liked,
            ]
        );
    }

    public function dislike($user = null)
    {
        return $this->like($user, false);
    }

    public function unlike(?User $user = null)
    {
        $this->likes->where('user_id', $user->id ?? auth()->id())->first()->delete();
    }

    public function isLikedBy(User $user, $liked = true)
    {
        return (bool) $user->likes->where('likeable_id', $this->id)->where('liked', $liked)->where('likeable_type', get_class())->count();
    }

    public function isDislikedBy(User $user)
    {
        return $this->isLikedBy($user, false);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}