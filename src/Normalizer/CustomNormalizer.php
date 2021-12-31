<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Normalizer;

use App\Message\GenericMessage;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectToPopulateTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

// TODO: double check and tidy up - this is a frankenstein class copied from
// here: https://github.com/symfony/symfony/blob/6.0/src/Symfony/Component/Serializer/Normalizer/CustomNormalizer.php
// and here: https://symfony.com/doc/current/serializer/custom_normalizer.html#creating-a-new-normalizer
class CustomNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface, CacheableSupportsMethodInterface
{
    use ObjectToPopulateTrait;
    use SerializerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return $object->normalize($this->serializer, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        dump('denormalizing!');
        return new GenericMessage($type, $data);
    }

    /**
     * Checks if the given class implements the NormalizableInterface.
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        // TODO: void this - we don't need it afaik...
        return $data instanceof NormalizableInterface;
    }

    /**
     * Checks if the given class implements the DenormalizableInterface.
     *
     * @param mixed  $data   Data to denormalize from
     * @param string $type   The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return
            $type === 'StockExchange\StockExchange\Event\Exchange\ExchangeCreated' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\TraderAddedToExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\ShareAddedToExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\ShareAllocatedToTrader' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\ShareAddedToExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\BidAddedToExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\BidRemovedFromExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\AskAddedToExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\AskRemovedFromExchange' ||
            $type === 'StockExchange\StockExchange\Event\Exchange\TradeExecuted'
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return __CLASS__ === static::class;
    }
}