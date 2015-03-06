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



    /**
     * Get proyectoId
     *
     * @return integer 
     */
    public function getProyectoId()
    {
        return $this->proyectoId;
    }

    /**
     * Set proyectoPresupuesto
     *
     * @param integer $proyectoPresupuesto
     * @return Proyecto
     */
    public function setProyectoPresupuesto($proyectoPresupuesto)
    {
        $this->proyectoPresupuesto = $proyectoPresupuesto;

        return $this;
    }

    /**
     * Get proyectoPresupuesto
     *
     * @return integer 
     */
    public function getProyectoPresupuesto()
    {
        return $this->proyectoPresupuesto;
    }

    /**
     * Set proyectoPathfotos
     *
     * @param string $proyectoPathfotos
     * @return Proyecto
     */
    public function setProyectoPathfotos($proyectoPathfotos)
    {
        $this->proyectoPathfotos = $proyectoPathfotos;

        return $this;
    }

    /**
     * Get proyectoPathfotos
     *
     * @return string 
     */
    public function getProyectoPathfotos()
    {
        return $this->proyectoPathfotos;
    }

    /**
     * Set eje
     *
     * @param \Login\Model\Entity\Eje $eje
     * @return Proyecto
     */
    public function setEje(\Login\Model\Entity\Eje $eje = null)
    {
        $this->eje = $eje;

        return $this;
    }

    /**
     * Get eje
     *
     * @return \Login\Model\Entity\Eje 
     */
    public function getEje()
    {
        return $this->eje;
    }

    /**
     * Set estado
     *
     * @param \Login\Model\Entity\Estado $estado
     * @return Proyecto
     */
    public function setEstado(\Login\Model\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Login\Model\Entity\Estado 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
