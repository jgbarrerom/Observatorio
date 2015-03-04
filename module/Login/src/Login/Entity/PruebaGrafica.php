<?php

namespace Login\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PruebaGrafica
 *
 * @ORM\Table(name="prueba_grafica")
 * @ORM\Entity
 */
class PruebaGrafica
{
    /**
     * @var integer
     *
     * @ORM\Column(name="grafica_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $graficaId;

    /**
     * @var string
     *
     * @ORM\Column(name="grafica_nombre", type="string", length=20, nullable=true)
     */
    private $graficaNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="grafica_valor1", type="string", length=20, nullable=true)
     */
    private $graficaValor1;

    /**
     * @var string
     *
     * @ORM\Column(name="grafica_valor2", type="string", length=20, nullable=true)
     */
    private $graficaValor2;

    /**
     * @var string
     *
     * @ORM\Column(name="grafica_valor3", type="string", length=20, nullable=true)
     */
    private $graficaValor3;



    /**
     * Get graficaId
     *
     * @return integer 
     */
    public function getGraficaId()
    {
        return $this->graficaId;
    }

    /**
     * Set graficaNombre
     *
     * @param string $graficaNombre
     * @return PruebaGrafica
     */
    public function setGraficaNombre($graficaNombre)
    {
        $this->graficaNombre = $graficaNombre;

        return $this;
    }

    /**
     * Get graficaNombre
     *
     * @return string 
     */
    public function getGraficaNombre()
    {
        return $this->graficaNombre;
    }

    /**
     * Set graficaValor1
     *
     * @param string $graficaValor1
     * @return PruebaGrafica
     */
    public function setGraficaValor1($graficaValor1)
    {
        $this->graficaValor1 = $graficaValor1;

        return $this;
    }

    /**
     * Get graficaValor1
     *
     * @return string 
     */
    public function getGraficaValor1()
    {
        return $this->graficaValor1;
    }

    /**
     * Set graficaValor2
     *
     * @param string $graficaValor2
     * @return PruebaGrafica
     */
    public function setGraficaValor2($graficaValor2)
    {
        $this->graficaValor2 = $graficaValor2;

        return $this;
    }

    /**
     * Get graficaValor2
     *
     * @return string 
     */
    public function getGraficaValor2()
    {
        return $this->graficaValor2;
    }

    /**
     * Set graficaValor3
     *
     * @param string $graficaValor3
     * @return PruebaGrafica
     */
    public function setGraficaValor3($graficaValor3)
    {
        $this->graficaValor3 = $graficaValor3;

        return $this;
    }

    /**
     * Get graficaValor3
     *
     * @return string 
     */
    public function getGraficaValor3()
    {
        return $this->graficaValor3;
    }
}
