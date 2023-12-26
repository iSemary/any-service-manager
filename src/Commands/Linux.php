<?php

namespace Isemary\AnyServiceManager\Commands;

interface Linux {
    const SYSTEMCTL_STATUS = "systemctl status";
    const INSTALL_COMMAND = "apt install";
    const UNINSTALL_COMMAND = "apt remove";
    const FIND_COMMAND = "which";
}
