<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * ReporteVia
 *
 * @ORM\Table(name="reporte_via", indexes={@ORM\Index(name="reporte_barrioFk_idx", columns={"barrio_id"})})
 * @ORM\Entity
 */
class ReporteVia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="reporteVia_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reporteviaId;

    /**
     * @var string
     *
     * @ORM\Column(name="reporteVia_direccion", type="string", length=45, nullable=false)
     */
    private $reporteviaDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="reporteVia_observacion", type="string", length=245, nullable=false)
     */
    private $reporteviaObservacion;

    /**
     * @var string
     *
     * @ORM\Column(name="reporteVias_fotos", type="string", length=20, nullable=false)
     */
    private $reporteviasFotos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="reportevia_leido", type="boolean", nullable=false)
     */
    private $reporteviaLeido = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reporteVia_fecha", type="datetime", nullable=false)
     */
    private $reporteviaFecha;// = 'CURRENT_TIMESTAMP';

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
     * Get reporteviaId
     *
     * @return integer 
     */
    public function getReporteviaId()
    {
        return $this->reporteviaId;
    }

    /**
     * Set reporteviaDireccion
     *
     * @param string $reporteviaDireccion
     * @return ReporteVia
     */
    public function setReporteviaDireccion($reporteviaDireccion)
    {
        $this->reporteviaDireccion = $reporteviaDireccion;

        return $this;
    }

    /**
     * Get reporteviaDireccion
     *
     * @return string 
     */
    public function getReporteviaDireccion()
    {
        return $this->reporteviaDireccion;
    }

    /**
     * Set reporteviaObservacion
     *
     * @param string $reporteviaObservacion
     * @return ReporteVia
     */
    public function setReporteviaObservacion($reporteviaObservacion)
    {
        $this->reporteviaObservacion = $reporteviaObservacion;

        return $this;
    }

    /**
     * Get reporteviaObservacion
     *
     * @return string 
     */
    public function getReporteviaObservacion()
    {
        return $this->reporteviaObservacion;
    }

    /**
     * Set reporteviasFotos
     *
     * @param string $reporteviasFotos
     * @return ReporteVia
     */
    public function setReporteviasFotos($reporteviasFotos)
    {
        $this->reporteviasFotos = $reporteviasFotos;

        return $this;
    }

    /**
     * Get reporteviasFotos
     *
     * @return string 
     */
    public function getReporteviasFotos()
    {
        return $this->reporteviasFotos;
    }

    /**
     * Set reporteviaLeido
     *
     * @param boolean $reporteviaLeido
     * @return ReporteVia
     */
    public function setReporteviaLeido($reporteviaLeido)
    {
        $this->reporteviaLeido = $reporteviaLeido;

        return $this;
    }

    /**
     * Get reporteviaLeido
     *
     * @return boolean 
     */
    public function getReporteviaLeido()
    {
        return $this->reporteviaLeido;
    }

    /**
     * Set reporteviaFecha
     *
     * @param \DateTime $reporteviaFecha
     * @return ReporteVia
     */
    public function setReporteviaFecha(DateTime $reporteviaFecha)
    {
        $this->reporteviaFecha = $reporteviaFecha;

        return $this;
    }

    /**
     * Get reporteviaFecha
     *
     * @return \DateTime 
     */
    public function getReporteviaFecha()
    {
        return $this->reporteviaFecha;
    }

    /**
     * Set barrio
     *
     * @param \Login\Model\Entity\Barrio $barrio
     * @return ReporteVia
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
}
