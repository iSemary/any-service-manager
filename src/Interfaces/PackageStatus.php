<?php
namespace Isemary\AnyServiceManager\Interfaces;

interface PackageStatus {
    const INSTALLED = 200;
    const ACTIVE = 201;
    const INACTIVE = 202;
    const UNINSTALLED = 400;
}
