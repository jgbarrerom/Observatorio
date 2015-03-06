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



    /**
     * Get proyectoviasId
     *
     * @return integer 
     */
    public function getProyectoviasId()
    {
        return $this->proyectoviasId;
    }

    /**
     * Set proyectoviasDirinicio
     *
     * @param string $proyectoviasDirinicio
     * @return ProyectoVias
     */
    public function setProyectoviasDirinicio($proyectoviasDirinicio)
    {
        $this->proyectoviasDirinicio = $proyectoviasDirinicio;

        return $this;
    }

    /**
     * Get proyectoviasDirinicio
     *
     * @return string 
     */
    public function getProyectoviasDirinicio()
    {
        return $this->proyectoviasDirinicio;
    }

    /**
     * Set proyectoviasDirfinal
     *
     * @param string $proyectoviasDirfinal
     * @return ProyectoVias
     */
    public function setProyectoviasDirfinal($proyectoviasDirfinal)
    {
        $this->proyectoviasDirfinal = $proyectoviasDirfinal;

        return $this;
    }

    /**
     * Get proyectoviasDirfinal
     *
     * @return string 
     */
    public function getProyectoviasDirfinal()
    {
        return $this->proyectoviasDirfinal;
    }

    /**
     * Set proyectoviasCiv
     *
     * @param string $proyectoviasCiv
     * @return ProyectoVias
     */
    public function setProyectoviasCiv($proyectoviasCiv)
    {
        $this->proyectoviasCiv = $proyectoviasCiv;

        return $this;
    }

    /**
     * Get proyectoviasCiv
     *
     * @return string 
     */
    public function getProyectoviasCiv()
    {
        return $this->proyectoviasCiv;
    }

    /**
     * Set proyectoviasLargo
     *
     * @param string $proyectoviasLargo
     * @return ProyectoVias
     */
    public function setProyectoviasLargo($proyectoviasLargo)
    {
        $this->proyectoviasLargo = $proyectoviasLargo;

        return $this;
    }

    /**
     * Get proyectoviasLargo
     *
     * @return string 
     */
    public function getProyectoviasLargo()
    {
        return $this->proyectoviasLargo;
    }

    /**
     * Set coordenadas
     *
     * @param string $coordenadas
     * @return ProyectoVias
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string 
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    /**
     * Set barrio
     *
     * @param \Login\Model\Entity\Barrio $barrio
     * @return ProyectoVias
     */
    public function setBarrio(\Login\Model\Entity\Barrio $barrio = null)
    {
        $this->barrio = $barrio;

        return $this;
    }

    /**
     * Get barrio
     *
     * @return \Login\Model\Entity\Barrio 
     */
    public function getBarrio()
    {
        return $this->barrio;
    }

    /**
     * Set proyecto
     *
     * @param \Login\Model\Entity\Proyecto $proyecto
     * @return ProyectoVias
     */
    public function setProyecto(\Login\Model\Entity\Proyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \Login\Model\Entity\Proyecto 
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set tipoobra
     *
     * @param \Login\Model\Entity\TipoObra $tipoobra
     * @return ProyectoVias
     */
    public function setTipoobra(\Login\Model\Entity\TipoObra $tipoobra = null)
    {
        $this->tipoobra = $tipoobra;

        return $this;
    }

    /**
     * Get tipoobra
     *
     * @return \Login\Model\Entity\TipoObra 
     */
    public function getTipoobra()
    {
        return $this->tipoobra;
    }
}
