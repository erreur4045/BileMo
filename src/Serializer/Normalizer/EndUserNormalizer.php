<?php

namespace App\Serializer\Normalizer;

use App\Entity\EndUser;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EndUserNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $normalizer;
    private $security;

    public function __construct(ObjectNormalizer $normalizer, Security $security)
    {
        $this->normalizer = $normalizer;
        $this->security = $security;

    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if ($context['groups'] == 'list_users') {
            $data = [
                'id' => $object->getId(),
                'email' => $object->getEmail(),
                '_href'  => [
                    'self' => $_SERVER['REQUEST_URI'],
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
                    'self' => $_SERVER['REQUEST_URI'],
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
