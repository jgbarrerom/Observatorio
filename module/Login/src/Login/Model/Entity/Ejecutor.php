<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ejecutor
 *
 * @ORM\Table(name="ejecutor")
 * @ORM\Entity
 */
class Ejecutor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ejecutor_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ejecutorId;

    /**
     * @var string
     *
     * @ORM\Column(name="ejecutor_nombre", type="string", length=30, nullable=false)
     */
    private $ejecutorNombre;



    /**
     * Get ejecutorId
     *
     * @return integer 
     */
    public function getEjecutorId()
    {
        return $this->ejecutorId;
    }

    /**
     * Set ejecutorNombre
     *
     * @param string $ejecutorNombre
     * @return Ejecutor
     */
    public function setEjecutorNombre($ejecutorNombre)
    {
        $this->ejecutorNombre = $ejecutorNombre;

        return $this;
    }

    /**
     * Get ejecutorNombre
     *
     * @return string 
     */
    public function getEjecutorNombre()
    {
        return $this->ejecutorNombre;
    }
}
