<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eje
 *
 * @ORM\Table(name="eje")
 * @ORM\Entity
 */
class Eje
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_eje", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEje;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_eje", type="string", length=25, nullable=false)
     */
    private $nombreEje;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_eje", type="string", length=150, nullable=false)
     */
    private $descripcionEje;



    /**
     * Get idEje
     *
     * @return integer 
     */
    public function getIdEje()
    {
        return $this->idEje;
    }

    /**
     * Set nombreEje
     *
     * @param string $nombreEje
     * @return Eje
     */
    public function setNombreEje($nombreEje)
    {
        $this->nombreEje = $nombreEje;

        return $this;
    }

    /**
     * Get nombreEje
     *
     * @return string 
     */
    public function getNombreEje()
    {
        return $this->nombreEje;
    }

    /**
     * Set descripcionEje
     *
     * @param string $descripcionEje
     * @return Eje
     */
    public function setDescripcionEje($descripcionEje)
    {
        $this->descripcionEje = $descripcionEje;

        return $this;
    }

    /**
     * Get descripcionEje
     *
     * @return string 
     */
    public function getDescripcionEje()
    {
        return $this->descripcionEje;
    }
}
