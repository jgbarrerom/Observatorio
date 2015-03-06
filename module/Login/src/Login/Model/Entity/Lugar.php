<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lugar
 *
 * @ORM\Table(name="lugar", indexes={@ORM\Index(name="barrio_fk_id_idx", columns={"barrio_id"})})
 * @ORM\Entity
 */
class Lugar
{
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
     * @ORM\Column(name="lugar_coordenadas", type="string", length=45, nullable=false)
     */
    private $lugarCoordenadas;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoLugar_id", type="string", length=45, nullable=false)
     */
    private $tipolugarId;

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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Login\Model\Entity\TipoLugar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lugar_id", referencedColumnName="tipoLugar_id")
     * })
     */
    private $lugar;



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
     * Set tipolugarId
     *
     * @param string $tipolugarId
     * @return Lugar
     */
    public function setTipolugarId($tipolugarId)
    {
        $this->tipolugarId = $tipolugarId;

        return $this;
    }

    /**
     * Get tipolugarId
     *
     * @return string 
     */
    public function getTipolugarId()
    {
        return $this->tipolugarId;
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
     * Set lugar
     *
     * @param \Login\Model\Entity\TipoLugar $lugar
     * @return Lugar
     */
    public function setLugar(\Login\Model\Entity\TipoLugar $lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return \Login\Model\Entity\TipoLugar 
     */
    public function getLugar()
    {
        return $this->lugar;
    }
}
