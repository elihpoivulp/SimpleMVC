<?php
function hasNamespacePresence(string $str): string
{
    return str_contains($str, '\\');
}