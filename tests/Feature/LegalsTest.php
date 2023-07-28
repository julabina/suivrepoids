<?php

namespace Tests\Feature;

it('has a about page', function () {
    $this->get(route('legals.about'))->assertOk();
});

it('has a cgu page', function () {
    $this->get(route('legals.cgu'))->assertOk();
});

it('has a contact page', function () {
    $this->get(route('legals.contact'))->assertOk();
});
