<?php

/**
 * Create by maxime
 * Date 2/15/2020
 * Time 12:30 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : CustomNormaliser.php as CustomNormaliser
 */

namespace App\Actions\Domain\FormatData;

use App\Entity\Phone;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CustomNormaliser implements ContextAwareNormalizerInterface
{
    /** @var UrlGeneratorInterface */
    private $router;
/** @var ObjectNormalizer */
    private $normalizer;
/**
     * CustomNormaliser constructor.
     * @param UrlGeneratorInterface $router
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(UrlGeneratorInterface $router, ObjectNormalizer $normalizer)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $context options that normalizers have access to
     */
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Phone;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param mixed $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool|\ArrayObject|null \ArrayObject is
     * used to make sure an empty object is encoded as an object not an array
     *
     * @throws InvalidArgumentException   Occurs when the object given is not a supported type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     * @throws ExceptionInterface         Occurs for all the other cases of errors
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['links']['self'] = $_SERVER['REQUEST_URI'];
        if ($data['links']['self'] != '/api/phones/' . $object->getId()) {
            $data['links']['details'] = '/api/phones/' . $object->getId();
        } else {
            $data['links']['list'] = $this->router->generate('get_phones', [], UrlGeneratorInterface::ABSOLUTE_PATH);
        }
        return $data;
    }
}
