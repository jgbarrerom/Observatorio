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


}
