<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserLoggedIn;
use App\Models\EncryptedFile;

class LogUserLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        $fileIds = session()->get('file_ids');
        if($fileIds){
            EncryptedFile::whereIn('id', $fileIds)->update(['user_id' => $event->user->id]);
        }
        session()->forget('file_ids');
    }
}
