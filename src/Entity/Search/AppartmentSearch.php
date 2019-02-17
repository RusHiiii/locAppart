<?php
/**
 * Created by PhpStorm.
 * User: Flo
 * Date: 17/02/2019
 * Time: 14:20
 */

namespace App\Entity\Search;


class AppartmentSearch
{
    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $department;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var boolean|null
     */
    private $garage;

    /**
     * @var boolean|null
     */
    private $locker;

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return AppartmentSearch
     */
    public function setDescription(?string $description): AppartmentSearch
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @param string|null $department
     * @return AppartmentSearch
     */
    public function setDepartment(?string $department): AppartmentSearch
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return AppartmentSearch
     */
    public function setCity(?string $city): AppartmentSearch
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return AppartmentSearch
     */
    public function setMaxPrice(?int $maxPrice): AppartmentSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getGarage(): ?bool
    {
        return $this->garage;
    }

    /**
     * @param bool|null $garage
     * @return AppartmentSearch
     */
    public function setGarage(?bool $garage): AppartmentSearch
    {
        $this->garage = $garage;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getLocker(): ?bool
    {
        return $this->locker;
    }

    /**
     * @param bool|null $locker
     * @return AppartmentSearch
     */
    public function setLocker(?bool $locker): AppartmentSearch
    {
        $this->locker = $locker;
        return $this;
    }
}