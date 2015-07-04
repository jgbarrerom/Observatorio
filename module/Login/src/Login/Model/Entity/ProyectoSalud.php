<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectoSalud
 *
 * @ORM\Table(name="proyecto_salud", indexes={@ORM\Index(name="salud_segmento_idx", columns={"segmento_id"}), @ORM\Index(name="proyecto_saludfk_idx", columns={"proyecto_id"})})
 * @ORM\Entity
 */
class ProyectoSalud
{
    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoSalud_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proyectosaludId;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoSalud_objetivos", type="string", length=45, nullable=false)
     */
    private $proyectosaludObjetivos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proyectoSalud_fechaInicio", type="date", nullable=false)
     */
    private $proyectosaludFechainicio;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoSalud_plazoEjecucion", type="integer", nullable=false)
     */
    private $proyectosaludPlazoejecucion;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoSalud_numero", type="string", length=45, nullable=false)
     */
    private $proyectosaludNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoSalud_ejecutor", type="string", length=45, nullable=false)
     */
    private $proyectosaludEjecutor;

    /**
     * @var \Login\Model\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Proyecto",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="proyecto_id")
     * })
     */
    private $proyecto;

    /**
     * @var \Login\Model\Entity\Segmento
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Segmento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="segmento_id", referencedColumnName="segmento_id")
     * })
     */
    private $segmento;



    /**
     * Get proyectosaludId
     *
     * @return integer 
     */
    public function getProyectosaludId()
    {
        return $this->proyectosaludId;
    }

    /**
     * Set proyectosaludObjetivos
     *
     * @param string $proyectosaludObjetivos
     * @return ProyectoSalud
     */
    public function setProyectosaludObjetivos($proyectosaludObjetivos)
    {
        $this->proyectosaludObjetivos = $proyectosaludObjetivos;

        return $this;
    }

    /**
     * Get proyectosaludObjetivos
     *
     * @return string 
     */
    public function getProyectosaludObjetivos()
    {
        return $this->proyectosaludObjetivos;
    }

    /**
     * Set proyectosaludFechainicio
     *
     * @param \DateTime $proyectosaludFechainicio
     * @return ProyectoSalud
     */
    public function setProyectosaludFechainicio($proyectosaludFechainicio)
    {
        $this->proyectosaludFechainicio = $proyectosaludFechainicio;

        return $this;
    }

    /**
     * Get proyectosaludFechainicio
     *
     * @return \DateTime 
     */
    public function getProyectosaludFechainicio()
    {
        return $this->proyectosaludFechainicio;
    }

    /**
     * Set proyectosaludPlazoejecucion
     *
     * @param integer $proyectosaludPlazoejecucion
     * @return ProyectoSalud
     */
    public function setProyectosaludPlazoejecucion($proyectosaludPlazoejecucion)
    {
        $this->proyectosaludPlazoejecucion = $proyectosaludPlazoejecucion;

        return $this;
    }

    /**
     * Get proyectosaludPlazoejecucion
     *
     * @return integer 
     */
    public function getProyectosaludPlazoejecucion()
    {
        return $this->proyectosaludPlazoejecucion;
    }

    /**
     * Set proyectosaludNumero
     *
     * @param string $proyectosaludNumero
     * @return ProyectoSalud
     */
    public function setProyectosaludNumero($proyectosaludNumero)
    {
        $this->proyectosaludNumero = $proyectosaludNumero;

        return $this;
    }

    /**
     * Get proyectosaludNumero
     *
     * @return string 
     */
    public function getProyectosaludNumero()
    {
        return $this->proyectosaludNumero;
    }

    /**
     * Set proyectosaludEjecutor
     *
     * @param string $proyectosaludEjecutor
     * @return ProyectoSalud
     */
    public function setProyectosaludEjecutor($proyectosaludEjecutor)
    {
        $this->proyectosaludEjecutor = $proyectosaludEjecutor;

        return $this;
    }

    /**
     * Get proyectosaludEjecutor
     *
     * @return string 
     */
    public function getProyectosaludEjecutor()
    {
        return $this->proyectosaludEjecutor;
    }

    /**
     * Set proyecto
     *
     * @param \Login\Model\Entity\Proyecto $proyecto
     * @return ProyectoSalud
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
     * Set segmento
     *
     * @param \Login\Model\Entity\Segmento $segmento
     * @return ProyectoSalud
     */
    public function setSegmento(\Login\Model\Entity\Segmento $segmento = null)
    {
        $this->segmento = $segmento;

        return $this;
    }

    /**
     * Get segmento
     *
     * @return \Login\Model\Entity\Segmento 
     */
    public function getSegmento()
    {
        return $this->segmento;
    }
}
