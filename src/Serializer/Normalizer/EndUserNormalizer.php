<?php

namespace App\Serializer\Normalizer;

use App\Entity\EndUser;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EndUserNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /** @var ObjectNormalizer  */
    private $normalizer;
    /** @var Security  */
    private $security;
    /** @var RequestStack */
    private $request;
    /** @var RouterInterface */
    private $router;

    /**
     * EndUserNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param Security $security
     * @param RequestStack $request
     * @param RouterInterface $router
     */
    public function __construct(
        ObjectNormalizer $normalizer,
        Security $security,
        RequestStack $request,
        RouterInterface $router
    ) {
        $this->normalizer = $normalizer;
        $this->security = $security;
        $this->request = $request;
        $this->router = $router;
    }


    public function normalize($object, $format = null, array $context = array()): array
    {
        if ($context['groups'] == 'list_users') {
            $data = [
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                'links'  => [
                    'self' => $this->request->getCurrentRequest()->getRequestUri(),
                    'posts' => $this->router->generate('post_user', ['client_id' => $this->whereIs()]),
                    'delete' => $this->router->generate('delete_users', ['client_id' => $this->whereIs(), 'id' => $object->getId()]),
                    'details' => $this->router->generate('get_user', ['client_id' => $this->whereIs(), 'id' => $object->getId()])
                ]
            ];
        } else {
            $data = [
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                'lastname' => $object->getLastname(),
                'fistname' => $object->getFistname(),
                'links'  => [
                    'self' => $this->request->getCurrentRequest()->getRequestUri(),
                    'posts' => $this->router->generate('post_user', ['client_id' => $this->whereIs()]),
                    'delete' => $this->router->generate('delete_users', ['client_id' => $this->whereIs(), 'id' => $object->getId()]),
                ]
            ];
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof EndUser;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    public function whereIs()
    {
        $id = $this->security->getUser()->getId();
        return $id;
    }
}
