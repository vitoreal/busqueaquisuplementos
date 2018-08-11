<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface {
    
    private $container;
    
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        
        $user = new Usuario();
        $user->setNome("Root");
        $user->setIdStatus(1);
        $user->setId_perfil(1);
        $user->setDtCadastro(new \DateTime("now"));
        
        $user->setUsername("root@root.com");
        $roles = ["ROLE_SUPER_ADMIN"];
        $user->getPermissoes()->setNome("Administrador Root");
        $user->getPermissoes()->setRoles($roles);
        
        $enconder = $this->container->get('security.password_encoder');
        $password = $enconder->encodePassword($user, '123456');
        $user->setPassword($password);
        
        $manager->persist($user);
        $manager->flush();
    }
    
     /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}