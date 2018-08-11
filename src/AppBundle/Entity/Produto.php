<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produto
 *
 * @ORM\Table(name="produto", indexes={@ORM\Index(name="fk_produto_tipo_produto1_idx", columns={"id_tipo_produto"}), @ORM\Index(name="fk_produto_sabor1_idx", columns={"id_sabor"}), @ORM\Index(name="fk_produto_marca1_idx", columns={"id_marca"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProdutoRepository")
 */
class Produto
{
    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;


    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=2000, nullable=false)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="peso", type="string", length=45, nullable=true)
     */
    private $peso;

    /**
     * @var string
     *
     * @ORM\Column(name="quatidade", type="string", length=45, nullable=true)
     */
    private $quatidade;

    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=45, nullable=true)
     */
    private $genero;

    /**
     * @var string
     *
     * @ORM\Column(name="forma", type="string", length=45, nullable=true)
     */
    private $forma;

    /**
     * @var string
     *
     * @ORM\Column(name="validade", type="string", length=45, nullable=true)
     */
    private $validade;

    /**
     * @var string
     *
     * @ORM\Column(name="recomendacao_uso", type="string", length=500, nullable=true)
     */
    private $recomendacaoUso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gluten", type="boolean", nullable=true)
     */
    private $gluten;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lactose", type="boolean", nullable=true)
     */
    private $lactose;

    /**
     * @var string
     *
     * @ORM\Column(name="importante", type="string", length=1000, nullable=true)
     */
    private $importante;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Marca
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Marca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_marca", referencedColumnName="id")
     * })
     */
    private $marca;

    /**
     * @var \AppBundle\Entity\Sabor
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sabor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sabor", referencedColumnName="id")
     * })
     */
    private $sabor;

    /**
     * @var \AppBundle\Entity\TipoProduto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoProduto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tipo_produto", referencedColumnName="id")
     * })
     */
    private $tipoProduto;



    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Produto
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
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Produto
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set peso
     *
     * @param string $peso
     *
     * @return Produto
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set quatidade
     *
     * @param string $quatidade
     *
     * @return Produto
     */
    public function setQuatidade($quatidade)
    {
        $this->quatidade = $quatidade;

        return $this;
    }

    /**
     * Get quatidade
     *
     * @return string
     */
    public function getQuatidade()
    {
        return $this->quatidade;
    }

    /**
     * Set genero
     *
     * @param string $genero
     *
     * @return Produto
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set forma
     *
     * @param string $forma
     *
     * @return Produto
     */
    public function setForma($forma)
    {
        $this->forma = $forma;

        return $this;
    }

    /**
     * Get forma
     *
     * @return string
     */
    public function getForma()
    {
        return $this->forma;
    }

    /**
     * Set validade
     *
     * @param string $validade
     *
     * @return Produto
     */
    public function setValidade($validade)
    {
        $this->validade = $validade;

        return $this;
    }

    /**
     * Get validade
     *
     * @return string
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * Set recomendacaoUso
     *
     * @param string $recomendacaoUso
     *
     * @return Produto
     */
    public function setRecomendacaoUso($recomendacaoUso)
    {
        $this->recomendacaoUso = $recomendacaoUso;

        return $this;
    }

    /**
     * Get recomendacaoUso
     *
     * @return string
     */
    public function getRecomendacaoUso()
    {
        return $this->recomendacaoUso;
    }

    /**
     * Set gluten
     *
     * @param boolean $gluten
     *
     * @return Produto
     */
    public function setGluten($gluten)
    {
        $this->gluten = $gluten;

        return $this;
    }

    /**
     * Get gluten
     *
     * @return boolean
     */
    public function getGluten()
    {
        return $this->gluten;
    }

    /**
     * Set lactose
     *
     * @param boolean $lactose
     *
     * @return Produto
     */
    public function setLactose($lactose)
    {
        $this->lactose = $lactose;

        return $this;
    }

    /**
     * Get lactose
     *
     * @return boolean
     */
    public function getLactose()
    {
        return $this->lactose;
    }

    /**
     * Set importante
     *
     * @param string $importante
     *
     * @return Produto
     */
    public function setImportante($importante)
    {
        $this->importante = $importante;

        return $this;
    }

    /**
     * Get importante
     *
     * @return string
     */
    public function getImportante()
    {
        return $this->importante;
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
     * Set marca
     *
     * @param \AppBundle\Entity\Marca $marca
     *
     * @return Produto
     */
    public function setMarca(\AppBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \AppBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set sabor
     *
     * @param \AppBundle\Entity\Sabor $sabor
     *
     * @return Produto
     */
    public function setSabor(\AppBundle\Entity\Sabor $sabor = null)
    {
        $this->sabor = $sabor;

        return $this;
    }

    /**
     * Get sabor
     *
     * @return \AppBundle\Entity\Sabor
     */
    public function getSabor()
    {
        return $this->sabor;
    }

    /**
     * Set tipoProduto
     *
     * @param \AppBundle\Entity\TipoProduto $tipoProduto
     *
     * @return Produto
     */
    public function setTipoProduto(\AppBundle\Entity\TipoProduto $tipoProduto = null)
    {
        $this->tipoProduto = $tipoProduto;

        return $this;
    }

    /**
     * Get tipoProduto
     *
     * @return \AppBundle\Entity\TipoProduto
     */
    public function getTipoProduto()
    {
        return $this->tipoProduto;
    }
}
