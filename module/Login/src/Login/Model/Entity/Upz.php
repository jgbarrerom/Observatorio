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


}
