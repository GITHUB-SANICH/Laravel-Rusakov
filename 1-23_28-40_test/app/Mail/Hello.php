<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Hello extends Mailable
{
    use Queueable, SerializesModels;
	 public $name;
    /**
     * Create a new message instance.
     */
	 
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
			
				from: new Address('admin@example.com', 'Менеджер'),
            subject: 'Тема письма',
        );
     }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
				view: 'emails.hello',
				text: 'emails.hello_text',
				with: [
					'a' => 10
				],
					//$this->withSymfonyMessage(function($message){
						//$message->getHeaders()->addTextHeader(
							//'My-Header', '123' 
						//);
					//});
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
