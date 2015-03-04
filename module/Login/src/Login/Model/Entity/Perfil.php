<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil", indexes={@ORM\Index(name="eje_id_idx", columns={"eje_id"})})
 * @ORM\Entity
 */
class Perfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="perfil_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $perfilId;

    /**
     * @var string
     *
     * @ORM\Column(name="perfil_nombre", type="string", length=45, nullable=false)
     */
    private $perfilNombre;

    /**
     * @var \Login\Model\Entity\Eje
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Eje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eje_id", referencedColumnName="eje_id")
     * })
     */
    private $eje;


}
