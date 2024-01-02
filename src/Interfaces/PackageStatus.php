<?php

namespace Isemary\AnyServiceManager\Interfaces;

/* The code is defining an interface named `PackageStatus` with four constant values: `INSTALLED`,
`ACTIVE`, `INACTIVE`, and `UNINSTALLED`. These constants represent different statuses that a package
can have. The values assigned to the constants are numeric codes that can be used to identify and
compare the statuses of packages in a program. */

interface PackageStatus {
    const INSTALLED = 200;
    const ACTIVE = 201;
    const INACTIVE = 202;
    const UNINSTALLED = 400;
}
