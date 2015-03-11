<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Upz
 *
 * @ORM\Table(name="upz")
 * @ORM\Entity
 */
class Upz
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_upz", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUpz;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_upz", type="string", length=20, nullable=false)
     */
    private $nombreUpz;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_upz", type="string", length=40, nullable=false)
     */
    private $descripcionUpz;



    /**
     * Get idUpz
     *
     * @return integer 
     */
    public function getIdUpz()
    {
        return $this->idUpz;
    }

    /**
     * Set nombreUpz
     *
     * @param string $nombreUpz
     * @return Upz
     */
    public function setNombreUpz($nombreUpz)
    {
        $this->nombreUpz = $nombreUpz;

        return $this;
    }

    /**
     * Get nombreUpz
     *
     * @return string 
     */
    public function getNombreUpz()
    {
        return $this->nombreUpz;
    }

    /**
     * Set descripcionUpz
     *
     * @param string $descripcionUpz
     * @return Upz
     */
    public function setDescripcionUpz($descripcionUpz)
    {
        $this->descripcionUpz = $descripcionUpz;

        return $this;
    }

    /**
     * Get descripcionUpz
     *
     * @return string 
     */
    public function getDescripcionUpz()
    {
        return $this->descripcionUpz;
    }
}
