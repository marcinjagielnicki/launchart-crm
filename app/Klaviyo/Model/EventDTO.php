<?php


namespace App\Klaviyo\Model;


use Illuminate\Contracts\Support\Arrayable;

class EventDTO implements Arrayable
{
    protected string $event;

    protected ?int $timestamp = null;

    protected ?array $properties = null;

    protected array $customerProperties = [];

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    /**
     * @return int|null
     */
    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    /**
     * @param int|null $timestamp
     */
    public function setTimestamp(?int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return array|null
     */
    public function getProperties(): ?array
    {
        return $this->properties;
    }

    /**
     * @param array|null $properties
     */
    public function setProperties(?array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return array
     */
    public function getCustomerProperties(): array
    {
        return $this->customerProperties;
    }

    /**
     * @param array $customerProperties
     */
    public function setCustomerProperties(array $customerProperties): void
    {
        $this->customerProperties = $customerProperties;
    }

    public function toArray(): array
    {
        return [
            'event' => $this->getEvent(),
            'time' => $this->timestamp,
            'customer_properties' => $this->getCustomerProperties(),
            'properties' => $this->getProperties()
        ];
    }
}
