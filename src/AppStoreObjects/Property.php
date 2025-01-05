<?php

namespace AppStoreLibrary\AppStoreObjects;

use Carbon\Carbon;

class Property
{
    private mixed $write;
    private mixed $value = null;
    private mixed $raw = null;

    public function __construct(
        private mixed $type,
        private mixed $arrayItemType = null,
        private mixed $default = null,
        private bool $nullable = true
    ) {
        if (in_array($this->type, ['array', Collection::class]) && !$this->arrayItemType) {
            throw new \Error('Array type requires array item type');
        }
        if (!$this->nullable && is_null($this->default)) {
            throw new \Error('Default value cant be null');
        }
        $this->value = $this->default;
        $this->write = [$this->type];
        if ($this->type === 'float') {
            $this->write[] = 'int';
        }
        if (enum_exists($this->type)) {
            $this->write[] = 'object';
            $this->write[] = (new \ReflectionEnum($this->type))->getBackingType()?->getName();
        } elseif (class_exists($this->type)) {
            $valueObj = new $this->type();
            $this->write[] = 'object';
            $this->write[] = match (true) {
                $valueObj instanceof \DateTime => 'int',
                $valueObj instanceof Signable => 'string',
                $valueObj instanceof BaseAppStoreObject => 'array',
                $valueObj instanceof Collection => 'array',
            };
        }
    }

    public function setValue(mixed $value): self
    {
        $this->raw = $value;
        if (is_null($value)) {
            if (!$this->nullable) {
                throw new \Error('nullable value doesnt accepted');
            }
            $this->value = null;
            return $this;
        }
        $valueType = gettype($value);
        $valueType = match ($valueType) {
            'double' => 'float',
            'integer' => 'int',
            'boolean' => 'bool',
            default => $valueType,
        };
        if (!in_array($valueType, $this->write)) {
            if ($valueType !== 'string') {
                throw new \Exception("Cannot setValue property to type $valueType");
            }

            if (in_array(Carbon::class, $this->write)) {
                $this->value = Carbon::parse($value);
                return $this;
            }

            if (in_array('float', $this->write)) {
                $this->value = (float) $value;
                return $this;
            }

            if (in_array('int', $this->write)) {
                $this->value = (int) $value;
                return $this;
            }

            throw new \Exception("Cannot setValue property to type $valueType");
        }
        if (enum_exists($this->type)) {
            $this->value = $value instanceof $this->type ? $value : $this->type::tryFrom($value);
            return $this;
        }
        if (class_exists($this->type)) {
            $propertyClass = new $this->type();
            if ($propertyClass instanceof Collection) {
                $itemType = $this->arrayItemType;
                if (class_exists($itemType)) {
                    $this->value = collect(
                        match (true) {
                            (new $itemType() instanceof Signable) => array_map(
                                fn($item) => $item instanceof BaseAppStoreObject
                                    ? $item
                                    : $itemType::fromJWS($item),
                                $value
                            ),
                            (new $itemType() instanceof BaseAppStoreObject) => array_map(
                                fn($item) => $item instanceof BaseAppStoreObject
                                    ? $item
                                    : $itemType::fromArray($item),
                                $value
                            ),
                            default => throw new \Exception('Unsupported item type'),
                        }
                    );
                    return $this;
                }
                $this->value = collect($value);
                return $this;
            }

            $this->value = match (true) {
                $propertyClass instanceof \DateTime => $value instanceof \DateTime
                    ? $value
                    : Carbon::createFromTimestampMs($value),
                $propertyClass instanceof Signable => $value instanceof Signable
                    ? $value
                    : $this->type::fromJWS($value),
                $propertyClass instanceof BaseAppStoreObject => $value instanceof BaseAppStoreObject
                    ? $value
                    : $this->type::fromArray($value),
            };
            return $this;
        }
        $this->value = $value;
        if (
            $valueType === 'string'
            && !($this->value = trim($value))
        ) {
            if (!$this->nullable) {
                throw new \Error('nullable value doesnt accepted');
            }
            $this->value = null;
        }
        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getRaw(): mixed
    {
        return $this->raw;
    }

    public function getType(): mixed
    {
        return $this->type;
    }

    public function getDefaultValue(): mixed
    {
        return $this->default;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}
