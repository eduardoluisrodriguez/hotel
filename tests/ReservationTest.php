<?php

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
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
            ->dontSee('Gość')
            ->dontSee('Data rozpoczęcia')
            ->dontSee('Data zakończenia')
            ->dontSee('Ilość osób')
            ->dontSee('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see('Brak rezerwacji w bazie danych')
            ->see('Dodaj');
    }

    public function testFilledIndex()
    {
        factory(Reservation::class, 3)->create();

        $this->visit('reservation')
            ->dontSee('Zaloguj')
            ->see('Rezerwacje')
            ->see('Pokój')
            ->see('Gość')
            ->see('Data rozpoczęcia')
            ->see('Data zakończenia')
            ->see('Ilość osób')
            ->see('Akcje')
            ->see('Edytuj')
            ->see('Usuń')
            ->dontSee('Brak rezerwacji w bazie danych')
            ->see('Dodaj');
    }

    public function testChooseGuestEmpty()
    {
        $this->visit('reservation/add')
            ->seePageIs('reservation/choose_guest')
            ->dontSee('Zaloguj')
            ->see('Wybierz gościa')
            ->dontSee('Imię')
            ->dontSee('Nazwisko')
            ->dontSee('Adres')
            ->dontSee('PESEL')
            ->dontSee('Kontakt')
            ->dontSee('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see('Brak gości w bazie danych')
            ->see('Dodaj');
    }

    public function testChooseGuestFilled()
    {
        factory(Guest::class)->create();

        $this->visit('reservation/add')
            ->seePageIs('reservation/choose_guest')
            ->dontSee('Zaloguj')
            ->see('Wybierz gościa')
            ->see('Imię')
            ->see('Nazwisko')
            ->see('Adres')
            ->see('PESEL')
            ->see('Kontakt')
            ->see('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->dontSee('Brak gości w bazie danych')
            ->see('Dodaj');
    }

    public function testSearchFreeRoomsDefaultPost()
    {
        $guest = factory(Guest::class)->create();

        $this->visit('reservation/add')
            ->seePageIs('reservation/choose_guest')
            ->dontSee('Zaloguj')
            ->see('Wybierz gościa')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->dontSee('Brak gości w bazie danych')
            ->see('Dodaj')
            ->click('Wybierz')
            ->seePageIs('reservation/search_free_rooms/'.$guest->id);

        $todayDate = Carbon::today()->format('d.m.Y');

        $this->see($guest->first_name.' '.$guest->last_name)
            ->see($todayDate)
            ->press('Wyślij');

        $this->see($guest->first_name.' '.$guest->last_name)
            ->see($todayDate)
            ->see('Data rozpoczęcia musi być datą wcześniejszą od data zakończenia.');
    }

    public function testSearchFreeRoomsCorrectPostNoRooms()
    {
        $guest = factory(Guest::class)->create();

        $this->visit('reservation/search_free_rooms/'.$guest->id);

        $todayDate = Carbon::today()->format('d.m.Y');
        $tomorrowDate = Carbon::tomorrow()->format('d.m.Y');

        $this->see($guest->first_name.' '.$guest->last_name)
            ->see($todayDate)
            ->type($tomorrowDate, 'date_end')
            ->press('Wyślij');

        $this->seePageIs('reservation/choose_room/'.$guest->id)
            ->see('Wybierz pokój dla '.$guest->first_name.' '.$guest->last_name)
            ->see('Brak pokoi w bazie danych')
            ->dontSee('Numer')
            ->dontSee('Piętro');
    }

    public function testSearchFreeRoomsCorrectPostWithRoomsAndAddReservation()
    {
        $guest = factory(Guest::class)->create();
        $room = factory(Room::class)->create();

        $this->visit('reservation/search_free_rooms/'.$guest->id);

        $todayDate = Carbon::today();
        $tomorrowDate = Carbon::tomorrow();

        $this->see($guest->first_name.' '.$guest->last_name)
            ->see($todayDate->format('d.m.Y'))
            ->type($tomorrowDate->format('d.m.Y'), 'date_end')
            ->press('Wyślij');

        $this->seePageIs('reservation/choose_room/'.$guest->id)
            ->see('Wybierz pokój dla '.$guest->first_name.' '.$guest->last_name)
            ->dontSee('Brak pokoi w bazie danych')
            ->see('Numer')
            ->see('Piętro')
            ->see('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see($room->number);

        $this->click('Wybierz')
            ->seePageIs('reservation')
            ->see('Zapisano pomyślnie')
            ->dontSee('Brak rezerwacji w bazie danych');

        $this->seeInDatabase('reservations', [
            'room_id'    => $room->id,
            'guest_id'   => $guest->id,
            'people'     => 1,
        ]);

        $this->see($todayDate->format('d.m.Y'))
            ->see($tomorrowDate->format('d.m.Y'));
    }

    public function testTryEditInvalidId()
    {
        $this->visit('reservation')
            ->see('Rezerwacje')
            ->visit('reservation/edit/10000');

        $this->see('Nie znaleziono obiektu')
            ->seePageIs('reservation');
    }

    /*public function testEditValidId()
    {
        $reservation = factory(Reservation::class)->create();

        $this->visit('reservation')
            ->see('Rezerwacje')
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

        $this->see('Zapisano pomyślnie')
            ->seePageIs('reservation')
            ->see('Edycja komentarza');
    }*/

    public function testDelete()
    {
        $reservation = factory(Reservation::class)->create();

        $this->seeInDatabase('reservations', [
            'id' => $reservation->id,
        ]);

        $this->seeInDatabase('rooms', [
            'id' => $reservation->room->id,
        ]);

        $this->seeInDatabase('guests', [
            'id' => $reservation->guest->id,
        ]);

        $response = $this->call('DELETE', 'reservation/delete/'.$reservation->id, [
            '_token' => csrf_token(),
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->notSeeInDatabase('reservations', [
            'id' => $reservation->id,
        ]);

        $this->seeInDatabase('rooms', [
            'id' => $reservation->room->id,
        ]);

        $this->seeInDatabase('guests', [
            'id' => $reservation->guest->id,
        ]);
    }

    /*public function testTryStoreInvalidId()
    {
        $this->makeRequest('POST', 'reservation/edit/1000', [
            '_token' => csrf_token(),
        ]);

        $this->notSeeInDatabase('reservations', []);
    }*/

    public function testEmptyFreeRooms()
    {
        $this->visit('room/free')
            ->dontSee('Zaloguj')
            ->see('Aktualnie wolne pokoje')
            ->see('Pokoje')
            ->dontSee('Użytkownicy')
            ->dontSee('Numer')
            ->dontSee('Piętro')
            ->dontSee('Pojemność')
            ->dontSee('Cena')
            ->dontSee('Komentarz')
            ->dontSee('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see('Brak pokoi w bazie danych')
            ->see('Dodaj');
    }

    public function testFilledFreeRooms()
    {
        factory(Room::class, 3)->create();

        $this->visit('room/free')
            ->dontSee('Zaloguj')
            ->see('Aktualnie wolne pokoje')
            ->see('Pokoje')
            ->see('Numer')
            ->see('Piętro')
            ->see('Pojemność')
            ->see('Cena')
            ->see('Komentarz')
            ->see('Akcje')
            ->see('Edytuj')
            ->see('Usuń')
            ->see('test comment')
            ->dontSee('Brak pokoi w bazie danych')
            ->see('Dodaj');
    }

    public function testEmptyOccupiedRooms()
    {
        $this->visit('room/occupied')
            ->dontSee('Zaloguj')
            ->see('Aktualnie zajęte pokoje')
            ->dontSee('Użytkownicy')
            ->see('Pokoje')
            ->dontSee('Numer')
            ->dontSee('Piętro')
            ->dontSee('Pojemność')
            ->dontSee('Cena')
            ->dontSee('Komentarz')
            ->dontSee('Akcje')
            ->dontSee('Edytuj')
            ->dontSee('Usuń')
            ->see('Brak pokoi w bazie danych')
            ->see('Dodaj');
    }

    public function testFilledOccupiedRooms()
    {
        factory(Reservation::class)->create();

        $this->visit('room/occupied')
            ->dontSee('Zaloguj')
            ->see('Aktualnie zajęte pokoje')
            ->dontSee('Użytkownicy')
            ->see('Pokoje')
            ->see('Numer')
            ->see('Piętro')
            ->see('Pojemność')
            ->see('Cena')
            ->see('Komentarz')
            ->see('Akcje')
            ->see('Edytuj')
            ->see('Usuń')
            ->see('test comment')
            ->dontSee('Brak pokoi w bazie danych')
            ->see('Dodaj');
    }
}
