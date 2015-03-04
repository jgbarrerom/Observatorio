<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil", indexes={@ORM\Index(name="id_eje", columns={"id_eje"}), @ORM\Index(name="id_eje_2", columns={"id_eje"})})
 * @ORM\Entity
 */
class Perfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_perfil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerfil;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_perfil", type="string", length=30, nullable=false)
     */
    private $nombrePerfil;

    /**
     * @var \Login\Entity\Eje
     *
     * @ORM\ManyToOne(targetEntity="Login\Entity\Eje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eje", referencedColumnName="id_eje")
     * })
     */
    private $idEje;



    /**
     * Get idPerfil
     *
     * @return integer 
     */
    public function getIdPerfil()
    {
        return $this->idPerfil;
    }

    /**
     * Set nombrePerfil
     *
     * @param string $nombrePerfil
     * @return Perfil
     */
    public function setNombrePerfil($nombrePerfil)
    {
        $this->nombrePerfil = $nombrePerfil;

        return $this;
    }

    /**
     * Get nombrePerfil
     *
     * @return string 
     */
    public function getNombrePerfil()
    {
        return $this->nombrePerfil;
    }

    /**
     * Set idEje
     *
     * @param \Login\Entity\Eje $idEje
     * @return Perfil
     */
    public function setIdEje(\Login\Entity\Eje $idEje = null)
    {
        $this->idEje = $idEje;

        return $this;
    }

    /**
     * Get idEje
     *
     * @return \Login\Entity\Eje 
     */
    public function getIdEje()
    {
        return $this->idEje;
    }
}
