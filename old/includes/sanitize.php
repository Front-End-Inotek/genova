<?php

function sanitize($input){
    if(is_string($input)){
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    return $input;
}