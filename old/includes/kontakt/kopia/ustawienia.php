<?php 

$adres_odbiorcy = 'gothicpochamsku@gmail.com';



/* Ustawienia wymaganych pól */
/* Pamiętaj, żeby oznaczyć wymagane pola w formularzu - plik formularz.php */

$valid['nick'] = 6 ; 	// Nick: 0 - oznacza pole nieobowiązkowe, inna liczba minimalną ilość znaków jakie musi wpisać użytkownik
$valid['mail'] = 0 ; 	// e-mail: 0 - oznacza pole nieobowiązkowe, 1 - pole wymagane
$valid['temat'] = 3 ; 	// Temat: 0 - oznacza pole nieobowiązkowe, inna liczba minimalną ilość znaków jakie musi wpisać użytkownik
$valid['tresc'] = 5 ; 	// Treść: 0 - oznacza pole nieobowiązkowe, inna liczba minimalną ilość znaków jakie musi wpisać użytkownik



/* Komunikaty */

$komunikat['sukces'] = 'Dziękujemy. Twoja wiadomość została wysłana.'; 		//Wiadomość po udanym wysłaniu formularza
$komunikat['blad'] = 'Wiadomość <b>NIE</b> została wysłana. Popraw poniższe błędy.'; 	//Wiadomość przy błędzie w sprawdzaniu danych, błędy zostaną wymienione poniżej
$komunikat['nick'] = 'Nick musi mieć min. 2 znaki.'; 	//Wpisz właściwą ilość znaków jeśli pole wymagane
$komunikat['mail'] = 'Podaj poprawny adres e-mail.'; 	//Wiadomość po błędnym wpisaniu adresu e-mail
$komunikat['temat'] = 'Temat musi mieć min. 3 znaki.'; 	//Wpisz właściwą ilość znaków jeśli pole wymagane
$komunikat['tresc'] = 'Treść musi mieć min. 5 znaków'; 	//Wpisz właściwą ilość znaków jeśli pole wymagane
$komunikat['fail'] = 'Przepraszamy wystąpił chwilowy błąd. Spróbuj ponownie później'; 	//W przypadku nieudanego wyslania wiadomości np. błędu serwera

?>