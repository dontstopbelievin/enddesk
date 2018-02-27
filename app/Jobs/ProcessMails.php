<?php

namespace App\Jobs;
use Mail;
use App\User;
use App\Mail\NotifyAdmins;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $my_req_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
      $this->my_req_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Notify admins
        //$users = User::where('usertype_id', '3')->get(); //Use this to restrict by usertype
        $users = User::all();
        $emails = [];
        foreach($users as $user){
          $emails[] = $user->email;
        }
        Mail::to($emails)->send(new NotifyAdmins($this->my_req_id));
    }
}
