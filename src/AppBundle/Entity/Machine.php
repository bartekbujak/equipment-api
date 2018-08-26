<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Machine
 *
 * @ORM\Table(name="machines")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MachineRepository")
 */
class Machine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="day", type="string", length=3)
     * @Assert\Choice({"Mon", "Tue", "Wen", "Thu", "Fri", "Sat", "Sun"})
     */
    private $day;


    /**
     * @var string
     *
     * @Assert\Regex("/(?:2[0-4]|[01][1-9]|10):([0-5][0-9])-(?:2[0-4]|[01][1-9]|10):([0-5][0-9])/")
     * @ORM\Column(name="hours", type="string", length=11)
     */
    private $hours;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Machine
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set day
     *
     * @param string $day
     *
     * @return Machine
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set hours
     *
     * @param string $hours
     *
     * @return Machine
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return string
     */
    public function getHours()
    {
        return $this->hours;
    }

    public function getStartHour() {
        $explode = explode('-', $this->hours);

        return $explode[0];
    }

    public function getEndHour()
    {
        $explode = explode('-', $this->hours);

        return $explode[1];
    }
}

