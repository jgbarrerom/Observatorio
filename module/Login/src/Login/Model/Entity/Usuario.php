<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="perfil_id_idx", columns={"perfil_id"})})
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $usuarioId;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_nombre", type="string", length=45, nullable=false)
     */
    private $usuarioNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_correo", type="string", length=45, nullable=false)
     */
    private $usuarioCorreo;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_password", type="string", length=45, nullable=false)
     */
    private $usuarioPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario_apellido", type="string", length=45, nullable=false)
     */
    private $usuarioApellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usuario_ultimaSesion", type="datetime", nullable=true)
     */
    private $usuarioUltimasesion;

    /**
     * @var \Login\Model\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil_id", referencedColumnName="perfil_id")
     * })
     */
    private $perfil;



    /**
     * Get usuarioId
     *
     * @return integer 
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set usuarioNombre
     *
     * @param string $usuarioNombre
     * @return Usuario
     */
    public function setUsuarioNombre($usuarioNombre)
    {
        $this->usuarioNombre = $usuarioNombre;

        return $this;
    }

    /**
     * Get usuarioNombre
     *
     * @return string 
     */
    public function getUsuarioNombre()
    {
        return $this->usuarioNombre;
    }

    /**
     * Set usuarioCorreo
     *
     * @param string $usuarioCorreo
     * @return Usuario
     */
    public function setUsuarioCorreo($usuarioCorreo)
    {
        $this->usuarioCorreo = $usuarioCorreo;

        return $this;
    }

    /**
     * Get usuarioCorreo
     *
     * @return string 
     */
    public function getUsuarioCorreo()
    {
        return $this->usuarioCorreo;
    }

    /**
     * Set usuarioPassword
     *
     * @param string $usuarioPassword
     * @return Usuario
     */
    public function setUsuarioPassword($usuarioPassword)
    {
        $this->usuarioPassword = $usuarioPassword;

        return $this;
    }

    /**
     * Get usuarioPassword
     *
     * @return string 
     */
    public function getUsuarioPassword()
    {
        return $this->usuarioPassword;
    }

    /**
     * Set usuarioApellido
     *
     * @param string $usuarioApellido
     * @return Usuario
     */
    public function setUsuarioApellido($usuarioApellido)
    {
        $this->usuarioApellido = $usuarioApellido;

        return $this;
    }

    /**
     * Get usuarioApellido
     *
     * @return string 
     */
    public function getUsuarioApellido()
    {
        return $this->usuarioApellido;
    }

    /**
     * Set usuarioUltimasesion
     *
     * @param \DateTime $usuarioUltimasesion
     * @return Usuario
     */
    public function setUsuarioUltimasesion($usuarioUltimasesion)
    {
        $this->usuarioUltimasesion = $usuarioUltimasesion;

        return $this;
    }

    /**
     * Get usuarioUltimasesion
     *
     * @return \DateTime 
     */
    public function getUsuarioUltimasesion()
    {
        return $this->usuarioUltimasesion;
    }

    /**
     * Set perfil
     *
     * @param \Login\Model\Entity\Perfil $perfil
     * @return Usuario
     */
    public function setPerfil(\Login\Model\Entity\Perfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \Login\Model\Entity\Perfil 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}
