<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Estado;
use AppBundle\Entity\Loja;
use AppBundle\Entity\LojaProduto;
use AppBundle\Entity\Status;
use AppBundle\Entity\Permissoes;
use AppBundle\Entity\Usuario;
use AppBundle\Repository\UsuarioRepository;
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
 * Cliente controller.
 *
 * @Route("cliente")
 */
class ClienteController extends Controller
{

    public function __construct()
    {
        $this->urlPage = "frontend/";
    }

    /**
     * Lists all cliente entities.
     *
     * @Route("/", name="cliente_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        return $this->render('cliente/index.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTable(),
            'validaJS' => array('validaUsuario'),
        ));
    }

    /**
     * Displays a form to edit an existing loja entity.
     *
     * @Route("/formClienteLojaEdit/{id}", name="cliente_formClienteLojaEdit")
     * @Method({"GET", "POST"})
     */
    public function formClienteLojaEditAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $listaEstado = $em->getRepository(Estado::class)->findAll();
        $status = $em->getRepository(Status::class)->findAll();
        $loja = $em->find(Loja::class, $id);

        return $this->render('cliente/alterarloja.html.twig', array(
            'loja' => $loja,
            'listaEstado' => $listaEstado,
            'listaStatus' => $status,
            'validaJS' => array('validaEndereco', 'validaLoja'),
        ));

    }



    /**
     * Displays a form to edit an existing cliente entity.
     *
     * @Route("/formDadosPessoais", name="cliente_formDadosPessoais")
     * @Method({"GET", "POST"})
     */

    public function formDadosPessoaisAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $usuario = $em->find(Usuario::class, $user->getId());

        $status = $em->getRepository(Status::class)->findOneBy(
            array('id' => $user->getStatus())
        );

        return $this->render($this->urlPage.'dadospessoais.html.twig', array(
            'usuario' => $usuario,
            'status' => $status,
        ));

    }

    /**
     * Displays a form to edit an existing cliente entity.
     *
     * @Route("/formAlterarSenha", name="cliente_formAlterarSenha")
     * @Method({"GET", "POST"})
     */
    public function formAlterarSenhaAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $usuario = $em->find(Usuario::class, $user->getId());

        return $this->render($this->urlPage.'clientealterarsenha.html.twig', array(
            'usuario' => $usuario,
            'validaJS' => array('validaUsuario'),
        ));

    }

    /**
     * Lists all cliente entities.
     *
     * @Route("/listarLoja/{idCliente}", name="cliente_listarLoja")
     * @Method({"GET", "POST"})
     */
    public function listarLojaAction(Request $request, $idCliente)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $listaLoja = $em->getRepository(Loja::class)->findByUsuario($idCliente);
        $cliente = $em->getRepository(Usuario::class)->find($idCliente);

        return $this->render('cliente/loja-cliente.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTableLojaCliente(),
            'validaJS' => array('validaClienteProdutoLoja'),
            'cliente' => $cliente,
        ));
    }

    /**
     * Lists all Produto entities.
     *
     * @Route("/listarProdutoLoja/{idLoja}", name="cliente_listarProdutoLoja")
     * @Method({"GET", "POST"})
     */
    public function listarProdutoLojaAction(Request $request, $idLoja)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        return $this->render($this->urlPage.'clienteprodutoloja.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTableProdutoLoja(),
            'validaJS' => array('validaClienteProdutoLoja'),
            'idLoja' => $idLoja,
        ));

    }

    public function montaHeaderDataTableProdutoLoja(){

        $listaDados = array (
            array ("TAMANHO_CAMPO"=>"25", "NOME_CAMPO"=>"Marca", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"40", "NOME_CAMPO"=>"Produto", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"15", "NOME_CAMPO"=>"Preço", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"15", "NOME_CAMPO"=>"Data Alteração", "ALINHA_COLUNA"=>"center"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtmlWEBSITE($listaDados, 5);

    }

    /**
     * Lists all cliente entities.
     *
     * @Route("/listarLojaDatatable/{idCliente}", name="cliente_listarLojaDatatable")
     * @Method({"GET", "POST"})
     */
    public function listarLojaDatatableAction(Request $request, $idCliente)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $aColumns = array( 'id', 'nomeStatus', 'nome', 'razaoSocial', 'endereco', 'telefone', );
            $fieldWhere = array( 'l.id', 's.nome', 'l.nome', 'l.razaoSocial', 'e.endereco', 'l.telefone1', 'l.telefone2' );

            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            $paramWhere   = "l.usuario = ".$idCliente;

            $pagination = new Pagination();
            $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

            $em = $this->getDoctrine()->getManager();

            $rResult = $em->getRepository(Loja::class)->listarDados($aColumns, $sWhere, $request);
            $iTotal = $em->getRepository(Loja::class)->totalRegistroFiltro();

            // Montando o output do datatable
            $output = $pagination->outputDataTable($request->get('sEcho'), $iTotal);

            // Montando os dados do banco
            for ( $w=0 ; $w<count($rResult) ; $w++ ) {
                $row = array();

                for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
                    if ( $aColumns[$i] != ' ' ) {

                        $valor = $rResult[$w][$aColumns[$i]];

                        $row[] = $valor;

                    }
                }

                $id = $rResult[$w]['id'];

               // $urlExcluir = "../../loja/delete/".$id;

                $urlExcluir = $this->generateUrl('loja_delete', array('id' => $id));
                $urlProdutoLoja = $this->generateUrl('loja_listarProdutoLoja', array('id' => $id));;

                // Linha que adiciona os checkboxes na pagina
                $row[] =  '
                    <a href="'.$urlProdutoLoja.'" title="Adicionar Produto" class="btn btn-xs btn-success"><i class="fa fa-suitcase"></i></a>
					<a href="../formClienteLojaEdit/'.$id.'" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
					<a onclick="atualizarItem('.$id.', \''.$urlExcluir.'\');" title="Excluir" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
			    ';

                array_shift($row);
                $output['aaData'][] = $row;

            }

            $response = new JsonResponse();
            $response->setData($output);
            return $response;

        }


    }



    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/edit-senha", name="cliente_editsenha")
     * @Method({"GET", "POST"})
     */
    public function editSenhaAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $enconder = $this->container->get('security.password_encoder');

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->find(Usuario::class, $user->getId());

            $password = $enconder->encodePassword($usuario, $request->request->get('senha'));
            $usuario->setPassword($password);
            $usuario->setUsername($request->request->get('login'));

            if (!$usuario) {
                throw $this->createNotFoundException(
                    'No usuario found for id '.$user->getId()
                );
            }

            try {
                $em->flush();
                $response = $msg->load('004');
            } catch (UniqueConstraintViolationException $e) {
                $response = $msg->load('020');
            }

            return $response;
        }


    }

    /**
     * ---------------------------------
     *  --- DATATABLE ---
     * ---------------------------------
     */

    public function montaHeaderDataTableLojaCliente(){

        $listaDados = array (
            array ("TAMANHO_CAMPO"=>"15", "NOME_CAMPO"=>"Status", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Nome", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Razão Social", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"25", "NOME_CAMPO"=>"Endereço", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"10", "NOME_CAMPO"=>"Telefones", "ALINHA_COLUNA"=>"center"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 10);

    }

    public function montaHeaderDataTable(){

        $listaDados = array (
            array ("TAMANHO_CAMPO"=>"15", "NOME_CAMPO"=>"Status", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Nome", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"10", "NOME_CAMPO"=>"CPF", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"15", "NOME_CAMPO"=>"Username", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"E-mail", "ALINHA_COLUNA"=>"center"),
            array ("TAMANHO_CAMPO"=>"10", "NOME_CAMPO"=>"Data", "ALINHA_COLUNA"=>"center"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 15);

    }

    /**
     *
     * @Route("/listar", name="cliente_listar")
     * @Method({"GET", "POST"})
     */
    public function listar(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $aColumns = array( 'id', 'nomeStatus', 'nome', 'cpf', 'username', 'email', 'dtCadastro', );
            $fieldWhere = array( 'u.id', 's.nome', 'u.nome', 'u.cpf', 'u.username', 'u.email', 'u.dtCadastro', );

            /* Indexed column (used for fast and accurate table cardinality) */
            $sIndexColumn = "id";
            $paramWhere   = "u.permissoes = 3";

            $pagination = new Pagination();
            $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

            $em = $this->getDoctrine()->getManager();

            $rResult = $em->getRepository(Usuario::class)->listarDados($aColumns, $sWhere, $request);
            $iTotal = $em->getRepository(Usuario::class)->totalRegistroFiltro();

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

                $urlExcluir = "../usuario/delete/".$id;

                // Linha que adiciona os checkboxes na pagina
                $row[] =  '
                    <a href="listarLoja/'.$id.'" title="Loja" class="btn btn-xs btn-warning"><i class="fa fa-folder-o"></i></a>
			  		<a href="../usuario/formEdit/'.$id.'" title="Editar" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
					<a href="../usuario/formEditSenha/'.$id.'" title="Alterar Senha" class="btn btn-xs btn-primary"><i class="fa fa-lock"></i></a>
			  		<a onclick="atualizarItem('.$id.', \''.$urlExcluir.'\');" title="Excluir" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
			    ';

                array_shift($row);
                $output['aaData'][] = $row;

            }

            $response = new JsonResponse();
            $response->setData($output);
            return $response;

        }


    }

    /**
     *
     * @Route("/listarProdutoCliente/{idLoja}", name="cliente_listarProdutoCliente")
     * @Method({"GET", "POST"})
     */
    public function listarProdutoClienteAction(Request $request, $idLoja)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){
            return $this->carregaDataTableProduto($request, $idLoja);
        }
    }

    public function carregaDataTableProduto(Request $request, $idLoja)
    {

        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $aColumns = array( 'id', 'nomeMarca', 'nomeProduto', 'preco', 'dtAlteracao' );

            $fieldWhere = array( 'lp.id', 'm.nome', 'p.nome', 'lp.preco', 'lp.dtAlteracao' );

            /* Indexed column (used for fast and accurate table cardinality) */
            $paramWhere   = "lp.loja = ".$idLoja." and l.usuario = ".$user->getId();

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
                            $row[] = $valor->format('d/m/Y - H:i');
                        } else {
                            $row[] = $valor;
                        }
                    }
                }

                $id = $rResult[$w]['id'];
                // dump($rResult[$w]); exit;
                $idProduto = $rResult[$w]['idProduto'];
                $preco = $rResult[$w]['preco'];



                // Linha que adiciona os checkboxes na pagina
                $row[] =  '
			  		<a onclick="abreModalAlterarPreco('.$idLoja.', '.$idProduto.', '.$preco.');" class="btn btn-sm btn-gray" title="Atualizar preço do produto"><i class="fa fa-money fa-lg"></i></a>
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
