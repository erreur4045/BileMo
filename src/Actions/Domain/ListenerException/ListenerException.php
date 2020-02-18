<?php
/**
 * Create by maxime
 * Date 2/17/2020
 * Time 1:31 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : ListenerException.php as ListenerException
 */

namespace App\Actions\Domain\ListenerException;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ListenerException
{
    /** @var SerializerInterface */
    private $serializer;

    /**
     * ListenerException constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        dump($exception);
        $data = [
            'Error' => $exception->getMessage(),
        ];
        if (method_exists($exception, 'getStatusCode'))
            $data['Code'] = $exception->getStatusCode();

        $response = new JsonResponse($data,500,['Content-Type' => 'application/json']);

        // setup the Response object based on the caught exception
        $event->setResponse($response);
    }


}