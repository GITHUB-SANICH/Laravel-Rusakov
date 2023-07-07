<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        echo 'Запись наблюдателя: запись с ID == '.$post->id.' создана.<br>';
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        echo 'Запись наблюдателя: запись с ID == '.$post->id.' обнавлена.<br>';
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        echo 'Запись наблюдателя: запись с ID == '.$post->id.' удалена.<br>';
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        echo 'Запись наблюдателя: запись с ID == '.$post->id.' восстановлена после удаления.<br>';
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        echo 'Запись наблюдателя: запись с ID == '.$post->id.' удалена безвозвратно.<br>';
    }
}
