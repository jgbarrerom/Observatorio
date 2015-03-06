<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="estado")
 * @ORM\Entity
 */
class Estado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="estado_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $estadoId;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_nombre", type="string", length=45, nullable=true)
     */
    private $estadoNombre;



    /**
     * Get estadoId
     *
     * @return integer 
     */
    public function getEstadoId()
    {
        return $this->estadoId;
    }

    /**
     * Set estadoNombre
     *
     * @param string $estadoNombre
     * @return Estado
     */
    public function setEstadoNombre($estadoNombre)
    {
        $this->estadoNombre = $estadoNombre;

        return $this;
    }

    /**
     * Get estadoNombre
     *
     * @return string 
     */
    public function getEstadoNombre()
    {
        return $this->estadoNombre;
    }
}
