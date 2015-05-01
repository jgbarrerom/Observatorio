<?php

namespace Login\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permiso
 *
 * @ORM\Table(name="permiso")
 * @ORM\Entity
 */
class Permiso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="permiso_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $permisoId;

    /**
     * @var string
     *
     * @ORM\Column(name="permiso_tipo", type="string", length=15, nullable=false)
     */
    private $permisoTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="permiso_descripcion", type="string", length=30, nullable=false)
     */
    private $permisoDescripcion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Login\Model\Entity\Usuario", inversedBy="permiso")
     * @ORM\JoinTable(name="usuario_permiso",
     *   joinColumns={
     *     @ORM\JoinColumn(name="permiso_id", referencedColumnName="permiso_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id")
     *   }
     * )
     */
    private $usuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuario = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get permisoId
     *
     * @return integer 
     */
    public function getPermisoId()
    {
        return $this->permisoId;
    }

    /**
     * Set permisoTipo
     *
     * @param string $permisoTipo
     * @return Permiso
     */
    public function setPermisoTipo($permisoTipo)
    {
        $this->permisoTipo = $permisoTipo;

        return $this;
    }

    /**
     * Get permisoTipo
     *
     * @return string 
     */
    public function getPermisoTipo()
    {
        return $this->permisoTipo;
    }

    /**
     * Set permisoDescripcion
     *
     * @param string $permisoDescripcion
     * @return Permiso
     */
    public function setPermisoDescripcion($permisoDescripcion)
    {
        $this->permisoDescripcion = $permisoDescripcion;

        return $this;
    }

    /**
     * Get permisoDescripcion
     *
     * @return string 
     */
    public function getPermisoDescripcion()
    {
        return $this->permisoDescripcion;
    }

    /**
     * Add usuario
     *
     * @param \Login\Model\Entity\Usuario $usuario
     * @return Permiso
     */
    public function addUsuario(\Login\Model\Entity\Usuario $usuario)
    {
        $this->usuario[] = $usuario;

        return $this;
    }

    /**
     * Remove usuario
     *
     * @param \Login\Model\Entity\Usuario $usuario
     */
    public function removeUsuario(\Login\Model\Entity\Usuario $usuario)
    {
        $this->usuario->removeElement($usuario);
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
