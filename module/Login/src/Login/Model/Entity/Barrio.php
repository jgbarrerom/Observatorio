<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Barrio
 *
 * @ORM\Table(name="barrio", indexes={@ORM\Index(name="upz_id_idx", columns={"upz_id"})})
 * @ORM\Entity
 */
class Barrio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="barrio_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $barrioId;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_nombre", type="string", length=45, nullable=false)
     */
    private $barrioNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_descripcion", type="string", length=200, nullable=false)
     */
    private $barrioDescripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="barrio_habitantes", type="string", length=45, nullable=false)
     */
    private $barrioHabitantes;

    /**
     * @var \Login\Model\Entity\Upz
     *
     * @ORM\ManyToOne(targetEntity="Login\Model\Entity\Upz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="upz_id", referencedColumnName="upz_id")
     * })
     */
    private $upz;



    /**
     * Get barrioId
     *
     * @return integer 
     */
    public function getBarrioId()
    {
        return $this->barrioId;
    }

    /**
     * Set barrioNombre
     *
     * @param string $barrioNombre
     * @return Barrio
     */
    public function setBarrioNombre($barrioNombre)
    {
        $this->barrioNombre = $barrioNombre;

        return $this;
    }

    /**
     * Get barrioNombre
     *
     * @return string 
     */
    public function getBarrioNombre()
    {
        return $this->barrioNombre;
    }

    /**
     * Set barrioDescripcion
     *
     * @param string $barrioDescripcion
     * @return Barrio
     */
    public function setBarrioDescripcion($barrioDescripcion)
    {
        $this->barrioDescripcion = $barrioDescripcion;

        return $this;
    }

    /**
     * Get barrioDescripcion
     *
     * @return string 
     */
    public function getBarrioDescripcion()
    {
        return $this->barrioDescripcion;
    }

    /**
     * Set barrioHabitantes
     *
     * @param string $barrioHabitantes
     * @return Barrio
     */
    public function setBarrioHabitantes($barrioHabitantes)
    {
        $this->barrioHabitantes = $barrioHabitantes;

        return $this;
    }

    /**
     * Get barrioHabitantes
     *
     * @return string 
     */
    public function getBarrioHabitantes()
    {
        return $this->barrioHabitantes;
    }

    /**
     * Set upz
     *
     * @param \Login\Model\Entity\Upz $upz
     * @return Barrio
     */
    public function setUpz(\Login\Model\Entity\Upz $upz = null)
    {
        $this->upz = $upz;

        return $this;
    }

    /**
     * Get upz
     *
     * @return \Login\Model\Entity\Upz 
     */
    public function getUpz()
    {
        return $this->upz;
    }
}
