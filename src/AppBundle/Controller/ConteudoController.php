<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conteudo;
use AppBundle\Entity\TipoConteudo;
use AppBundle\Utils\Pagination;
use AppBundle\Utils\Mensagens;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Conteudo controller.
 *
 * @Route("conteudo")
 */
class ConteudoController extends Controller
{
    /**
     * DefaultController constructor.
     */
    public function __construct()
    {
        $this->urlPage = "frontend/";
    }

    /**
     * @Route("/materia/{conteudo}", name="conteudo_carrega")
     * @Method({"GET", "POST"})
     */
    public function carregaConteudoAction(Request $request, $conteudo)
    {
        $urlPage = "";
        $codTipoConteudo = "";

        switch ($conteudo) {
            case "sobre":
                $urlPage = $this->urlPage.'sobre.html.twig';
                $codTipoConteudo = 1;
                break;
            case "servico":
                $urlPage = $this->urlPage.'servico.html.twig';
                $codTipoConteudo = 3;
                break;
            case "publicidade":
                $urlPage = $this->urlPage.'publicidade.html.twig';
                $codTipoConteudo = 4;
                break;
            case "termosdeuso":
                $urlPage = $this->urlPage.'termosdeuso.html.twig';
                $codTipoConteudo = 5;
                break;
            case "contato":
                $urlPage = $this->urlPage.'contato.html.twig';
                $codTipoConteudo = 2;
                break;
            case "registrar":
                $urlPage = $this->urlPage.'registrar.html.twig';
                $codTipoConteudo = 2;
                break;
        }
        $em = $this->getDoctrine()->getManager();
        $conteudo = $em->getRepository(Conteudo::class)->findOneByTipoConteudo($codTipoConteudo);

        return $this->render($urlPage, array(
            'conteudo' => $conteudo,
        ));
    }

    /**
     * Lists all conteudo entities.
     *
     * @Route("/", name="conteudo_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('conteudo/index.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTable(),
            'validaJS' => array('validaConteudo'),
        ));

    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/new/{id}", name="conteudo_new")
     * @Method({"GET", "POST"})
     */

    public function newAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();

        $conteudo = $em->getRepository(Conteudo::class)->findOneByTipoConteudo($id);

        $isPersiste = false;

        if (is_null($conteudo)) {
            $conteudo = new Conteudo();
            $isPersiste = true;
        }

        if ($request->isXmlHttpRequest()) {

            $tipoConteudo = $em->getRepository(TipoConteudo::class)->find($id);

            $conteudo->setTipoConteudo($tipoConteudo);
            $conteudo->setMetaDescription($request->request->get('metaDescription'));
            $conteudo->setMetaKeywords($request->request->get('metaKeyWords'));
            $conteudo->setMetaTitle($request->request->get('metaTitle'));
            $conteudo->setDescricao($request->request->get('descricao'));

            if (is_null($request->request->get('descricao')) || $request->request->get('descricao') == ""){
                $response = $msg->load('019');
                return $response;
            }

            try {

                $response = $msg->load('004');

                if ($isPersiste) {
                    $em->persist($conteudo);
                    $response = $msg->load('003');
                }

                $em->flush();

            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;
        }



        return $this->render('conteudo/new.html.twig', array(
            'conteudo' => $conteudo,
            'validaJS' => array('validaConteudo'),
            'idTipoConteudo' => $id,
        ));
    }



    /**
     * ---------------------------------
     *  --- DATATABLE ---
     * ---------------------------------
     */
    public function montaHeaderDataTable(){

        $listaDados = array (
            0 => array ("TAMANHO_CAMPO"=>"90", "NOME_CAMPO"=>"Nome", "ALINHA_COLUNA"=>"left"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 15);

    }

    /**
     *
     * @Route("/listar", name="conteudo_listar")
     * @Method({"GET", "POST"})
     */
    public function listar(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $aColumns = array( 'id', 'nome' );
            $fieldWhere = array( 's.id', 's.nome' );

            $paramWhere   = "";

            $pagination = new Pagination();
            $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

            $em = $this->getDoctrine()->getManager();

            $rResult = $em->getRepository(TipoConteudo::class)->listarDados($aColumns, $sWhere, $request);
            $iTotal = $em->getRepository(TipoConteudo::class)->totalRegistroFiltro();

            // Montando o output do datatable
            $output = $pagination->outputDataTable($request->get('sEcho'), $iTotal);

            // Montando os dados do banco
            for ( $w=0 ; $w<count($rResult) ; $w++ ) {
                $row = array();

                for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
                    if ( $aColumns[$i] != ' ' ) {
                        $row[] = $rResult[$w][$aColumns[$i]];
                    }
                }

                $id = $rResult[$w]['id'];

                $urlExcluir = "delete/".$id;

                // Linha que adiciona os checkboxes na pagina
                $row[] =  '
			  		<a href="new/'.$id.'" title="Inserir Descrição" class="btn btn-xs btn-success"><i class="fa fa-file-o"></i></a>
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
