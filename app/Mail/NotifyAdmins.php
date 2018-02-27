<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\requests;
use App\categories;
use App\priorities;

class NotifyAdmins extends Mailable
{
    use Queueable, SerializesModels;

    protected $my_request;
    protected $my_priority;
    protected $my_category;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->my_request = requests::find($id);
        $this->my_priority = priorities::find($this->my_request->priority_id);
        $this->my_category = categories::find($this->my_request->category_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notify_admins.shipped')->with([
          'my_request' => $this->my_request,
          'my_priority' => $this->my_priority,
          'my_category' => $this->my_category
        ]);
    }
}
