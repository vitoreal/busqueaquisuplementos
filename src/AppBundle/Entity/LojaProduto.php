<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LojaProduto
 *
 * @ORM\Table(name="loja_produto", indexes={@ORM\Index(name="fk_loja_has_produto_produto1_idx", columns={"id_produto"}), @ORM\Index(name="fk_loja_has_produto_loja1_idx", columns={"id_loja"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LojaProdutoRepository")
 */
class LojaProduto
{
    /**
     * @var string
     *
     * @ORM\Column(name="preco", type="string", length=9, nullable=false)
     */
    private $preco;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_alteracao", type="datetime", nullable=false)
     */
    private $dtAlteracao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Loja
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Loja")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_loja", referencedColumnName="id")
     * })
     */
    private $loja;

    /**
     * @var \AppBundle\Entity\Produto
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produto", referencedColumnName="id")
     * })
     */
    private $produto;

    /**
     * Set preco
     *
     * @param string $preco
     *
     * @return LojaProduto
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * Get preco
     *
     * @return string
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set dtAlteracao
     *
     * @param \DateTime $dtAlteracao
     *
     * @return LojaProduto
     */
    public function setDtAlteracao($dtAlteracao)
    {
        $this->dtAlteracao = $dtAlteracao;

        return $this;
    }

    /**
     * Get dtAlteracao
     *
     * @return \DateTime
     */
    public function getDtAlteracao()
    {
        return $this->dtAlteracao;
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
     * Set loja
     *
     * @param \AppBundle\Entity\Loja $loja
     *
     * @return LojaProduto
     */
    public function setLoja(\AppBundle\Entity\Loja $loja = null)
    {
        $this->loja = $loja;

        return $this;
    }

    /**
     * Get loja
     *
     * @return \AppBundle\Entity\Loja
     */
    public function getLoja()
    {
        return $this->loja;
    }

    /**
     * Set produto
     *
     * @param \AppBundle\Entity\Produto $produto
     *
     * @return LojaProduto
     */
    public function setProduto(\AppBundle\Entity\Produto $produto = null)
    {
        $this->produto = $produto;

        return $this;
    }

    /**
     * Get produto
     *
     * @return \AppBundle\Entity\Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }
}
