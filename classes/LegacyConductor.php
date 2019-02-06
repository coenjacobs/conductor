<?php

class LegacyConductor
{
    public function checkPhpVersion($requiredVersion)
    {
        return version_compare(phpversion(), $requiredVersion, '<=');
    }
}
