<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Barrio
 *
 * @ORM\Table(name="barrio", indexes={@ORM\Index(name="upz_id_idx", columns={"upz_id"})})
 * @ORM\Entity
 */
class Barrio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="barrio_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $barrioId;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_nombre", type="string", length=45, nullable=false)
     */
    private $barrioNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_descripcion", type="string", length=200, nullable=false)
     */
    private $barrioDescripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_habitantes", type="string", length=45, nullable=false)
     */
    private $barrioHabitantes;

    /**
     * @var \Login\Model\Entity\Upz
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Upz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="upz_id", referencedColumnName="upz_id")
     * })
     */
    private $upz;


}
