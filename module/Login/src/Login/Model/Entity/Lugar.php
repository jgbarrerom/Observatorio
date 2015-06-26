<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lugar
 *
 * @ORM\Table(name="lugar", indexes={@ORM\Index(name="barrio_fk_id_idx", columns={"barrio_id"}), @ORM\Index(name="tipoLugar_id_idx", columns={"tipoLugar_id"})})
 * @ORM\Entity
 */
class Lugar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="lugar_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $lugarId;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_nombre", type="string", length=45, nullable=false)
     */
    private $lugarNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_direccion", type="string", length=45, nullable=false)
     */
    private $lugarDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_coordenadas", type="string", length=300, nullable=false)
     */
    private $lugarCoordenadas;

    /**
     * @var integer
     *
     * @ORM\Column(name="lugar_telefono", type="integer", nullable=true)
     */
    private $lugarTelefono;

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
     * @var \Login\Model\Entity\TipoLugar
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\TipoLugar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoLugar_id", referencedColumnName="tipoLugar_id")
     * })
     */
    private $tipolugar;



    /**
     * Get lugarId
     *
     * @return integer 
     */
    public function getLugarId()
    {
        return $this->lugarId;
    }

    /**
     * Set lugarNombre
     *
     * @param string $lugarNombre
     * @return Lugar
     */
    public function setLugarNombre($lugarNombre)
    {
        $this->lugarNombre = $lugarNombre;

        return $this;
    }

    /**
     * Get lugarNombre
     *
     * @return string 
     */
    public function getLugarNombre()
    {
        return $this->lugarNombre;
    }

    /**
     * Set lugarDireccion
     *
     * @param string $lugarDireccion
     * @return Lugar
     */
    public function setLugarDireccion($lugarDireccion)
    {
        $this->lugarDireccion = $lugarDireccion;

        return $this;
    }

    /**
     * Get lugarDireccion
     *
     * @return string 
     */
    public function getLugarDireccion()
    {
        return $this->lugarDireccion;
    }

    /**
     * Set lugarCoordenadas
     *
     * @param string $lugarCoordenadas
     * @return Lugar
     */
    public function setLugarCoordenadas($lugarCoordenadas)
    {
        $this->lugarCoordenadas = $lugarCoordenadas;

        return $this;
    }

    /**
     * Get lugarCoordenadas
     *
     * @return string 
     */
    public function getLugarCoordenadas()
    {
        return $this->lugarCoordenadas;
    }

    /**
     * Set lugarTelefono
     *
     * @param integer $lugarTelefono
     * @return Lugar
     */
    public function setLugarTelefono($lugarTelefono)
    {
        $this->lugarTelefono = $lugarTelefono;

        return $this;
    }

    /**
     * Get lugarTelefono
     *
     * @return integer 
     */
    public function getLugarTelefono()
    {
        return $this->lugarTelefono;
    }

    /**
     * Set barrio
     *
     * @param \Login\Model\Entity\Barrio $barrio
     * @return Lugar
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
     * Set tipolugar
     *
     * @param \Login\Model\Entity\TipoLugar $tipolugar
     * @return Lugar
     */
    public function setTipolugar(\Login\Model\Entity\TipoLugar $tipolugar = null)
    {
        $this->tipolugar = $tipolugar;

        return $this;
    }

    /**
     * Get tipolugar
     *
     * @return \Login\Model\Entity\TipoLugar 
     */
    public function getTipolugar()
    {
        return $this->tipolugar;
    }
}
