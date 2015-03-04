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


}
