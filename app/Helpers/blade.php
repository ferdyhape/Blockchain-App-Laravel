<?php

function toRp($money)
{
    return 'Rp ' . number_format($money, 0, ',', '.');
}
