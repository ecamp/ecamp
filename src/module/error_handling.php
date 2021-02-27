<?php

if (isset($GLOBALS['sentry_dsn'])) {
    Sentry\init(['dsn' => $GLOBALS['sentry_dsn'], 'environment' => $GLOBALS['sentry_environment'] ]);
}
