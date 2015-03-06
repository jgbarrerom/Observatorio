<?php

namespace Login\Model\Entity;

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
     * @ORM\Column(name="upz_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $upzId;

    /**
     * @var string
     *
     * @ORM\Column(name="upz_nombre", type="string", length=45, nullable=true)
     */
    private $upzNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="upz_descripcion", type="string", length=200, nullable=true)
     */
    private $upzDescripcion;



    /**
     * Get upzId
     *
     * @return integer 
     */
    public function getUpzId()
    {
        return $this->upzId;
    }

    /**
     * Set upzNombre
     *
     * @param string $upzNombre
     * @return Upz
     */
    public function setUpzNombre($upzNombre)
    {
        $this->upzNombre = $upzNombre;

        return $this;
    }

    /**
     * Get upzNombre
     *
     * @return string 
     */
    public function getUpzNombre()
    {
        return $this->upzNombre;
    }

    /**
     * Set upzDescripcion
     *
     * @param string $upzDescripcion
     * @return Upz
     */
    public function setUpzDescripcion($upzDescripcion)
    {
        $this->upzDescripcion = $upzDescripcion;

        return $this;
    }

    /**
     * Get upzDescripcion
     *
     * @return string 
     */
    public function getUpzDescripcion()
    {
        return $this->upzDescripcion;
    }
}
