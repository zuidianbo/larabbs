<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
//    public function creating(Reply $reply)
//    {
//        //
//    }
//
//    public function updating(Reply $reply)
//    {
//        //
//    }

//    public function created(Reply $reply)
//    {
//        $reply->topic->increment('reply_count', 1);
//    }


//净化处理
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }


    public function created(Reply $reply)
    {

//        \DB::enableQueryLog();

        $reply->topic->reply_count = $reply->topic->replies->count();

//        dd(\DB::getQueryLog());


        $reply->topic->save();
    }

}