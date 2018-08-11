<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Loja
 *
 * @ORM\Table(name="loja", indexes={@ORM\Index(name="fk_loja_endereco1_idx", columns={"id_endereco"}), @ORM\Index(name="fk_loja_usuario1_idx", columns={"id_usuario"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LojaRepository")
 */
class Loja
{

    /**
     * One Loja has One Status.
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="id_status", referencedColumnName="id")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="razao_social", type="string", length=45, nullable=false)
     */
    private $razaoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="cnpj", type="string", length=19, nullable=false)
     */
    private $cnpj;

    /**
     * @var integer
     *
     * @ORM\Column(name="qtdproduto", type="integer")
     */
    private $qtdproduto;


    /**
     * @var string
     *
     * @ORM\Column(name="telefone1", type="string", length=14, nullable=false)
     */
    private $telefone1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefone2", type="string", length=14, nullable=true)
     */
    private $telefone2;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="text", length=65535, nullable=true)
     */
    private $descricao;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Endereco
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Endereco", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_endereco", referencedColumnName="id")
     * })
     */
    private $endereco;

    /**
     * @var \AppBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $usuario;


    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus(){
        return $this->status;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Loja
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
     * Set razaoSocial
     *
     * @param string $razaoSocial
     *
     * @return Loja
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;

        return $this;
    }

    /**
     * Get razaoSocial
     *
     * @return string
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set cnpj
     *
     * @param string $cnpj
     *
     * @return Loja
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get cnpj
     *
     * @return string
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * Set telefone1
     *
     * @param string $telefone1
     *
     * @return Loja
     */
    public function setTelefone1($telefone1)
    {
        $this->telefone1 = $telefone1;

        return $this;
    }

    /**
     * Get telefone1
     *
     * @return string
     */
    public function getTelefone1()
    {
        return $this->telefone1;
    }

    /**
     * Set telefone2
     *
     * @param string $telefone2
     *
     * @return Loja
     */
    public function setTelefone2($telefone2)
    {
        $this->telefone2 = $telefone2;

        return $this;
    }

    /**
     * Get telefone2
     *
     * @return string
     */
    public function getTelefone2()
    {
        return $this->telefone2;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Loja
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set endereco
     *
     * @param Endereco $endereco
     *
     * @return Loja
     */
    public function setEndereco(Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return Endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set usuario
     *
     * @param Usuario $usuario
     *
     * @return Loja
     */
    public function setUsuario(Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return int
     */
    public function getQtdproduto()
    {
        return $this->qtdproduto;
    }

    /**
     * @param int $qtdproduto
     */
    public function setQtdproduto($qtdproduto)
    {
        $this->qtdproduto = $qtdproduto;
    }


}
