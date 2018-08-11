<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;

    /**
     * @ORM\Column(type="integer", length=100)
     * @Assert\NotBlank()
     */
	private $id_menu;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     */
	private $url;

    /**
     * @ORM\Column(type="integer", length=100)
     * @Assert\NotBlank()
     */
    private $ordem;

    /**
     * Many Menu have Many Perfil.
     * @ORM\ManyToMany(targetEntity="Perfil", inversedBy="menus")
     * @ORM\JoinTable(name="menu_perfil", joinColumns={
     *      @ORM\JoinColumn(name="id_menu", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_perfil", referencedColumnName="id")
     *  })
     */
	private $perfis;

    public function __construct() {
        $this->perfis = new ArrayCollection();
    }

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function setId_menu($id_menu){
		$this->id_menu = $id_menu;
	}
	public function getId_menu(){
		return $this->id_menu;
	}
	
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getNome(){
		return $this->nome;
	}
	
	public function setUrl($url){
		$this->url = $url;
	}
	public function getUrl(){
		return $this->url;
	}
		
    public function getOrdem()
    {
        return $this->ordem;
    }

    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
    }

    public function getPerfis()
    {
        return $this->perfis;
    }

    public function setPerfis($perfis)
    {
        $this->perfis = $perfis;
    }

}
