<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Segmento
 *
 * @ORM\Table(name="segmento")
 * @ORM\Entity
 */
class Segmento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="segmento_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $segmentoId;

    /**
     * @var string
     *
     * @ORM\Column(name="segmento_nombre", type="string", length=45, nullable=false)
     */
    private $segmentoNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="segmento_descripcion", type="string", length=200, nullable=false)
     */
    private $segmentoDescripcion;



    /**
     * Get segmentoId
     *
     * @return integer 
     */
    public function getSegmentoId()
    {
        return $this->segmentoId;
    }

    /**
     * Set segmentoNombre
     *
     * @param string $segmentoNombre
     * @return Segmento
     */
    public function setSegmentoNombre($segmentoNombre)
    {
        $this->segmentoNombre = $segmentoNombre;

        return $this;
    }

    /**
     * Get segmentoNombre
     *
     * @return string 
     */
    public function getSegmentoNombre()
    {
        return $this->segmentoNombre;
    }

    /**
     * Set segmentoDescripcion
     *
     * @param string $segmentoDescripcion
     * @return Segmento
     */
    public function setSegmentoDescripcion($segmentoDescripcion)
    {
        $this->segmentoDescripcion = $segmentoDescripcion;

        return $this;
    }

    /**
     * Get segmentoDescripcion
     *
     * @return string 
     */
    public function getSegmentoDescripcion()
    {
        return $this->segmentoDescripcion;
    }
}
