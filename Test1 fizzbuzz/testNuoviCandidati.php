<?php
//Inicialização e População do Dataset: --- O dataset é inicializado como um array vazio e preenchido com objetos stdClass dentro de um loop for
/* Creo un Dataset proveniente da base dati in formato array di oggetti */
$dataset = array();
$nomi = array("pino", "paolo", "pietro", "marco", "gianni", "salvatore", "jhon", "clelia", "Remigio", "andrea");
for ($x = 0; $x < 10; $x++) {
    $objTmp = new stdClass();
    if ($x == 2 || $x == 8) {
        // Problema: Verifica se o índice $x-1 existe no array $dataset sem garantir que ele está definido.
        $objTmp->order_ref = $dataset[$x - 1]->order_ref;
        $objTmp->name = $dataset[$x - 1]->name;
        $objTmp->address = $dataset[$x - 1]->address;
        $objTmp->cap = $dataset[$x - 1]->cap;
        $objTmp->city = $dataset[$x - 1]->city;
        $objTmp->prov = $dataset[$x - 1]->prov;
        $objTmp->country_code = $dataset[$x - 1]->country_code;
    } else {
        $objTmp->order_ref = "test-" . rand(1, 100);
        $objTmp->name = $nomi[$x];
        $objTmp->address = "via qualunque $x";
        // Problema: str_pad deve ter o comprimento desejado como um parâmetro inteiro.
        $objTmp->cap = str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT);
        $objTmp->city = "Qualunquopoli";
        $objTmp->prov = "QL";
        $objTmp->country_code = "IT";
    }

    $objTmp->sku = "qualcosa-" . rand(0, 10);
    $objTmp->qty = rand(1, 10);

    $dataset[] = $objTmp;
}

$path = "/home/clienti/";
$client_id = 1;
$fileCreati = 0;
$ordineInScrittura = "";
$fileOut = "";

/* Ciclo di creazione file
 * Problema: o loop deve ir de 0 até count($dataset) - 1 para evitar acessar índices fora do array.
 * Uso incorreto da função in_array: in_array verifica se um valor está presente em um array, não se um índice existe.
 */
for ($x = 0; $x <= sizeof($dataset); $x++) {
    /* Verifico presenza della key */
    if (in_array($x, $dataset) != FALSE) {
        // Problema: in_array não verifica a existência de um índice, mas sim a presença de um valor.
        $row = $dataset[$x];
        $termineCiclo = FALSE;
    } else {
        $row = new stdClass();
        $row->order_ref = $ordineInScrittura;
        $termineCiclo = TRUE;
    }

    /* Verifica ordine in scrittura
     * Problema: O valor de $ordineInScrittura pode não ser atualizado corretamente, o que pode causar falhas na lógica.
     * Problema: Se $termineCiclo é TRUE, o loop deve ser interrompido corretamente.
     */
    if ($ordineInScrittura != $row->order_ref || $ordineInScrittura == "" || $termineCiclo == TRUE) {
        /* La scrittura su file avviene solo se esiste un ordine in scrittura */
        if ($ordineInScrittura != "") {
            /* costruzione nome del file */
            $nomefile = "ORD" . $client_id . trim($ordineInScrittura) . ".csv";

            /* Problema: Non viene effettivamente scritto alcun contenuto nel file, solo il nome del file viene stampato.
             * Problema: $byteScritti è impostato come true ma non riflette l'esito reale della scrittura su file.
             */
            $byteScritti = true;
            echo "FILE CSV -> " . $path . $nomefile . "\n";

            if ($byteScritti != FALSE) {
                /* scrittura del file di lock */
                $filelck = str_replace('csv', 'lck', $nomefile);
                echo "FILE LOCK -> " . $path . $filelck . "\n";

                /* incremento contatore file creati */
                $fileCreati++;

                /* svuoto in contenuto di fileOut */
                $fileOut = "";

                /* Se termine ciclo esco da ciclo for */
                if ($termineCiclo == TRUE) {
                    break;
                }
            } else {
                throw new Exception("Scrittura file Odoo $nomefile fallita");
            }
        }

        /* cambio l'ordine in scrittura */
        $ordineInScrittura = $row->order_ref;
    }

    /* procedo a scrittura dati */
    $fileOut .= $client_id . "-" . $row->order_ref . ";";
    $fileOut .= $row->name . ";";
    $fileOut .= str_replace(",", "", $row->address) . ";";
    $fileOut .= $row->cap . ";";
    $fileOut .= $row->city . ";";
    $fileOut .= $row->prov . ";";
    $fileOut .= $row->country_code . ";";
    $fileOut .= $row->sku . ";";
    $fileOut .= $row->qty . ";";
    $fileOut .= "\r\n";
}
?>
