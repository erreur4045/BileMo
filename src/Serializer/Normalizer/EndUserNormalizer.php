<?php

namespace App\Serializer\Normalizer;

use App\Entity\EndUser;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
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

    /**
     * EndUserNormalizer constructor.
     * @param ObjectNormalizer $normalizer
     * @param Security $security
     * @param RequestStack $request
     */
    public function __construct(ObjectNormalizer $normalizer, Security $security, RequestStack $request)
    {
        $this->normalizer = $normalizer;
        $this->security = $security;
        $this->request = $request;
    }


    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        if ($context['groups'] == 'list_users') {
            $data = [
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                '_href'  => [
                    'self' => $this->request->getCurrentRequest()->getUri(),
                    'posts' => '/api/users',
                    'delete' => sprintf('/api/clients/%s/users/%s', $this->whereIs(), $object->getId()),
                    'details' => sprintf('/api/users/%s', $object->getId())
                ]
            ];
        } else {
            $data = [
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                'lastname' => $object->getLastname(),
                'fistname' => $object->getFistname(),
                'links'  => [
                    'self' => $this->request->getCurrentRequest()->getUri(),
                    'posts' => sprintf('/api/clients/%s/users/', $this->whereIs()),
                    'delete' => sprintf('/api/clients/%s/users/%s', $this->whereIs(), $object->getId())
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
