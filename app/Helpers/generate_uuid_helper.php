<?php

if (! function_exists("generate_uuid")) {
    function generate_uuid(): string
    {
        return service("uuid")->uuid4()->toString();
    }
}
