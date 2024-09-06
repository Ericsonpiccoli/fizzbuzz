<?php

///Come funziona il codice:
// (A) loop da 1 a 100: Utilizza un ciclo for per iterare dai numeri 1 a 100.
// (B) Multipli di 3 e 5: Se il numero corrente è divisibile sia per 3 che per 5, stampa "FizzBuzz".
// (C) Multipli di 3: Se il numero è divisibile solo per 3, stampa "Fizz".
// (D) Multipli di 5: Se il numero è divisibile solo per 5, stampa "Buzz".
// (E) Altro caso: Se il numero non è divisibile né per 3 né per 5, stampa il numero stesso.

 // (A) loop da 1 a 100:
for ($i = 1; $i <= 100; $i++) {
    // (B) Multipli di 3 e 5:
    if ($i % 3 == 0 && $i % 5 == 0) {
        echo "FizzBuzz\n";
    }
    // (C) Multipli di 3:
    elseif ($i % 3 == 0) {
        echo "Fizz\n";
    }
    // (D) Multipli di 5:
    elseif ($i % 5 == 0) {
        echo "Buzz\n";
    }
   // (E) Altro caso:
    else {
        echo $i . "\n";
    }
}


?>
