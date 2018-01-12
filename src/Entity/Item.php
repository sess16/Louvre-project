<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 06/01/2018
 * Time: 17:46
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks()
 */
class Item
{
    const ADULT_RATE = 1;
    const CHILD_RATE = 2;
    const SENIOR_RATE = 3;
    const REDUCED_RATE = 4;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Veuillez entrer un prénom.")
     * @Assert\Regex(pattern="/\d/", match=false, message="Pas de chiffre dans votre prénom.")
     * @Assert\Length(min=2, max=45,
     *     minMessage="Un prénom doit avoir au moins 2 caractères.",
     *     maxMessage="45 caractères maximum.")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="Veuillez entrer un nom.")
     * @Assert\Regex(pattern="/\d/", match=false, message="Pas de chiffre dans votre nom.")
     * @Assert\Length(min=2, max=45,
     *     minMessage="Un nom doit avoir au moins 2 caractères.",
     *     maxMessage="45 caractères maximum.")
     */
    private $lastName;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Veuillez entrer une date de naissance.")
     */
    private $birthDate;

    /**
     * @var \App\Entity\Country
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @var boolean
     */
    private $isReducedRate;

    /**
     * @var integer
     */
    private $ticketRate;

    /**
     * @var \App\Entity\Ticket
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Ticket")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket;

    /**
     * @var \App\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = ucfirst(strtolower($firstName));
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = ucfirst(strtolower($lastName));
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return bool
     */
    public function isReducedRate()
    {
        return $this->isReducedRate;
    }

    /**
     * @param bool $isReducedRate
     */
    public function setReducedRate($isReducedRate)
    {
        $this->isReducedRate = $isReducedRate;
    }

    /**
     * @return int
     */
    public function getTicketRate()
    {
        return $this->ticketRate;
    }

    /**
     * @param int $ticketRate
     */
    public function setTicketRate($ticketRate)
    {
        $this->ticketRate = $ticketRate;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param Ticket $ticket
     */
    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Function to determine the ticket rate
     * @ORM\PrePersist()
     */
    public function calculateTicketRate()
    {
        //calculate the age range of the ticket
        $interval = date_diff($this->order->getVenueDate(), $this->birthDate, $differenceFormat = '%y');
        $age = $interval->format($differenceFormat);
        if ($age < 4) {
            //this should not happen !
            throw new \LogicException("Minimum de 4 ans pour pourvoir acheter un ticket.");
        }
        //by default rate is adult rate
        $rate = self::ADULT_RATE;
        //check if we have a reduced rate selected
        if ($this->isReducedRate()) {
            $rate = self::REDUCED_RATE;
        } else if ($age >= 60) {
            $rate = self::SENIOR_RATE;
        } else if ($age >= 4 && $age <= 12) {
            $rate = self::CHILD_RATE;
        }
        $this->ticketRate = $rate;
    }

}