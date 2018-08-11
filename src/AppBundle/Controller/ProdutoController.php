<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categoria;
use AppBundle\Entity\FotoProduto;
use AppBundle\Entity\Loja;
use AppBundle\Entity\LojaProduto;
use AppBundle\Entity\Marca;
use AppBundle\Entity\Produto;
use AppBundle\Entity\Sabor;
use AppBundle\Entity\TipoProduto;
use AppBundle\Utils\Pagination;
use AppBundle\Utils\Mensagens;
use AppBundle\Utils\Utilitario;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Produto controller.
 *
 * @Route("produto")
 */
class ProdutoController extends Controller
{
    /**
     * Lists all Produto entities.
     *
     * @Route("/", name="produto_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        return $this->render('produto/index.html.twig', array(
            'headerDataTable' => $this->montaHeaderDataTable(),
            'validaJS' => array('validaProduto'),
        ));

    }

    /**
     * Creates a new Produto entity.
     *
     *  @Route("/new", name="produto_new")
     *  @Method({"GET", "POST"})
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $listaCategoria = $em->getRepository(Categoria::class)->findAll();
        $listaSabor = $em->getRepository(Sabor::class)->findAll();
        $listaMarca = $em->getRepository(Marca::class)->findAll();

        return $this->render('produto/new.html.twig', array(
            'listaCategoria' => $listaCategoria,
            'listaSabor' => $listaSabor,
            'listaMarca' => $listaMarca,
            'validaJS' => array('validaProduto'),
        ));
    }

    /**
     * Displays a form to edit an existing TipoProduto entity.
     *
     * @Route("/formEdit/{id}", name="produto_formEdit")
     * @Method({"GET", "POST"})
     */
    public function formEditAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $produto = $em->find(Produto::class, $id);

        $tipoProduto = $em->getRepository(TipoProduto::class)->find($produto->getTipoProduto()->getId());

        //dump($tipoProduto->getCategoria()); exit;

        $listaCategoria = $em->getRepository(Categoria::class)->findAll();
        $listaSabor = $em->getRepository(Sabor::class)->findAll();
        $listaMarca = $em->getRepository(Marca::class)->findAll();

        return $this->render('produto/edit.html.twig', array(
            'listaCategoria' => $listaCategoria,
            'idTipoProduto' => $produto->getTipoProduto()->getId(),
            'categoriaSelecionada' => $tipoProduto->getCategoria()->getId(),
            'listaSabor' => $listaSabor,
            'listaMarca' => $listaMarca,
            'produto' => $produto,
            'validaJS' => array('validaProduto'),
        ));

    }

    /**
     * Displays a form to edit an existing TipoProduto entity.
     *
     * @Route("/buscaTipoProdutoPorCategoria", name="produto_buscaTipoProdutoPorCategoria")
     * @Method({"GET", "POST"})
     */
    public function buscaTipoProdutoPorCategoriaAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $idCategoria = $request->request->get('idCategoria');

        $listaTipoProduto = $em->getRepository(TipoProduto::class)->loadByIdCategoria($idCategoria);

        $response = new JsonResponse();
        $response->setData($listaTipoProduto);
        return 	$response;

    }


    /**
     * Creates a new Produto entity.
     *
     *  @Route("/addUpdateProduto", name="produto_addUpdate")
     *  @Method({"POST"})
     */
    public function addUpdateProdutoAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $em = $this->getDoctrine()->getManager();

            $idEdit = $request->request->get('idEdit');

            if(is_null($idEdit)){
                $produto = new Produto();
            } else {
                $produto = $em->getRepository(Produto::class)->find($idEdit);
            }


            $sabor = $em->getRepository(Sabor::class)->find($request->request->get('sabor'));
            $marca = $em->getRepository(Marca::class)->find($request->request->get('marca'));
            $tipoProduto = $em->getRepository(TipoProduto::class)->find($request->request->get('tipoProduto'));


            $produto->setSabor($sabor);
            $produto->setMarca($marca);
            $produto->setTipoProduto($tipoProduto);
            $produto->setNome($request->request->get('nome'));
            $produto->setDescricao($request->request->get('descricao'));
            $produto->setForma($request->request->get('forma'));
            $produto->setGenero($request->request->get('genero'));
            $produto->setGluten($request->request->get('gluten'));
            $produto->setImportante($request->request->get('importante'));
            $produto->setLactose($request->request->get('lactose'));
            $produto->setPeso($request->request->get('peso'));
            $produto->setQuatidade($request->request->get('quatidade'));
            $produto->setRecomendacaoUso($request->request->get('recomendacao_uso'));
            $produto->setValidade($request->request->get('validade'));

            try {

                if(is_null($idEdit)){
                    $em->persist($produto);
                    $response = $msg->load('003');
                } else {
                    $response = $msg->load('004');

                }

                $em->flush();

            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;

        }

    }

    /**
     * Displays a form to edit an existing TipoProduto entity.
     *
     * @Route("/fotoProduto/{id}", name="produto_fotoProduto")
     * @Method({"GET", "POST"})
     */
    public function fotoProdutoAction(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $fotoProduto = $em->getRepository(FotoProduto::class)->findBy(
            array('produto' => $id)
        );

        return $this->render('produto/foto-produto.html.twig', array(
            'idProduto' => $id,
            'fotoProduto' => $fotoProduto,
            'validaJS' => array('validaFotoProduto'),
        ));

    }

    /**
     * Deletes a produto entity.
     *
     * @Route("/delete/{id}", name="produto_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();
        $produto = $em->find(Produto::class, $id);

        if ($produto != null) {

            try {
                $em->remove($produto);
                $em->flush();
                $response = $msg->load('005');


            } catch (ConstraintViolationException $e) {
                $response = $msg->load('010');
            }

        }


        return $response;
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/carregaFotoProduto", name="produto_carregaFotoProdutoAdmin")
     * @Method({"GET", "POST"})
     */
    public function carregaFotoProdutoAction(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $idProduto = $request->request->get('idEdit');

            $em = $this->getDoctrine();

            $listaFotos = $em->getRepository(FotoProduto::class)->findByProduto($idProduto);

            if (!is_null($listaFotos)){

                $htmlToRender = $this->render('produto/carrega-foto-produto.html.twig', array(
                    'listaFotos' => $listaFotos,
                ));

                $jsonArray = array(
                    'data' => $htmlToRender->getContent(),
                );

                $response = new Response(json_encode($jsonArray));
                //$response->headers->set('Content-Type', 'application/html');
                return $response;

            }

        }

    }


    /**
     * Displays a form to edit an existing corretor entity.
     *
     * @Route("/addFotoProduto", name="produto_addFotoProduto")
     * @Method({"GET", "POST"})
     */
    public function editFotoProdutoAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $msg = new Mensagens();

            $em = $this->getDoctrine()->getManager();

            try {

                $upload = new Utilitario();

                $fileUpload = $request->files->get('foto');
                $idProduto = $request->request->get('idEdit');

                $produto = $em->find(Produto::class, $idProduto);

                $upFile = new UploadedFile($fileUpload->getPathname(), $fileUpload->getClientOriginalName(), $fileUpload->getClientMimeType());

                $fileName = md5 ( uniqid () ) . '.' . $upFile->guessExtension ();

                $file = $upFile->move("upload/foto_produto/temp/", $fileName);

                $urlUpload = "upload/foto_produto/";

                $nomeImagem = $upload->enviarFoto($file->getPathname(), $urlUpload);

                unset($file);

                $fotoProduto = new FotoProduto();

                $fotoProduto->setFoto($urlUpload.$nomeImagem);
                $fotoProduto->setProduto($produto);

                $em->persist($fotoProduto);

                $response = $msg->load('003');

                $em->flush();

            } catch (Exception $e) {
                $response = $msg->load('018');
            }

            return $response;

        }

    }

    /**
     * Displays a form to edit an existing corretor entity.
     *
     * @Route("/excluirFotoProduto", name="produto_excluirFotoProduto")
     * @Method({"GET", "POST"})
     */
    public function excluirFotoProdutoAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()) {

            $util = new Utilitario();
            $msg = new Mensagens();

            $em = $this->getDoctrine()->getManager();

            $idProduto = $request->request->get('id');

            $fotoDB = $em->getRepository(FotoProduto::class)->findOneById($idProduto);

            // verificando se o imovel eh do usuario logado
            $produto = $em->getRepository(Produto::class)->findOneBy(array('id' => $fotoDB->getProduto()->getId()));

            if (is_null($produto)){
                $response = $msg->load('011');
                return $response;
            }

            $em->remove($fotoDB);
            $em->flush();

            $filesystem = new Filesystem();
            $filesystem->remove($fotoDB->getFoto());

            $response = $msg->load('005');

            return $response;

        }

    }


    /**
     * Creates a new LojaProduto entity.
     *
     * @Route("/associarProdutoLoja", name="produto_associarProdutoLoja")
     * @Method({"GET", "POST"})
     */
    public function associarProdutoLojaAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();


        if ($request->isXmlHttpRequest()) {

            $idProduto = $request->request->get('idProduto');
            $idLoja = $request->request->get('idLoja');

            $produto = $em->find(Produto::class, $idProduto);
            $loja = $em->find(Loja::class, $idLoja);

            $lojaP = $em->getRepository(LojaProduto::class)->findBy(array('produto' => $produto, 'loja' => $loja));

            if ($lojaP != false){
                $response = $msg->load('022');
                return $response;
            }

            $totalProduto = $em->getRepository(LojaProduto::class)->totalRegistroPorLoja($idLoja);

            if ($totalProduto >= $loja->getQtdproduto()){
                $response = $msg->load('023');
                return $response;
            }

            $lojaProduto = new LojaProduto();

            $lojaProduto->setLoja($loja);
            $lojaProduto->setProduto($produto);

            try {
                $em->persist($lojaProduto);
                $em->flush();
                $response = $msg->load('003');
            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;
        }

    }

    /**
     * Creates a new LojaProduto entity.
     *
     * @Route("/desassociarProdutoLoja", name="produto_desassociarProdutoLoja")
     * @Method({"GET", "POST"})
     */
    public function desassociarProdutoLojaAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();


        if ($request->isXmlHttpRequest()) {

            $idProduto = $request->request->get('idProduto');
            $idLoja = $request->request->get('idLoja');

            $produto = $em->find(Produto::class, $idProduto);
            $loja = $em->find(Loja::class, $idLoja);

            $lojaProduto = $em->getRepository(LojaProduto::class)->findOneBy(array('produto' => $produto, 'loja' => $loja));

            try {
                $em->remove($lojaProduto);
                $em->flush();
                $response = $msg->load('003');
            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;
        }

    }

    /**
     * Creates a new LojaProduto entity.
     *
     * @Route("/alterarPrecoProduto", name="produto_alterarPrecoProduto")
     * @Method({"GET", "POST"})
     */
    public function alterarPrecoProdutoAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO', null, 'Unable to access this page!');

        $msg = new Mensagens();

        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $idProduto = $request->request->get('idProduto');
            $idLoja = $request->request->get('idLoja');
            $preco = $request->request->get('preco');

            $produto = $em->find(Produto::class, $idProduto);
            $loja = $em->find(Loja::class, $idLoja);

            $lojaProduto = $em->getRepository(LojaProduto::class)->findOneBy(array('produto' => $produto, 'loja' => $loja));

            $lojaProduto->setPreco($preco);
            $lojaProduto->setDtAlteracao(new \DateTime());

            try {
                $em->flush();
                $response = $msg->load('025');
            } catch (Exception $e) {
                $response = $msg->load('009');
            }

            return $response;
        }

    }


    /**
     * ---------------------------------
     *  --- DATATABLE ---
     * ---------------------------------
     */
    public function montaHeaderDataTable(){

        $listaDados = array (
            0 => array ("TAMANHO_CAMPO"=>"20", "NOME_CAMPO"=>"Tipo de Produto", "ALINHA_COLUNA"=>"left"),
            1 => array ("TAMANHO_CAMPO"=>"25", "NOME_CAMPO"=>"Marca", "ALINHA_COLUNA"=>"left"),
            2 => array ("TAMANHO_CAMPO"=>"45", "NOME_CAMPO"=>"Produto", "ALINHA_COLUNA"=>"left"),
        );

        $pagination = new Pagination();

        return $pagination->MontaTableHtml($listaDados, 15);

    }

    /**
     *
     * @Route("/listar", name="produto_listar")
     * @Method({"GET", "POST"})
     */
    public function listar(Request $request)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){
           return $this->carregaDataTableProduto($request, false, null);
        }
    }

    /**
     *
     * @Route("/listarAssociar/{idLoja}", name="produto_listarAssociar")
     * @Method({"GET", "POST"})
     */
    public function listarAssociarAction(Request $request, $idLoja)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if ($request->isXmlHttpRequest()){
            return $this->carregaDataTableProduto($request, true, $idLoja);
        }
    }

    public function carregaDataTableProduto($request, $carregaDoModal, $idLoja) {

        if ($carregaDoModal){
            $aColumns = array( 'id', 'nomeTipoProduto', 'marcaProduto', 'nomeProduto', 'descricao' );
            $fieldWhere = array( 'tp.id', 'tp.nome', 'm.nome', 'p.nome', 'p.descricao' );
        } else {
            $aColumns = array( 'id', 'nomeTipoProduto', 'marcaProduto', 'nomeProduto' );
            $fieldWhere = array( 'tp.id', 'tp.nome', 'm.nome', 'p.nome' );
        }


        /* Indexed column (used for fast and accurate table cardinality) */
        $paramWhere   = "";

        $pagination = new Pagination();
        $sWhere = $pagination->montaQueryPagination($request, $fieldWhere, $paramWhere);

        $em = $this->getDoctrine()->getManager();

        $rResult = $em->getRepository(Produto::class)->listarDados($aColumns, $sWhere, $request);
        $iTotal = $em->getRepository(Produto::class)->totalRegistroFiltro();

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

            // Linha que adiciona os checkboxes na pagina
            if($carregaDoModal){
                $row[] =  '
			  		<a onclick="associarProdutoLoja('.$idLoja.', '.$id.');" class="btn btn-xs btn-success" title="Associar Produto"><i class="fa fa-refresh"></i></a>
			    ';
            } else {

                $urlExcluir = "delete/".$id;

                $row[] =  '
			  		<a href="fotoProduto/'.$id.'" class="btn btn-xs btn-warning" title="Foto do produto"><i class="fa fa-camera"></i></a>
			  		<a href="formEdit/'.$id.'" class="btn btn-xs btn-info" title="Alterar"><i class="fa fa-pencil"></i></a>
			  		<a onclick="atualizarItem('.$id.', \''.$urlExcluir.'\');" class="btn btn-xs btn-danger" title="Excluir"><i class="fa fa-trash-o"></i></a>
			    ';
            }


            // retira o id da busca
            array_shift($row);

            $output['aaData'][] = $row;

        }

        $response = new JsonResponse();
        $response->setData($output);
        return $response;


    }
}
