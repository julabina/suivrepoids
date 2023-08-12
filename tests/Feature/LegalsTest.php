<?php

namespace Tests\Feature;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

it('has a about page', function () {
    $this->get(route('legals.about'))->assertOk();
});

it('has a cgu page', function () {
    $this->get(route('legals.cgu'))->assertOk();
});

it('has a contact page', function () {
    $this->get(route('legals.contact'))->assertOk();
});

it('send contact message email', function () {
    Mail::fake();

    $response = $this->post(
        uri: route('legals.sendMessage', [
            'name' => 'Julien',
            'email' => 'test@test.fr',
            'topic' => 'test',
            'message' => 'message',
        ]),
    );

    Mail::assertSent(ContactMail::class, function ($mail) {
        return  $mail->hasTo('julien.lenfume@gmail.com');
    });
});
