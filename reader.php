<?php

ini_set('memory_limit', '1024M');

$row = 1;
$jsonarray = [];
$eachobj = [];
$count = 0;

$acidentes = [];

if (($handle = fopen("acidentes-".$_GET['ano'].".csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        /*
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < 20; $c++) {
            echo $data[$c] . "<br />\n";
        }
        */
        //0		1 			2 		3 		4 		5			6		7	8 	9 	10 		11 			12			13
        //ID	DATA_HORA	DIA_SEM	FERIDOS	TEMPO	NOITE_DIA	REGIAO	DIA	MES	ANO	FX_HORA	CONT_ACID	CONT_VIT	UPS

        //array['20121'] = [ ['535815', 'SEXTA-FEIRA', 'NOITE', 'BOM', 6, 1, 1, 0], [], [] ]

     //    for ($c=0; $c < 20; $c++) {

     //    	//if($data[8] == "MES") continue;

        	


	    //     //if($data[2] == "QUARTA-FEIRA"){
        	
     //    	if($data[2] == "SEXTA-FEIRA" && $data[5] == "NOITE"){
	    //     	$eachobj[0] = $data[0];
	    //     	$eachobj[1] = $data[2];
	    //     	$eachobj[2] = $data[5];
	    //     	$eachobj[3] = $data[4];
	    //     	$eachobj[4] = $data[7];
	    //     	$eachobj[5] = $data[8];
	    //     	$eachobj[6] = $data[11];
	    //     	$eachobj[7] = $data[3];
	    //     	$jsonarray[$count] = $eachobj;
    	// 		$count++;
	    //     }
	        
	        
	    // }
	    	if($data[8] == "MES") continue;

	    	$yearmo = "a".$data[9].$data[8];

        	$diasem = $data[2];
        	$tempo = $data[4];
        	$noite = $data[5];
        	$regiao = $data[6];

        	if(!isset($acidentes[$yearmo])){
	        	$acidentes[$yearmo] = null;
	        	$acidentes[$yearmo]["Feridos"] = null;
	        	$acidentes[$yearmo]["Acidentes"] = null;
	        }
        	$acidentes[$yearmo]["Feridos"] = $acidentes[$yearmo]["Feridos"]+$data[3];
        	$acidentes[$yearmo]["Acidentes"]++;

        	if(!isset($acidentes[$yearmo][$tempo]["Feridos"])) $acidentes[$yearmo][$tempo]["Feridos"] = 0;
        	if(!isset($acidentes[$yearmo][$tempo]["Acidentes"])) $acidentes[$yearmo][$tempo]["Acidentes"] = 0;
        	$acidentes[$yearmo][$tempo]["Feridos"] += $data[3];
        	$acidentes[$yearmo][$tempo]["Acidentes"]++;

        	if(!isset($acidentes[$yearmo][$noite]["Feridos"])) $acidentes[$yearmo][$noite]["Feridos"] = 0;
        	if(!isset($acidentes[$yearmo][$noite]["Acidentes"])) $acidentes[$yearmo][$noite]["Acidentes"] = 0;
        	$acidentes[$yearmo][$noite]["Feridos"] += $data[3];
        	$acidentes[$yearmo][$noite]["Acidentes"]++;

        	if(!isset($acidentes[$yearmo][$diasem])){
        		$acidentes[$yearmo][$diasem] = null;
        		$acidentes[$yearmo][$diasem]["Feridos"] = 0;
        		$acidentes[$yearmo][$diasem]["Acidentes"] = 0;
        	}
        	$acidentes[$yearmo][$diasem]["Feridos"] += $data[3];
        	$acidentes[$yearmo][$diasem]["Acidentes"]++;

        	if(!isset($acidentes[$yearmo][$diasem][$noite]["Feridos"])) $acidentes[$yearmo][$diasem][$noite]["Feridos"] = 0;
        	if(!isset($acidentes[$yearmo][$diasem][$noite]["Acidentes"])) $acidentes[$yearmo][$diasem][$noite]["Acidentes"] = 0;
        	$acidentes[$yearmo][$diasem][$noite]["Feridos"] += $data[3];
        	$acidentes[$yearmo][$diasem][$noite]["Acidentes"]++;
        	
        	if(!isset($acidentes[$yearmo][$regiao]["Feridos"])) $acidentes[$yearmo][$regiao]["Feridos"] = 0;
        	if(!isset($acidentes[$yearmo][$regiao]["Acidentes"])) $acidentes[$yearmo][$regiao]["Acidentes"] = 0;
        	$acidentes[$yearmo][$regiao]["Feridos"] += $data[3];
        	$acidentes[$yearmo][$regiao]["Acidentes"]++;

    }
    
    fclose($handle);
    //print_r($acidentes);
    print_r(json_encode($acidentes));

    //echo json_encode($jsonarray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

}


/*

{
    "cols": [
        {
            "label": "ID",
            "type": "string"
        },
        {
            "label": "Life Expectancy",
            "type": "number"
        },
        {
            "label": "Fertility Rate",
            "type": "number"
        },
        {
            "label": "Region",
            "type": "string"
        },
        {
            "label": "Population",
            "type": "number"
        }
    ],
    "rows": [
        {
            "c": [
                {
                    "v": "Seg"
                },
                {
                    "v": 1
                },
                {
                    "v": 2
                },
                {
                    "v": "A"
                },
                {
                    "v": 40
                }
            ]
        }
    ],
    "p": null
}

*/
/*
$cols = [["label"=>"A","type"=>"string"],["label"=>"B","type"=>"string"],["label"=>"C","type"=>"string"],["label"=>"D","type"=>"string"],["label"=>"E","type"=>"string"]];
$rows = [["c"=>[["v"=>"Seg"],["v"=>"1"],["v"=>"2"],["v"=>"A"],["v"=>"40"]]], ["c"=>[["v"=>"Seg"],["v"=>"1"],["v"=>"2"],["v"=>"A"],["v"=>"40"]]], ["c"=>[["v"=>"Seg"],["v"=>"1"],["v"=>"2"],["v"=>"A"],["v"=>"40"]]]];

$jsonarray["cols"] = $cols;
$jsonarray["rows"] = $rows;
echo json_encode($jsonarray);
*/
?>