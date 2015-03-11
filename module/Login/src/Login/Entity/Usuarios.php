<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="id_perfil", columns={"id_perfil"}), @ORM\UniqueConstraint(name="nombre_usuario", columns={"nombre_usuario"})})
 * @ORM\Entity
 */
class Usuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_usuario", type="string", length=20, nullable=false)
     */
    private $nombreUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_usuario", type="string", length=40, nullable=false)
     */
    private $apellidoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="password_usuario", type="string", length=100, nullable=false)
     */
    private $passwordUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="correo_usuario", type="string", length=30, nullable=false)
     */
    private $correoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_usuario", type="string", length=10, nullable=false)
     */
    private $telefonoUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_usuario", type="string", length=30, nullable=false)
     */
    private $direccionUsuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimaSesion_usuario", type="datetime", nullable=false)
     */
    private $ultimasesionUsuario;

    /**
     * @var \Login\Entity\Perfil
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_perfil", referencedColumnName="id_perfil")
     * })
     */
    private $idPerfil;



    /**
     * Get idUsuario
     *
     * @return integer 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set nombreUsuario
     *
     * @param string $nombreUsuario
     * @return Usuarios
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * Get nombreUsuario
     *
     * @return string 
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Set apellidoUsuario
     *
     * @param string $apellidoUsuario
     * @return Usuarios
     */
    public function setApellidoUsuario($apellidoUsuario)
    {
        $this->apellidoUsuario = $apellidoUsuario;

        return $this;
    }

    /**
     * Get apellidoUsuario
     *
     * @return string 
     */
    public function getApellidoUsuario()
    {
        return $this->apellidoUsuario;
    }

    /**
     * Set passwordUsuario
     *
     * @param string $passwordUsuario
     * @return Usuarios
     */
    public function setPasswordUsuario($passwordUsuario)
    {
        $this->passwordUsuario = $passwordUsuario;

        return $this;
    }

    /**
     * Get passwordUsuario
     *
     * @return string 
     */
    public function getPasswordUsuario()
    {
        return $this->passwordUsuario;
    }

    /**
     * Set correoUsuario
     *
     * @param string $correoUsuario
     * @return Usuarios
     */
    public function setCorreoUsuario($correoUsuario)
    {
        $this->correoUsuario = $correoUsuario;

        return $this;
    }

    /**
     * Get correoUsuario
     *
     * @return string 
     */
    public function getCorreoUsuario()
    {
        return $this->correoUsuario;
    }

    /**
     * Set telefonoUsuario
     *
     * @param string $telefonoUsuario
     * @return Usuarios
     */
    public function setTelefonoUsuario($telefonoUsuario)
    {
        $this->telefonoUsuario = $telefonoUsuario;

        return $this;
    }

    /**
     * Get telefonoUsuario
     *
     * @return string 
     */
    public function getTelefonoUsuario()
    {
        return $this->telefonoUsuario;
    }

    /**
     * Set direccionUsuario
     *
     * @param string $direccionUsuario
     * @return Usuarios
     */
    public function setDireccionUsuario($direccionUsuario)
    {
        $this->direccionUsuario = $direccionUsuario;

        return $this;
    }

    /**
     * Get direccionUsuario
     *
     * @return string 
     */
    public function getDireccionUsuario()
    {
        return $this->direccionUsuario;
    }

    /**
     * Set ultimasesionUsuario
     *
     * @param \DateTime $ultimasesionUsuario
     * @return Usuarios
     */
    public function setUltimasesionUsuario($ultimasesionUsuario)
    {
        $this->ultimasesionUsuario = $ultimasesionUsuario;

        return $this;
    }

    /**
     * Get ultimasesionUsuario
     *
     * @return \DateTime 
     */
    public function getUltimasesionUsuario()
    {
        return $this->ultimasesionUsuario;
    }

    /**
     * Set idPerfil
     *
     * @param \Login\Entity\Perfil $idPerfil
     * @return Usuarios
     */
    public function setIdPerfil(\Login\Entity\Perfil $idPerfil = null)
    {
        $this->idPerfil = $idPerfil;

        return $this;
    }

    /**
     * Get idPerfil
     *
     * @return \Login\Entity\Perfil 
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }
}
