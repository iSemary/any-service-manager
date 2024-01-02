<?php

namespace Isemary\AnyServiceManager\Commands;

interface Linux {
    const ROOT_COMMAND = "sudo";
    const SYSTEMCTL_STATUS = "systemctl status";
    const INSTALL_COMMAND = "apt-get install";
    const UNINSTALL_COMMAND = "apt-get remove";
    const PURGE_COMMAND = "apt-get purge";
    const CHECK_VERSION_COMMAND = "--version";
    const FIND_COMMAND = "which";
    const POWER_OFF = "/sbin/poweroff";
    const RESTART = "sudo /sbin/reboot";
}
