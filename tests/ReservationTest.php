<?php

use App\Models\Reservation;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReservationTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        Session::start();

        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user);
    }

    public function testEmptyIndex()
    {
        $this->visit('reservation')
            ->dontSee('Zaloguj')
            ->see('Rezerwacje')
            ->dontSee('Numer')
            ->dontSee('Piętro')
            ->dontSee('Cena')
            ->dontSee('Komentarz')
            ->dontSee('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see('Brak rezerwacji w bazie danych')
            ->see('Dodaj');
    }

    /*public function testFilledIndex()
    {
        factory(Reservation::class, 3)->create();

        $this->visit('reservation')
            ->dontSee('Zaloguj')
            ->see('Rezerwacje')
            ->see('Numer')
            ->see('Piętro')
            ->see('Pojemność')
            ->see('Cena')
            ->see('Komentarz')
            ->see('Akcje')
            ->see('Edytuj')
            ->see('Usuń')
            ->see('test comment')
            ->dontSee('Brak rezerwacji w bazie danych')
            ->see('Dodaj');
    }*/

    /*public function testAddEmptyForm()
    {
        $this->visit('reservation/add')
            ->dontSee('Zaloguj')
            ->see('Dodaj pokój')
            ->see('Numer')
            ->see('Piętro')
            ->see('Pojemność')
            ->see('Cena')
            ->see('Komentarz')
            ->see('Wyślij')
            ->press('Wyślij');

        $this->seePageIs('reservation/add')
            ->see('jest wymagane');
    }*/

    /*public function testTryEditInvalidId()
    {
        $this->visit('reservation')
            ->see('Pokoje')
            ->visit('reservation/edit/10000');

        $this->seePageIs('reservation')
            ->see('Nie znaleziono obiektu');
    }*/

    /*public function testEditValidId()
    {
        $reservation = factory(Reservation::class)->create();

        $this->visit('reservation')
            ->see('Pokoje')
            ->visit('reservation/edit/'.$reservation->id);

        $this->see('Edytuj pokój')
            ->see('Numer')
            ->see('Piętro')
            ->see('Pojemność')
            ->see('Cena')
            ->see('Komentarz')
            ->see('test comment')
            ->see('Wyślij');

        $this->type('Edycja komentarza', 'comment')
            ->press('Wyślij');

        $this->seePageIs('reservation')
            ->see('Zapisano pomyślnie')
            ->see('Edycja komentarza');
    }*/

    /*public function testDelete()
    {
        $reservation = factory(Reservation::class)->create();

        $this->seeInDatabase('reservations', [
            'ID' => $reservation->id,
        ]);

        $response = $this->call('DELETE', 'reservation/delete/'.$reservation->id, [
            '_token' => csrf_token(),
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->notSeeInDatabase('reservations', [
            'ID' => $reservation->id,
        ]);
    }*/

    /*public function testTryStoreInvalidId()
    {
        $this->makeRequest('POST', 'reservation/edit/1000', [
            '_token' => csrf_token(),
        ]);

        $this->notSeeInDatabase('reservations', []);
    }*/
}
