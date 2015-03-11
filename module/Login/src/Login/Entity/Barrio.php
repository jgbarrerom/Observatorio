<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Barrio
 *
 * @ORM\Table(name="barrio", indexes={@ORM\Index(name="id_upz", columns={"id_upz"})})
 * @ORM\Entity
 */
class Barrio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_barrio", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBarrio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_barrio", type="string", length=30, nullable=false)
     */
    private $nombreBarrio;

    /**
     * @var integer
     *
     * @ORM\Column(name="habitantes_barrio", type="integer", nullable=false)
     */
    private $habitantesBarrio;

    /**
     * @var string
     *
     * @ORM\Column(name="presidenteJunta_barrio", type="string", length=60, nullable=false)
     */
    private $presidentejuntaBarrio;

    /**
     * @var \Login\\Entity\Upz
     *
     * @ORM\ManyToOne(targetEntity="Login\\Entity\Upz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_upz", referencedColumnName="id_upz")
     * })
     */
    private $idUpz;



    /**
     * Get idBarrio
     *
     * @return integer 
     */
    public function getIdBarrio()
    {
        return $this->idBarrio;
    }

    /**
     * Set nombreBarrio
     *
     * @param string $nombreBarrio
     * @return Barrio
     */
    public function setNombreBarrio($nombreBarrio)
    {
        $this->nombreBarrio = $nombreBarrio;

        return $this;
    }

    /**
     * Get nombreBarrio
     *
     * @return string 
     */
    public function getNombreBarrio()
    {
        return $this->nombreBarrio;
    }

    /**
     * Set habitantesBarrio
     *
     * @param integer $habitantesBarrio
     * @return Barrio
     */
    public function setHabitantesBarrio($habitantesBarrio)
    {
        $this->habitantesBarrio = $habitantesBarrio;

        return $this;
    }

    /**
     * Get habitantesBarrio
     *
     * @return integer 
     */
    public function getHabitantesBarrio()
    {
        return $this->habitantesBarrio;
    }

    /**
     * Set presidentejuntaBarrio
     *
     * @param string $presidentejuntaBarrio
     * @return Barrio
     */
    public function setPresidentejuntaBarrio($presidentejuntaBarrio)
    {
        $this->presidentejuntaBarrio = $presidentejuntaBarrio;

        return $this;
    }

    /**
     * Get presidentejuntaBarrio
     *
     * @return string 
     */
    public function getPresidentejuntaBarrio()
    {
        return $this->presidentejuntaBarrio;
    }

    /**
     * Set idUpz
     *
     * @param \Login\Entity\Upz $idUpz
     * @return Barrio
     */
    public function setIdUpz(\Login\Entity\Upz $idUpz = null)
    {
        $this->idUpz = $idUpz;

        return $this;
    }

    /**
     * Get idUpz
     *
     * @return \Login\Entity\Upz 
     */
    public function getIdUpz()
    {
        return $this->idUpz;
    }
}
