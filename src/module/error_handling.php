<?php

if (isset($GLOBALS['sentry_dsn_php'])) {
    Sentry\init(['dsn' => $GLOBALS['sentry_dsn_php'], 'environment' => $GLOBALS['sentry_environment'] ]);
}
