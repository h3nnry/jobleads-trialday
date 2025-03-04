<?php

namespace App\Serializer;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\UnicodeString;

class StringSliceNormalizer implements NormalizerInterface
{
    private const MAX_LENGTH = 100;

    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private readonly NormalizerInterface $normalizer,
    ) {
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $properties = $context ['properties'] ?? [];
        $maxLength = $context ['max_length'] ?? self::MAX_LENGTH;
        $useStringSlice = $context ['use_string_slice'] ?? false;
        $sliceLength = $maxLength - 3;

        if (!$useStringSlice) {
            return $data;
        }

        foreach ($properties as $property) {
            if (is_string($data[$property])) {
                $value = new UnicodeString($data[$property]);
                if ($value->length() <= $maxLength) {
                    continue;
                }

                $value = $value->slice(0,$sliceLength)->append('...');
                $data[$property] = $value->toString();
            }
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null): bool
    {
        return is_object($data);
    }
}

