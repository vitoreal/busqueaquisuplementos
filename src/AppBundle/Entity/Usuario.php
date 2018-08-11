<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One Usuario has One Status.
     * @ORM\OneToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="id_status", referencedColumnName="id")
     */
    private $status;


    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", length=14, nullable=false, unique=true)
     */
    private $cpf;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $dtCadastro;

    /**
     * One Usuario has One Permissoes.
     * @ORM\OneToOne(targetEntity="Permissoes")
     * @ORM\JoinColumn(name="id_permissoes", referencedColumnName="id")
     */
    private $permissoes;

    private $roles = array();

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setDtCadastro($dtCadastro){
        $this->dtCadastro = $dtCadastro;
    }

    public function getDtCadastro(){
        return $this->dtCadastro;
    }


    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getPermissoes()
    {
        return $this->permissoes;
    }

    public function setPermissoes($permissoes)
    {
        $this->permissoes = $permissoes;
    }

    public function getRoles() {
        return $this->getPermissoes()->getRoles();
    }

    public function getSalt() {

    }

    public function eraseCredentials() {

    }



}