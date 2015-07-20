<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadSalud
 *
 * @ORM\Table(name="actividad_salud", indexes={@ORM\Index(name="proyectoSalud_actividad_idx", columns={"proyecto_id"}), @ORM\Index(name="actividad_lugar_idx", columns={"lugar_id"})})
 * @ORM\Entity
 */
class ActividadSalud
{
    /**
     * @var integer
     *
     * @ORM\Column(name="actividadSalud_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $actividadsaludId;

    /**
     * @var string
     *
     * @ORM\Column(name="actividadSalud_nombre", type="string", length=200, nullable=false)
     */
    private $actividadsaludNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="actividadSalud_objetivo", type="string", length=200, nullable=false)
     */
    private $actividadsaludObjetivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="actividadSalud_fechaHora", type="datetime", nullable=false)
     */
    private $actividadsaludFechahora;

    /**
     * @var string
     *
     * @ORM\Column(name="actividadSalud_requisitos", type="string", nullable=true)
     */
    private $actividadsaludRequisitos;

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
     * @var \Login\Model\Entity\ProyectoSalud
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\ProyectoSalud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="proyectoSalud_id")
     * })
     */
    private $proyecto;



    /**
     * Get actividadsaludId
     *
     * @return integer 
     */
    public function getActividadsaludId()
    {
        return $this->actividadsaludId;
    }

    /**
     * Set actividadsaludNombre
     *
     * @param string $actividadsaludNombre
     * @return ActividadSalud
     */
    public function setActividadsaludNombre($actividadsaludNombre)
    {
        $this->actividadsaludNombre = $actividadsaludNombre;

        return $this;
    }

    /**
     * Get actividadsaludNombre
     *
     * @return string 
     */
    public function getActividadsaludNombre()
    {
        return $this->actividadsaludNombre;
    }

    /**
     * Set actividadsaludObjetivo
     *
     * @param string $actividadsaludObjetivo
     * @return ActividadSalud
     */
    public function setActividadsaludObjetivo($actividadsaludObjetivo)
    {
        $this->actividadsaludObjetivo = $actividadsaludObjetivo;

        return $this;
    }

    /**
     * Get actividadsaludObjetivo
     *
     * @return string 
     */
    public function getActividadsaludObjetivo()
    {
        return $this->actividadsaludObjetivo;
    }

    /**
     * Set actividadsaludFechahora
     *
     * @param \DateTime $actividadsaludFechahora
     * @return ActividadSalud
     */
    public function setActividadsaludFechahora($actividadsaludFechahora)
    {
        $this->actividadsaludFechahora = $actividadsaludFechahora;

        return $this;
    }

    /**
     * Get actividadsaludFechahora
     *
     * @return \DateTime 
     */
    public function getActividadsaludFechahora()
    {
        return $this->actividadsaludFechahora;
    }

    /**
     * Set actividadsaludRequisitos
     *
     * @param integer $actividadsaludRequisitos
     * @return ActividadSalud
     */
    public function setActividadsaludRequisitos($actividadsaludRequisitos)
    {
        $this->actividadsaludRequisitos = $actividadsaludRequisitos;

        return $this;
    }

    /**
     * Get actividadsaludRequisitos
     *
     * @return integer 
     */
    public function getActividadsaludRequisitos()
    {
        return $this->actividadsaludRequisitos;
    }

    /**
     * Set lugar
     *
     * @param \Login\Model\Entity\Lugar $lugar
     * @return ActividadSalud
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
     * @param \Login\Model\Entity\ProyectoSalud $proyecto
     * @return ActividadSalud
     */
    public function setProyecto(\Login\Model\Entity\ProyectoSalud $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \Login\Model\Entity\ProyectoSalud 
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }
}
