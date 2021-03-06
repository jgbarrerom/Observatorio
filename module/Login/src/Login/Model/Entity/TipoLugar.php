<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoLugar
 *
 * @ORM\Table(name="tipo_lugar")
 * @ORM\Entity
 */
class TipoLugar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tipoLugar_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tipolugarId;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoLugar_nombre", type="string", length=45, nullable=true)
     */
    private $tipolugarNombre;



    /**
     * Get tipolugarId
     *
     * @return integer 
     */
    public function getTipolugarId()
    {
        return $this->tipolugarId;
    }

    /**
     * Set tipolugarNombre
     *
     * @param string $tipolugarNombre
     * @return TipoLugar
     */
    public function setTipolugarNombre($tipolugarNombre)
    {
        $this->tipolugarNombre = $tipolugarNombre;

        return $this;
    }

    /**
     * Get tipolugarNombre
     *
     * @return string 
     */
    public function getTipolugarNombre()
    {
        return $this->tipolugarNombre;
    }
}
