<?php
/**
 * Created by PhpStorm.
 * User: krasnitskiy
 * Date: 21.05.2019
 * Time: 16:35
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Proxy\Proxy;
use Symfony\Component\Validator\Constraints as Assert;

class Entry
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
     * @Assert\NotBlank()
     * @Assert\Length(min="2")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entryDate", type="datetime")
     */
    private $entryDate;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="2")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $shortUrlCode;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Entry
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set entryDate.
     *
     * @param \DateTime $date
     *
     * @return Entry
     */
    public function setEntryDate($date)
    {
        $this->entryDate = $date;
        return $this;
    }

    /**
     * Get entryDate.
     *
     * @return \DateTime.
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set shortUrlCode.
     *
     * @param string $string
     *
     * @return Entry
     */
    public function setShortUrlCode($string)
    {
        $this->shortUrlCode = $string;
        return $this;
    }

    /**
     * Get shortUrlCode.
     *
     * @return string.
     */
    public function getShortUrlCode()
    {
        return $this->shortUrlCode;
    }



}