<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:prune-batches')->daily();
