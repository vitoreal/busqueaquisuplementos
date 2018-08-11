<?php

namespace AppBundle\Utils;

class Pagination {

    public function MontaTableHtml($listaDados, $sizeAcoes){

        $htmlTable = '
		
		<table class="table table-striped table-bordered table-hover datatable" width="100%">
			<thead>
				<tr>
				';

        for ($i=0; $i<count($listaDados); $i++) {

            $alinhaColuna = "";

            if (isset($listaDados[$i]['ALINHA_COLUNA'])) {
                $alinhaColuna = "text-align:".$listaDados[$i]['ALINHA_COLUNA'];
            }
            $htmlTable .= '<th style="'.$alinhaColuna.'" width="'.$listaDados[$i]['TAMANHO_CAMPO'].'%">'.$listaDados[$i]['NOME_CAMPO'].'</th>';
        }

        $htmlTable .= '
					<th width="'.$sizeAcoes.'%" class="removeIconOrder" style="text-align:center;">Ações</th>
				</tr>
			</thead>
		</table>';

       return $htmlTable;

    }

    public function MontaTableHtmlWEBSITE($listaDados, $sizeAcoes){

        $htmlTable = '
		
		<table class="table table-striped table-bordered table-hover datatable table-condensed" width="100%">
			<thead>
				<tr>
				';

        for ($i=0; $i<count($listaDados); $i++) {

            $alinhaColuna = "";

            if (isset($listaDados[$i]['ALINHA_COLUNA'])) {
                $alinhaColuna = "text-align:".$listaDados[$i]['ALINHA_COLUNA'];
            }
            $htmlTable .= '<th style="'.$alinhaColuna.'" width="'.$listaDados[$i]['TAMANHO_CAMPO'].'%">'.$listaDados[$i]['NOME_CAMPO'].'</th>';
        }

        $htmlTable .= '
					<th width="'.$sizeAcoes.'%" class="removeIconOrder" style="text-align:center;">Ações</th>
				</tr>
			</thead>
		</table>';

        return $htmlTable;

    }

	public function montaQueryPagination($request, $aColumns, $paramWhere){


		/*
		 * Paging
		 */

		$iDisplayStart = $request->get('start');
		$iDisplayLength = $request->get('length');
        $iSortCol_0 = $request->get('iSortCol_0');
        $iSortingCols = $request->get('iSortingCols');
        $sSearch = $request->get('search');

		$sLimit = "";
		if ( isset( $iDisplayStart ) && $iDisplayLength != '-1' ) {
		    //$sLimit = "LIMIT ".$iDisplayStart.", ".$iDisplayLength;
		}
		 
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $iSortCol_0 ) ) {

			$sOrder = "ORDER BY  ";
		    
		    for ( $i=0 ; $i<intval( $iSortingCols ) ; $i++ ) {

		        if ( $request->get('bSortable_'.intval( $request->get('iSortCol_'.$i))) == "true" ) {

                    $iSortCol = $request->get('iSortCol_'.$i);
                    $sSortDir = $request->get('sSortDir_'.$i);

		            $sOrder .= $aColumns[ intval( $iSortCol ) ]." ".$sSortDir.", ";
		        }
		    }
		     
		    $sOrder = substr_replace( $sOrder, "", -2 );
		    if ( $sOrder == "ORDER BY" ||  $sOrder == "ORDER BY   asc" ||  $sOrder == "ORDER BY   desc") {
		        $sOrder = "";
		    }
		}
		
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( isset($sSearch) && $sSearch != "" )
		{
		    $sWhere = " (";
		    for ( $i=0 ; $i<count($aColumns) ; $i++ )
		    {
		        $sWhere .= $aColumns[$i]." LIKE '%".$sSearch['value']."%' OR ";
		    }
		    $sWhere = substr_replace( $sWhere, "", -3 );
		    $sWhere .= ') ';
		}

		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
            $bSearchable = $request->get('bSearchable_'.$i);
            $sSearchArray = $request->get('sSearch_'.$i);

		    if ( isset($bSearchable) && $bSearchable == "true" && $sSearchArray != '' )
		    {
		        if ( $sWhere == "" )
		        {
		            $sWhere = "WHERE ";
		        }
		        else
		        {
		            $sWhere .= " AND ";
		        }
		        $sWhere .= $aColumns[$i]." LIKE '%".$sSearchArray."%' ";
		    }
		}

		if ($paramWhere != "") {

			if ($sWhere == "") {
				$sWhere .= "WHERE ".$paramWhere;
			} else {
				$sWhere .= " AND ".$paramWhere;
			}

		}
		return trim($sWhere." ".$sOrder." ".$sLimit);
		
	}
	
	public function outputDataTable($sEcho, $iTotal){
		
		/*
		 * Output
		 */
		$output = array(
		    "sEcho" => intval($sEcho),
		    "iTotalRecords" => $iTotal,
		    "iTotalDisplayRecords" => $iTotal,
		    "aaData" => array()
		);
		
		return $output;
		
	}
	
}

?>