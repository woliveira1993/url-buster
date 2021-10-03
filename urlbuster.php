<?php
error_reporting(0);
set_time_limit(0);
function acessa($url) {
	global $return;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
    curl_setopt($curl, CURLOPT_URL, $url);
    $return = curl_exec($curl);
	$codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return array("status" => $return,"codigo" => $codigo);
}


$vermelho = "\033[1;31m";
$verde = "\033[1;32m";
$azul = "\033[1;34m";
$reset = "\033[0;0m";
$alvo = $argv[1];
$wordlist = $argv[2];
$saida = $argv[3];


	if(empty($wordlist)){
		echo "\n\n\n $verde";
		echo "| [+] URL Buster - https://github.com/woliveira1993                    \n";
		echo "| [/] Modo de uso: [ php urlbuster.php alvo.com wordlist.txt saida.txt ]    $reset  \n";
	} elseif(empty($saida)){
		$fp = file($wordlist);
		$array = array_map('trim', $fp);
		$chars = "\,/,+";
		$charsA = explode(",", $chars);
		echo "\n\n\n\n\n\n\n\n\n\n\n\n\n $verde";
		echo "| [+] URL Buster                                                                    \n";
		echo "| [/] Iniciando ataque a [ $vermelho $alvo $verde ], os resultados não serão salvos!     $reset     \n";
	} else {
		$fp = file($wordlist);
		$array = array_map('trim', $fp);
		$chars = "\,/,+";
		$charsA = explode(",", $chars);
		echo "\n\n\n\n\n\n\n\n\n\n\n\n\n $verde";
		echo "| [+] URL Buster                                                                    \n";
		echo "| [/] Iniciando ataque a [ $vermelho $alvo $verde ], o resultado ficará salvo em [ $vermelho $saida $verde ]   $reset     \n";
	}



	foreach($array as $ataque){
		$acessa = acessa($alvo.'/'.$ataque);
			if($acessa['codigo'] != 404){
				echo "$verde [".$charsA[rand(0,2)]."] Encontrado =>     $alvo/$ataque     (HTTP CODE => ".$acessa['codigo'].")\n $reset";
					if(!empty($saida)){
						$abre = fopen($saida, "a");
						fwrite($abre, "$alvo/$ataque     (HTTP CODE => ".$acessa['codigo'].")\n");
				    }
			} else {
				echo "$vermelho [".$charsA[rand(0,2)]."] Não existe =>  $alvo/$ataque     (HTTP CODE => ".$acessa['codigo'].")\n $reset";
			}
	}
	
	if(!empty($saida)){
		echo "$azul \n\n Testes finalizados, os resultados foram salvos em  = > $saida $reset \n \n \n \n";
 	}



?>