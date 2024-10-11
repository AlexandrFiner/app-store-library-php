<?php

namespace AppStoreLibrary\AppStoreObjects;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;

/**
 * @property mixed $raw
 */
abstract class BaseAppStoreObject
{
    /** @var array<Property> */
    protected array $properties;
    protected mixed $raw = null;

    /**
     * @throws \Exception
     */
    public static function fromArray(array $data, mixed $raw = null): static
    {
        $instance = new static();
        $instance->raw = $raw ?? $data;
        foreach ($data as $key => $value) {
            $instance->__set($key, $value);
        }
        return $instance;
    }

    private function isPropertyExists(string $key): bool
    {
        return isset($this->properties[$key]);
    }

    /**
     * @throws \Exception
     */
    public function __set(string $key, $value): void
    {
        if (!$this->isPropertyExists($key)) {
            throw new \Exception("Undefined property $key");
        }
        $this->properties[$key]->setValue($value);
    }

    public function __get($key)
    {
        if (!$this->isPropertyExists($key)) {
            if ($key === 'raw') {
                return $this->raw;
            }
            throw new \Exception("Undefined property $key");
        }
        return $this->properties[$key]->getValue();
    }

    public function toResponse(bool $rawDatetime = false): array
    {
        return collect($this->properties)
            ->map(fn(Property $property) => $this->convertPropertyToResponse($property, $rawDatetime))
            ->toArray();
    }

    private function convertPropertyToResponse(Property $property, bool $rawDatetime = false): mixed
    {
        $type = $property->getType();
        $value = $property->getValue();

        $getValueClass = function () use ($type, $value, $property, $rawDatetime) {
            $valueObj = new $type();
            return match (true) {
                // Todo: implement collection of non BaseModel
                $valueObj instanceof Collection => $value->map(
                    fn($item) => $item->toResponse($value)
                )->toArray(),
                $valueObj instanceof BaseAppStoreObject => $value->toResponse(),
                $valueObj instanceof Carbon => $rawDatetime
                    ? (int)$value->getTimestampMs()
                    : $value->toDateTimeString(),
                $valueObj instanceof DateTime => $rawDatetime
                    ? (int)$value->getTimestampMs()
                    : $value->format('Y-m-d H:i:s'),
                default => $value,
            };
        };

        return match (true) {
            is_null($value) => null,
            enum_exists($type) => $value->value,
            class_exists($type) => $getValueClass(),
            default => $value,
        };
    }
}
