<?php
namespace NotificationChannels\Sms;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use NotificationChannels\Sms\Exceptions\CouldNotSendNotification;

class SmsChannel
{
    /**
     * @var sms
     */
    protected $sms;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * SmsChannel constructor.
     *
     * @param Sms        $sms
     * @param Dispatcher $events
     */
    public function __construct(Sms $sms, Dispatcher $events)
    {
        $this->sms    = $sms;
        $this->events = $events;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $to      = $this->getTo($notifiable);
            $message = $notification->toSms($notifiable);
            if (is_string($message)) {
                $message = new SmsMessage($message);
            }
            if (!$message instanceof SmsMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }

            return $this->sms->sendMessage($message, $to);
        } catch (Exception $exception) {
            $this->events->dispatch(
                new NotificationFailed($notifiable, $notification, 'sms', ['message' => $exception->getMessage()])
            );
        }
    }

    /**
     * Get the address to send a notification to.
     *
     * @param mixed $notifiable
     * @return mixed
     * @throws CouldNotSendNotification
     */
    protected function getTo($notifiable)
    {
        if ($notifiable->routeNotificationFor('sms')) {
            return $notifiable->routeNotificationFor('sms');
        }
        if (isset($notifiable->phone)) {
            return $notifiable->phone;
        }
        throw CouldNotSendNotification::invalidReceiver();
    }

    /**
     * Get the alphanumeric sender.
     *
     * @param $notifiable
     * @return mixed|null
     * @throws CouldNotSendNotification
     */
    protected function canReceiveAlphanumericSender($notifiable)
    {
        return false;
    }
}
