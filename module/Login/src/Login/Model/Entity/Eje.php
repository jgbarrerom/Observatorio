<?php

namespace Login\Model\Entity;

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
     * @ORM\Column(name="eje_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ejeId;

    /**
     * @var string
     *
     * @ORM\Column(name="eje_nombre", type="string", length=45, nullable=false)
     */
    private $ejeNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="eje_descripcion", type="string", length=200, nullable=false)
     */
    private $ejeDescripcion;



    /**
     * Get ejeId
     *
     * @return integer 
     */
    public function getEjeId()
    {
        return $this->ejeId;
    }

    /**
     * Set ejeNombre
     *
     * @param string $ejeNombre
     * @return Eje
     */
    public function setEjeNombre($ejeNombre)
    {
        $this->ejeNombre = $ejeNombre;

        return $this;
    }

    /**
     * Get ejeNombre
     *
     * @return string 
     */
    public function getEjeNombre()
    {
        return $this->ejeNombre;
    }

    /**
     * Set ejeDescripcion
     *
     * @param string $ejeDescripcion
     * @return Eje
     */
    public function setEjeDescripcion($ejeDescripcion)
    {
        $this->ejeDescripcion = $ejeDescripcion;

        return $this;
    }

    /**
     * Get ejeDescripcion
     *
     * @return string 
     */
    public function getEjeDescripcion()
    {
        return $this->ejeDescripcion;
    }
}
