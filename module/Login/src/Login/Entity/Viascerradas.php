<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viascerradas
 *
 * @ORM\Table(name="viascerradas")
 * @ORM\Entity
 */
class Viascerradas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="viaCerrada_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $viacerradaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyecto_id", type="integer", nullable=false)
     */
    private $proyectoId;

    /**
     * @var string
     *
     * @ORM\Column(name="viaCerrada_polyline", type="string", length=40, nullable=false)
     */
    private $viacerradaPolyline;



    /**
     * Get viacerradaId
     *
     * @return integer 
     */
    public function getViacerradaId()
    {
        return $this->viacerradaId;
    }

    /**
     * Set proyectoId
     *
     * @param integer $proyectoId
     * @return Viascerradas
     */
    public function setProyectoId($proyectoId)
    {
        $this->proyectoId = $proyectoId;

        return $this;
    }

    /**
     * Get proyectoId
     *
     * @return integer 
     */
    public function getProyectoId()
    {
        return $this->proyectoId;
    }

    /**
     * Set viacerradaPolyline
     *
     * @param string $viacerradaPolyline
     * @return Viascerradas
     */
    public function setViacerradaPolyline($viacerradaPolyline)
    {
        $this->viacerradaPolyline = $viacerradaPolyline;

        return $this;
    }

    /**
     * Get viacerradaPolyline
     *
     * @return string 
     */
    public function getViacerradaPolyline()
    {
        return $this->viacerradaPolyline;
    }
}
