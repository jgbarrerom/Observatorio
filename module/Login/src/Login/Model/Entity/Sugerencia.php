<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sugerencia
 *
 * @ORM\Table(name="sugerencia", indexes={@ORM\Index(name="barrio_id", columns={"barrio_id"})})
 * @ORM\Entity
 */
class Sugerencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sugerencia_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sugerenciaId;

    /**
     * @var string
     *
     * @ORM\Column(name="sugerencia_nombre", type="string", length=30, nullable=false)
     */
    private $sugerenciaNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="sugerencia_apellido", type="string", length=30, nullable=false)
     */
    private $sugerenciaApellido;

    /**
     * @var string
     *
     * @ORM\Column(name="sugerencia_telefono", type="string", length=12, nullable=false)
     */
    private $sugerenciaTelefono;

    /**
     * @var string
     *
     * @ORM\Column(name="sugerencia_correo", type="string", length=30, nullable=false)
     */
    private $sugerenciaCorreo;

    /**
     * @var string
     *
     * @ORM\Column(name="sugerencia_comentario", type="string", length=250, nullable=false)
     */
    private $sugerenciaComentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sugerencia_fecha", type="datetime", nullable=false)
     */
    private $sugerenciaFecha = 'CURRENT_TIMESTAMP';

    /**
     * @var boolean
     *
     * @ORM\Column(name="sugerencia_leido", type="boolean", nullable=false)
     */
    private $sugerenciaLeido = '0';

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
     * Get sugerenciaId
     *
     * @return integer 
     */
    public function getSugerenciaId()
    {
        return $this->sugerenciaId;
    }

    /**
     * Set sugerenciaNombre
     *
     * @param string $sugerenciaNombre
     * @return Sugerencia
     */
    public function setSugerenciaNombre($sugerenciaNombre)
    {
        $this->sugerenciaNombre = $sugerenciaNombre;

        return $this;
    }

    /**
     * Get sugerenciaNombre
     *
     * @return string 
     */
    public function getSugerenciaNombre()
    {
        return $this->sugerenciaNombre;
    }

    /**
     * Set sugerenciaApellido
     *
     * @param string $sugerenciaApellido
     * @return Sugerencia
     */
    public function setSugerenciaApellido($sugerenciaApellido)
    {
        $this->sugerenciaApellido = $sugerenciaApellido;

        return $this;
    }

    /**
     * Get sugerenciaApellido
     *
     * @return string 
     */
    public function getSugerenciaApellido()
    {
        return $this->sugerenciaApellido;
    }

    /**
     * Set sugerenciaTelefono
     *
     * @param string $sugerenciaTelefono
     * @return Sugerencia
     */
    public function setSugerenciaTelefono($sugerenciaTelefono)
    {
        $this->sugerenciaTelefono = $sugerenciaTelefono;

        return $this;
    }

    /**
     * Get sugerenciaTelefono
     *
     * @return string 
     */
    public function getSugerenciaTelefono()
    {
        return $this->sugerenciaTelefono;
    }

    /**
     * Set sugerenciaCorreo
     *
     * @param string $sugerenciaCorreo
     * @return Sugerencia
     */
    public function setSugerenciaCorreo($sugerenciaCorreo)
    {
        $this->sugerenciaCorreo = $sugerenciaCorreo;

        return $this;
    }

    /**
     * Get sugerenciaCorreo
     *
     * @return string 
     */
    public function getSugerenciaCorreo()
    {
        return $this->sugerenciaCorreo;
    }

    /**
     * Set sugerenciaComentario
     *
     * @param string $sugerenciaComentario
     * @return Sugerencia
     */
    public function setSugerenciaComentario($sugerenciaComentario)
    {
        $this->sugerenciaComentario = $sugerenciaComentario;

        return $this;
    }

    /**
     * Get sugerenciaComentario
     *
     * @return string 
     */
    public function getSugerenciaComentario()
    {
        return $this->sugerenciaComentario;
    }

    /**
     * Set sugerenciaFecha
     *
     * @param \DateTime $sugerenciaFecha
     * @return Sugerencia
     */
    public function setSugerenciaFecha($sugerenciaFecha)
    {
        $this->sugerenciaFecha = $sugerenciaFecha;

        return $this;
    }

    /**
     * Get sugerenciaFecha
     *
     * @return \DateTime 
     */
    public function getSugerenciaFecha()
    {
        return $this->sugerenciaFecha;
    }

    /**
     * Set sugerenciaLeido
     *
     * @param boolean $sugerenciaLeido
     * @return Sugerencia
     */
    public function setSugerenciaLeido($sugerenciaLeido)
    {
        $this->sugerenciaLeido = $sugerenciaLeido;

        return $this;
    }

    /**
     * Get sugerenciaLeido
     *
     * @return boolean 
     */
    public function getSugerenciaLeido()
    {
        return $this->sugerenciaLeido;
    }

    /**
     * Set barrio
     *
     * @param \Login\Model\Entity\Barrio $barrio
     * @return Sugerencia
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
