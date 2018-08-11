<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cidade;
use AppBundle\Entity\Endereco;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Loja;
use AppBundle\Entity\LojaProduto;
use AppBundle\Entity\Status;
use AppBundle\Entity\TipoProduto;
use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Utils\Pagination;
use AppBundle\Utils\Mensagens;

/**
 * Endereco controller.
 *
 * @Route("loja")
 */
class LojaController extends Controller
{
    /**
     * LojaController constructor.
     */
    public function __construct()
    {
        $this->urlPage = "frontend/";
    }

    /**
     * @Route("/adminwebsite", name="loja_adminwebsite")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $listaLoja = $em->getRepository(Loja::class)->findByUsuario($user->getId());

        // replace this example code with whatever you need
        return $this->render($this->urlPage.'admin.html.twig', array(
            'listaLoja' => $listaLoja,
        ));
    }

    /**
     * Creates a new loja entity.
     *
     * @Route("/new", name="loja_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();

        $listaEstado = $em->getRepository(Estado::class)->findAll();

        if ($request->isXmlHttpRequest()) {

            $loja = new Loja();
            $endereco = new Endereco();

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $usuario = $em->find(Usuario::class, $user->getId());

            $status = $em->getRepository(Status::class)->find(2); // Aguardando analise

            $cidade = $em->getRepository(Cidade::class)->find($request->request->get('cidade'));

            $endereco->setBairro($request->request->get('bairro'));
            $endereco->setCep($request->request->get('cep'));
            $endereco->setCidade($cidade);
            $endereco->setComplemento($request->request->get('complemento'));
            $endereco->setEndereco($request->request->get('endereco'));
            $endereco->setNumero($request->request->get('numero'));

            $loja->setNome($request->request->get('nome'));
            $loja->setCnpj($request->request->get('cnpj'));
            $loja->setRazaoSocial($request->request->get('razaoSocial'));
            $loja->setTelefone1($request->request->get('telefone1'));
            $loja->setTelefone2($request->request->get('telefone2'));
            $loja->setDescricao($request->request->get('descricao'));
            $loja->setUsuario($usuario);
            $loja->setEndereco($endereco);
            $loja->setStatus($status);

            try {
                $em->persist($loja);
                $em->flush();
                $response = $msg->load('003');
            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;
        }

        return $this->render($this->urlPage.'cadastrarloja.html.twig', array(
            'listaEstado' => $listaEstado,
            'validaJS' => array('validaEndereco', 'validaLoja'),
        ));
    }

    /**
     * Displays a form to edit an existing loja entity.
     *
     * @Route("/formLojaEdit/{id}", name="loja_formLojaEdit")
     * @Method({"GET", "POST"})
     */
    public function formLojaEditAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $listaEstado = $em->getRepository(Estado::class)->findAll();

        $loja = $em->find(Loja::class, $id);

        return $this->render($this->urlPage.'alterarloja.html.twig', array(
            'loja' => $loja,
            'listaEstado' => $listaEstado,
            'validaJS' => array('validaEndereco', 'validaLoja'),
        ));

    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/edit", name="loja_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $authChecker = $this->get('security.authorization_checker');


        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $idEdit = $request->request->get('idEdit');

            $em = $this->getDoctrine()->getManager();

            $loja = $em->find(Loja::class, $idEdit);

            $endereco = $em->find(Endereco::class, $loja->getEndereco());

            $cidade = $em->find(Cidade::class, $request->request->get('cidade'));

            $endereco->setBairro($request->request->get('bairro'));
            $endereco->setCep($request->request->get('cep'));
            $endereco->setCidade($cidade);
            $endereco->setComplemento($request->request->get('complemento'));
            $endereco->setEndereco($request->request->get('endereco'));
            $endereco->setNumero($request->request->get('numero'));

            $loja->setNome($request->request->get('nome'));
            $loja->setCnpj($request->request->get('cnpj'));
            $loja->setRazaoSocial($request->request->get('razaoSocial'));
            $loja->setTelefone1($request->request->get('telefone1'));
            $loja->setTelefone2($request->request->get('telefone2'));
            $loja->setDescricao($request->request->get('descricao'));

            if ($authChecker->isGranted('ROLE_ADMIN')) {
                $status = $em->getRepository(Status::class)->find($request->request->get('status'));
                $loja->setStatus($status);
            }

            if(is_null($request->request->get('qtdproduto'))){
                $qtdProduto = 0;
            } else {
                $qtdProduto = $request->request->get('qtdproduto');
            }
            $loja->setQtdproduto($qtdProduto);
            $loja->setEndereco($endereco);

            try {
                $em->flush();
                $response = $msg->load('004');
            } catch (Exception $e) {
                $response = $msg->load('006');
            }

            return $response;
        }


    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/desativaLojaPeloCliente", name="loja_desativaLojaPeloCliente")
     * @Method({"GET", "POST"})
     */
    public function desativaLojaPeloClienteAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $idEdit = $request->request->get('id');

            $em = $this->getDoctrine()->getManager();

            $loja = $em->getRepository(Loja::class)->findOneBy(
                array('id' => $idEdit, 'usuario' => $user)
            );

            $status = $em->getRepository(Status::class)->find(5); // Desativado pelo Cliente

            $loja->setStatus($status);

            try {
                $em->flush();
                $response = $msg->load('021');
            } catch (Exception $e) {
                $response = $msg->load('006');
            }

            return $response;
        }


    }

    /**
     * Deletes a loja entity.
     *
     * @Route("/delete/{id}", name="loja_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();
        $loja = $em->find(Loja::class, $id);

        if ($loja != null) {
            try {
                $em->remove($loja);
                $em->flush();
                $response = $msg->load('005');
            } catch (ForeignKeyConstraintViolationException $e) {
                $response = $msg->load('010');
            }
        }



        return $response;
    }

    /**
     * Lists all Produto entities.
     *
     * @Route("/listarProdutoLoja/{id}", name="loja_listarProdutoLoja")
     * @Method({"GET", "POST"})
     */
    public function listarProdutoLojaAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('produto/listar-produto-loja.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTable(),
            'validaJS' => array('validaProdutoLoja'),
            'idLoja' => $id,
        ));

    }


    /**
     * ---------------------------------
     *  --- DATATABLE ---
     * ---------------------------------
     */

    public function montaHeaderDataTable(){

        $listaDados = array (
            array ("TAMANHO_CAMPO"=>"50", "NOME_CAMPO"=>"Produto", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Preço", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Data Alteração", "ALINHA_COLUNA"=>"center"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 5);

    }

    /**
     *
     * @Route("/listar/{idLoja}", name="lojaProduto_listar")
     * @Method({"GET", "POST"})
     */
    public function listar(Request $request, $idLoja)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $aColumns = array( 'id', 'nomeProduto', 'preco', 'dtAlteracao' );

            $fieldWhere = array( 'lp.id', 'p.nome', 'lp.preco', 'lp.dtAlteracao' );

            /* Indexed column (used for fast and accurate table cardinality) */
            $paramWhere   = "lp.loja = ".$idLoja;

            $pagination = new Pagination();
            $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

            $em = $this->getDoctrine()->getManager();

            $rResult = $em->getRepository(LojaProduto::class)->listarDados($aColumns, $sWhere, $request);
            $iTotal = $em->getRepository(LojaProduto::class)->totalRegistroFiltro();

            // Montando o output do datatable
            $output = $pagination->outputDataTable($request->get('sEcho'), $iTotal);

            // Montando os dados do banco
            for ( $w=0 ; $w<count($rResult) ; $w++ ) {
                $row = array();

                for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
                    if ( $aColumns[$i] != ' ' ) {
                        $valor = $rResult[$w][$aColumns[$i]];

                        if($valor instanceof \DateTime){
                            $row[] = $valor->format('d/m/Y');
                        } else {
                            $row[] = $valor;
                        }
                    }
                }

                $id = $rResult[$w]['id'];
               // dump($rResult[$w]); exit;
                $idProduto = $rResult[$w]['idProduto'];

                // Linha que adiciona os checkboxes na pagina
                $row[] =  '
			  		<a onclick="desassociarProdutoLoja('.$idLoja.', '.$idProduto.');" class="btn btn-xs btn-danger" title="Desassociar Produto"><i class="fa fa-refresh"></i></a>
			    ';

                // retira o id da busca
                array_shift($row);

                $output['aaData'][] = $row;

            }

            $response = new JsonResponse();
            $response->setData($output);
            return $response;

        }
    }


}
