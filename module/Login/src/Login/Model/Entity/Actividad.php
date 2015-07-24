<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividad
 *
 * @ORM\Table(name="actividad", indexes={@ORM\Index(name="proyectoSalud_actividad_idx", columns={"proyecto_id"}), @ORM\Index(name="actividad_lugar_idx", columns={"lugar_id"})})
 * @ORM\Entity
 */
class Actividad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="actividad_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $actividadId;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad_nombre", type="string", length=200, nullable=false)
     */
    private $actividadNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad_objetivo", type="string", length=200, nullable=false)
     */
    private $actividadObjetivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actividad_fechaHora", type="datetime", nullable=false)
     */
    private $actividadFechahora;

    /**
     * @var string
     *
     * @ORM\Column(name="actividad_requisitos", type="string", length=200, nullable=true)
     */
    private $actividadRequisitos;

    /**
     * @var \Login\Model\Entity\Lugar
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Lugar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lugar_id", referencedColumnName="lugar_id")
     * })
     */
    private $lugar;

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
     * Get actividadId
     *
     * @return integer 
     */
    public function getActividadId()
    {
        return $this->actividadId;
    }

    /**
     * Set actividadNombre
     *
     * @param string $actividadNombre
     * @return Actividad
     */
    public function setActividadNombre($actividadNombre)
    {
        $this->actividadNombre = $actividadNombre;

        return $this;
    }

    /**
     * Get actividadNombre
     *
     * @return string 
     */
    public function getActividadNombre()
    {
        return $this->actividadNombre;
    }

    /**
     * Set actividadObjetivo
     *
     * @param string $actividadObjetivo
     * @return Actividad
     */
    public function setActividadObjetivo($actividadObjetivo)
    {
        $this->actividadObjetivo = $actividadObjetivo;

        return $this;
    }

    /**
     * Get actividadObjetivo
     *
     * @return string 
     */
    public function getActividadObjetivo()
    {
        return $this->actividadObjetivo;
    }

    /**
     * Set actividadFechahora
     *
     * @param \DateTime $actividadFechahora
     * @return Actividad
     */
    public function setActividadFechahora($actividadFechahora)
    {
        $this->actividadFechahora = $actividadFechahora;

        return $this;
    }

    /**
     * Get actividadFechahora
     *
     * @return \DateTime 
     */
    public function getActividadFechahora()
    {
        return $this->actividadFechahora;
    }

    /**
     * Set actividadRequisitos
     *
     * @param string $actividadRequisitos
     * @return Actividad
     */
    public function setActividadRequisitos($actividadRequisitos)
    {
        $this->actividadRequisitos = $actividadRequisitos;

        return $this;
    }

    /**
     * Get actividadRequisitos
     *
     * @return string 
     */
    public function getActividadRequisitos()
    {
        return $this->actividadRequisitos;
    }

    /**
     * Set lugar
     *
     * @param \Login\Model\Entity\Lugar $lugar
     * @return Actividad
     */
    public function setLugar(\Login\Model\Entity\Lugar $lugar = null)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return \Login\Model\Entity\Lugar 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set proyecto
     *
     * @param \Login\Model\Entity\Proyecto $proyecto
     * @return Actividad
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
