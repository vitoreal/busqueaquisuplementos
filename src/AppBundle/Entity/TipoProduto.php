<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoProduto
 *
 * @ORM\Table(name="tipo_produto", indexes={@ORM\Index(name="fk_tipo_produto_categoria1_idx", columns={"id_categoria"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoProdutoRepository")
 */
class TipoProduto
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=200, nullable=false)
     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Categoria
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categoria", referencedColumnName="id")
     * })
     */
    private $categoria;



    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return TipoProduto
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Categoria
     *
     * @param \AppBundle\Entity\Categoria $categoria
     *
     * @return TipoProduto
     */
    public function setCategoria(Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get Categoria
     *
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
