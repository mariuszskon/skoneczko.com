#!/bin/bash

# a small simple build script before I switch to a better build system

sass -t expanded src/base.scss css/style.css
sass -t compressed --sourcemap=none src/base.scss css/style.min.css
