<?php
// Inizializzazione e Popolamento del Dataset
$dataset = array(); // Inizializza un array vuoto per il dataset
$nomi = array("pino", "paolo", "pietro", "marco", "gianni", "salvatore", "jhon", "clelia", "Remigio", "andrea"); // Array di nomi

for ($x = 0; $x < 10; $x++) {
    $objTmp = new stdClass(); // Crea un oggetto stdClass temporaneo
    
    if ($x == 2 || $x == 8) {
        // Se l'indice è 2 o 8, copia i dati dal precedente oggetto del dataset
        if (isset($dataset[$x - 1])) { // Verifica se l'indice $x - 1 esiste
            $objTmp->order_ref = $dataset[$x - 1]->order_ref;
            $objTmp->name = $dataset[$x - 1]->name;
            $objTmp->address = $dataset[$x - 1]->address;
            $objTmp->cap = $dataset[$x - 1]->cap;
            $objTmp->city = $dataset[$x - 1]->city;
            $objTmp->prov = $dataset[$x - 1]->prov;
            $objTmp->country_code = $dataset[$x - 1]->country_code;
        }
    } else {
        // Altrimenti, assegna nuovi valori all'oggetto
        $objTmp->order_ref = "test-" . rand(1, 100);
        $objTmp->name = $nomi[$x];
        $objTmp->address = "via qualunque $x";
        $objTmp->cap = str_pad(rand(1, 9999), 4, "0", STR_PAD_LEFT); // Assicura che il CAP abbia 4 caratteri
        $objTmp->city = "Qualunquopoli";
        $objTmp->prov = "QL";
        $objTmp->country_code = "IT";
    }

    $objTmp->sku = "qualcosa-" . rand(0, 10); // Assegna un SKU casuale
    $objTmp->qty = rand(1, 10); // Assegna una quantità casuale

    $dataset[] = $objTmp; // Aggiunge l'oggetto al dataset
}

$path = "/home/clienti/"; // Percorso per i file
$client_id = 1; // ID cliente
$fileCreati = 0; // Contatore dei file creati
$ordineInScrittura = ""; // Ordine in scrittura
$fileOut = ""; // Contenuto del file di output

// Ciclo di creazione file
foreach ($dataset as $index => $row) {
    if ($ordineInScrittura != $row->order_ref || $ordineInScrittura == "" || $fileCreati >= 8) {
        if ($ordineInScrittura != "") {
            $nomefile = "ORD" . $client_id . trim($ordineInScrittura) . ".csv"; // Nome del file CSV

            // Simula a escrita do arquivo
            echo "FILE CSV -> " . $path . $nomefile . "\n";

            $filelck = str_replace('csv', 'lck', $nomefile); // Nome del file di lock
            echo "FILE LOCK -> " . $path . $filelck . "\n";

            $fileCreati++; // Incrementa il contatore dei file creati
            $fileOut = ""; // Resetta il contenuto del file di output

            if ($fileCreati >= 8) {
                break; // Esce do ciclo se foram criados 8 file
            }
        }

        $ordineInScrittura = $row->order_ref; // Aggiorna l'ordine in scrittura
    }

    // Aggiunge i dati al contenuto del file di output
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
