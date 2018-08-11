<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Utils\Pagination;
use AppBundle\Utils\Mensagens;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Categoria controller.
 *
 * @Route("categoria")
 */
class CategoriaController extends Controller
{
    /**
     * Lists all categoria entities.
     *
     * @Route("/", name="categoria_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('categoria/index.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTable(),
            'validaJS' => array('validaDefault'),
        ));

    }

    /**
     * Creates a new categoria entity.
     *
     * @Route("/new", name="categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $categoria = new Categoria();

            $categoria->setNome($request->request->get('nome'));

            try {
                $em->persist($categoria);
                $em->flush();
                $response = $msg->load('003');
            } catch (UniqueConstraintViolationException $e) {
                $response = $msg->load('009');
            }

            return $response;
        }

        return $this->render('categoria/new.html.twig', array(
            'validaJS' => array('validaDefault'),
        ));
    }

    /**
     * Displays a form to edit an existing categoria entity.
     *
     * @Route("/formEdit/{id}", name="categoria_formEdit")
     * @Method({"GET", "POST"})
     */
    public function formEditAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $categoria = $em->find(Categoria::class, $id);

        return $this->render('categoria/edit.html.twig', array(
            'categoria' => $categoria,
            'validaJS' => array('validaDefault'),
        ));

    }

    /**
     * Displays a form to edit an existing categoria entity.
     *
     * @Route("/edit", name="categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $idEdit = $request->request->get('idEdit');

            $em = $this->getDoctrine()->getManager();
            $categoria = $em->find(Categoria::class, $idEdit);

            $categoria->setNome($request->request->get('nome'));

            if (!$categoria) {
                throw $this->createNotFoundException(
                    'Categoria não encontrada para id '.$idEdit
                );
            }

            try {
                $em->flush();
                $response = $msg->load('004');
            } catch (UniqueConstraintViolationException $e) {
                $response = $msg->load('006');
            }

            return $response;
        }
    }

    /**
     * Deletes a categoria entity.
     *
     * @Route("/delete/{id}", name="categoria_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();
        $categoria = $em->find(Categoria::class, $id);

        if ($categoria != null) {

            try {
                $em->remove($categoria);
                $em->flush();
                $response = $msg->load('005');
            } catch (ForeignKeyConstraintViolationException $e) {
                $response = $msg->load('010');
            }

        }

        return $response;
    }

    /**
     * ---------------------------------
     *  --- DATATABLE ---
     * ---------------------------------
     */
    public function montaHeaderDataTable(){

        $listaDados = array (
            0 => array ("TAMANHO_CAMPO"=>"90", "NOME_CAMPO"=>"Categoria", "ALINHA_COLUNA"=>"left"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 15);

    }

    /**
     *
     * @Route("/listar", name="categoria_listar")
     * @Method({"GET", "POST"})
     */
    public function listar(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $aColumns = array( 'id', 'nome' );
            $fieldWhere = array( 's.id', 's.nome' );

            /* Indexed column (used for fast and accurate table cardinality) */
            $paramWhere   = "";

            $pagination = new Pagination();
            $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

            $em = $this->getDoctrine()->getManager();

            $rResult = $em->getRepository(Categoria::class)->listarDados($aColumns, $sWhere, $request);
            $iTotal = $em->getRepository(Categoria::class)->totalRegistroFiltro();

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
			  		<a href="formEdit/'.$id.'" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
			  		<a onclick="atualizarItem('.$id.', \''.$urlExcluir.'\');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
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
