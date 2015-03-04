<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto", indexes={@ORM\Index(name="estado_id_idx", columns={"estado_id"}), @ORM\Index(name="eje_id_idx", columns={"eje_id"})})
 * @ORM\Entity
 */
class Proyecto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="proyecto_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proyectoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyecto_presupuesto", type="bigint", nullable=true)
     */
    private $proyectoPresupuesto;

    /**
     * @var string
     *
     * @ORM\Column(name="proyecto_pathFotos", type="string", length=45, nullable=true)
     */
    private $proyectoPathfotos;

    /**
     * @var \Login\Model\Entity\Eje
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Eje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eje_id", referencedColumnName="eje_id")
     * })
     */
    private $eje;

    /**
     * @var \Login\Model\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_id", referencedColumnName="estado_id")
     * })
     */
    private $estado;


}
