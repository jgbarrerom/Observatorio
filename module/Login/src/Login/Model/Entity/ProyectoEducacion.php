<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectoEducacion
 *
 * @ORM\Table(name="proyecto_educacion", indexes={@ORM\Index(name="educacion_proyecto_fk_idx", columns={"proyecto_id"})})
 * @ORM\Entity
 */
class ProyectoEducacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoEducacion_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proyectoeducacionId;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoEducacion_objetivo", type="string", length=500, nullable=false)
     */
    private $proyectoeducacionObjetivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="proyectoEducacion_fechaInicio", type="date", nullable=false)
     */
    private $proyectoeducacionFechainicio;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoEducacion_plazoEjecucion", type="integer", nullable=false)
     */
    private $proyectoeducacionPlazoejecucion;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoEducacion_numero", type="string", length=45, nullable=false)
     */
    private $proyectoeducacionNumero;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoEducacion_ejecutor", type="string", length=50, nullable=false)
     */
    private $proyectoeducacionEjecutor;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoEducacion_nombre", type="string", length=100, nullable=false)
     */
    private $proyectoeducacionNombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyectoEducacion_cupos", type="integer", nullable=false)
     */
    private $proyectoeducacionCupos;

    /**
     * @var string
     *
     * @ORM\Column(name="proyectoEducacion_perfilBeneficiario", type="string", length=500, nullable=false)
     */
    private $proyectoeducacionPerfilbeneficiario;

    /**
     * @var \Login\Model\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Proyecto",cascade={"persist","remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="proyecto_id")
     * })
     */
    private $proyecto;



    /**
     * Get proyectoeducacionId
     *
     * @return integer 
     */
    public function getProyectoeducacionId()
    {
        return $this->proyectoeducacionId;
    }

    /**
     * Set proyectoeducacionObjetivo
     *
     * @param string $proyectoeducacionObjetivo
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionObjetivo($proyectoeducacionObjetivo)
    {
        $this->proyectoeducacionObjetivo = $proyectoeducacionObjetivo;

        return $this;
    }

    /**
     * Get proyectoeducacionObjetivo
     *
     * @return string 
     */
    public function getProyectoeducacionObjetivo()
    {
        return $this->proyectoeducacionObjetivo;
    }

    /**
     * Set proyectoeducacionFechainicio
     *
     * @param \DateTime $proyectoeducacionFechainicio
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionFechainicio($proyectoeducacionFechainicio)
    {
        $this->proyectoeducacionFechainicio = $proyectoeducacionFechainicio;

        return $this;
    }

    /**
     * Get proyectoeducacionFechainicio
     *
     * @return \DateTime 
     */
    public function getProyectoeducacionFechainicio()
    {
        return $this->proyectoeducacionFechainicio;
    }

    /**
     * Set proyectoeducacionPlazoejecucion
     *
     * @param integer $proyectoeducacionPlazoejecucion
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionPlazoejecucion($proyectoeducacionPlazoejecucion)
    {
        $this->proyectoeducacionPlazoejecucion = $proyectoeducacionPlazoejecucion;

        return $this;
    }

    /**
     * Get proyectoeducacionPlazoejecucion
     *
     * @return integer 
     */
    public function getProyectoeducacionPlazoejecucion()
    {
        return $this->proyectoeducacionPlazoejecucion;
    }

    /**
     * Set proyectoeducacionNumero
     *
     * @param string $proyectoeducacionNumero
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionNumero($proyectoeducacionNumero)
    {
        $this->proyectoeducacionNumero = $proyectoeducacionNumero;

        return $this;
    }

    /**
     * Get proyectoeducacionNumero
     *
     * @return string 
     */
    public function getProyectoeducacionNumero()
    {
        return $this->proyectoeducacionNumero;
    }

    /**
     * Set proyectoeducacionEjecutor
     *
     * @param string $proyectoeducacionEjecutor
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionEjecutor($proyectoeducacionEjecutor)
    {
        $this->proyectoeducacionEjecutor = $proyectoeducacionEjecutor;

        return $this;
    }

    /**
     * Get proyectoeducacionEjecutor
     *
     * @return string 
     */
    public function getProyectoeducacionEjecutor()
    {
        return $this->proyectoeducacionEjecutor;
    }

    /**
     * Set proyectoeducacionNombre
     *
     * @param string $proyectoeducacionNombre
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionNombre($proyectoeducacionNombre)
    {
        $this->proyectoeducacionNombre = $proyectoeducacionNombre;

        return $this;
    }

    /**
     * Get proyectoeducacionNombre
     *
     * @return string 
     */
    public function getProyectoeducacionNombre()
    {
        return $this->proyectoeducacionNombre;
    }

    /**
     * Set proyectoeducacionCupos
     *
     * @param integer $proyectoeducacionCupos
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionCupos($proyectoeducacionCupos)
    {
        $this->proyectoeducacionCupos = $proyectoeducacionCupos;

        return $this;
    }

    /**
     * Get proyectoeducacionCupos
     *
     * @return integer 
     */
    public function getProyectoeducacionCupos()
    {
        return $this->proyectoeducacionCupos;
    }

    /**
     * Set proyectoeducacionPerfilbeneficiario
     *
     * @param string $proyectoeducacionPerfilbeneficiario
     * @return ProyectoEducacion
     */
    public function setProyectoeducacionPerfilbeneficiario($proyectoeducacionPerfilbeneficiario)
    {
        $this->proyectoeducacionPerfilbeneficiario = $proyectoeducacionPerfilbeneficiario;

        return $this;
    }

    /**
     * Get proyectoeducacionPerfilbeneficiario
     *
     * @return string 
     */
    public function getProyectoeducacionPerfilbeneficiario()
    {
        return $this->proyectoeducacionPerfilbeneficiario;
    }

    /**
     * Set proyecto
     *
     * @param \Login\Model\Entity\Proyecto $proyecto
     * @return ProyectoEducacion
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
}
