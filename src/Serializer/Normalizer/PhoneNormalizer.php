<?php

namespace App\Serializer\Normalizer;

use App\Entity\Phone;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PhoneNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    private $normalizer;

    /** @var RouterInterface */
    private $router;


    public function __construct(ObjectNormalizer $normalizer, RouterInterface $router)
    {
        $this->normalizer = $normalizer;
        $this->router = $router;
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['links']['self'] = $_SERVER['REQUEST_URI'];
        if ($context['groups'] == 'phone_list') {
            $data['links']['details'] = '/api/phones/' . $object->getId();
        } else {
            $data['links']['list'] = $this->router->generate('get_phones', [], UrlGeneratorInterface::ABSOLUTE_PATH);
        }
        return $data;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Phone;
    }
}
