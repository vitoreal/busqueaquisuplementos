<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FotoProduto
 *
 * @ORM\Table(name="foto_produto", indexes={@ORM\Index(name="fk_foto_produto_produto1_idx", columns={"id_produto"})})
 * @ORM\Entity
 */
class FotoProduto
{
    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=45, nullable=false)
     */
    private $foto;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * Set foto
     *
     * @param string $foto
     *
     * @return FotoProduto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
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
     * Set produto
     *
     * @param \AppBundle\Entity\Produto $idProduto
     *
     * @return FotoProduto
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
