<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="resultado", indexes={@ORM\Index(name="proyecto_resultados_idx", columns={"proyecto_id"})})
 * @ORM\Entity
 */
class Resultado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="resultado_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $resultadoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="resultado_total", type="integer", nullable=false)
     */
    private $resultadoTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado_json", type="string", length=450, nullable=false)
     */
    private $resultadoJson;

    /**
     * @var \Login\Model\Entity\Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Proyecto",cascade={"remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="proyecto_id")
     * })
     */
    private $proyecto;


    /**
     * Get resultadoId
     *
     * @return integer 
     */
    public function getResultadoId()
    {
        return $this->resultadoId;
    }

    /**
     * Set resultadoTotal
     *
     * @param integer $resultadoTotal
     * @return Resultado
     */
    public function setResultadoTotal($resultadoTotal)
    {
        $this->resultadoTotal = $resultadoTotal;

        return $this;
    }

    /**
     * Get resultadoTotal
     *
     * @return integer 
     */
    public function getResultadoTotal()
    {
        return $this->resultadoTotal;
    }

    /**
     * Set resultadoJson
     *
     * @param string $resultadoJson
     * @return Resultado
     */
    public function setResultadoJson($resultadoJson)
    {
        $this->resultadoJson = $resultadoJson;

        return $this;
    }

    /**
     * Get resultadoJson
     *
     * @return string 
     */
    public function getResultadoJson()
    {
        return $this->resultadoJson;
    }

    /**
     * Set proyecto
     *
     * @param \Login\Model\Entity\Proyecto $proyecto
     * @return Resultado
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
