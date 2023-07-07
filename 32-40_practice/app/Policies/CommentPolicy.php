<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Session;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    
    /**
     * Determine whether the user can delete the model.
     */  
    public function delete(?User $user, Comment $comment): bool
    {
        return Session::get('access_token') === $comment->access_token;
    }
}
