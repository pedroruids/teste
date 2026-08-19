<?php

use Illuminate\Support\Facades\DB;

it('liga à base de dados', function () {
    expect(DB::select('select 1 as um'))->not->toBeEmpty();
});

it('responde no health check', function () {
    $this->get('/up')->assertSuccessful();
});
