<?php

namespace Isemary\AnyServiceManager\Commands;

interface Linux {
    const SYSTEMCTL_STATUS = "systemctl status";
    const INSTALL_COMMAND = "apt install";
    const UNINSTALL_COMMAND = "apt remove";
    const PURGE_COMMAND = "apt purge";
    const CHECK_VERSION_COMMAND = "--version";
    const FIND_COMMAND = "which";
}
