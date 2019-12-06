<?php

Route::view('/{any}', 'index')->where('any', '.*')->name('vue');
//Route::view('/{any?}', 'index')->where('any', '[\/\w\.-]*')->name('vue');
