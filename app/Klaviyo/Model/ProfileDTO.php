<?php


namespace App\Klaviyo\Model;


use Illuminate\Contracts\Support\Arrayable;

class ProfileDTO implements Arrayable
{
    protected ?string $email = null;
    protected ?int $internalId = null;
    protected ?string $firstName = null;
    protected ?string $lastName = null;
    protected ?string $phoneNumber = null;
    protected ?string $title = null;
    protected ?array $customProperties = null;
    protected ?string $klaviyoId = null;


    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array|null
     */
    public function getCustomProperties(): ?array
    {
        return $this->customProperties;
    }

    /**
     * @param array|null $customProperties
     */
    public function setCustomProperties(?array $customProperties): void
    {
        $this->customProperties = $customProperties;
    }

    /**
     * @return string|null
     */
    public function getKlaviyoId(): ?string
    {
        return $this->klaviyoId;
    }

    /**
     * @param string|null $klaviyoId
     */
    public function setKlaviyoId(?string $klaviyoId): void
    {
        $this->klaviyoId = $klaviyoId;
    }

    public function toArray(): array
    {
        return [
                '$email' => $this->getEmail(),
                '$id' => $this->getInternalId(),
                '$first_name' => $this->getFirstName(),
                '$last_name' => $this->getLastName(),
                '$phone_number' => $this->getPhoneNumber(),
                '$title' => $this->getTitle()
            ] + ($this->getCustomProperties() ?? []);
    }

    /**
     * @return int|null
     */
    public function getInternalId(): ?int
    {
        return $this->internalId;
    }

    /**
     * @param int|null $internalId
     */
    public function setInternalId(?int $internalId): void
    {
        $this->internalId = $internalId;
    }
}
