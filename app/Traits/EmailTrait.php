<?php
namespace App\Traits;
use Illuminate\Support\Facades\Mail;

trait EmailTrait
{
    public function sendEmail($to, $subject, $content)
    {
        try {
            Mail::send([], [], function ($message) use ($to, $subject, $content) {
                $message->to($to)
                        ->subject($subject)
                        ->html($content);
            });
    
            return 'Email sent successfully!';
        } catch (\Exception $e) {
            return 'Error sending email: ' . $e->getMessage();
        }
    }
}

?>