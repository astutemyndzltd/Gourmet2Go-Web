<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderStatusDetails;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignedOrder extends Notification
{
    use Queueable;

    /**
     * @var Order
     */
    private $order;
    private $orderStatusDetails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order, OrderStatusDetails $orderStatusDetails)
    {
        $this->order = $order;
        $this->orderStatusDetails = $orderStatusDetails;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'fcm'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toFcm($notifiable)
    {
        $message = new FcmMessage();
        $notification = [
            'title' => "Order #" . $this->order->id . " of " . $this->order->user->name ." has been assigned to you",
            'text'         => $this->order->foodOrders[0]->food->restaurant->name,
            'image' => $this->order->foodOrders[0]->food->restaurant->getFirstMediaUrl('image', 'thumb'),
            'icon' => $this->order->foodOrders[0]->food->restaurant->getFirstMediaUrl('image', 'thumb'),
			'sound' => 'default'
        ];
        
        $data = [
            'click_action' => "FLUTTER_NOTIFICATION_CLICK",
            'sound' => 'default',
            'id' => '1',
            'status' => 'done',
            'message' => $notification,
            'order_status' => $this->order->orderStatus->status,
            'status_duration' => isset($this->orderStatusDetails) ? $this->orderStatusDetails->lasts_for : null
        ];

        $message->content($notification)->data($data)->priority(FcmMessage::PRIORITY_HIGH);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order['id'],
        ];
    }
}
