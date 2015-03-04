<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectoVias
 *
 * @ORM\Table(name="proyecto_vias", indexes={@ORM\Index(name="proyecto_id_idx", columns={"proyecto_id"}), @ORM\Index(name="tipoObra_id_idx", columns={"tipoObra_id"}), @ORM\Index(name="barrio_proyectoVias_fk_idx", columns={"barrio_id"})})
 * @ORM\Entity
 */
class ProyectoVias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoVias_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proyectoviasId;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoVias_dirInicio", type="string", length=45, nullable=false)
     */
    private $proyectoviasDirinicio;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoVias_dirFinal", type="string", length=45, nullable=false)
     */
    private $proyectoviasDirfinal;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoVias_civ", type="string", length=45, nullable=false)
     */
    private $proyectoviasCiv;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoVias_largo", type="string", length=45, nullable=false)
     */
    private $proyectoviasLargo;

    /**
     * @var string
     *
     * @ORM\Column(name="coordenadas", type="string", length=45, nullable=false)
     */
    private $coordenadas;

    /**
     * @var \Login\Model\Entity\Barrio
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Barrio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="barrio_id", referencedColumnName="barrio_id")
     * })
     */
    private $barrio;

    /**
     * @var \Login\Model\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Proyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="proyecto_id")
     * })
     */
    private $proyecto;

    /**
     * @var \Login\Model\Entity\TipoObra
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\TipoObra")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoObra_id", referencedColumnName="tipoObra_id")
     * })
     */
    private $tipoobra;


}
