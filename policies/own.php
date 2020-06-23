<?php

if(isset($context->options["filter"])) {
  $context->options["filter"] = [];
}

$context->options["filter"]["_mby"] = $context->user["_id"];

return $context;