name              "lorekeepers"
maintainer        "Inviqa"
license           "Apache 2.0"
description       "lorekeepers.org specific cookbooks"
version           "0.0.1"

recipe "default", "Remove standard PHP installation"
recipe "security", "Update app configuration settings"

depends 'mysql', '~> 6.0'