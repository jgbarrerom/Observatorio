<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoObra
 *
 * @ORM\Table(name="tipo_obra")
 * @ORM\Entity
 */
class TipoObra
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tipoObra_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $tipoobraId;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoObra_nombre", type="string", length=45, nullable=true)
     */
    private $tipoobraNombre;



    /**
     * Get tipoobraId
     *
     * @return integer 
     */
    public function getTipoobraId()
    {
        return $this->tipoobraId;
    }

    /**
     * Set tipoobraNombre
     *
     * @param string $tipoobraNombre
     * @return TipoObra
     */
    public function setTipoobraNombre($tipoobraNombre)
    {
        $this->tipoobraNombre = $tipoobraNombre;

        return $this;
    }

    /**
     * Get tipoobraNombre
     *
     * @return string 
     */
    public function getTipoobraNombre()
    {
        return $this->tipoobraNombre;
    }
}
