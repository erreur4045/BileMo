<?php

/**
 * Create by maxime
 * Date 2/22/2020
 * Time 12:10 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : EventSubscriber.php as EventSubscriber
 */

namespace App\Domain\Subscriber;

use App\Exception\InputExceptions;
use App\Responder\ResponderJson;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class EventSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if ($event->getThrowable()->getCode() and $event->getThrowable()->getCode() > 200) {
            $code = $event->getThrowable()->getCode();
        } elseif (method_exists($event->getThrowable(), 'getStatusCode') == true) {
            $code = $event->getThrowable()->getStatusCode();
        } else {
            $code = 404;
        }
        $message = [
            'message' => $event->getThrowable()->getMessage(),
            'code' => $code
        ];
        switch (get_class($event->getThrowable())) {
            case InputExceptions::class:
                $message['message'] = $event->getThrowable()->getErrors();
                $message['code'] = 400;
                $code = 400;
                break;
            case MethodNotAllowedHttpException::class:
                $message['message'] = $event->getThrowable()->getMessage();
                $message['code'] = 405;
                break;
            case NotEncodableValueException::class:
                if (strpos($event->getThrowable()->getMessage(), 'Syntax')) {
                    $message['message'] = 'No content, request seems empty, header Content-Type missing, Synxtax error';
                } else {
                    $message['message'] = $event->getThrowable()->getMessage();
                }
                $message['code'] = 400;
                $code = 400;
                break;
            case NotFoundHttpException::class:
                if (strpos($event->getThrowable()->getMessage(), 'controller')) {
                    $message['message'] = 'No content, request seems empty or header Content-Type missing';
                } else {
                    $message['message'] = $event->getThrowable()->getMessage();
                }
                $message['code'] = 404;
                break;
            case HttpException::class:
                break;
        }
        $event->setResponse(ResponderJson::response($message, $code));
    }
}
