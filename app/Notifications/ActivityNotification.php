<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database'];  Add 'database' as a delivery channel
        return ['database']; // Add 'database' as a delivery channel
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = $this->getMessage();

        return (new MailMessage)
            ->line($message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->getMessage(),
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => $this->getMessage(),
            // Add any additional data you want to store in the database
        ];
    }

    /**
     * Get the notification message based on the type and data.
     *
     * @return string
     */
    protected function getMessage(): string
    {
        switch ($this->type) {
            case 'new_thread':
                $message = $this->data['message'];
                $user = $this->data['user'];

                return $message;

                case 'new_post':
                    $post = $this->data['post'];
                    $msg = $this->data['message']; // User who posted
                  

                    return $msg;
                
            case 'new_category':
                $category = $this->data['category'];
                $user = $this->data['user'];
                $role = $user->role ?? 'User'; // Default to 'User' if role is not available

                return "New category '{$category->name}' created by $role $user->name";
            case 'new_reply':
                $reply = $this->data['reply'];
                $user = $this->data['user'];
                $postUrl = route('threads.show', ['category' => $reply->category, 'thread' => $reply->thread]).'#post-' . $reply->post->id;
                $message = "<a href='$postUrl'>New reply by $user->name on your post</a>";
                return $message;

            case 'new_report':
                $message = $this->data['message'];
               
                        return $message;
                        
            case 'report':
                $message = $this->data['message'];
               
                        return $message;
                
                break;
            default:
                return '';
        }
    }

}
