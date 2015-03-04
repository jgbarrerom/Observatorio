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


}
