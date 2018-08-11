<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Entity\Cidade;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Sabor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Marca;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->urlPage = "frontend/";
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render($this->urlPage.'index.html.twig');
    }

    /**
     * @Route("/buscaProdutoPage", name="buscaProdutoPage")
     */
    public function buscaProdutoPageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render($this->urlPage.'resultadobusca.html.twig');
    }

    /**
     * @Route("/carregaBuscaAvancadaForm", name="carregaBuscaAvancadaForm")
     * @Method({"GET", "POST"})
     */
    public function carregaBuscaAvancadaFormAction(Request $request)
    {
        $session = new Session();

        $em = $this->getDoctrine()->getManager();

        $listaMarca = $em->getRepository(Marca::class)->findAll();
        $listaCategoria = $em->getRepository(Categoria::class)->findAll();
        $listaEstado = $em->getRepository(Estado::class)->findAll();

        $listaTodosEndereco = $em->getRepository(Cidade::class)->loadEnderecoExisteLoja();

        $listaEstado = array();

        foreach ($listaTodosEndereco as $keyTE=>$valTE){
            $listaEstado[$valTE['sigla']] = $valTE['estado'];
        }

        $session->set('listaEnderecos', $listaTodosEndereco);

        //dump($session->get('listaEnderecos')); exit;

        // replace this example code with whatever you need
        return $this->render($this->urlPage.'topoformbusca.html.twig', array(
            'listaMarca' => $listaMarca,
            'listaCategoria' => $listaCategoria,
            'listaEstado' => $listaEstado,
        ));
    }

}
