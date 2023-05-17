$(function() {
	document.getElementById("tabs-container").style.display = "block";
    //dla każdego kontenera z treścią tabów dodajemy klasę js -> patrz dalej
    $('.tabs-container').addClass('js');

    $('.tabs').each(function() {
        const $a = $(this).find('a'); //pobieram wszystkie linki-zakładki

        //po kliknięciu na link...
        $a.on('click', function(e) {
            //podstawiamy pod zmienną $this kliknięty link
            const $this = $(this);

            //pobieramy href klikniętego linka
            const href = $this.attr('href');
            //pobieramy treść na którą wskazuje link
            const $target = $(href);

            //jeżeli ta treść w ogóle istnieje...
            if ($target.length) {
                e.preventDefault(); //przerwij domyślną czynność jeżeli istnieje zawartość zakładki - inaczej niech dziala jak link

                //usuwamy z sąsiednich linków klasę active
                $this.siblings('a').removeClass('active');
                //klikniętemu linkowi dajemy klasę active
                $this.addClass('active');

                //podobne działanie robimy dla treści tabów
                $target.siblings('.tab-content').removeClass('active');
                $target.addClass('active');
            }
        });
    });
});

$('body').click(function(event) {
    if (!$(event.target).is('a'))
    {
        $('a').removeClass('active');
		$('.tab-content').removeClass('active');
    }
});
