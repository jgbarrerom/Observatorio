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


}
